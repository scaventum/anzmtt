<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository
{
  public function getPageDataBySlug(string $slug): object
  {
    // @temp: get items from actual CMS
    $page = Page::whereSlug($slug)->first();

    $pageData = $page?->toArray() ?? [
      'title' => 'Not found',
      'blocks' => [
        [
          'type' => 'error',
          'data' => [
            'body' => 'Sorry, the page you\'re looking for doesn\'t exist or under development.'
          ],
        ],
      ],
    ];

    return json_decode(json_encode($pageData));
  }

  public function checkPageFoundBySlug(string $slug): bool
  {
    return Page::whereSlug($slug)->exists();
  }
}
