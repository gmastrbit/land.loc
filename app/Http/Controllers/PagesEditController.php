<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;
use Validator;

class PagesEditController extends Controller
{
    // dependency injection - впровадження залежностей
//    public function execute($id)
    public function execute(Page $page, Request $request)
    {
//        $page = Page::find($id);
//        dd($page);

        if ($request->isMethod('delete')) {
            $page->delete();
            return redirect('admin')->with('status', 'сторінка видалена');
        }

        if ($request->isMethod('post')) {
            // отримаємо всі дані із request крім токена
            $input = $request->except('_token');

            // зберігаємо об'єкт класу Валідатор
            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'alias' => 'required|max:255|unique:pages,alias,'.$input['id'],
                'text' => 'required'
            ]);

            // перевірка валідації
            if ($validator->fails()) {
                return redirect()->route('pagesEdit', ['page' => $input['id']])->withErrors($validator);
            }

            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $file->move(public_path().'/assets/img',$file->getClientOriginalName());
                $input['images'] = $file->getClientOriginalName();
            } else {
                // якщо файл не вибраний і не відправлений
                $input['images'] = $input['old_images'];
            }

            unset($input['old_images']);

            // заповнення
            $page->fill($input);

            if ($page->update()) {
                return redirect('admin')->with('status', 'сторінка оновлена');
            }
        }


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
