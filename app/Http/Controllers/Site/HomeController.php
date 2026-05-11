<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\Public\HomePageService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(HomePageService $homePage): View
    {
        return view('site.home', $homePage->buildViewData());
    }
}
