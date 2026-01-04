<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
  protected $fillable = [
    'page_id',
    'parent_id',
    'sort_order',
  ];

  protected static function booted()
  {
    static::creating(function ($item) {
      if (is_null($item->sort_order)) {
        // Determine the parent id
        $parentId = $item->parent_id;

        // Find the max sort_order among siblings (or top-level items if no parent)
        $maxSort = self::where('parent_id', $parentId)->max('sort_order');

        // Assign next integer
        $item->sort_order = $maxSort ? $maxSort + 1 : 1;
      }
    });
  }

  // Each navigation item belongs to a Page
  public function page()
  {
    return $this->belongsTo(Page::class);
  }

  // Self-referencing hierarchy
  public function parent()
  {
    return $this->belongsTo(self::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(self::class, 'parent_id')
      ->orderBy('sort_order');
  }
}
