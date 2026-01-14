<?php

namespace App\Filament\Resources\Fieldsets;

use App\Models\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;

class CallForPapersFieldset
{
  public static function make(): Fieldset
  {
    return Fieldset::make('Call for Papers')
      ->relationship('callForPapers')
      ->visible(fn(Get $get) => $get('type') === Page::TYPE_CALL_FOR_PAPERS)
      ->schema([
        Grid::make(2)->schema([
          TextInput::make('publication_name')
            ->label('Publication Name')
            ->required()
            ->columnSpanFull(),

          TextInput::make('journal')
            ->label('Journal'),

          DatePicker::make('publication_date_from')
            ->label('Publication Start Date')
            ->required(),

          DatePicker::make('publication_date_to')
            ->label('Publication End Date')
            ->required(),

          DatePicker::make('submission_deadline')
            ->label('Submission Deadline')
            ->required(),
        ])
          ->columnSpanFull(),

        RichEditor::make('information')
          ->required()
          ->columnSpanFull(),

        TextInput::make('information_link')
          ->label('Information Link')
          ->url()
          ->columnSpanFull(),
      ]);
  }
}
