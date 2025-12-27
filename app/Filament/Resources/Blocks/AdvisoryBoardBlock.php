<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;

class AdvisoryBoardBlock extends BaseBlock
{
  public static function make(): Block
  {
    return Block::make('advisory-board')
      ->schema(
        array_merge(
          [],
          parent::baseSchema()
        )
      );
  }
}
