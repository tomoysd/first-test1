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
        $inputs = $request->validated();
        $inputs['tel'] = implode('-', [$request->tel1, $request->tel2, $request->tel3]);
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
        $request->validate([
        'tel1' => ['required', 'digits_between:2,4', 'regex:/^[0-9]+$/'],
        'tel2' => ['required', 'digits_between:3,4', 'regex:/^[0-9]+$/'],
        'tel3' => ['required', 'digits:4', 'regex:/^[0-9]+$/'],
    ]);
        // バリデーション済みデータを取得
        $data = $request->validated();

        $data['tel'] = implode('-', [$request->tel1, $request->tel2, $request->tel3]);

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