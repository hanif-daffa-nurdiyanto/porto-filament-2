<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationGroup = 'Blog';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->required(),
                Forms\Components\Select::make('author_id')
                    ->disabledOn('edit')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->disk('public')
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make()
                    ->columns(2)
                    ->schema([
                        ImageColumn::make('image')
                            ->extraImgAttributes([
                                'class' => 'w-full rounded object-cover',
                                'style' => 'aspect-ratio: 16/9',
                            ])
                            ->columnSpanFull()
                            ->height('auto'),
                        TextColumn::make('title')
                            ->columnSpanFull()
                            ->searchable()
                            ->weight(FontWeight::SemiBold)
                            ->size(TextColumnSize::Large),
                        TextColumn::make('description')
                            ->columnSpanFull()
                            ->html(),
                        // Likes and Views in the same row with adjusted spacing
                        Grid::make()
                            ->columns(2) // Put them in the same row (2 columns)
                            ->schema([
                                TextColumn::make('likes')
                                    ->icon('heroicon-m-hand-thumb-up')
                                    ->badge()
                                    ->color('success'),
                                TextColumn::make('views')
                                    ->icon('heroicon-m-eye')
                                    ->badge()
                                    ->color('primary'),
                            ]),
                    ])

            ])
            ->contentGrid(['md' => 2, 'xl' => 3])
            ->recordUrl(null)
            ->recordAction('View Information')
            ->filters([
                Tables\Filters\SelectFilter::make('author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('View Information')
                    ->hiddenLabel()
                    ->infolist([
                        Split::make([
                            Section::make('Blog')
                                ->schema([
                                    ImageEntry::make('image')
                                        ->size(400)
                                        ->disk('public')
                                        ->columnSpan('full'),
                                    TextEntry::make('title')
                                        ->columnSpan('full'),
                                    TextEntry::make('description')
                                        ->columnSpan('full'),
                                ])
                                ->columns(),
                            Section::make('Author Information')
                                ->schema([
                                    ImageEntry::make('author.avatar')
                                        ->circular()
                                        ->columnSpan('full'),
                                    TextEntry::make('author.name'),
                                ])->grow(false)
                                ->columns(),
                        ])->from('md'),
                    ]),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
}
