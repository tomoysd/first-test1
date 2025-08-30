<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password; 

class RegisterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'                  => ['required','string','max:255'],
            'email'                 => ['required','string','email','max:255','unique:users,email'],
            'password'              => ['required','confirmed', Password::defaults()], // ←OK
            'password_confirmation' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                  => 'お名前を入力してください。',
            'email.required'                 => 'メールアドレスを入力してください。',
            'email.email'                    => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください。',
            'email.unique'                   => 'このメールアドレスは既に登録されています。',
            'password.required'              => 'パスワードを入力してください。',
            'password.confirmed'             => 'passwordとpassword確認が一致しません。',
            'password_confirmation.required' => 'パスワード確認を入力してください。',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'お名前',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード確認',
        ];
    }
}
