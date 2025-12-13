<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository
{
  // @temp: get items from actual CMS
  const DATA = [
    '/' => [
      'title' => 'ANZMTT',
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
      'sections' => [],
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
    return json_decode(
      json_encode($this->checkPageFoundBySlug($slug) ? static::DATA[$slug] : [
        'title' => 'Not found',
        'sections' => [
          [
            'type' => 'error',
            'message' => '404 - Not found'
          ]
        ]
      ])
    );
  }

  public function checkPageFoundBySlug(string $slug): bool
  {
    // @temp: get items from actual CMS
    return isset(static::DATA[$slug]);
  }
}
