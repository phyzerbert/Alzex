<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\User;
use App\Models\Category;
use App\Models\Account;
use App\Models\Accountgroup;

class TransactionController extends Controller
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
    public function index(Request $request)
    {
        config(['site.page' => 'transaction']);
        $categories = Category::all();
        $accountgroups = Accountgroup::all();
        $users = User::all();
        
        $mod = new Transaction();
        $mod1 = new Transaction();
        $category = $account = $user = $type = $period = '';

        if ($request->get('type') != ""){
            $type = $request->get('type');
            $mod = $mod->where('type', $type);
            $mod1 = $mod1->where('type', $type);
        }
        if ($request->get('user') != ""){
            $user = $request->get('user');
            $users = User::where('name', 'LIKE', "%$user%")->pluck('id');
            $mod = $mod->whereIn('user_id', $users);
            $mod1 = $mod1->whereIn('user_id', $users);
        }
        if ($request->get('category') != ""){
            $category = $request->get('category');
            $mod = $mod->where('category_id', $category);
            $mod1 = $mod1->where('category_id', $category);
        }
        if ($request->get('account') != ""){
            $account = $request->get('account');
            $mod = $mod->where('from', $account)->orWhere('to', $account);
            $mod1 = $mod1->where('from', $account)->orWhere('to', $account);
        }
        if ($request->get('period') != ""){   
            $period = $request->get('period');
            $from = substr($period, 0, 10);
            $to = substr($period, 14, 10);
            $mod = $mod->whereBetween('timestamp', [$from, $to]);
            $mod1 = $mod1->whereBetween('timestamp', [$from, $to]);
        }

        $data = $mod->orderBy('created_at', 'desc')->paginate(15);
        $expenses = $mod->where('type', 1)->sum('amount');
        $incomes = $mod->where('type', 2)->sum('amount');
        $pagesize = $request->session()->get('pagesize');
        if(!$pagesize){$pagesize = 10;}
        $data = $mod->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('transaction.index', compact('data', 'expenses', 'incomes', 'categories', 'accountgroups', 'users', 'type', 'user', 'category', 'account', 'period', 'pagesize'));
    }

    public function create(Request $request){
        $users = User::all();
        $categories = Category::all();
        $accountgroups = Accountgroup::all();        
        return view('transaction.create', compact('users', 'categories', 'accountgroups'));
    }

    public function expense(Request $request){
        $request->validate([
            'user'=>'required',
            'category'=>'required',
            'account'=>'required',
            'amount'=>'required',
        ]);
        $account = Account::find($request->get('account'));
        // if ($account->balance < $request->get('amount')) {
        //     return back()->withErrors(['insufficent' => 'Insufficent balance.']);
        // }
        $attachment = '';
        if($request->file('attachment') != null){
            $image = request()->file('attachment');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploaded/transaction_attachments'), $imageName);
            $attachment = 'uploaded/transaction_attachments/'.$imageName;
        }

        Transaction::create([
            'type' => 1,
            'user_id' => $request->get('user'),
            'category_id' => $request->get('category'),
            'from' => $request->get('account'),
            'amount' => $request->get('amount'),
            'description' => $request->get('description'),
            'timestamp' => $request->get('timestamp'),
            'attachment' => $attachment,
        ]);

        $account->decrement('balance', $request->get('amount'));
        return back()->with('success', __('page.created_successfully'));
    }

    public function incoming(Request $request){
        $request->validate([
            'user'=>'required',
            'category'=>'required',
            'account'=>'required',
            'amount'=>'required',
        ]);
        
        $attachment = '';
        if($request->file('attachment') != null){
            $image = request()->file('attachment');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploaded/transaction_attachments'), $imageName);
            $attachment = 'uploaded/transaction_attachments/'.$imageName;
        }

        Transaction::create([
            'type' => 2,
            'user_id' => $request->get('user'),
            'category_id' => $request->get('category'),
            'to' => $request->get('account'),
            'amount' => $request->get('amount'),
            'description' => $request->get('description'),
            'timestamp' => $request->get('timestamp'),
            'attachment' => $attachment,
        ]);
        $account = Account::find($request->get('account'));
        $account->increment('balance', $request->get('amount'));

        return back()->with('success', __('page.created_successfully'));
    }

    public function transfer(Request $request){
        $request->validate([
            'user'=>'required',
            'category'=>'required',
            'account'=>'required',
            'target'=>'required',
            'amount'=>'required',
        ]);

        $account = Account::find($request->get('account'));
        $target = Account::find($request->get('target'));

        // if ($account->balance < $request->get('amount')) {
        //     return back()->withErrors(['insufficent' => 'Insufficent balance.']);
        // }

        $attachment = '';
        if($request->file('attachment') != null){
            $image = request()->file('attachment');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploaded/transaction_attachments'), $imageName);
            $attachment = 'uploaded/transaction_attachments/'.$imageName;
        }

        Transaction::create([
            'type' => 3,
            'user_id' => $request->get('user'),
            'category_id' => $request->get('category'),
            'from' => $request->get('account'),
            'to' => $request->get('target'),
            'amount' => $request->get('amount'),
            'description' => $request->get('description'),
            'timestamp' => $request->get('timestamp'),
            'attachment' => $attachment,
        ]);
        
        $account->decrement('balance', $request->get('amount'));
        $target->increment('balance', $request->get('amount'));

        return back()->with('success', __('page.created_successfully'));
    }

    public function edit(Request $request, $id){
        $item = Transaction::find($id);
        $users = User::all();
        $categories = Category::all();
        $accountgroups = Accountgroup::all();  
        return view('transaction.edit', compact('item', 'users', 'categories', 'accountgroups'));
    }

    public function update(Request $request){
        $item = Transaction::find($request->get('id'));
        $type = $item->type;
        $item->user_id = $request->get('user');
        $item->category_id = $request->get('category');
        $item->description = $request->get('description');
        $item->timestamp = $request->get('timestamp');
        if($type == 1){
            // dd($request->all());
            $old_account = $item->account;
            if($item->from != $request->get('account')){
                $new_account = Account::find($request->get('account'));
                $old_account->increment('balance', $item->amount);
                $new_account->decrement('balance', $request->get('amount'));
                $old_account->decrement('balance', $request->get('amount'));
                $new_account->increment('balance', $item->amount);                
                $item->amount = $request->get('amount');
                $item->from = $request->get('account');
            }else if($item->amount != $request->get('amount')){
                $old_account->increment('balance', $item->amount);
                $old_account->decrement('balance', $request->get('amount'));             
                $item->amount = $request->get('amount');
            }
        }else if($type == 2){
            $old_target = $item->target;
            if($item->to != $request->get('account')){
                $new_target = Account::find($request->get('account'));
                $new_target->increment('balance', $request->get('amount'));
                $old_target->decrement('balance', $item->amount);
                $item->to = $request->get('account');
            }
            $item->amount = $request->get('amount');
        }else if($type == 3){
            $old_from = $item->account;
            if($item->from != $request->get('account')){
                $new_from = Account::find($request->get('account'));
                $old_from->increment('balance', $item->amount);
                $new_from->decrement('balance', $request->get('amount'));
                $item->from = $request->get('account');
            }

            $old_target = $item->target;
            if($item->to != $request->get('target')){
                $new_target = Account::find($request->get('target'));
                $new_target->increment('balance', $request->get('amount'));
                $old_target->decrement('balance', $item->amount);
                $item->to = $request->get('target');
            }

            if($item->to == $request->get('target') && $item->from == $request->get('account') && $item->amount != $request->get('amount')){
                $old_account->increment('balance', $item->amount);
                $old_target->decrement('balance', $item->amount);
                $old_account->decrement('balance', $request->get('amount'));
                $old_target->increment('balance', $request->get('amount'));
            }
            $item->amount = $request->get('amount');
        }

        if($request->file('attachment') != null){
            $image = request()->file('attachment');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploaded/transaction_attachments'), $imageName);
            $item->attachment = 'uploaded/transaction_attachments/'.$imageName;
        }

        $item->save();

        return redirect(route('transaction.index'))->with('success', __('page.updated_successfully'));

    }

    public function delete($id){
        $item = Transaction::find($id);
        $item->delete();
        return back()->with("success", "Deleted Successfully");
    }
}
