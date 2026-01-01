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
