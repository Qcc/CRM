<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Handlers\ImageUploadHandler;
use Auth;
use Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
            $users = User::where('name','like','%'.$request->name.'%')->withTrashed()->orderBy('created_at','desc')->paginate(10);
        }else{
            $users = User::withTrashed()->orderBy('created_at','desc')->with('permissions')->paginate(10);
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
        if($request->permissions != null){
            if($request->permissions =='1'){
                $user->givePermissionTo('manager');
            }else{
                // 至少保留一个管理员
                if(count(User::permission('manager')->get()) > 1){
                    $user->revokePermissionTo('manager');
                }else{
                    return back()->with('danger', '至少保留一个活动的管理员!'); 
                }
            }
        }
        if($request->password != null){
            $data['password'] = bcrypt($request->password);
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
        $avatars = [
            'avatar001.png',
            'avatar002.png',
            'avatar003.png',
            'avatar004.png',
            'avatar005.png',
            'avatar006.png',
            'avatar007.png',
            'avatar008.png',
            'avatar009.png',
            'avatar010.png',
            'avatar011.png',
            'avatar012.png',
            'avatar013.png',
        ];
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        // 随机选择一个头像
        $user->avatar = asset('images/avatar/'.$avatars[array_rand($avatars)]);
        $user->save();
        return back()->with('success', '添加用户成功!');
    }

    // 用户修改密码
    public function password(Request $request, User $user)
    {
        $this->validate($request, [
            'oldPassword' => 'bail|required|max:30',
            'password' => 'bail|required|confirmed|min:6|max:30',
        ]);
        if(Hash::check($request->oldPassword, $user->password)){
            $request->user()->fill([
                'password' => Hash::make($request->password)
                ])->save();
        }else{
            return back()->with('danger', '密码不正确，更新密码失败！');
        }
        return back()->with('success', '密码更新成功！');
    }

    public function uploadAvatar(Request $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();
        $user = Auth::user();
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return back()->with('success', '头像更新成功！');
    }
}
