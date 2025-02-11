<?php

namespace App\Http\Controllers\Food;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AuthRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    public function index()
    {
        return view('food.login');
    }

    public function login(Request $request)
    {
        try{
            // return redirect()->route('dashboard');

            if($this->auth->login($request)){
                $request->session()->regenerate();
                return redirect()->route('food.dashboard');

            }else{
                Toastr::error(__("auth.failed"), 'error');
                return back()->withErrors([
                    'email' => __("auth.failed"),
                ])->onlyInput('email');
            }

        }catch (\Exception $e){
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        try{
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');

        }catch (\Exception $e){
            dd($e);
            return redirect()->back();
        }
    }
}
