<?php

namespace App\Filament\Resources\TiketResource\Pages;

use App\Filament\Resources\TiketResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Models\Comment;
use App\Models\Tiket;
use Illuminate\Support\Facades\DB;

class ManageTikets extends ManageRecords
{
    protected static string $resource = TiketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


}
