<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Auth;
use Hash;

class UserController extends Controller
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
        config(['site.page' => 'user']);
        $data = User::paginate(15);
        return view('admin.users', compact('data'));
    }

        
    public function profile(Request $request){
        $user = Auth::user();
        $current_page = 'profile';
        
        $data = array(
            'user' => $user,
            'current_page' => $current_page
        );
        return view('profile', $data);
    }

    public function updateuser(Request $request){
        $request->validate([
            'name'=>'required',
            'phone_number'=>'required',
        ]);
        $user = Auth::user();
        $user->name = $request->get("name");
        $user->phone_number = $request->get("phone_number");

        if($request->get('password') != ''){
            $user->password = Hash::make($request->get('password'));
        }
        if($request->has("picture")){
            $picture = request()->file('picture');
            $imageName = time().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/profile_pictures'), $imageName);
            $user->picture = 'images/profile_pictures/'.$imageName;
        }
        $user->update();
        return back()->with("success", __('page.updated_successfully'));
    }

    public function edituser(Request $request){
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
        ]);
        $user = User::find($request->get("id"));
        $user->name = $request->get("name");
        $user->phone_number = $request->get("phone");

        if($request->get('password') != ''){
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();
        return response()->json('success');
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string|unique:users',
            'phone_number'=>'required',
            'role'=>'required',
            'password'=>'required|string|min:6|confirmed'
        ]);
        
        User::create([
            'name' => $request->get('name'),
            'phone_number' => $request->get('phone_number'),
            'role_id' => $request->get('role'),
            'password' => Hash::make($request->get('password'))
        ]);
        return response()->json('success');
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return back()->with("success", __('page.deleted_successfully'));
    }

}
