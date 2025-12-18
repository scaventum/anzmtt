<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class QuoteBlock extends BaseBlock
{
  public static function make(): Block
  {
    return  Block::make('quote')
      ->schema(
        array_merge(
          [
            Textarea::make('quote')
              ->required(),
            TextInput::make('author')
              ->maxLength(255),
          ],
          parent::baseSchema()
        )
      );
  }
}
