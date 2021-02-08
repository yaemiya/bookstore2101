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
                                <label for="name" class="col-form-label">{{ __('お名前（必須）') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                <label for="email" class="col-form-label">{{ __('メールアドレス（必須）') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <label for="password" class="col-form-label">{{ __('パスワード（必須）') }}</label>

                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

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
                                <label for="password-confirm" class="col-form-label">{{ __('パスワード確認（必須）') }}</label>

                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
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
                                    value="{{ old('postal_code') }}" autocomplete="postal_code" autofocus
                                    placeholder="半角英数字7桁">

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
                                <label for="region" class="col-form-label">{{ __('都道府県') }}</label>

                                <select class="form-control @error('region') is-invalid @enderror"
                                    value="{{ old('region') }}" autocomplete="region" autofocus>
                                    <option>Default select</option>
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
                                <label for="address" class="col-form-label">{{ __('住所') }}</label>

                                <input id="address" type="text"
                                    class="form-control @error('address') is-invalid @enderror" name="address"
                                    value="{{ old('address') }}" autocomplete="address">

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
                                <label for="building" class="col-form-label">{{ __('建物') }}</label>

                                <input id="building" type="text"
                                    class="form-control @error('building') is-invalid @enderror" name="building"
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

                                <input id="tel" type="tel" class="form-control" name="tel" autocomplete="tel"
                                    placeholder="半角数字10桁または11桁（ハイフンなし）">
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
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('新規登録') }}
                </button>
            </div>
        </div>
    </form>
    <br>
    <form method="POST" action="">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 text-right">
                <button type="submit" class="btn btn-success">
                    {{ __('Googleで登録') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection