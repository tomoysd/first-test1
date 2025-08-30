<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'last_name'   => ['required', 'string', 'max:50'],
            'first_name'  => ['required', 'string', 'max:50'],

            // 性別は 1/2/3 で送る（男/女/その他）
            'gender'      => ['required', 'in:1,2,3'],

            'email'       => ['required', 'email'],

            // 電話番号は 10〜11 桁の数字のみ（ハイフン無し）
            'tel'         => ['required', 'regex:/^\d{10,11}$/'],

            'address'     => ['required', 'string', 'max:255'],
            'building'    => ['nullable', 'string', 'max:255'],

            // カテゴリは categories テーブルの id（数値）で来る
            'category_id' => ['required', 'exists:categories,id'],

            // テキストエリアは detail
            'detail'      => ['required', 'string', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'last_name.required'   => '姓を入力してください。',
            'first_name.required'  => '名を入力してください。',
            'gender.required'      => '性別を選択してください。',
            'gender.in'            => '性別の選択が不正です。',
            'email.required'       => 'メールアドレスを入力してください。',
            'email.email'          => 'メールアドレスはメール形式で入力してください。',
            'tel.required'         => '電話番号を入力してください。',
            'tel.regex'            => '電話番号は10〜11桁の数字で入力してください（ハイフンなし）。',
            'address.required'     => '住所を入力してください。',
            'category_id.required' => 'お問い合わせの種類を選択してください。',
            'category_id.exists'   => 'お問い合わせの種類の選択が不正です。',
            'detail.required'      => 'お問い合わせ内容を入力してください。',
            'detail.max'           => 'お問い合わせ内容は120文字以内で入力してください。',
        ];
    }

    public function attributes(): array
    {
        return [
            'last_name'   => '姓',
            'first_name'  => '名',
            'gender'      => '性別',
            'email'       => 'メールアドレス',
            'tel'         => '電話番号',
            'address'     => '住所',
            'building'    => '建物名',
            'category_id' => 'お問い合わせの種類',
            'detail'      => 'お問い合わせ内容',
        ];
    }
}