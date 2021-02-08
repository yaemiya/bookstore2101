@extends('layouts.app')

@section('content')

{{ $name }}様

BOOKSTOREをご利用いただきまして誠にありがとうございます。
下記の内容をご確認ください。

注文内容
注文日：{{ $order_date }}
注文完了商品：
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

 発送手配が整い次第、別途メールにてご連絡いたします。

WEB：https://bookstore2101.herokuapp.com/

@endsection