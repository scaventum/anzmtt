<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Blocks\ContactBlock;
use App\Filament\Resources\Blocks\NewsBlock;
use App\Filament\Resources\Blocks\ParagraphBlock;
use App\Filament\Resources\Blocks\QuoteBlock;
use App\Filament\Resources\Blocks\UnorderedListBlock;
use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\Pages\CreatePage;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Models\Page;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                                            fn($state, $set) =>
                                            $set('slug', Str::slug($state))
                                        ),

                                    TextInput::make('subtitle')
                                        ->maxLength(255),

                                    TextInput::make('short_title')
                                        ->helperText('Shorter title to be shown in menu section')
                                        ->maxLength(255),

                                    TextInput::make('slug')
                                        ->maxLength(255)
                                        ->unique(ignoreRecord: true)
                                        ->prefix('/'),
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
                                            QuoteBlock::make(),
                                            ContactBlock::make(),
                                        ])
                                        ->columnSpanFull(),
                                ]),
                        ])
                        ->columnSpan(['lg' => 2]),

                    Section::make('Settings')
                        ->schema([
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
                                        ->directory('hero')
                                ])
                        ])
                        ->columnSpan(['lg' => 1]),
                ])
                ->columns(['lg' => 3]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('slug')->searchable(),
                TextColumn::make('subtitle')->searchable(),
                TextColumn::make('short_title')->searchable(),

                IconColumn::make('published')->boolean(),

                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->recordAction(null) // disable modal 
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
                DeleteAction::make(),
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
