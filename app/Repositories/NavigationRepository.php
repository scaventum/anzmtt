<?php

namespace App\Repositories;

use App\Models\NavigationItem;
use Illuminate\Support\Collection;

class NavigationRepository
{
  /**
   * Get all navigation items as a hierarchical array
   */
  public function getItems(): array
  {
    // Get top-level items sorted by sort_order, with children eager loaded
    $items = NavigationItem::with(['page', 'children.page'])
      ->whereNull('parent_id')
      ->orderBy('sort_order')
      ->get();

    // Convert to nested array
    return $items->map(function ($item) {
      return $this->formatItem($item);
    })->toArray();
  }

  /**
   * Recursive helper to format a NavigationItem
   */
  private function formatItem(NavigationItem $item): array
  {
    $array = [
      'label' => $item->page?->title ?? 'Untitled',
      'path' => $item->page?->slug ?? '#', // assuming your Page model has a slug
    ];

    // Include children if they exist
    if ($item->children->isNotEmpty()) {
      $array['submenu'] = $item->children->map(function ($child) {
        return $this->formatItem($child);
      })->toArray();
    }

    return $array;
  }

  /**
   * Compose breadcrumbs by slug
   */
  public function composeBreadcrumbBySlug(string $slug): Collection
  {
    $breadcrumbs = collect();

    // Exit early on home
    if ($slug === '/') {
      return $breadcrumbs;
    }

    // Split slug into segments
    $segments = explode('/', $slug);

    $currentSlug = '';

    foreach ($segments as $segment) {
      $currentSlug .= $segment ? "/{$segment}" : '';

      $label = $segment ? ucwords(str_replace('-', ' ', $segment)) : 'Home';
      $isLast = $currentSlug === "/{$slug}";

      $breadcrumbs->add((object)[
        'label' => $label,
        'href' => $isLast ? null : $currentSlug ?? '/',
      ]);
    }

    return $breadcrumbs;
  }
}
