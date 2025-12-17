<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;

class ParagraphBlock
{

  public static function make(): Block
  {
    return  Block::make('paragraph')
      ->schema(
        [
          Textarea::make('content')
            ->required(),
        ]
      );
  }
}
