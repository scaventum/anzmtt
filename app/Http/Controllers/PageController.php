<?php

namespace App\Http\Controllers;

use App\Repositories\MetaRepository;
use App\Repositories\NavigationRepository;
use App\Repositories\PageRepository;
use Inertia\Inertia;

class PageController extends Controller
{
    protected PageRepository $pageRepository;

    protected NavigationRepository $navigationRepository;

    protected MetaRepository $metaRepository;

    public function __construct(
        PageRepository $pageRepository,
        NavigationRepository $navigationRepository,
        MetaRepository $metaRepository,
    ) {
        $this->pageRepository = $pageRepository;
        $this->navigationRepository = $navigationRepository;
        $this->metaRepository = $metaRepository;
    }

    public function show()
    {
        $path = request()->path();

        // Get navigation items
        $navigationItems = $this->navigationRepository->getItems();

        // Find page data by slug
        $pageData = $this->pageRepository->findBySlug($path);

        // Compose meta data by page data
        $meta = $this->metaRepository->composeByPageData($pageData);

        return Inertia::render('Page', [
            'meta' => $meta,
            'data' => $pageData,
            'navigationItems' => $navigationItems,
        ]);
    }
}
