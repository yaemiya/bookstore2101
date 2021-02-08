@extends('layouts.app')

@section('content')
{{-- 小計が0なら（カートテーブル内の商品が0なら）  --}}
@if($sub_total === 0)
<div class="container bg-light mt-5 mb-5">
    <h2 class="text-center">カートには商品が入っていません</h2>
    <br>
    <div class="text-center">
        <button class="btn btn-lg btn-secondary p-2 mt-5" type="submit" onclick="history.back()">前画面にもどる</button>
    </div>
</div>

{{-- カートに商品があるなら  --}}
@else
@if(!empty($flash_msg))
<div class="container bg-light">
    <div class="alert alert-info text-center">
        {{ $flash_msg }}
    </div>
    @else
    <div class="container bg-light pt-5">
        <div class="border cart_container">
            @endif
            <h3 class="text-center mt-5 mb-5">カート</h3>
            <div class="table-responsive">
                <table class="table table-bordered border-secondary responsive table-hover bg-light">
                    <thead class="text-center">
                        <th class="align-middle">商品名</th>
                        <th class="align-middle">数量</th>
                        <th class="align-middle">価格<br>（税抜）</th>
                        <th class="align-middle">小計<br>（税抜）</th>
                        <th></th>
                    </thead>
                    <tbody class="text-center">
                        @foreach($carts as $cart)
                        <tr>
                            <td class="align-middle">
                                <a class="carts" href="{{ $cart->book_id }}">{{ $cart->name }}</a>
                            </td>
                            <td class="align-middle">
                                <input type="number" form="quantity" class="text-center quantity" name="quantity[]"
                                    value="{{ $cart->quantity }}">
                                <input type="hidden" form="quantity" name="id[]" value="{{ $cart->id }}">
                            </td>
                            <td class="align-middle">{{ floor($cart->price) }}円</td>
                            <td class="align-middle">{{ floor($cart->price * $cart->quantity) }}円
                            </td>
                            <td>
                                <form method="post" action="{{ route('delete', $cart->id)}}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">削除する</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tbody class="total_area text-center">
                        <tr class="nohover">
                            <td class="border-0 nohover"></td>
                            <td class="border-0 nohover"></td>
                            <td class="border-0 nohover"></td>
                            <td class="border-0 nohover"></td>
                            <td class="border-0 nohover"></td>
                        </tr>
                        <tr class="nohover">
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0 align-middle">小計<br>（税抜）</td>
                            <td class="border-0 align-middle">{{ $sub_total }}円</td>
                        </tr>
                        <tr class="nohover">
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0">消費税</td>
                            <td class="border-0">{{ floor($sub_total * 0.1) }}円</td>
                        <tr class="nohover">
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0 total">合計</td>
                            <td class="border-0 total">{{ floor($sub_total * 1.1) }}円</td>
                        </tr>
                        <tr>
                            <td class="border-0 nohover"></td>
                            <td class="border-0 nohover"></td>
                            <td class="border-0 nohover"></td>
                            <td class="border-0 nohover"></td>
                            <td class="border-0 nohover">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="border-0 nohover text-center">
                                ※ 数量変更後に再計算ボタンを押してください
                            </td>
                            <td class="border-0 text-center">
                                <form method="POST" id="quantity">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success"
                                        formaction="{{ route('update')}}">再計算する</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="text-center mt-5">
                    <button class="btn-block btn-lg btn-primary d-flex align-items-center justify-content-center p-3"
                        type="submit" formaction="{{ route('address_edit')}}">ご注文の手続きに進む</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endsection