<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\User;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\Purchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PurchaseController extends Controller
{
    // お届け先情報入力画面表示
    public function edit(Request $request)
    {
        $addresses = Address::select()
        ->join('users', 'users.id', '=', 'addresses.user_id')
        ->where('users.id', Auth::id())
        ->first();
        // 宛名
        if (session()->has('ad_name')) {
            $name = session()->get('ad_name');
        } elseif (Auth::check()) {
            $name = Auth::user()->name;
        } else {
            $name = '';
        }
        // メールアドレス
        if (session()->has('email')) {
            $email = session()->get('email');
        } elseif (Auth::check()) {
            $email = Auth::user()->email;
        } else {
            $email = '';
        }
        // 郵便番号
        if (session()->has('postal_code')) {
            $postal_code = session()->get('postal_code');
        } elseif (!empty($addresses->postal_code)) {
            $postal_code = $addresses->postal_code;
        } else {
            $postal_code = '';
        }
        // 都道府県
        if (session()->has('region')) {
            $region = session()->get('region');
        } elseif (!empty($addresses->region)) {
            $region = $addresses->region;
        } else {
            $region = '';
        }
        // 住所
        if (session()->has('address')) {
            $address = session()->get('address');
        } elseif (!empty($addresses->address)) {
            $address = $addresses->address;
        } else {
            $address = '';
        }
        // 建物
        if (session()->has('building')) {
            $building = session()->get('building');
        } elseif (!empty($addresses->building)) {
            $building = $addresses->building;
        } else {
            $building = '';
        }
        // 電話番号
        if (session()->has('tel')) {
            $tel = session()->get('tel');
        } elseif (!empty($addresses->tel)) {
            $tel = $addresses->tel;
        } else {
            $tel = '';
        }

        return view('address', compact('name', 'email', 'postal_code', 'region', 'address', 'building', 'tel'));
        // } else {
        //     return view('address');
        // }
    }

    // 住所情報の登録・更新処理制御〜注文確認画面表示
    public function address_control(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'postal_code' => ['required', 'string', 'digits:7'],
            'region' =>['required'],
            'address' => ['required', 'string'],
            'tel' => ['required', 'string', 'digits_between:10,11'],
        ]);

        // バリデーションエラーだった場合
        if ($validator->fails()) {
            return redirect()
                ->route('address_edit')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Nullエラー防止
        if (empty($request->building)) {
            $request->building = '';
        }

        // ログイン中で保存チェックボックスにチェック時ーアドレス保存
        if (Auth::check() && $request->has('address_reserve')) {
            User::where('id', Auth::id())->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            Address::updateOrCreate(
                [
                'user_id' => Auth::id(),
                ],
                [
                'postal_code' => $request->postal_code,
                'region' => $request->region,
                'address' => $request->address,
                'building' => $request->building,
                'tel' => $request->tel,
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
            $request->session()->put('email', $request->email);
            $request->session()->put('postal_code', $request->postal_code);
            $request->session()->put('region', $request->region);
            $request->session()->put('address', $request->address);
            $request->session()->put('building', $request->building);
            $request->session()->put('tel', $request->tel);


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
                $request->session()->put('email', $request->email);
                $request->session()->put('postal_code', $request->postal_code);
                $request->session()->put('region', $request->region);
                $request->session()->put('address', $request->address);
                $request->session()->put('building', $request->building);
                $request->session()->put('tel', $request->tel);

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
                $request->session()->put('email', $request->email);
                $request->session()->put('postal_code', $request->postal_code);
                $request->session()->put('region', $request->region);
                $request->session()->put('address', $request->address);
                $request->session()->put('building', $request->building);
                $request->session()->put('tel', $request->tel);

                return view('confirm', compact('carts', 'sub_total'));
            }
        }
    }

    // 注文完了ページの表示とメール送信
    public function checkout()
    {
        // メール宛名
        // if (Auth::check()) {
        //     $name = Auth::user()->name;
        // } else {
        $name = session()->get('ad_name');
        // }

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
            // カート削除
            $cs = Cart::where('session_id', $session_id)->delete();
        
        // ログイン中
        } else {
            $carts = Cart::select('id', 'name', 'quantity', 'price', 'book_id')
            ->where('user_id', Auth::id())
            ->get();
            // カート削除
            $cu = Cart::where('user_id', Auth::id())->delete();
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

        
        //セッション全削除
        session()->flush();

        return view('checkout', compact('name', 'order_date', 'carts', 'sub_total', 'total_quantity'));
    }
}
