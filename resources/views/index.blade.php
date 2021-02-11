@extends('layouts.app')

@section('content')
<div class="container bg-light">
    <br>
    @if($books->isEmpty())
    <br>
    <h4 class="text-center">該当商品がありません</h4>
    @else
    <div class="text-right order">
        <a href="ranking_order">人気順</a>
        ／
        <a href="issue_date_order">新着順</a>
        ／
        <a href="price_order">価格の安い順</a>
    </div>
    <br>
    <div class="row justify-content-left">
        @foreach ($books as $book)
        <div class="col-md-3 mb-3">
            <div class="card">
                <a href="book/{{ $book->id }}" class="book-card">
                    {{-- <a href="{{ route('book_detail', ['id' => $book->id]) }}" class="book-card"> --}}
                    <div class="card-body text-center">
                        <h5>{{ $book->name }}</h5>
                        <br>
                        <p class="text-left">
                            ジャンル　：　{{ $book->genre }}<br>
                            人気　　　：　{{ $book->ranking }}位<br>
                            出版　　　：　{{ $book->issue_date->format('Y年n月') }}<br>
                            価格　　　：　{{ $book->price }}円
                        </p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <br>
    <br>
    <div class="d-flex justify-content-center">
        {{ $books->appends(['keywords' => $keywords, 'genre' => $genre])->links() }}
    </div>
    @endif
</div>
@endsection