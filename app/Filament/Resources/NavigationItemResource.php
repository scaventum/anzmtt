<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationItemResource\Pages;
use App\Models\NavigationItem;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NavigationItemResource extends Resource
{
    protected static ?string $model = NavigationItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Main')->schema([
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
                    ->readOnly(),
            ])->columns(2),

            Section::make('Children')->schema([
                // Repeater for child items
                Repeater::make('children')
                    ->label('Child Items')
                    ->defaultItems(0)
                    ->relationship() // tells Filament this is a hasMany relationship
                    ->orderColumn('sort_order') // allow drag & drop sorting
                    ->schema([
                        Select::make('page_id')
                            ->relationship('page', 'title')
                            ->required(),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->readOnly(),
                    ])->columns(2),
            ])
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
                TextColumn::make('sort_order'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->paginated(false);
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
