<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use Mail;
use App\Page;
use App\People;
use App\Service;
use App\Portfolio;

class IndexController extends Controller
{
    //
    public function execute(Request $request)
    {

        $messages = [
            'required' => 'Поле :attribute обов\'язкове для заповнення',
            'email' => 'Поле :attribute повинне відповідати email-адресі',
        ];

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ], $messages);

            $data = $request->all();

            // відправка листа з параметрами
            $result = Mail::send('site.email', ['data' => $data], function($message) use ($data){
                $mail_admin = env('MAIL_ADMIN');

                $message->from($data['email'], $data['name']);

                $message->to($mail_admin, 'Mr. Admin')->subject('Question');
            });

            if ($result) {
                return redirect()->route('home')->with('status', 'email is send');
            }
        }

        $pages = Page::all();
        $portfolios = Portfolio::get(['name', 'filter', 'images']);
        $services = Service::all();
        $peoples = People::take(3)->get();

        // унікальна інформація без дублів
        $tags = DB::table('portfolios')->distinct()->lists('filter');
//        dd($tags);

        $menu = [];
        foreach ($pages as $page) {
            $item = ['title' => $page->name, 'alias' => $page->alias];
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
            'portfolios' => $portfolios,
            'tags' => $tags,
            'peoples' => $peoples
        ]);

    }
}
