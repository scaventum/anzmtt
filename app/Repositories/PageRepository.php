<?php

namespace App\Repositories;

use App\Models\Page;
use Illuminate\Support\Collection;

class PageRepository
{
  public function getPageDataBySlug(string $slug): object
  {

    $page = Page::slug($slug)->first();

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

  public function checkPageFoundBySlug(string $slug): bool
  {
    return Page::slug($slug)->exists();
  }

  public function getNewsPages(int $limit = 9): Collection
  {
    $pages = Page::news()->orderByDesc('updated_at')->limit($limit)->get();

    return $pages;
  }
}
