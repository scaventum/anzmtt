<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;

class NewsBlock
{
  public static function make(): Block
  {
    return  Block::make('news')
      ->schema(
        [
          TextInput::make('supertitle')
            ->maxLength(255),
          TextInput::make('title')
            ->maxLength(255)
            ->required(),
        ]
      );
  }
}
