<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    //
    public function index()
    {
        return view('index');
    }

    public function confirm(ContactRequest $request)
    {
        $inputs = $request->all();

        $map = Category::pluck('content','id')->toArray();
        $inputs['category_label'] = $map[$inputs['category_id']] ?? '';
        return view('confirm', compact('inputs'));
    }

    public function create(Request $request)
    {
        if ($request-> all()) $request->flash();
        $categories = Category::pluck('content', 'id');
        return view('index', compact('categories'));
    }

    public function send(ContactRequest $request)
    {
        // バリデーション済みデータを取得
        $data = $request->validated();

        // DB保存（Contactモデルに fillable を用意しておく）
        Contact::create($data);

        // 二重送信対策で old 入力を消す（任意）
        $request->session()->forget('_old_input');

        // サクセスページへ
        return redirect()->route('contact.thanks');
    }

    public function thanks()
    {
        return view('thanks');

    }
}