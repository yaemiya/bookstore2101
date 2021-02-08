@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4>{{ __('BOOKSTOREにログイン') }}</h4>
                </div>
                <br>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="email" class="col-form-label">{{ __('メールアドレス') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <label for="password" class="col-form-label">{{ __('パスワード') }}</label>

                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('ログイン') }}
                                </button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('次回から自動でログインする') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="text-right">
                                <a href="login/google" type="button" class="btn btn-success">
                                    {{ __('Googleでログイン') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <a href="register">無料会員登録はこちら</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection