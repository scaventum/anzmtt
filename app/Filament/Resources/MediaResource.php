<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Media Library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->disabledClick(),
                TextColumn::make('collection_name')->sortable()->disabledClick(),
                TextColumn::make('file_name')
                    ->label('File')
                    ->formatStateUsing(function ($state, Media $record) {
                        if ($record instanceof Media && str_starts_with($record->mime_type, 'image/')) {
                            // Show thumbnail wrapped in a link that opens in a new tab
                            return '<a href="' . $record->getFullUrl() . '" target="_blank">'
                                . '<img src="' . $record->getFullUrl() . '" style="max-width:100px; max-height:100px;">'
                                . '</a>';
                        }

                        // For non-images, show filename as a clickable link
                        return '<a href="' . $record->getFullUrl() . '" target="_blank">' . $record->file_name . '</a>';
                    })
                    ->disabledClick()
                    ->html()

            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('collection_name')
                    ->options(Media::pluck('collection_name', 'collection_name')->unique()->toArray()),
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
