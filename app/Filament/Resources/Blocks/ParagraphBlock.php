<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class ParagraphBlock extends BaseBlock
{

  public static function make(): Block
  {
    return  Block::make('paragraph')
      ->schema(
        array_merge(
          [
            Toggle::make('logo')
              ->required(),
            Textarea::make('content')
              ->required(),
          ],
          parent::baseSchema()
        )
      );
  }
}
