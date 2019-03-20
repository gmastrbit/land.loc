<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PageAddController extends Controller
{
    public function execute(Request $request)
    {
        if (view()->exists('admin.pages_add')) {


            $data = [
                'title' => 'Нова сторінка',
            ];

            return view('admin.pages_add', $data);
        }

        abort(404);
    }
}
