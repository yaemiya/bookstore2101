@extends('layouts.auth')

@section('content')
<div class="container">
    <h4 class="text-center">アカウント情報編集</h4>
    <br>
    <br>
    <form method="POST" action="{{ action('UserController@update') }}">
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
                                    @if(!empty($name)) value="{{ old('name', $name) }}" @endif autocomplete="name"
                                    autofocus placeholder="必須">

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
                                    name="email" @if(!empty($email)) value="{{ old('email', $email) }}" @endif
                                    autocomplete="email" autofocus placeholder="必須">

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
                                    @if(!empty($password)) value="{{ old('password', $password) }}" @endif
                                    placeholder="必須">

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
                                <label for="password_confirm" class="col-form-label">{{ __('パスワード確認') }}</label>

                                <input id="password_confirmation" type="password" class="form-control"
                                    name="password_confirmation" @if(!empty($password_confirm))
                                    value="{{ old('password_confirm', $password_confirm) }}" @endif placeholder="必須">

                                @error('password_confirm')
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
                    <div class="card-header">{{ __('お届け先情報') }}</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="postal_code" class="col-form-label">{{ __('郵便番号') }}</label>
                                <input id="postal_code" type="text"
                                    class="form-control @error('postal_code') is-invalid @enderror" name="postal_code"
                                    @if(!empty($postal_code)) value="{{ old('postal_code', $postal_code) }}" @endif
                                    maxlength="7" autocomplete=" postal_code" autofocus placeholder="半角数字、ハイフンなし"
                                    onKeyUp="AjaxZip3.zip2addr(this,'','region','address');">

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
                                <select name="region" class="form-control" id="region">
                                    <option value="">-- 選択してください --</option>
                                    @foreach(config('prefs') as $pref)
                                    @if (!empty($region) && old('region', $region) === $pref)
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
                                <input id="address" type="text"
                                    class="form-control @error('address') is-invalid @enderror" name="address"
                                    @if(!empty($address)) value="{{ old('address', $address) }}" @endif
                                    autocomplete="address">

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
                                    @if(!empty($building)) value="{{ old('building', $building) }}" @endif
                                    autocomplete="building">

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

                                <input id="tel" type="string" class="form-control @error('tel') is-invalid @enderror"
                                    name="tel" @if(!empty($tel)) value="{{ old('tel', $tel) }}" @endif
                                    autocomplete="tel" placeholder="半角数字10桁または11桁、ハイフンなし" maxlength="11">

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
                    onclick="return confirm('アカウントを更新します。よろしいですか？');">
                    {{ __('変更完了') }}
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
</div>
@endsection