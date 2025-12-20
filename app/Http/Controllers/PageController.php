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
        $slug = request()->path();

        // Get navigation items
        $navigationItems = $this->navigationRepository->getItems();

        // Compose breadcrumbs by slug
        $breadcrumbs = $this->navigationRepository->composeBreadcrumbBySlug($slug);

        // Get page data by slug
        $pageData = $this->pageRepository->getPageDataBySlug($slug);

        // Compose meta data by page data
        $meta = $this->metaRepository->composeByPageData($pageData);

        // Hide breadcrumbs if page not found
        $showBreadcrumbs = $this->pageRepository->checkPageFoundBySlug($slug);

        // Get news pages
        $newsPages = $this->pageRepository->getNewsPages();

        return Inertia::render('Page', [
            'meta' => $meta,
            'data' => $pageData,
            'navigationItems' => $navigationItems,
            'breadcrumbs' => $breadcrumbs,
            'showBreadcrumbs' => $showBreadcrumbs,
            'newsPages' => $newsPages,
        ]);
    }
}
