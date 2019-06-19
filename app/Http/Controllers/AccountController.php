<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Accountgroup;

class AccountController extends Controller
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
        config(['site.page' => 'account']);
        $data = Accountgroup::all();
        return view('admin.accounts', compact('data'));
    }


    public function create(Request $request){
        $request->validate([
            'name'=>'required|string',
            'group'=>'required',
        ]);

        Account::create([
            'name' => $request->get('name'),
            'comment' => $request->get('comment'),
            'group_id' => $request->get('group'),
        ]);
        return back()->with('success', 'Created Successfully');
    }

    public function create_group(Request $request){
        $request->validate([
            'name'=>'required|string',
        ]);

        Accountgroup::create([
            'name' => $request->get('name'),
            'comment' => $request->get('comment'),
        ]);
        return back()->with('success', 'Created Successfully');
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
            'group'=>'required',
        ]);
        $item = Account::find($request->get("id"));
        $item->name = $request->get("name");
        $item->comment = $request->get("comment");
        $item->group_id = $request->get("group");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function edit_group(Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $item = Accountgroup::find($request->get("id"));
        $item->name = $request->get("name");
        $item->comment = $request->get("comment");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function delete($id){
        $item = Account::find($id);
        $item->delete();
        return back()->with("success", "Deleted Successfully");
    }

    public function delete_group($id){
        $item = Accountgroup::find($id);
        $item->delete();
        return back()->with("success", "Deleted Successfully");
    }
}
