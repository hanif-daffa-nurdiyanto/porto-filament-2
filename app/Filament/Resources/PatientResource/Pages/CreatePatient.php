<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\CreateRecordAndRedirectToIndex;
use App\Filament\Resources\PatientResource;
use Filament\Actions;

class CreatePatient extends CreateRecordAndRedirectToIndex
{
    protected static string $resource = PatientResource::class;
}
