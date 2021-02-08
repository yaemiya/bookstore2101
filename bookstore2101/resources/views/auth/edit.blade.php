@extends('layouts.auth')

@section('content')
<div class="container">
    <h4 class="text-center">アカウント情報編集</h4>
    <br>
    <br>
    <div class="cart-container">
        <form method="POST" action="{{ action('UserController@update') }}">
            @csrf
            <div class="form-group row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <label for="name" class="col-form-label">お名前</label>
                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="name"
                        @if(!empty($name)) value="{{ $name }}" @endif autocomplete="namepostal_code" autofocus
                        placeholder="必須">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <label for="email" class="col-form-label">メールアドレス</label>
                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="email"
                        @if(!empty($email)) value="{{ $email }}" @endif autocomplete="email" autofocus placeholder="必須">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <label for="postal_code" class="col-form-label">{{ __('郵便番号') }}</label>
                    <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror"
                        name="postal_code" @if(!empty($postal_code)) value="{{ $postal_code }}" @endif maxlength="8"
                        autocomplete=" postal_code" autofocus placeholder="必須、ハイフン任意"
                        onKeyUp="AjaxZip3.zip2addr(this,'','region','address');">

                    {{-- @error('region')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                    </span>
                    @enderror --}}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <label for="region" class="col-form-label">{{ __('都道府県') }}</label>
                    <select name="region" class="form-control">
                        <option value="">-- 選択してください --</option>
                        @foreach(config('prefs') as $pref)
                        @if (!empty($region) && $region === $pref)
                        <option value="{{ $pref }}" selected="selected">{{ $pref }}</option>
                        @else
                        <option value="{{ $pref }}">{{ $pref }}</option>
                        @endif
                        @endforeach
                    </select>

                    @error('region')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <label for="address" class="col-form-label">住所</label>

                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                        name="address" @if(!empty($address)) value="{{ $address }}" @endif autocomplete="address"
                        placeholder="必須">

                    {{-- @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror --}}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <label for="building" class="col-form-label">建物</label>

                    <input id="building" type="text" class="form-control @error('building') is-invalid @enderror"
                        name="building" @if(!empty($building)) value="{{ $building }}" @endif autocomplete="building"
                        placeholder="任意">

                    {{-- @error('building')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                    </span>
                    @enderror --}}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <label for="tel" class="col-form-label">{{ __('電話番号') }}</label>

                    <input id="tel" type="tel" class="form-control" name="tel" @if(!empty($tel)) value="{{ $tel }}"
                        @endif autocomplete=" tel" placeholder="必須、半角数字10桁または11桁（ハイフンなし）">
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        {{ __('変更完了') }}
                    </button>
                </div>
            </div>
        </form>
        <br>
        <br>
        <form method="POST" action="">
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-2 text-right">
                    <button type="submit" class="btn btn-success">
                        {{ __('Googleで登録') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection