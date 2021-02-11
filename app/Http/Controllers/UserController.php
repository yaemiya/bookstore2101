<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class UserController extends Controller
{
    //userデータの表示
    public function edit()
    {
        $addresses = Address::select()
            ->join('users', 'users.id', '=', 'addresses.user_id')
            ->where('users.id', Auth::id())
            ->first();
        if (Auth::check()) {
            $name = Auth::user()->name;
            $email = Auth::user()->email;
            $password = Auth::user()->password;
            $postal_code = $addresses->postal_code;
            $region = $addresses->region;
            $address = $addresses->address;
            $building = $addresses->building;
            $tel = $addresses->tel;

            return view('auth.edit', compact('name', 'email', 'addresses', 'postal_code', 'region', 'address', 'building', 'tel'));
        }
    }

    
    //userデータの保存
    public function update(Request $request)
    {
        $user_form = $request->all();
        $user = Auth::user();
        // 不要な「_token」の削除
        unset($user_form['_token']);

        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'postal_code' => ['nullable', 'string', 'digits:7'],
            'address' => ['nullable', 'string'],
            'tel' => ['nullable', 'string', 'digits_between:10,11'],
        ]);
        // バリデーションエラーだった場合
        if ($validator->fails()) {
            return redirect('auth/edit')
        ->withErrors($validator)
        ->withInput();
        }
        
        // 値の更新もしくは新規登録
        if (Auth::check()) {
            User::where('id', Auth::id())->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            Address::updateOrCreate(
                [
                'user_id' => Auth::id(),
                ],
                [
                'postal_code' => $request->postal_code ?? '',
                'region' => $request->region ?? '',
                'address' => $request->address ?? '',
                'building' => $request->building ?? '',
                'tel' => $request->tel ?? ''
                ]
            );

            //保存
            $user->fill($user_form)->save();
            //リダイレクト
            return redirect('/');
        }
    }


    //アカウント削除画面表示
    public function show()
    {
        $addresses = Address::select()
            ->join('users', 'users.id', '=', 'addresses.user_id')
            ->where('users.id', Auth::id())
            ->first();
        if (Auth::check()) {
            $name = Auth::user()->name;
            $email = Auth::user()->email;
            $password = Auth::user()->password;
            $postal_code = $addresses->postal_code;
            $region = $addresses->region;
            $address = $addresses->address;
            $building = $addresses->building;
            $tel = $addresses->tel;

            return view('auth.delete', compact('name', 'email', 'addresses', 'postal_code', 'region', 'address', 'building', 'tel'));
        }
    }


    // アカウント削除
    public function destroy()
    {
        User::where('id', Auth::id())->delete();
        
        return redirect('/');
    }
}
