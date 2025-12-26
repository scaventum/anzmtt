<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->icon('heroicon-o-check')
                ->action('save'),
            Action::make('view')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('info')
                ->url(fn() => url($this->record->url))
                ->visible(fn(): bool => $this->record->published)
                ->openUrlInNewTab(),
            Action::make('preview')
                ->label('Preview (auto-refresh 5s)')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->tooltip('Preview page auto-refreshes every 5 seconds')
                ->url(fn() => url($this->record->previewUrl))
                ->visible(fn(): bool => !$this->record->published)
                ->openUrlInNewTab(),
            DeleteAction::make(),
        ];
    }
}
