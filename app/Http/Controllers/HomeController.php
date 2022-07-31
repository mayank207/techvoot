<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $brands = Brand::get();
        if(Auth::user()->is_admin == 1){
            $data['page_title'] = "Admin Dashboard";
            return view('dashboard',compact('brands'))->with($data);
        }
        else{
            $data['page_title'] = "Users Dashbord";
            return view('dashboard',compact('brands'))->with($data);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/login')->with('toast-success','Logged out successfully');
    }
}
