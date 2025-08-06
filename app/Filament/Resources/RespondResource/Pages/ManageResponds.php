<?php

namespace App\Filament\Resources\RespondResource\Pages;

use App\Filament\Resources\RespondResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageResponds extends ManageRecords
{
    protected static string $resource = RespondResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
