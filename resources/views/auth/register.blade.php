@extends('layouts.auth')

@section('content')
<div class="container">
    <h4 class="text-center">アカウント新規登録</h4>
    <br>
    <br>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('会員情報') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="name" class="col-form-label">お名前</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    autocomplete="name" autofocus placeholder="必須" value="{{ old('name') }}">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="email" class="col-form-label">メールアドレス</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    name="email" autocomplete="email" autofocus placeholder="必須"
                                    value="{{ old('email') }}">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="password" class="col-form-label">{{ __('パスワード') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="必須" value="{{ old('password') }}" auto-complete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="password_confirmation" class="col-form-label">{{ __('パスワード確認') }}</label>
                                <input id="password_confirmation" type="password" class="form-control"
                                    name="password_confirmation" placeholder="必須" value="{{ old('password_confirm') }}"
                                    auto-complete="current-password">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('お届け先情報（ご注文時にも登録可能です）') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="postal_code" class="col-form-label">{{ __('郵便番号') }}</label>
                                <input id="postal_code" type="text"
                                    class="form-control @error('postal_code') is-invalid @enderror" name="postal_code"
                                    maxlength="7" autocomplete="postal_code" autofocus placeholder="半角数字7桁、ハイフンなし"
                                    onKeyUp="AjaxZip3.zip2addr(this,'','region','address');"
                                    value="{{ old('postal_code') }}">

                                @error('postal_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="region" class="col-form-label">{{ __('都道府県') }}</label>
                                <select name="region" class="form-control">
                                    <option value="">-- 選択してください --</option>
                                    @foreach(config('prefs') as $pref)
                                    <option value="{{ $pref }}" @if(old('region')==$pref) selected @endif>
                                        {{ $pref }}</option>
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

                                <input id="address" type="text"
                                    class="form-control @error('address') is-invalid @enderror" name="address"
                                    maxlength="100" autocomplete="address" value="{{ old('address') }}">

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="building" class="col-form-label">建物</label>

                                <input id="building" type="text"
                                    class="form-control @error('building') is-invalid @enderror" name="building"
                                    maxlength="100" autocomplete="building" value="{{ old('building') }}">

                                @error('building')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="tel" class="col-form-label">{{ __('電話番号') }}</label>

                                <input id="tel" type="tel" class="form-control @error('tel') is-invalid @enderror"
                                    name="tel" autocomplete="tel" maxlength="11" placeholder="半角数字10桁または11桁（ハイフンなし）"
                                    value="{{ old('tel') }}">

                                @error('tel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <button type="submit" class="btn btn-primary btn-block btn-lg"
                    onclick="return confirm('新規登録します。よろしいですか？');">
                    {{ __('新規登録') }}
                </button>
            </div>
        </div>
    </form>
    <div class="row mt-5">
        <div class="col-10 text-right">
            <a href="{{ route('index') }}" class="text-secondary">トップページにもどる</a>
        </div>
        <div class="col-2">
        </div>
    </div>
    <br>
    @endsection