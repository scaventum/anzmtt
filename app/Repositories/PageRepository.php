<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository
{
  // @temp: get items from actual CMS
  const DATA = [
    '/' => [
      'title' => 'Home',
      'sections' => [
        [
          'type' => 'hero',
          'backgroundImage' => [
            'src' => ''
          ],
          'title' => 'ANZMTT',
          'Subtitle' => 'Aotearoa New Zealand Muslim Think Tank',
          'ctaLink' => [
            'href' => '/about',
            'label' => 'About'
          ]
        ]
      ]
    ],
    'about' => [
      'title' => 'About',
    ],
    'about/faq' => [
      'title' => 'FAQ',
    ],
    'conferences/map-1-2025' => [
      'title' => 'MAP 1 (2025)',
    ]
  ];

  public function findBySlug(string $slug): object
  {
    // @temp: get items from actual CMS
    return json_decode(
      json_encode(static::DATA[$slug] ?? [
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
}
