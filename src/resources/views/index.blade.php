@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <h1 class="contact-form__heading">Contact</h1>

    <form method="POST" action="{{ url('/confirm') }}">
        @csrf

        {{-- お名前（姓・名で分ける） --}}
        <div class="form__group">
            <label class="form__label">
                お名前 <span class="form__label--required">※</span>
            </label>
            <div class="form__inputs-row">
                <div class="form__input--text form__input--half">
                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="例）山田">
                    <div class="form__error">
                        @error('last_name'){{ $message }}@enderror
                    </div>
                </div>
                <div class="form__input--text form__input--half">
                    <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="例）太郎">
                    <div class="form__error">
                        @error('first_name'){{ $message }}@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- 性別（デフォルトで男性を選択） --}}
        <div class="form__group">
            <label class="form__label">
                性別 <span class="form__label--required">※</span>
            </label>
            <div class="form__input--radios">
                @php $gender = old('gender', '1'); @endphp
                <label>
                <input type="radio" name="gender" value="1" {{ $gender == '1' ? 'checked' : '' }}> 男性
                </label>
                <label>
                <input type="radio" name="gender" value="2" {{ $gender == '2' ? 'checked' : '' }}> 女性
                </label>
                <label>
                <input type="radio" name="gender" value="3" {{ $gender == '3' ? 'checked' : '' }}> その他
                </label>

                <div class="form__error">
                    @error('gender'){{ $message }}@enderror
                </div>
            </div>
        </div>

        {{-- メールアドレス --}}
        <div class="form__group">
            <label class="form__label">
                メールアドレス <span class="form__label--required">※</span>
            </label>
            <div class="form__input--text">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="test@example.com">
                <div class="form__error">
                    @error('email'){{ $message }}@enderror
                </div>
            </div>
        </div>

        {{-- 電話番号 --}}
        <div class="form__group">
            <label class="form__label">電話番号 <span class="form__label--required">※</span></label>
                <div class="form__input--tel">
                    <input type="tel" name="tel1" value="{{ old('tel1') }}" placeholder="090"
                            class="tel tel-3" inputmode="numeric" pattern="\d*" maxlength="4">
                    <span class="hyphen">-</span>

                    <input type="tel" name="tel2" value="{{ old('tel2') }}" placeholder="1234"
                            class="tel tel-4" inputmode="numeric" pattern="\d*" maxlength="4">
                    <span class="hyphen">-</span>

                    <input type="tel" name="tel3" value="{{ old('tel3') }}" placeholder="5678"
                            class="tel tel-4" inputmode="numeric" pattern="\d*" maxlength="4">
                
                    @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
                        <div class="form__error">電話番号を入力してください。</div>
                    @endif
                    </div>
        </div>


        {{-- 住所 --}}
        <div class="form__group">
        <label class="form__label">住所 <span class="form__label--required">※</span></label>
        <div class="form__input--text">
            <input type="text" name="address" value="{{ old('address') }}" placeholder="例）東京都渋谷区〇〇">
            <div class="form__error">@error('address'){{ $message }}@enderror</div>
        </div>
        </div>

        {{-- 建物名 --}}
        <div class="form__group">
        <label class="form__label">建物名</label>
        <div class="form__input--text">
            <input type="text" name="building" value="{{ old('building') }}" placeholder="例）千代田マンション101">
            <div class="form__error">@error('building'){{ $message }}@enderror</div>
        </div>
        </div>


        {{-- お問い合わせの種類（デフォルトで「選択してください」） --}}
        <div class="form__group">
            <label class="form__label">
                お問い合わせの種類 <span class="form__label--required">※</span>
            </label>
            <div class="form__input--select">
                <select name="category_id" required>
                    <option value="">選択してください</option>
                    @foreach($categories as $id => $name)
                        <option value="{{ $id }}" @selected(old('category_id') == $id)>{{ $name }}</option>
                    @endforeach
                </select>
                <div class="form__error">
                    @error('category_id'){{ $message }}@enderror
                </div>
            </div>
        </div>

        {{-- お問い合わせ内容（120文字以内） --}}
        <div class="form__group">
            <label class="form__label">
                お問い合わせ内容 <span class="form__label--required">※</span>
            </label>
            <div class="form__input--textarea">
                <textarea name="detail" maxlength="120" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                @error('detail')<div class="form__error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection