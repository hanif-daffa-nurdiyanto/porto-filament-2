<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\EditRecordAndRedirectToIndex;
use App\Filament\Resources\PatientResource;
use Filament\Actions;

class EditPatient extends EditRecordAndRedirectToIndex
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
