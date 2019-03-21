<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use App\Page;

class PagesAddController extends Controller
{
    public function execute(Request $request)
    {

        if ($request->isMethod('post')) {
            // всі дані запиту, виключаючи токен
            $input = $request->except('_token');

            // користувацькі повідомлення про помилки
            $messages = [
                'required' => 'Поле :attribute обов\'язкове до заповнення',
                'unique' => 'Поле :attribute повинне бути унікальне'
            ];

            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'alias' => 'required|unique:pages|max:255',
                'text' => 'required'
            ], $messages);

            if ($validator->fails()) {
                return redirect()->route('pagesAdd')->withErrors($validator)->withInput();
            }

            if ($request->hasFile('images')) {
                // отримаємо екземпляр об'єкту Uploaded File
                $file = $request->file('images');

                $input['images'] = $file->getClientOriginalName();

                $file->move(public_path().'/assets/img', $input['images']);
            }

            // збереження інформації в БД
            $page = new Page();

            // дозволяє заповнення будь-якого поля моделі
//            $page->unguard();

            // заповнює поля моделі даними, які зберігаються у вигляді масиву
            $page->fill($input);

            if ($page->save()) {
                return redirect('admin')->with('status', 'сторінка додана');
            }
        }

        if (view()->exists('admin.pages_add')) {

            $data = [
                'title' => 'Нова сторінка',
            ];

            return view('admin.pages_add', $data);
        }

        abort(404);
    }
}
