<?php

namespace App\Filament\Resources\RewardResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\RewardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRewards extends ListRecords
{
    protected static string $resource = RewardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
