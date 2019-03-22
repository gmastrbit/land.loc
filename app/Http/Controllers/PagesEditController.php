<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;

class PagesEditController extends Controller
{
    // dependency injection - впровадження залежностей
//    public function execute($id)
    public function execute(Page $page, Request $request)
    {
//        $page = Page::find($id);
//        dd($page);

        $old = $page->toArray();

        if (view()->exists('admin.pages_edit')) {
            $data = [
                'title' => 'Редагування сторінки '.$old['name'],
                'data' => $old
            ];

            return view('admin.pages_edit', $data);
        }
    }
}
