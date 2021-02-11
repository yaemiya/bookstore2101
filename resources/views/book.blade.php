@extends('layouts.app')

@section('content')
@if(!empty($flash_msg))
<div class="container bg-light">
    <div class="alert alert-info text-center">
        {{ $flash_msg }}
    </div>
    @else
    <div class="container bg-light pt-5">
        @endif
        <div class="card p-5">
            <div class="row mb-10">
                <div class="col-md-1"></div>
                <div class="col-md-4 border d-flex align-items-center justify-content-center bg-secondary">
                    <p class="display-4 text-center font-italic text-white">image</p>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="card-body pb-0">
                        @if(!empty($name))
                        <h3 class="card-title">{{ $name }}</h3>
                        @else
                        <h3 class="card-title">{{ $book->name }}</h3>
                        @endif
                        <br>
                        @if(!empty($genre))
                        <p class="card-text">ジャンル　：　{{ $genre }}</p>
                        @else
                        <p class="card-text">ジャンル　：　{{ $book->genre }}</p>
                        @endif

                        @if(!empty($ranking))
                        <p class="card-text">人気　　　：　{{ $ranking }}位</p>
                        @else
                        <p class="card-text">人気　　　：　{{ $book->ranking }}位</p>
                        @endif

                        @if(!empty($issue_date))
                        <p class="card-text">
                            出版　　　：　{{ DateTime::createFromFormat('Y-m-d H:i:s',$issue_date)->format('Y年n月') }}</p>
                        @else
                        <p class="card-text">出版　　　：　{{ $book->issue_date->format('Y年n月') }}</p>
                        @endif

                        @if(!empty($price))
                        <p class="card-text">価格　　　：　{{ floor($price * 1.1) }}円（本体{{ $price }}円+税）</p>
                        @else
                        <p class="card-text">価格　　　：　{{ floor($book->price * 1.1) }}円（本体{{ $book->price }}円+税）</p>
                        @endif
                        <br>
                        <br>
                        <div class="cart_btn mb-3">
                            @unless (Session::has('cart_store'))
                            <form method="post" action="{{ route('cart_store') }}">
                                @csrf
                                <input type="hidden" name="name" value="{{ $book->name }}">
                                <input type="hidden" name="issue_date" value="{{ $book->issue_date }}">
                                <input type="hidden" name="ranking" value="{{ $book->ranking }}">
                                <input type="hidden" name="price" value="{{ $book->price }}">
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button
                                    class="btn btn-block btn-primary d-flex align-items-center justify-content-center"
                                    type="submit"><i class="fas fa-shopping-cart"></i>　カートに入れる</button>
                            </form>
                            @else
                            {{-- <form action="cart"> --}}
                            <a class="btn btn-block btn-success d-flex align-items-center justify-content-center"
                                {{-- href="cart"  --}} href="{{ url('cart')}}" <i
                                class="fas fa-shopping-cart"></i>　　カートを見る
                            </a>
                            {{-- </form> --}}
                            @endunless
                        </div>
                        <a class="btn btn-block btn-secondary justify-content-center"
                            href="{{ url()->previous() }}">前画面にもどる</a>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row pb-10">
                <div class="col-md-1"></div>
                <p class="card-text">商品説明　：</p>
            </div>
            <br>
            <br>
            <br>
        </div>
    </div>
    @endsection