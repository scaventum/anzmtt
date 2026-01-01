<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationItemResource\Pages;
use App\Models\NavigationItem;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class NavigationItemResource extends Resource
{
    protected static ?string $model = NavigationItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    // Only show top-level items in sidebar
    public static function shouldRegisterNavigation(): bool
    {
        return static::$model::whereNull('parent_id')->exists();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('page_id')
                ->relationship('page', 'title')
                ->searchable()
                ->required(),

            Select::make('parent_id')
                ->label('Parent')
                ->options(fn() => NavigationItem::with('page')->whereNull('parent_id')->get()
                    ->pluck('page.short_title', 'id'))
                ->searchable()
                ->nullable()
                ->helperText('Leave empty for top-level items'),

            TextInput::make('sort_order')
                ->numeric()
                ->minValue(1)
                ->default(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page.short_title')
                    ->label('Label')
                    ->formatStateUsing(function ($state, $record) {
                        // Compute depth for indentation
                        $depth = 0;
                        $parent = $record->parent;
                        while ($parent) {
                            $depth++;
                            $parent = $parent->parent;
                        }

                        // Prepend — for children
                        return str_repeat('— ', $depth) . $state;
                    }),
                TextColumn::make('parent.page.short_title')->label('Parent'),
                TextColumn::make('sort_order')->sortable(),
            ])
            ->defaultSort('parent_id');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigationItems::route('/'),
            'create' => Pages\CreateNavigationItem::route('/create'),
            'edit' => Pages\EditNavigationItem::route('/{record}/edit'),
        ];
    }
}
