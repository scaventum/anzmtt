<?php

namespace App\Repositories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PageRepository
{
  public function getPageDataBySlug(string $slug, bool $published = true): object
  {
    $page = Page::with('conference')->slug($slug)->when($published, function (Builder $query) {
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

  public function getNewsPages(bool $published = true): Collection
  {
    $pages = Page::news()->when($published, function (Builder $query) {
      $query->published();
    })->orderByDesc('updated_at')->get();

    return $pages;
  }

  public function getConferencesPages(bool $published = true): Collection
  {
    $pages = Page::with('conference')->conferences()->when($published, function (Builder $query) {
      $query->published();
    })->orderByDesc('date_from')->get();

    // $pages = $pages->map(function (Page $page) {
    //   $page->upcoming = optional($page->conference)->upcoming;
    //   return $page;
    // })

    return $pages;
  }
}
