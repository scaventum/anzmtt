<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class AccordionBlock extends BaseBlock
{
  public static function make(): Block
  {
    return Block::make('accordion')
      ->schema(
        array_merge(
          [
            Repeater::make('questions')
              ->required()
              ->schema([
                Textarea::make('question')
                  ->required(),
                Textarea::make('answer')
                  ->required(),
              ]),
          ],
          parent::baseSchema()
        )
      );
  }
}
