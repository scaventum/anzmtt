<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;

class ContactBlock
{
  public static function make(): Block
  {
    return  Block::make('contact')
      ->schema(
        [
          TextInput::make('title')
            ->maxLength(255)
            ->required(),
          TextInput::make('subtitle')
            ->maxLength(255),
        ]
      );
  }
}
