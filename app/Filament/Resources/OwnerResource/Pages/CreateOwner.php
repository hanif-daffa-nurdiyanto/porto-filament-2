<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\CreateRecordAndRedirectToIndex;
use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOwner extends CreateRecordAndRedirectToIndex
{
    protected static string $resource = OwnerResource::class;
}
