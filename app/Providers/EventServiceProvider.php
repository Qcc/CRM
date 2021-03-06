<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        //注册事件监听器监听 EmailVerified 邮箱验证事件
        \Illuminate\Auth\Events\Verified::class => [
            \App\Listeners\EmailVerified::class,
        ],
        //注册事件监听器监听 EmailVerified 邮箱验证事件
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\UserLogin::class,
        ],
        //注册事件监听器监听 EmailVerified 邮箱验证事件
        \Illuminate\Auth\Events\PasswordReset::class => [
            \App\Listeners\UserPasswordReset::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
