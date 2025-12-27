<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;

class MemberDirectoryBlock extends BaseBlock
{
  public static function make(): Block
  {
    return Block::make('memberDirectory')
      ->schema(
        array_merge(
          [],
          parent::baseSchema()
        )
      );
  }
}
