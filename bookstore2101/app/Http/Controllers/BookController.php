<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\User;
use App\Cart;
use Auth;
use DateTime;

class BookController extends Controller
{
    public function index()
    {
        $genre=null;
        $keywords=null;
        $books = Book::paginate(16);

        return view('index', ['books' => $books, 'genre' => $genre, 'keywords' => $keywords]);
    }


    // 本タブ実行時
    public function booksGenre(Request $request)
    {
        $genre='本';
        $keywords=null;
        $books = Book::where('genre', $genre)->paginate(16);

        //ジャンルを一時的にセッションに保存
        $request->session()->flash('genre', $genre);

        return view('index', ['books' => $books, 'genre' => $genre, 'keywords' => $keywords]);
    }
    

    // コミックタブ実行時
    public function comicsGenre(Request $request)
    {
        $genre='コミック';
        $keywords=null;
        $books = Book::where('genre', $genre)->paginate(16);

        //ジャンルを一時的にセッションに保存
        $request->session()->flash('genre', $genre);

        return view('index', ['books' => $books, 'genre' => $genre, 'keywords' => $keywords]);
    }
    

    // 雑誌タブ実行時
    public function magazinesGenre(Request $request)
    {
        $genre='雑誌';
        $keywords=null;
        $books = Book::where('genre', $genre)->paginate(16);

        //ジャンルを一時的にセッションに保存
        $request->session()->flash('genre', $genre);

        return view('index', ['books' => $books, 'genre' => $genre, 'keywords' => $keywords]);
    }
    

    // 洋書タブ実行時
    public function foreignBooksGenre(Request $request)
    {
        $genre='洋書';
        $keywords=null;
        $books = Book::where('genre', $genre)->paginate(16);

        //ジャンルを一時的にセッションに保存
        $request->session()->flash('genre', $genre);

        return view('index', ['books' => $books, 'genre' => $genre, 'keywords' => $keywords]);
    }
    

