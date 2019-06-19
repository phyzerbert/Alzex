<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
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
        config(['site.page' => 'category']);
        $data = Category::all();
        return view('admin.categories', compact('data'));
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $item = Category::find($request->get("id"));
        $item->name = $request->get("name");
        $item->comment = $request->get("comment");
        $item->save();
        return back()->with('success', 'Updated Successfully');
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string',
        ]);

        Category::create([
            'name' => $request->get('name'),
            'comment' => $request->get('comment'),
            'parent_id' => $request->get('parent'),
        ]);
        return back()->with('success', 'Created Successfully');
    }

    public function delete($id){
        $user = Category::find($id);
        $user->delete();
        return back()->with("success", "Deleted Successfully");
    }

}
