<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;

class ContactBlock extends BaseBlock
{
  public static function make(): Block
  {
    return Block::make('contact')
      ->schema(
        array_merge(
          [
            TextInput::make('title')
              ->maxLength(255)
              ->required(),
            TextInput::make('subtitle')
              ->maxLength(255),
          ],
          parent::baseSchema()
        )
      );
  }
}
