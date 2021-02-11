@extends('layouts.auth')

@section('content')
<div class="container">
    <h4 class="text-center">アカウント削除</h4>
    <br>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('アカウント情報') }}</div>

                <div class="card-body">
                    <table class="table table-bordered border-secondary responsive confirm">
                        <tbody>
                            <tr>
                                <td>お名前</td>
                                <td>@if(!empty($name)){{ $name }} @endif</td>
                            </tr>
                            <tr>
                                <td>メールアドレス</td>
                                <td>@if(!empty($email)){{ $email }} @endif</td>
                            </tr>
                            <tr>
                                <td>郵便番号</td>
                                <td>@if(!empty($postal_code)){{ $postal_code }} @endif</td>
                            </tr>
                            <tr>
                                <td>都道府県</td>
                                <td>@if(!empty($region)){{ $region }} @endif</td>
                            </tr>
                            <tr>
                                <td>住所</td>
                                <td>@if(!empty($address)){{ $address }} @endif</td>
                            </tr>
                            <tr>
                                <td>建物</td>
                                <td>@if(!empty($building)){{ $building }} @endif</td>
                            </tr>
                            <tr>
                                <td>電話番号</td>
                                <td>@if(!empty($tel)){{ $tel }} @endif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('auth_destroy') }}" class="btn btn-danger btn-block btn-lg"
                onclick="return confirm('アカウントを削除します。よろしいですか？');">
                {{ __('削除する') }}
            </a>
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