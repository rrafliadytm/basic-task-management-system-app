<?php

namespace App\Filament\Resources\PrioritiesResource\Pages;

use App\Filament\Resources\PrioritiesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPriorities extends EditRecord
{
    protected static string $resource = PrioritiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
