<?php

namespace App\Http\Controllers;

use App\Repositories\MemberRepository;
use App\Repositories\MetaRepository;
use App\Repositories\NavigationRepository;
use App\Repositories\PageRepository;
use Inertia\Inertia;

class PageController extends Controller
{
    protected PageRepository $pageRepository;

    protected NavigationRepository $navigationRepository;

    protected MetaRepository $metaRepository;

    protected MemberRepository $memberRepository;

    public function __construct(
        PageRepository $pageRepository,
        NavigationRepository $navigationRepository,
        MetaRepository $metaRepository,
        MemberRepository $memberRepository,
    ) {
        $this->pageRepository = $pageRepository;
        $this->navigationRepository = $navigationRepository;
        $this->metaRepository = $metaRepository;
        $this->memberRepository = $memberRepository;
    }

    public function show()
    {
        $slug = request()->slug ?? 'home';

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

        // Hide headers on home
        $showHeaders = $slug !== '/';

        // Get news pages
        $newsPages = $this->pageRepository->getNewsPages();

        // Get conferences pages
        $conferencesPages = $this->pageRepository->getConferencesPages();

        // Get executive commitee members
        $executiveCommitteeMembers = $this->memberRepository->getExecutiveCommittee();

        // Get executive commitee members
        $advisoryBoardMembers = $this->memberRepository->getAdvisoryBoard();

        // Get executive commitee members
        $members = $this->memberRepository->getAll();

        return Inertia::render('Page', [
            'meta' => $meta,
            'data' => $pageData,
            'navigationItems' => $navigationItems,
            'breadcrumbs' => $breadcrumbs,
            'showHeaders' => $showHeaders,
            'showBreadcrumbs' => $showBreadcrumbs,
            'newsPages' => $newsPages,
            'conferencesPages' => $conferencesPages,
            'executiveCommitteeMembers' => $executiveCommitteeMembers,
            'advisoryBoardMembers' => $advisoryBoardMembers,
            'members' => $members,
            'preview' => false,
        ]);
    }

    public function preview()
    {
        $slug = request()->slug ?? 'home';

        // Get navigation items
        $navigationItems = $this->navigationRepository->getItems();

        // Compose breadcrumbs by slug
        $breadcrumbs = $this->navigationRepository->composeBreadcrumbBySlug($slug);

        // Get page data by slug
        $pageData = $this->pageRepository->getPageDataBySlug($slug, false);

        // Compose meta data by page data
        $meta = $this->metaRepository->composeByPageData($pageData);

        // Hide breadcrumbs if page not found
        $showBreadcrumbs = $this->pageRepository->checkPageFoundBySlug($slug, false);

        // Hide headers on home
        $showHeaders = $slug !== '/';

        // Get news pages
        $newsPages = $this->pageRepository->getNewsPages(published: false);

        // Get conferences pages
        $conferencesPages = $this->pageRepository->getConferencesPages(published: false);

        // Get executive commitee members
        $executiveCommitteeMembers = $this->memberRepository->getExecutiveCommittee();

        // Get executive commitee members
        $advisoryBoardMembers = $this->memberRepository->getAdvisoryBoard();

        // Get executive commitee members
        $members = $this->memberRepository->getAll();

        return Inertia::render('Page', [
            'meta' => $meta,
            'data' => $pageData,
            'navigationItems' => $navigationItems,
            'breadcrumbs' => $breadcrumbs,
            'showHeaders' => $showHeaders,
            'showBreadcrumbs' => $showBreadcrumbs,
            'newsPages' => $newsPages,
            'conferencesPages' => $conferencesPages,
            'executiveCommitteeMembers' => $executiveCommitteeMembers,
            'advisoryBoardMembers' => $advisoryBoardMembers,
            'members' => $members,
            'preview' => true,
        ]);
    }
}
