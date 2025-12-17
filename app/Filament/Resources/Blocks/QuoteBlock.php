<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class QuoteBlock
{
  public static function make(): Block
  {
    return  Block::make('quote')
      ->schema(
        [
          Textarea::make('quote')
            ->required(),
          TextInput::make('author')
            ->maxLength(255),
        ]
      );
  }
}
