<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Nexmo;

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
    public function index(Request $request) {        
        config(['site.page' => 'home']);
        $from = $to = '';        
        if ($request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
        }
        return view('home', compact('from', 'to'));
    } 
}
