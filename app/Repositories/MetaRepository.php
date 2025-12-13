<?php

namespace App\Repositories;

use App\Models\Page;

class MetaRepository
{
  public function composeByPageData(object $pageData): object
  {
    $appName = config('app.name');

    // @temp: get page from actual CMS
    return json_decode(
      json_encode([
        'navTitle' => $appName,
        'navSubtitle' => 'Aotearoa New Zealand Muslim Think Tank',
        'title' => "{$appName} - {$pageData->title}",
      ])
    );
  }
}
