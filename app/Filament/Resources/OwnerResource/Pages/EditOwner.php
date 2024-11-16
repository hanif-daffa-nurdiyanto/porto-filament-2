<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\EditRecordAndRedirectToIndex;
use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOwner extends EditRecordAndRedirectToIndex
{
    protected static string $resource = OwnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
