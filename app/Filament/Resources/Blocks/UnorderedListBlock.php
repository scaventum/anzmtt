<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class UnorderedListBlock
{

  public static function make(): Block
  {
    return  Block::make('unorderedList')
      ->schema(
        [
          TextInput::make('title')
            ->maxLength(255)
            ->required(),

          TextInput::make('ctaLink.href')
            ->label('CTA link URL / path')
            ->maxLength(255),

          TextInput::make('ctaLink.label')
            ->label('CTA link label')
            ->maxLength(255),

          Repeater::make('listItems')
            ->required()
            ->schema(
              [
                TextInput::make('listItem')
                  ->maxLength(255)
                  ->required(),
              ]
            )
        ]
      );
  }
}
