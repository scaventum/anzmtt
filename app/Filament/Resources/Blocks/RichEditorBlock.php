<?php

namespace App\Filament\Resources\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;

class RichEditorBlock extends BaseBlock
{

  public static function make(): Block
  {
    return  Block::make('richEditor')
      ->schema(
        array_merge(
          [
            TextInput::make('title')
              ->maxLength(255),
            TextInput::make('subtitle')
              ->maxLength(255),
            RichEditor::make('content'),
          ],
          parent::baseSchema()
        )
      );
  }
}
