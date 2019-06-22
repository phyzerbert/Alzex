<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Nexmo;
use Carbon\Carbon;

use App\User;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;

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
        $search_accounts = Account::pluck('id')->toArray();
        
        $from = date('Y-m-d', strtotime(Transaction::orderBy('timestamp')->first()->timestamp));
        // $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = date('Y-m-d');
        $period = $spec_date = '';        
        if ($request->get('spec_date') != ""){   
            $spec_date = $request->get('spec_date');
            $to = $spec_date;
        }else if ($request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
        }
        return view('home', compact('period', 'search_users', 'search_categories', 'search_accounts', 'from', 'to', 'spec_date'));
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