    // 人気順
    public function rankingOrder(Request $request)
    {
        $genre='すべて';
        $keywords=null;

        // 検索ワードの取得
        if ($request->session()->has('keyword_array')) {
            $keyword_array = $request->session()->get('keyword_array');
            // 検索ボックス再表示用
            $keywords = implode(" ", $keyword_array);
        }

        //ジャンルの取得
        if ($request->session()->has('genre')) {
            $genre = $request->session()->get('genre');
        }

        // セレクトボックスが「すべて」ではなく、検索キーワードが存在する場合
        if (!empty($keyword_array) && $genre !== 'すべて') {
            $query=Book::query();
            // 配列にキーワード条件を格納
            foreach ($keyword_array as $keyword) {
                // キーワード一つを変数に格納
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('price', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('issue_date', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('ranking', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('genre', 'LIKE', '%'.$keyword.'%');
                });
            }
            $query->where('genre', $genre);
            $books = $query->orderBy('ranking')->paginate(16);
        }

        // セレクトボックスが「すべて」で検索キーワードが存在する場合
        if (!empty($keyword_array) && $genre === 'すべて') {
            $query=Book::query();
            // 配列にキーワード条件を格納
            foreach ($keyword_array as $keyword) {
                // キーワード一つを変数に格納
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('price', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('issue_date', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('ranking', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('genre', 'LIKE', '%'.$keyword.'%');
                });
            }
            $books = $query->orderBy('ranking')->paginate(16);
        }

        // ジャンルが「すべて」ではなく、検索ワードが存在しない場合
        if (empty($keyword_array) && $genre !== 'すべて') {
            $books = Book::where('genre', $genre)
                ->orderBy('ranking')
                ->paginate(16);
        }

        // ジャンルが「すべて」で、検索ワードが存在しない場合
        if (empty($keyword_array) && $genre === 'すべて') {
            $books = Book::orderBy('ranking')->paginate(16);
        }

        if (!empty($genre)) {
            //ジャンルを一時的にセッションに保存
            $request->session()->flash('genre', $genre);
        }

        if (!empty($keyword_array)) {
            // 検索ワードを一時的にセッションに保存
            $request->session()->flash('keyword_array', $keyword_array);
        }

        return view('index', ['books' => $books, 'genre' => $genre, 'keywords' => $keywords]);
    }


    // 新着順
    public function issueDateOrder(Request $request)
    {
        $genre='すべて';
        $keywords=null;

        // 検索ワードの取得
        if ($request->session()->has('keyword_array')) {
            $keyword_array = $request->session()->get('keyword_array');
            // 検索ボックス再表示用
            $keywords = implode(" ", $keyword_array);
        }

        //ジャンルの取得
        if ($request->session()->has('genre')) {
            $genre = $request->session()->get('genre');
        }

        // セレクトボックスが「すべて」ではなく、検索キーワードが存在する場合
        if (!empty($keyword_array) && $genre !== 'すべて') {
            $query=Book::query();
            // 配列にキーワード条件を格納
            foreach ($keyword_array as $keyword) {
                // キーワード一つを変数に格納
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('price', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('issue_date', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('ranking', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('genre', 'LIKE', '%'.$keyword.'%');
                });
            }
            $query->where('genre', $genre);
            $books = $query->latest('issue_date')->paginate(16);
        }

        // セレクトボックスが「すべて」で検索キーワードが存在する場合
        if (!empty($keyword_array) && $genre === 'すべて') {
            $query=Book::query();
            // 配列にキーワード条件を格納
            foreach ($keyword_array as $keyword) {
                // キーワード一つを変数に格納
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('price', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('issue_date', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('ranking', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('genre', 'LIKE', '%'.$keyword.'%');
                });
            }
            $books = $query->latest('issue_date')->paginate(16);
        }

        // ジャンルが「すべて」ではなく、検索ワードが存在しない場合
        if (empty($keyword_array) && $genre !== 'すべて') {
            $books = Book::where('genre', $genre)
                ->latest('issue_date')
                ->paginate(16);
        }

        // ジャンルが「すべて」で、検索ワードが存在しない場合
        if (empty($keyword_array) && $genre === 'すべて') {
            $books = Book::latest('issue_date')->paginate(16);
        }
        
        if (!empty($genre)) {
            //ジャンルを一時的にセッションに保存
            $request->session()->flash('genre', $genre);
        }

        if (!empty($keyword_array)) {
            // 検索ワードを一時的にセッションに保存
            $request->session()->flash('keyword_array', $keyword_array);
        }

        return view('index', ['books' => $books, 'genre' => $genre, 'keywords' => $keywords]);
    }


    // 価格の安い順
    public function priceOrder(Request $request)
    {
        $genre='すべて';
        $keywords=null;

        // 検索ワードの取得
        if ($request->session()->has('keyword_array')) {
            $keyword_array = $request->session()->get('keyword_array');
            // 検索ボックス再表示用
            $keywords = implode(" ", $keyword_array);
        }

        //ジャンルの取得
        if ($request->session()->has('genre')) {
            $genre = $request->session()->get('genre');
        }

        // セレクトボックスが「すべて」ではなく、検索キーワードが存在する場合
        if (!empty($keyword_array) && $genre !== 'すべて') {
            $query=Book::query();
            // 配列にキーワード条件を格納
            foreach ($keyword_array as $keyword) {
                // キーワード一つを変数に格納
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('price', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('issue_date', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('ranking', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('genre', 'LIKE', '%'.$keyword.'%');
                });
            }
            $query->where('genre', $genre);
            $books = $query->orderBy('price')->paginate(16);
        }

        // セレクトボックスが「すべて」で検索キーワードが存在する場合
        if (!empty($keyword_array) && $genre === 'すべて') {
            $query=Book::query();
            // 配列にキーワード条件を格納
            foreach ($keyword_array as $keyword) {
                // キーワード一つを変数に格納
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('price', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('issue_date', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('ranking', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('genre', 'LIKE', '%'.$keyword.'%');
                });
            }
            $books = $query->orderBy('price')->paginate(16);
        }

        // ジャンルが「すべて」ではなく、検索ワードが存在しない場合
        if (empty($keyword_array) && $genre !== 'すべて') {
            $books = Book::where('genre', $genre)
                ->orderBy('price')
                ->paginate(16);
        }
        // ジャンルが「すべて」で、検索ワードが存在しない場合
        if (empty($keyword_array) && $genre === 'すべて') {
            $books = Book::orderBy('price')->paginate(16);
        }

        if (!empty($genre)) {
            //ジャンルを一時的にセッションに保存
            $request->session()->flash('genre', $genre);
        }

        if (!empty($keyword_array)) {
            // 検索ワードを一時的にセッションに保存
            $request->session()->flash('keyword_array', $keyword_array);
        }

        return view('index', ['books' => $books, 'genre' => $genre, 'keywords' => $keywords]);
    }


    // 検索実行時
    public function search(Request $request)
    {
        $genre='すべて';
        $keywords=null;

        //ジャンルの取得
        $genre = $request->input('genre');
        // 検索ワードの取得
        $keywords = $request->input('keywords');
        // 全角スペースを半角スペースに変換
        $keywords_hankaku_space = str_replace("　", " ", $keywords);
        //配列に格納
        $keyword_array = explode(" ", $keywords_hankaku_space);

        // booksテーブルのクエリビルダ生成
        // セレクトボックスが「すべて」ではなく、検索キーワードが存在する場合
        if (!empty($keyword_array) && $genre !== 'すべて') {
            $query=Book::query();
            // 配列にキーワード条件を格納
            foreach ($keyword_array as $keyword) {
                // キーワード一つを変数に格納
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('price', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('issue_date', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('ranking', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('genre', 'LIKE', '%'.$keyword.'%');
                });
            }
            $query->where('genre', $genre);
            $books = $query->paginate(16);
        }

        // セレクトボックスが「すべて」で検索キーワードが存在する場合
        if (!empty($keyword_array) && $genre === 'すべて') {
            $query=Book::query();
            // 配列にキーワード条件を格納
            foreach ($keyword_array as $keyword) {
                // キーワード一つを変数に格納
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('price', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('issue_date', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('ranking', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('genre', 'LIKE', '%'.$keyword.'%');
                });
            }
            $books = $query->paginate(16);
        }

        // セレクトボックスが「すべて」ではなく、検索ワードが存在しない場合
        if (empty($keyword_array) && $genre !== 'すべて') {
            $books = Book::where('genre', $genre)
                ->paginate(16);
        }

        // セレクトボックスが「すべて」で、検索ワードが存在しない場合
        if (empty($keyword_array) && $genre === 'すべて') {
            $books = Book::paginate(16);
        }

        if (!empty($genre)) {
            //ジャンルを一時的にセッションに保存
            $request->session()->flash('genre', $genre);
        }

        if (!empty($keyword_array)) {
            // 検索ワードを一時的にセッションに保存
            $request->session()->flash('keyword_array', $keyword_array);
        }

        return view('index', ['books' => $books, 'genre' => $genre, 'keywords' => $keywords]);
    }


    // 詳細ページ表示
    public function show(Book $book, Request $request)
    {
        $genre='すべて';
        $keywords=null;

        if ($request->session()->has('keyword_array')) {
            $keyword_array = $request->session()->get('keyword_array');
            // 検索ボックス再表示用
            $keywords = implode(" ", $keyword_array);
        }
        //ジャンルの取得
        if ($request->session()->has('genre')) {
            $genre = $request->session()->get('genre');
        }

        if (!empty($genre)) {
            //ジャンルを一時的にセッションに保存
            $request->session()->flash('genre', $genre);
        }

        if (!empty($keyword_array)) {
            // 検索ワードを一時的にセッションに保存
            $request->session()->flash('keyword_array', $keyword_array);
        }

        return view('book', ['book' => $book, 'genre' => $genre, 'keywords' => $keywords]);
    }
}
