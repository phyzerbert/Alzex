<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Nexmo;
use Carbon\Carbon;

use App\User;
use App\Models\Transaction;
use App\Models\Category;

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
        $search_users = User::pluck('id')->toArray();
        $search_categories = Category::pluck('id')->toArray();
        
        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth()->format('Y-m-d');
        $period = '';        
        if ($request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
        }
        return view('home', compact('period', 'search_users', 'search_categories', 'from', 'to'));
    } 
    
    public function set_pagesize(Request $request){
        // config(['app.pagesize' => $request->get('pagesize')]);
        $request->session()->put('pagesize', $request->get('pagesize'));
        // $setting = Setting::find(1);
        // $setting->pagesize = $request->get('pagesize');
        // $setting->save();
        return back();
    }
}
