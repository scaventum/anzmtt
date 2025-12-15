<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages\ManagePages;
use App\Models\Page;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema(
                        [
                            Section::make('Content')
                                ->schema([
                                    TextInput::make('title')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function ($state, $set) {
                                            $set('slug', Str::slug($state));
                                        }),
                                    TextInput::make('short_title')
                                        ->helperText('Shorter title to be shown in menu section')
                                        ->maxLength(255),
                                    TextInput::make('slug')
                                        ->required()
                                        ->maxLength(255)
                                        ->unique(ignoreRecord: true)
                                        ->prefix('/'),

                                    Builder::make('blocks')
                                        ->label('Page Blocks')
                                        ->blocks([
                                            Block::make('heading')
                                                ->schema([
                                                    TextInput::make('title')
                                                        ->required()
                                                        ->maxLength(255),
                                                    Select::make('level')
                                                        ->options([
                                                            'h1' => 'Heading 1',
                                                            'h2' => 'Heading 2',
                                                            'h3' => 'Heading 3',
                                                            'h4' => 'Heading 4',
                                                        ])
                                                        ->default('h2'),
                                                ])
                                                ->columns(2),

                                            Block::make('text')
                                                ->schema([
                                                    RichEditor::make('content')
                                                        ->required()
                                                        ->toolbarButtons([
                                                            'bold',
                                                            'italic',
                                                            'link',
                                                            'bulletList',
                                                            'orderedList',
                                                        ]),
                                                ]),

                                            Block::make('image')
                                                ->schema([
                                                    FileUpload::make('image')
                                                        ->image()
                                                        ->directory('pages/images')
                                                        ->required(),
                                                    TextInput::make('alt')
                                                        ->label('Alt Text')
                                                        ->maxLength(255),
                                                ]),
                                        ])
                                        ->collapsible()
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(['lg' => 2]),
                            Section::make('Settings')
                                ->schema([

                                    Toggle::make('published')
                                        ->label('Publish')
                                        ->default(false),

                                    DateTimePicker::make('published_at')
                                        ->label('Publish Date')
                                        ->default(now()),

                                    Select::make('user_id')
                                        ->label('Author')
                                        ->relationship('user', 'name')
                                        ->default(auth()->id())
                                        ->required(),
                                ])
                                ->columnSpan(['lg' => 1]),
                        ]
                    )
                    ->columns(['lg' => 3]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->searchable(),

                IconColumn::make('published')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('published')
                    ->label('Published')
                    ->query(fn($query) => $query->where('published', true)),

                Filter::make('drafts')
                    ->label('Drafts')
                    ->query(fn($query) => $query->where('published', false)),
            ])
            ->actions([
                Action::make('preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Page $record): string => $record->preview_url)
                    ->openUrlInNewTab()
                    ->visible(fn(Page $record): bool => !$record->published),

                Action::make('view')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn(Page $record): string => $record->url ?? '#')
                    ->openUrlInNewTab()
                    ->visible(fn(Page $record): bool => $record->published),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePages::route('/'),
        ];
    }
}
