<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Page;
use App\People;
use App\Service;
use App\Portfolio;

class IndexController extends Controller
{
    //
    public function execute(Request $request)
    {
        $pages = Page::all();
        $portfolios = Portfolio::get(['name', 'filter', 'images']);
//        $portfolios = Portfolio::all();
        $services = Service::where('id', '<', '20');
//        $services = Service::all();
        $peoples = People::take(3)->get();
//        $peoples = People::all();

//        dd($peoples);

        $menu = [];
        foreach ($pages as $page) {
            $item = ['title' => $page->name,'alias' => $page->alias];
            array_push($menu, $item);
        }

        $item = ['title' => 'Services', 'alias' => 'service'];
        array_push($menu, $item);

        $item = ['title' => 'Portfolio', 'alias' => 'Portfolio'];
        array_push($menu, $item);

        $item = ['title' => 'Team', 'alias' => 'team'];
        array_push($menu, $item);

        $item = ['title' => 'Contact', 'alias' => 'contact'];
        array_push($menu, $item);

        return view('site.index', [
            'menu' => $menu,
            'pages' => $pages,
            'services' => $services,
            'portfolios' => $peoples
        ]);
    }
}
