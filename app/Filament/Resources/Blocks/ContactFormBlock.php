<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ContactFormBlock extends BaseBlock
{
  public static function make(): Block
  {
    return Block::make('contactForm')
      ->schema(
        array_merge(
          [
            TextInput::make('title')
              ->maxLength(255)
              ->required(),
            Textarea::make('description')
              ->maxLength(255),
          ],
          parent::baseSchema()
        )
      );
  }
}
