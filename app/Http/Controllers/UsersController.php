<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
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
    public function update(Request $request, User $user)
    {
        $data = [];
        // 获取所有用户包括软删除用户 withTrashed 方法来获取包括软删除模型在内的模型
        $user = User::withTrashed()->find($request->id);
        if($request->name != $user->name){
            $data['name'] = $request->name;
        }
        if($request->email != $user->email){
            $data['email'] = $request->email;
        }
        if($request->password != null){
            $data['password'] = Hash::make($request->password);
        }
        if(count($data) != 0){
            $user->update($data);
        }
        if($request->deleted_at != null){
            if($request->deleted_at == '1'){
                $user->restore();
            }else{
                $user->delete();
            }
            $user->save();
        }
        return back()->with('success', '用户信息修改完成!');
    }

    public function store(UserRequest $request, User $user)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return back()->with('success', '添加用户成功!');
    }
}
