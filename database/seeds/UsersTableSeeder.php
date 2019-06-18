<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
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

        // 生成数据集合
        $users = factory(User::class)
                        ->times(5)
                        ->make()
                        ->each(function ($user, $index)
                            use ($faker, $avatars)
        {
            // 从头像数组中随机取出一个并赋值
            $user->avatar = asset('images/avatar/'.$faker->randomElement($avatars));
        });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = '王力';
        $user->email = 'kevin@kouton.com';
        $user->avatar = asset('images/avatar/'.$avatars[array_rand($avatars)]);
        $user->save();
        // 初始化用户角色，将 1 号用户指派为『管理员』
        $user->givePermissionTo('manager');
        // 单独处理第一个用户的数据
        $user = User::find(2);
        $user->name = '张长健';
        $user->email = 'changjian@kouton.com';
        $user->avatar = asset('images/avatar/'.$avatars[array_rand($avatars)]);
        $user->save();
        // 单独处理第一个用户的数据
        $user = User::find(3);
        $user->name = '陈珍';
        $user->email = 'seazen@kouton.com';
        $user->avatar = asset('images/avatar/'.$avatars[array_rand($avatars)]);
        $user->save();
        // 单独处理第一个用户的数据
        $user = User::find(4);
        $user->name = '陈喜';
        $user->email = 'chenxi@kouton.com';
        $user->avatar = asset('images/avatar/'.$avatars[array_rand($avatars)]);
        $user->save();
    }
}
