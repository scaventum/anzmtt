<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class NewsBlock extends BaseBlock
{
  public static function make(): Block
  {
    return  Block::make('news')
      ->schema(
        array_merge(
          [
            TextInput::make('supertitle')
              ->maxLength(255),
            TextInput::make('title')
              ->maxLength(255),
            Toggle::make('moreNews')
              ->default(true)
          ],
          parent::baseSchema()
        )
      );
  }
}
