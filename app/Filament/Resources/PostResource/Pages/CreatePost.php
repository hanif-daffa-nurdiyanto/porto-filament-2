<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\CreateRecordAndRedirectToIndex;
use App\Filament\Resources\PostResource;
use Filament\Actions;

class CreatePost extends CreateRecordAndRedirectToIndex
{
    protected static string $resource = PostResource::class;
}
