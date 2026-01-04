<?php

namespace App\Filament\Resources\NavigationItemResource\Pages;

use App\Filament\Resources\NavigationItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListNavigationItems extends ListRecords
{
    protected static string $resource = NavigationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    protected function getTableQuery(): null|Builder
    {
        return parent::getTableQuery()
            ->whereNull('parent_id') // only top-level items
            ->orderBy('sort_order'); // optional: sort by sort_order
    }
}
