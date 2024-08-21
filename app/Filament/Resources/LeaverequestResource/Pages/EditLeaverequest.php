<?php

namespace App\Filament\Resources\LeaverequestResource\Pages;

use App\Filament\Resources\LeaverequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeaverequest extends EditRecord
{
    protected static string $resource = LeaverequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
