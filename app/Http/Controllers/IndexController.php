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

        return view('site.index');
    }
}
