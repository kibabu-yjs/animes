<?php

namespace App\Http\Controllers;

use App\Models\PageBuilder;
use Illuminate\Routing\Controller;
use Threls\FilamentPageBuilder\Models\Page;
use Threls\FilamentPageBuilder\Data\PageData;

class HomeController extends Controller{
    public function filamentPageBuilder($slug) {
        $page = PageBuilder::where('slug', $slug)->first();

        return view('home-test', ['page' => $page]);
    }
}