<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Address;

class UserController extends Controller
{
    //userデータの編集
    public function edit()
    {
        $address = Address::select()
            ->join('users', 'users.id', '=', 'addresses.user_id')
            ->find(1);
        if (Auth::check()) {
            // $user = Auth::user();
            $name = Auth::user()->name;
            $email = Auth::user()->email;
            $building = $address->building;
            $tel = $address->tel;
            $postal_code = $address->postal_code;
            $region = $address->region;
            $address = $address->address;

            return view('auth.edit', compact('name', 'email', 'postal_code', 'region', 'address', 'building', 'tel'));
            // return view('auth.edit', ['user' => Auth::user()]);
        }
    }

    //userデータの保存
    public function update(Request $request)
    {
        $user_form = $request->all();
        $user = Auth::user();
        //不要な「_token」の削除
        unset($user_form['_token']);

        if (Auth::check()) {
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

            //保存
            $user->fill($user_form)->save();
            //リダイレクト
            return redirect('/');
        }
    }
}
