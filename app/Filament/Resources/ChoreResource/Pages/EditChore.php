<?php

namespace App\Filament\Resources\ChoreResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use App\Filament\Resources\ChoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChore extends EditRecord
{
    protected static string $resource = ChoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
