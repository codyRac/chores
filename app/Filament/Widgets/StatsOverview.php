<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\Support\Htmlable;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    // protected ?string $heading = 'Group Stats';
    protected ?string $pollingInterval = '10s';

    protected function getHeading(): string
    {
        $groupId = $this->pageFilters['group_id'] ?? null;
        if (!$groupId) {
            return 'Group Stats';
        }

        // (Optional) verify the current user actually belongs to this group
        $isAllowed = DB::table('group_user')
            ->where('user_id', Auth::id())
            ->where('group_id', $groupId)
            ->exists();

        if (!$isAllowed) {
            return 'Group Stats';
        }

        $name = Group::whereKey($groupId)->value('title');

        // return just the title, or append “Stats” if you like
        return $name ?: 'Group Stats';

    }


    protected function getStats(): array
{
    $userId = Auth::id();

    // Allowed groups for this user
    $allowedGroupIds = DB::table('group_user')
        ->where('user_id', $userId)
        // ->whereNull('deleted_at') // keep only if your pivot has this column
        ->pluck('group_id')
        ->all();

    // Safely read page filter (pageFilters can be null on first load)
    $filters = is_array($this->pageFilters ?? null) ? $this->pageFilters : [];
    $requested = $filters['group_id'] ?? null;

    // Resolve selected group
    $selectedGroupId = null;
    if ($requested !== null && $requested !== 'all') {
        $candidate = (int) $requested;
        if (in_array($candidate, $allowedGroupIds, true)) {
            $selectedGroupId = $candidate;
        }
    }
    // Fallback to first allowed group
    $selectedGroupId ??= $allowedGroupIds[0] ?? null;

    // If nothing selected / no groups, show empty stats
    if (!$selectedGroupId) {
        return [
            Stat::make('My Points', '0')->description('Select a group'),
            Stat::make('My Earned', '$0.00'),
            Stat::make('My Redeemed', '0'),
        ];
    }

    // Pivot row for this user + selected group
    $pivot = DB::table('group_user')
        ->where('user_id', $userId)
        ->where('group_id', $selectedGroupId)
        // ->whereNull('deleted_at') // only if present
        ->first();

    $points   = (int)   ($pivot->points   ?? 0);
    $earned   = (float) ($pivot->earned   ?? 0);
    $redeemed = (int)   ($pivot->redeemed ?? 0);

    return [
        Stat::make('My Points', number_format($points)),
        Stat::make('My Earned', '$' . number_format($earned, 2)),
        Stat::make('My Redeemed', number_format($redeemed)),
    ];
}



    protected function filterLabel($myGroupIds): string
    {
        if ($this->filter !== null && $this->filter !== 'all') {
            $name = Group::whereIn('id', $myGroupIds)->find((int) $this->filter)?->name;
            return $name ? "Group: {$name}" : 'Group';
        }
        return 'All My Groups';
    }
}
