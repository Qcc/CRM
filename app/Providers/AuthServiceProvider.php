<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Horizon\Horizon;
use Auth;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Customer::class => \App\Policies\CustomerPolicy::class,
		\App\Models\Follow::class => \App\Policies\FollowPolicy::class,
		\App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Horizon::auth(function ($request) {
            if(Auth::user()){
                // 是否有权限访问队列仪表
                return Auth::user()->can('manager');
            }else{
                return false;
            }
        });

        // Horizon::auth(function ($request) {
        //     // 访问队列仪表盘需要权限 return true / false;
        //    return Auth::user()->can('manager');
        // });
    }
}
