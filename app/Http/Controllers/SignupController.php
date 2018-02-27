<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class SignupController extends Controller
{
    /**
     * 検証済みデータ格納用セッションキー
     */
    protected $sessionKey = 'SignupData';
    
    /**
     * 登録画面
     */
    public function index(User $user)
    {
        if ($data = \Session::get($this->sessionKey)) {
            $user->fill($data);
        }
        return view('signup.index')->with(compact('user'));
    }
    
    /**
     * 検証
     */
    public function postIndex(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|max:255',
            'email'    => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed|password_between:4,30|password_string',
        ]);
        \Session::put($this->sessionKey, $data);
        return redirect()->route('signup.confirm');
    }
    
}
