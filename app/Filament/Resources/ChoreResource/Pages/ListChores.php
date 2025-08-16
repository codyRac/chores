<?php

namespace App\Filament\Resources\ChoreResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ChoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChores extends ListRecords
{
    protected static string $resource = ChoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
