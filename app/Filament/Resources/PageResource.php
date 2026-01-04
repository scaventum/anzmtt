<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Blocks\AdvisoryBoardBlock;
use App\Filament\Resources\Blocks\ConferencesBlock;
use App\Filament\Resources\Blocks\ContactBlock;
use App\Filament\Resources\Blocks\ExecutiveCommitteeBlock;
use App\Filament\Resources\Blocks\MemberDirectoryBlock;
use App\Filament\Resources\Blocks\NewsBlock;
use App\Filament\Resources\Blocks\ParagraphBlock;
use App\Filament\Resources\Blocks\QuoteBlock;
use App\Filament\Resources\Blocks\UnorderedListBlock;
use App\Filament\Resources\PageResource\Pages\CreatePage;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Models\Page;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-window';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make()
                ->schema([
                    Section::make('General')
                        ->schema([


                            Fieldset::make('Title')
                                ->schema([
                                    TextInput::make('title')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(
                                            function ($state, callable $set, Get $get) {
                                                $prefix = $get('type') !== Page::TYPE_GENERAL ? $get('type') . '/' : '';
                                                return $set('slug', $prefix . Str::slug($state));
                                            }
                                        ),
                                    TextInput::make('subtitle')
                                        ->maxLength(255),

                                    TextInput::make('short_title')
                                        ->helperText('Shorter title to be shown in menu section')
                                        ->maxLength(255),

                                    TextInput::make('slug')
                                        ->maxLength(255)
                                        ->unique(ignoreRecord: true)
                                        ->prefix('/')
                                        ->readOnly(fn(Get $get) => $get('type') !== 'general')
                                        ->required()
                                        ->reactive(),
                                ]),


                            Fieldset::make('Conference')
                                ->relationship('conference')
                                ->visible(fn(Get $get) => $get('type') === Page::TYPE_CONFERENCES)
                                ->schema([
                                    Grid::make(2)->schema([
                                        TextInput::make('full_name')
                                            ->label('Conference Name')
                                            ->columnSpanFull(),

                                        TextInput::make('location'),

                                        TextInput::make('cost'),

                                        DatePicker::make('date_from')
                                            ->label('Start Date'),

                                        DatePicker::make('date_to')
                                            ->label('End Date'),

                                        TimePicker::make('time_from')
                                            ->label('Start Time'),

                                        TimePicker::make('time_to')
                                            ->label('End Time'),
                                    ]),

                                    RichEditor::make('information')
                                        ->required()
                                        ->columnSpanFull(),

                                    TextInput::make('registration_link')
                                        ->url()
                                        ->columnSpanFull(),

                                    FileUpload::make('downloadables')
                                        ->maxSize(2048)
                                        ->directory('conference')
                                        ->columnSpanFull(),
                                ]),

                            Fieldset::make('Content')
                                ->schema([
                                    Builder::make('blocks')
                                        ->label('Page Blocks')
                                        ->collapsible()
                                        ->blocks([
                                            ParagraphBlock::make(),
                                            UnorderedListBlock::make(),
                                            NewsBlock::make(),
                                            ConferencesBlock::make(),
                                            QuoteBlock::make(),
                                            ContactBlock::make(),
                                            ExecutiveCommitteeBlock::make(),
                                            AdvisoryBoardBlock::make(),
                                            MemberDirectoryBlock::make(),
                                        ])
                                        ->columnSpanFull(),
                                ]),
                        ])
                        ->columnSpan(['lg' => 2]),

                    Section::make('Settings')
                        ->schema([
                            Fieldset::make(label: 'Type')->schema([
                                Select::make('type')
                                    ->columnSpanFull()
                                    ->label('Page type')
                                    ->options(Page::TYPES)
                                    ->default(Page::TYPE_GENERAL)
                                    ->reactive()
                                    ->required(),
                            ]),
                            Fieldset::make('Status')
                                ->schema([

                                    Toggle::make('published')
                                        ->label('Publish')
                                        ->columnSpanFull()
                                        ->default(false),

                                    DateTimePicker::make('published_at')
                                        ->label('Publish Date')
                                        ->default(now()),

                                    Select::make('user_id')
                                        ->label('Author')
                                        ->relationship('user', 'name')
                                        ->default(auth()->id())
                                        ->required(),
                                ]),
                            Fieldset::make('Hero')
                                ->schema([
                                    TextInput::make('hero.title')
                                        ->columnSpanFull()
                                        ->maxLength(255),

                                    TextInput::make('hero.subtitle')
                                        ->columnSpanFull()
                                        ->maxLength(255),

                                    TextInput::make('hero.ctaLink.href')
                                        ->label('CTA link URL / path')
                                        ->maxLength(255),

                                    TextInput::make('hero.ctaLink.label')
                                        ->label('CTA link label')
                                        ->maxLength(255),

                                    FileUpload::make('hero.backgroundImage.src')
                                        ->label('Background image source')
                                        ->image()
                                        ->columnSpanFull()
                                        ->maxSize(2048)
                                        ->directory('hero')
                                ]),
                        ])
                        ->columnSpan(['lg' => 1]),
                ])
                ->columns(['lg' => 3]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->defaultGroup('type')
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('slug')->searchable(),
                TextColumn::make('updated_at')->sortable(),
                IconColumn::make('published')->boolean(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(Page::TYPES),
                TernaryFilter::make('published')
            ])
            ->recordAction(null) // disable modal 
            ->recordUrl(fn($record) => static::getUrl('edit', ['record' => $record]))
            ->actions([
                Action::make('preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Page $record): string => $record->preview_url)
                    ->openUrlInNewTab()
                    ->visible(fn(Page $record): bool => !$record->published),
                Action::make('view')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn(Page $record): string => $record->url)
                    ->openUrlInNewTab()
                    ->visible(fn(Page $record): bool => $record->published),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit'   => EditPage::route('/{record}/edit'),
        ];
    }
}
