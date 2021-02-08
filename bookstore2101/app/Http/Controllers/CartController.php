<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Session\Store;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $genre='すべて';
        $keywords=null;
        $session_id = session()->getId();
        // ログイン時のカートの数量
        $user_quantity = Cart::where('user_id', Auth::id())->where('book_id', $request->book_id)->value('quantity');
        // ゲスト時のカートの数量
        $guest_quantity = Cart::where('session_id', $session_id)->where('book_id', $request->book_id)->value('quantity');

        // ログインしていればユーザーIDで識別して更新／挿入
        if (Auth::check()) {
            Cart::updateOrCreate(
                [
                'user_id' => Auth::id(),
                'book_id' => $request->book_id,
            ],
                [
                'name' => $request->name,
                'quantity' => $user_quantity + 1,
                'price' => $request->price,
                'book_id' => $request->book_id
                ]
            );
        }
        // ゲストユーザーならセッションIDで識別して更新／挿入
        if (!Auth::check()) {
            Cart::updateOrCreate(
                [
                'session_id' => $session_id,
                'book_id' => $request->book_id,
            ],
                [
                'name' => $request->name,
                'quantity' => $guest_quantity + 1,
                'price' => $request->price,
                'session_id' => $session_id,
                'book_id' => $request->book_id
                ]
            );
        }


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
        
        // セッションにカートストアが存在してい無ければ一時的にセッションに保存
        if (empty($request->session()->get('cart_store'))) {
            $request->session()->flash('cart_store', 'stored');
        }

        // 「カートに入れる」ボタン押下時に受け渡しの変数
        $name = $request->name;
        $ranking = $request->ranking;
        $issue_date = $request->issue_date;
        $price = $request->price;

        return view('book', ['book' => $book, 'genre' => $genre, 'keywords' => $keywords, 'name' => $name, 'ranking' => $ranking, 'issue_date' => $issue_date, 'price' => $price])->with('flash_msg', 'カートに追加しました');
    }



    public function index(Request $request)
    {
        // ゲスト
        $session_id = session()->getId();
        if (!Auth::check()) {
            $carts = Cart::select('id', 'name', 'quantity', 'price', 'book_id')
        ->where('session_id', $session_id)
        ->get();
        // ログイン中
        } else {
            $carts = Cart::select('id', 'name', 'quantity', 'price', 'book_id')
        ->where('user_id', Auth::id())
        ->get();
        }
        // 小計
        $sub_total = 0;
        foreach ($carts as $cart) {
            $sub_total += $cart->price * $cart->quantity;
        }
        return view('cart', compact('carts', 'sub_total'));
    }


    public function destroy(Request $request, Cart $cart)
    {
        $cart->delete();

        // ゲスト
        $session_id = session()->getId();
        if (!Auth::check()) {
            $carts = Cart::select('id', 'name', 'quantity', 'price', 'book_id')
        ->where('session_id', $session_id)
        ->get();
        // ログイン中
        } else {
            $carts = Cart::select('id', 'name', 'quantity', 'price', 'book_id')
        ->where('user_id', Auth::id())
        ->get();
        }

        // 小計
        $sub_total = 0;
        foreach ($carts as $cart) {
            $sub_total += $cart->price * $cart->quantity;
        }

        $flash_msg = 'カートから削除しました';
        return view('cart', compact('cart', 'flash_msg', 'carts', 'sub_total'));
    }

    // 再計算ボタンクリック時
    public function update(Request $request)
    {
        // カートテーブル更新
        $carts = array(
            'id' => $request->input('id'),
            'quantity' => $request->input('quantity')
         );
        for ($i=0; $i<count($carts['id']); $i++) {
            DB::table('carts')
            ->where('id', $carts['id'][$i])
            ->update(['quantity'=> $carts['quantity'][$i]]);
        }

        // ゲスト
        $session_id = session()->getId();
        if (!Auth::check()) {
            $carts = Cart::select('id', 'name', 'quantity', 'price', 'book_id')
        ->where('session_id', $session_id)
        ->get();
        
        // ログイン中
        } else {
            $carts = Cart::select('id', 'name', 'quantity', 'price', 'book_id')
        ->where('user_id', Auth::id())
        ->get();
        }

        // 小計
        $sub_total = 0;
        foreach ($carts as $cart) {
            $sub_total += $cart->price * $cart->quantity;
        }
        $quantity = $cart->quantity;
        $flash_msg = '再計算しました';
        return view('cart', compact('cart', 'flash_msg', 'carts', 'sub_total'));
    }
}
