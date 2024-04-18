<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    //show Register/Create Form
    public function create(){
        return view('users.register');
    }

    //store new users
    public function store(Request $request){
        $formfields=$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>['required','confirmed','min:6']
        ]);

        //Hash Password
        $formfields['password']=bcrypt($formfields['password']);

        //create User
        $user=User::create($formfields);
        
        //Login
        auth()->login($user);

        return redirect('/')->with('message','User Created Successfully and logged in');

    }
    
    //Logout User
    public function logout(Request $request){
       auth()->logout();

       $request->session()->invalidate();
       $request->session()->regenerateToken();

       return redirect('/')->with('message','You have been logged out!');
    }

    //show login page
    public function login(){
        return view('users.login');
    }

    //Authenticate User
    public function authenticate(Request $request){
        $formfields=$request->validate([
            'email'=>['required','email'],
            'password'=>'required'
        ]);

        if(auth()->attempt($formfields)){
            $request->session()->regenerate();
            return redirect('/')->with('message','You are logged in');
        }

        return back()->withErrors(['email'=>'Invalid credentials'])->onlyInput('email');

    }
}
