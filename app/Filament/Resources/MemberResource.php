<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static string|BackedEnum|null  $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('first_name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('last_name')
                        ->maxLength(255),

                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    TextInput::make('title')
                        ->maxLength(255),

                    TextInput::make('role')
                        ->maxLength(255),

                    TextInput::make('organisation')
                        ->maxLength(255),
                ]),

                CheckboxList::make('types')
                    ->label('Member Types')
                    ->options(Member::TYPES)
                    ->columns(2)
                    ->helperText('A member can have none or multiple types.'),

                Textarea::make('interests')
                    ->label('Interests')
                    ->helperText('Enter one interest per line')
                    ->rows(4)
                    ->afterStateHydrated(
                        fn($component, $state) =>
                        $component->state(is_array($state) ? implode("\n", $state) : '')
                    )
                    ->dehydrateStateUsing(
                        fn($state) =>
                        collect(explode("\n", $state))
                            ->map(fn($s) => trim($s))
                            ->filter()
                            ->values()
                            ->toArray()
                    ),

                Textarea::make('bio')
                    ->rows(4)
                    ->columnSpanFull(),

                DateTimePicker::make('last_active_at')
                    ->label('Last Active At'),

                FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image()
                    ->directory('members/avatars')
                    ->imagePreviewHeight('150')
                    ->maxSize(1024)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(
                        fn($record) =>
                        'https://ui-avatars.com/api/?name=' .
                            urlencode($record->first_name . ' ' . $record->last_name)
                    ),
                TextColumn::make('first_name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('last_name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('organisation')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('types')
                    ->formatStateUsing(function (string $state) {
                        $types = explode(', ', $state);
                        $types = array_map(fn($type): string => Member::TYPES[$type] ?? '', $types);
                        sort($types);
                        return implode(', ', $types);
                    })
                    ->separator(),
                TextColumn::make('last_active_at')
                    ->label('Last Active')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
