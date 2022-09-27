<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::all();
        return view('contact.index', compact('contacts','request'));
    }

    public function confirm(Request $request){
    $request->session()->put('request', $request->all());
    $this->valid($request);
    $inputs = $request->all();
    return view('contact.confirm', [
        'inputs' => $inputs
    ]);
    }

    public function create(Request $request){
        $user = new User;

        $user->name = e($request['name']);
        $user->email = e($request['email']);
        $user->password = e($request['password']);
        $user->timestamps = false;

        $user->save();

        // トークンを使った二重送信防止策
        $request->session()->regenerateToken();

        return view('contact.complete');
    }

    public function edit($id){
        $user = User::find($id);
        return view('contact/edit', compact('contact'));
    }
    public function update(Request $request, $id){
        $user = User::find($id);

        $this->valid($request);

        $user->name = e($request['name']);
        $user->email = e($request['email']);
        $user->body = e($request['password']);
        $user->timestamps = false;
        // $contact->timestamps = false; //追加

        $user->save();

        // トークンを使った二重送信防止策
        $request->session()->regenerateToken();

        return view('contact.edit_complete');
    }

    public function destroy($id){
        $user = User::find($id);

        $user->delete();
        
        return view('contact.delete');
    }

    public function valid($request){
        $validateRules = [
            'name' => 'required|max:10',
            'email' => 'email',
            'password' => 'required'
        ];

        $validateMessages = [
            "name.required" => "氏名は必須入力です。",
           
            "body.required" => "お問い合わせ内容は必須入力です。",
            "name.max" => "10文字以内でご入力ください。",
   
            "email" => "メールアドレスは正しくご入力ください。",
            "numeric" => "0-9の数字のみでご入力ください。"
        ];

        $this->validate($request, $validateRules, $validateMessages);
    }
}


