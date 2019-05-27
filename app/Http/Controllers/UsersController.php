<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class UsersController extends Controller
{
    public function setStore()
    {
        dd();
    }

    public function settings()
    {   $user = Auth::user();
        return view('users.settings');
    }

    /**
     * 后台批量展示用户
     *
     * @return void
     */
    public function users(Request $request, User $user){
        if($request->name){
            $users = User::where('name','like','%'.$request->name.'%')->withTrashed()->paginate(10);
        }else{
            $users = User::withTrashed()->paginate(10);
        }
        return view('pages.system.users',compact('users'));
    }
    /**
     * 修改用户
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function userStore(Request $request, User $user)
    {
        $data = $request->all();
        if($request->password){
            $data['password'] = Hash::make($request->password);
        }
        $user = User::find($data['id']);
        $user->fill($data);
        if($request->delete_at){
            if($data['delete_at'] == '1'){
                $user->restore();
            }
            if($data['delete_at'] == '0'){
                $user->delete();
            }
        }
        $user->save();
        return back()->with('success', '用户户信息修改完成!');
    }
}
