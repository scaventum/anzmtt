<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository
{
  // @temp: get items from actual CMS
  const DATA = [
    '/' => [
      'title' => 'Home',
      'subtitle' => 'Aotearoa New Zealand Muslim Think Tank',
      'hero' => [
        'backgroundImage' => [
          'src' => null,
        ],
        'title' => 'MAP 1',
        'subtitle' => '1st Muslims in Asia-Pacific Conference 2025',
        'ctaLink' => [
          'href' => '/conferences/map-1-2025',
          'label' => 'Register'
        ]
      ],
      'blocks' => [
        [
          'type' => 'profile',
          'body' => 'ANZMTT profile here.'
        ]
      ],
    ],
    'about' => [
      'title' => 'About',
    ],
    'about/faq' => [
      'title' => 'FAQ',
      'subtitle' => 'Frequently Asked Questions',
    ],
    'conferences/map-1-2025' => [
      'title' => 'MAP 1 (2025)',
      'subtitle' => '1st Muslims in Asia-Pacific Conference 2025',
    ]
  ];

  public function getPageDataBySlug(string $slug): object
  {
    // @temp: get items from actual CMS
    $page = Page::whereSlug($slug)->first();

    $pageData = $page?->toArray() ?? [
      'title' => 'Not found',
      'blocks' => [
        [
          'type' => 'error',
          'body' => '404 - Not found'
        ],
      ],
    ];

    return json_decode(json_encode($pageData));
  }

  public function checkPageFoundBySlug(string $slug): bool
  {
    // @temp: get items from actual CMS
    return isset(static::DATA[$slug]);
  }
}
