<?php

namespace App\Filament\Resources\PrioritiesResource\Pages;

use App\Filament\Resources\PrioritiesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPriorities extends ListRecords
{
    protected static string $resource = PrioritiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
