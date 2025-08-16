<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Forms\Components\Select;
use App\Models\Group;


class Dashboard extends BaseDashboard
{
    use HasFiltersAction;

    // protected string $view = 'filament.pages.dashboard';

    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->form([
                    Select::make('group_id')
                        ->label('Group')
                        ->options(
                            Group::query()
                                ->whereHas('users', fn ($q) => $q->whereKey(auth()->id()))
                                ->orderBy('title')
                                ->pluck('title', 'id')
                        )
                        ->searchable()
                        ->preload()
                        ->native(false),
                ]),
        ];
    }
}
