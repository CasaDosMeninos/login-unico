<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('mailer', function ($app) {
            $app->configure('services');
            return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer');
        });

        Validator::extend('ldap_exists', function($attribute, $value, $parameters, $validator) { return User::valida($value); });

        $this->app->bind('ldap', function() {

            $conn = ldap_connect(env('LDAP_HOST'));
            ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);

            ldap_bind($conn, env('LDAP_BIND_DN'), env('LDAP_BIND_PASSWORD'));
            return $conn;
        });
    }
}
