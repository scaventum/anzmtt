<?php

namespace App\Repositories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PageRepository
{
  public function getPageDataBySlug(string $slug, bool $published = true): object
  {
    $page = Page::slug($slug)->when($published, function (Builder $query) {
      $query->published();
    })->first();

    $pageData = $page?->toArray() ?? [
      'title' => 'Not found',
      'blocks' => [
        [
          'type' => 'error',
          'data' => [
            'body' => 'Sorry, the page you\'re looking for doesn\'t exist or under development.',
            'background' => 'light'
          ],
        ],
      ],
    ];

    return json_decode(json_encode($pageData));
  }

  public function checkPageFoundBySlug(string $slug, bool $published = true): bool
  {
    return Page::slug($slug)->when($published, function (Builder $query) {
      $query->published();
    })->exists();
  }

  public function getNewsPages(int $limit = 9, bool $published = true): Collection
  {
    $pages = Page::news()->when($published, function (Builder $query) {
      $query->published();
    })->orderByDesc('updated_at')->limit($limit)->get();

    return $pages;
  }
}
