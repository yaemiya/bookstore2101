@extends('layouts.app')

@section('content')
<div class="container bg-light pt-5">
    <div class="border cart_container">
        <h3 class="text-center mt-2 mb-5">ご注文確認</h3>
        <p class="h5">商品</p>
        <div class="table-responsive">
            <table class="table table-bordered border-secondary responsive bg-light confirm">
                <thead class="text-center">
                    <th class="align-middle">商品名</th>
                    <th class="align-middle">数量</th>
                    <th class="align-middle">価格<br>（税抜）</th>
                    <th class="align-middle">小計<br>（税抜）</th>
                </thead>
                <tbody class="text-center">
                    @foreach( $carts as $cart)
                    <tr>
                        <td class="align-middle">
                            {{ $cart->name }}
                        </td>
                        <td class="align-middle">
                            {{ $cart->quantity }}
                        </td>
                        <td class="align-middle">
                            {{ $cart->price }}円</td>
                        <td class="align-middle">
                            {{ $cart->price * $cart->quantity }}円
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody class="text-center table-bordered">
                    <tr class="nohover">
                        <td class="border-0 nohover"></td>
                        <td class="border-0 nohover"></td>
                        <td class="border-0 nohover"></td>
                        <td class="border-0 nohover"></td>
                    </tr>
                    <tr class="nohover">
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0 align-middle">小計<br>（税抜）</td>
                        <td class="border-0 align-middle">{{ $sub_total }}円</td>
                    </tr>
                    <tr class="nohover">
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0">消費税</td>
                        <td class="border-0">{{ floor($sub_total * 0.1) }}円</td>
                    <tr class="nohover">
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0 total">合計</td>
                        <td class="border-0 total">{{ floor($sub_total * 1.1) }}円</td>
                    </tr>
                </tbody>
            </table>
            <br><br>
            <div class="h5 mt-5">お届け先</div>
            <table class="table table-bordered border-secondary responsive confirm">
                <tbody>
                    <tr>
                        <td>お名前</td>
                        <td>{{ Session::get('ad_name') }}</td>
                    </tr>
                    <tr>
                        <td>メールアドレス</td>
                        <td>{{ Session::get('email') }}</td>
                    </tr>
                    <tr>
                        <td>郵便番号</td>
                        <td>{{ Session::get('postal_code') }}</td>
                    </tr>
                    <tr>
                        <td>都道府県</td>
                        <td>{{ Session::get('region') }}</td>
                    </tr>
                    <tr>
                        <td>住所</td>
                        <td>{{ Session::get('address') }}</td>
                    </tr>
                    <tr>
                        <td>建物</td>
                        <td>{{ Session::get('building') }}</td>
                    </tr>
                    <tr>
                        <td>電話番号</td>
                        <td>{{ Session::get('tel') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="text-center mt-5">
            <a class="btn btn-block btn-lg btn-primary d-flex align-items-center justify-content-center p-3"
                type="submit" href="checkout" onclick="return confirm('ご注文を確定します。よろしいですか？');">ご注文を確定する</a>
        </div>
        <div class="row">
            <div class="col-6 text-center mt-5">
                <a class="btn btn-block btn-secondary d-flex align-items-center justify-content-center p-3"
                    type="submit" href="cart">ご注文内容を修正する</a>
            </div>
            <div class="col-6 text-center mt-5">
                <button class="btn btn-block btn-secondary d-flex align-items-center justify-content-center p-3"
                    type="submit" onclick="history.back()">お届け先情報を修正する</button>
            </div>
        </div>
    </div>
</div>
@endsection