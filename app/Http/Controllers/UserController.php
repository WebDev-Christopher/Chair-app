<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chair;
use App\Mail\LoginUser;
use App\Mail\CreateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserCreateRequest;
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
     * @param  \Illuminate\Http\UserLoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(UserLoginRequest $request) {
        $user_data = $request->validated();

        $user = User::where('username', $user_data['username'])->first();
        
        if ($user) {
            if(password_verify($user_data["password"], $user->password)) {
                if(auth()->login($user)) {
                    $request->session()->regenerate();

                    Mail::to($user["email"])->queue(new LoginUser($user_data));

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
     * @param  \Illuminate\Http\UserCreateRequest   $request
     * @return \Illuminate\Http\Response
     */    
    public function createUser(UserCreateRequest $request) {
        $user_data = $request->validated();

        $user_data["password"] = password_hash($user_data["password"], PASSWORD_DEFAULT);

        if(auth()->login(User::create($user_data))) {
            $request->session()->regenerate();

            Mail::to($user_data["email"])->queue(new CreateUser($user_data));

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
