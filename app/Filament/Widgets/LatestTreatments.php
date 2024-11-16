<?php

namespace App\Filament\Widgets;

use App\Models\Treatment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTreatments extends BaseWidget
{
    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Treatment::query()->orderBy('created_at', 'desc')->limit(5)
            )
            ->columns([
                TextColumn::make('patient.name'),
                TextColumn::make('patient.type')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('description'),
                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
            ]);
    }
}
