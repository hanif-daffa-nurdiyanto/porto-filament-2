<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\EditRecordAndRedirectToIndex;
use App\Filament\Resources\PostResource;
use Filament\Actions;

class EditPost extends EditRecordAndRedirectToIndex
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
