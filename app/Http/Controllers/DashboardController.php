<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\{Chore, Reward};

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user   = $request->user();

        // User's groups (id + name)
        $groups = $user->groups()
            ->select('groups.id', 'groups.title')
            ->orderBy('title')
            ->get();

        // Pick selected group (query param), fallback to first available
        $requested = (int) $request->query('group_id', 0);
        $selectedGroupId = $groups->pluck('id')->contains($requested)
            ? $requested
            : ($groups->first()->id ?? null);

        // Example stats from the pivot row (adjust to your real logic):
        $pivot = $selectedGroupId
            ? DB::table('group_user')
                ->where('user_id', $user->id)
                ->where('group_id', $selectedGroupId)
                ->first()
            : null;

        $stats = [
            // Replace with your own fields/queries
            'points'   => (int)   ($pivot->points   ?? 0),
            'redeemed' => (int)   ($pivot->redeemed ?? 0),
            'earned' => (int)   ($pivot->earned ?? 0),
            'role' => (int)   ($pivot->role ?? 0),

            'groups'   => (int)   $groups->count(), // or something else you prefer
        ];

        // All users in the selected group (with pivot info)
        $members = $selectedGroupId
            ? DB::table('users')
                ->join('group_user', function ($j) {
                    $j->on('users.id', '=', 'group_user.user_id');
                    // $j->whereNull('group_user.deleted_at'); // uncomment if you soft-delete pivot rows
                })
                ->where('group_user.group_id', $selectedGroupId)
                ->orderBy('users.name')
                ->get([
                    'users.id',
                    'users.name',
                    'users.email',
                    'group_user.role',
                    'group_user.points',
                    'group_user.earned',
                    'group_user.redeemed',
                    'group_user.joined_at',
                ])
            : collect();

                // ✅ Completed chores for this user & selected group
                $completedChores = $selectedGroupId
                ? DB::table('chore_completions as cc')
                    ->join('chore as c', 'c.id', '=', 'cc.chore_id')
                    ->where('cc.user_id', $user->id)
                    ->where('cc.group_id', $selectedGroupId)
                    ->orderByDesc('cc.completed_at')
                    ->get([
                        'cc.id',
                        'cc.chore_id',
                        'c.title',
                        'c.points',
                        'cc.completed_at',
                    ])
                : collect();



        return Inertia::render('Dashboard', [
            'stats'            => $stats,
            'groups'           => $groups->map(fn ($g) => ['id' => $g->id, 'title' => $g->title]),
            'selectedGroupId'  => $selectedGroupId,
            'members'         => $members,
            'chores'=> Chore::all(),
            'rewards'=> Reward::all(),
            'completedChores' => $completedChores, // 👈 send to page



        ]);
    }

    // app/Http/Controllers/DashboardController.php
    public function complete(Request $request, int $choreId)
{
    $request->validate(['group_id' => ['required','integer']]);

    $user    = $request->user();
    $groupId = (int) $request->input('group_id');


    DB::transaction(function () use ($user, $groupId, $choreId) {
        $exists = DB::table('group_user')->where('user_id', $user->id)->where('group_id', $groupId)->exists();
        abort_unless($exists, 403, 'You are not a member of this group.');

        // 🔧 fix table name (chores)
        $chore = DB::table('chore')->where('id', $choreId)->first();
        abort_unless($chore, 404, 'Chore not found.');

        $inserted = false;
        try {
            DB::table('chore_completions')->insert([
                'chore_id'       => $chore->id,
                'user_id'        => $user->id,
                'group_id'       => $groupId,
                'points_awarded' => (int) $chore->points,
                'completed_at'   => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
            $inserted = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $inserted = false; // already completed for this group
        }

        if ($inserted) {
            DB::table('group_user')
                ->where('user_id', $user->id)
                ->where('group_id', $groupId)
                ->increment('points', (int) $chore->points);
        }
    });

    return redirect()->route('dashboard', ['group_id' => $groupId]);
}


}
