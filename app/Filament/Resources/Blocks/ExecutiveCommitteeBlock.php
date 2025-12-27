<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;

class ExecutiveCommitteeBlock extends BaseBlock
{
  public static function make(): Block
  {
    return Block::make('executiveCommittee')
      ->schema(
        array_merge(
          [],
          parent::baseSchema()
        )
      );
  }
}
