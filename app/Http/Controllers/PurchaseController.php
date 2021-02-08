<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\Book;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\Purchase;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    // お届け先情報入力画面表示
    public function edit(Request $request)
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

        $address = Address::select()
            ->join('users', 'users.id', '=', 'addresses.user_id')
            ->find(1);
        if (Auth::check()) {
            $name = Auth::user()->name;
            $email = Auth::user()->email;
            $building = $address->building;
            $tel = $address->tel;
            $postal_code = $address->postal_code;
            $region = $address->region;
            $address = $address->address;
            return view('address', compact('name', 'email', 'postal_code', 'region', 'address', 'building', 'tel'));
        } else {
            return view('address');
        }
    }

    // 住所情報の登録・更新処理制御〜注文確認画面表示
    public function address_control(Request $request)
    {
        // ログイン中で保存チェックボックスにチェック時ーアドレス保存
        if (Auth::check() && $request->has('address_reserve')) {
            $address = Address::updateOrCreate(
                [
                'user_id' => Auth::id(),
                ],
                [
                'name' => $request->name,
                'email' => $request->email,
                'postal_code' => $request->postal_code,
                'region' => $request->region,
                'address' => $request->address,
                'building' => $request->building,
                'tel' => $request->tel,
                'user_id' => Auth::id(),
                ]
            );
            $carts = Cart::where('user_id', Auth::id())
            ->get();
            // 小計
            $sub_total = 0;
            foreach ($carts as $cart) {
                $sub_total += $cart->price * $cart->quantity;
            }

            // 住所をセッションに保存
            $request->session()->put('ad_name', $request->name);
            $request->session()->flash('email', $request->email);
            $request->session()->flash('postal_code', $request->postal_code);
            $request->session()->flash('region', $request->region);
            $request->session()->flash('address', $request->address);
            $request->session()->flash('building', $request->building);
            $request->session()->flash('tel', $request->tel);


            return view('confirm', compact('carts', 'sub_total'));

        // チェックボックスにチェックしてない時
        } else {
            //ログイン時
            if (Auth::check()) {
                $carts = Cart::where('user_id', Auth::id())
                ->get();
                // 小計
                $sub_total = 0;
                foreach ($carts as $cart) {
                    $sub_total += $cart->price * $cart->quantity;
                }

                // 住所をセッションに保存
                $request->session()->put('ad_name', $request->name);
                $request->session()->flash('email', $request->email);
                $request->session()->flash('postal_code', $request->postal_code);
                $request->session()->flash('region', $request->region);
                $request->session()->flash('address', $request->address);
                $request->session()->flash('building', $request->building);
                $request->session()->flash('tel', $request->tel);

                return view('confirm', compact('carts', 'sub_total'));

            // ログインしていない時
            } else {
                $carts = Cart::where('session_id', session()->getId())
                ->get();
                // 小計
                $sub_total = 0;
                foreach ($carts as $cart) {
                    $sub_total += $cart->price * $cart->quantity;
                }

                // 住所をセッションに保存
                $request->session()->put('ad_name', $request->name);
                $request->session()->flash('email', $request->email);
                $request->session()->flash('postal_code', $request->postal_code);
                $request->session()->flash('region', $request->region);
                $request->session()->flash('address', $request->address);
                $request->session()->flash('building', $request->building);
                $request->session()->flash('tel', $request->tel);

                return view('confirm', compact('carts', 'sub_total'));
            }
        }
    }

    // 注文完了ページの表示とメール送信
    public function checkout()
    {
        // メール宛名
        if (Auth::check()) {
            $name = Auth::user()->name;
        } else {
            $name = session()->get('ad_name');
        }

        // メール注文日
        $today = Carbon::today();
        $order_date = $today->format('Y年n月j日');

        // カート情報
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
        // 総オーダー商品数
        $total_quantity = 0;
        foreach ($carts as $cart) {
            $sub_total += $cart->price * $cart->quantity;
            $total_quantity += $cart->quantity;
        }

        //メール送信
        Mail::send(new Purchase($name, $order_date, $carts, $sub_total, $total_quantity));

        return view('checkout', compact('name', 'order_date', 'carts', 'sub_total', 'total_quantity'));
    }
}
