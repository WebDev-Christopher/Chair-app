<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    protected $chairs;
    protected $users;

    public function __construct(){
        $this->chairs = new Chair();
        $this->users = new User();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('pages.users.login');
    }

    /**
     * check if user can login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request) {
        $user_data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $user_data['username'])->first();
        
        if ($user) {
            if(password_verify($user_data["password"], $user->password)) {
                if(auth()->login($user)) {
                    $request->session()->regenerate();
                    
                    return redirect()->back()->with('message', 'You are now logged in');
                }
                else {
                    return redirect()->back()->with('message', 'Email or password incorrect');
                }
            }
            else {
                return redirect()->back()->with('message', 'Password incorrect');
            }
        }
        else {
            return redirect()->back()->with('message', "User doesn't exist");
        }
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register() {
        return view('pages.users.register');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    
    public function createUser(Request $request) {
        $user_data = $request->validate([
            'username' => 'required|unique:users|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $user_data["password"] = password_hash($user_data["password"], PASSWORD_DEFAULT);

        if(auth()->login(User::create($user_data))) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are now logged in');
        }
        else {
            return redirect()->back()->with('message', "User couldn't be created");
        }
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->regenerate();
        return redirect('/login');
    }
}
