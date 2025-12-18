<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Select;

class BaseBlock
{
  protected static function baseSchema(): array
  {
    return  [
      Select::make('background')
        ->options([
          'dark' => 'Dark',
          'light' => 'Light',
        ])
        ->placeholder('Neutral')
    ];
  }
}
