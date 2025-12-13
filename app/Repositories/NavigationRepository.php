<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

class NavigationRepository
{
  // @temp: get items from actual CMS
  private const ITEMS = [
    [
      'label' => 'About',
      'path' => 'about',
      'submenu' => [
        [
          'label' => 'Executive Committee',
          'path' => 'about/executive-committee',
        ],
        [
          'label' => 'Advisory Board',
          'path' => 'about/advisory-board',
        ],
        [
          'label' => 'F.A.Q',
          'path' => 'about/faq',
        ],
      ],
    ],
    [
      'label' => 'Announcements',
      'path' => 'announcements',
      'submenu' => [
        [
          'label' => 'Call For Papers',
          'path' => 'announcements/call-for-papers',
        ],
        [
          'label' => 'News',
          'path' => 'announcements/news',
        ],
        [
          'label' => 'Upcoming Events',
          'path' => 'announcements/events',
        ],
      ],
    ],
    [
      'label' => 'Research & Networks',
      'path' => 'research-networks',
      'submenu' => [
        [
          'label' => 'About',
          'path' => 'research-networks/about'
        ],
        [
          'label' => 'Team / Governance',
          'path' => 'research-networks/team'
        ],
        [
          'label' => 'Initiatives',
          'path' => 'research-networks/initiatives'
        ],
        [
          'label' => 'Member Directory',
          'path' => 'research-networks/member-directory',
        ],
        [
          'label' => 'Member Area',
          'path' => 'research-networks/member-area'
        ],
        [
          'label' => 'Resources / Outputs',
          'path' => 'research-networks/resources',
        ],
      ],
    ],
    [
      'label' => 'Conferences',
      'path' => 'conferences',
      'submenu' => [
        [
          'label' => 'MAP 1 (2025)',
          'path' => 'conferences/map-1-2025'
        ],
        [
          'label' => 'MAP 2 (2026)',
          'path' => 'conferences/map-2-2026'
        ],
        [
          'label' => 'MAP 3 (2027)',
          'path' => 'conferences/map-3-2027'
        ],
      ],
    ],
  ];

  public function getItems(): array
  {
    // @temp: get items from actual CMS
    return static::ITEMS;
  }

  public function composeBreadcrumbBySlug(string $slug): Collection
  {
    $breadcrumbs = collect();

    // Exit early on home
    if ($slug === '/') {
      return $breadcrumbs;
    }

    // Separate slug by segments
    $segments = explode('/', $slug);

    $currentSlug = '';

    foreach ($segments as $segment) {
      // Join current segment with previous segment
      $currentSlug .= $segment ? "/{$segment}" : '';

      // Human readable breadcrumb label
      $label = $segment ? ucwords(str_replace('-', ' ', $segment)) : 'Home';

      // Skip current page from being a link
      $isLast = $currentSlug === "/{$slug}";

      // add breadcrumb to collection
      $breadcrumbs->add((object)[
        'label' => $label,
        'href' => $isLast ? null : $currentSlug ??  '/',
      ]);
    }

    return $breadcrumbs;
  }
}
