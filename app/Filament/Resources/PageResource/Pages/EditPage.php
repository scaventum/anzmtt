<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn() => url($this->record->url))
                ->visible(fn(): bool => $this->record->published)
                ->openUrlInNewTab(),
            Action::make('preview')
                ->icon('heroicon-o-eye')
                ->url(fn() => url($this->record->previewUrl))
                ->visible(fn(): bool => !$this->record->published)
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
