<?php


namespace App\Filament\Resources\Fieldsets;

use App\Models\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Get;

class ConferenceFieldset
{
  public static function make(): Fieldset
  {
    return Fieldset::make('Conference')
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

        TextInput::make('call_for_abstract_link')
          ->url()
          ->columnSpanFull(),

        TextInput::make('registration_link')
          ->url()
          ->columnSpanFull(),

        FileUpload::make('downloadables')
          ->disk(config('app.env') === 'local' ? 'local' : 's3')
          ->directory('conference')
          ->columnSpanFull(),
      ]);
  }
}
