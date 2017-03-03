<?php

namespace App\Providers;

use \DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('valid_members', function($attributes, $value, $parameters, \Illuminate\Validation\Validator $validator) {
            $group = $validator->attributes()[$parameters[0]];
            $count = $group->members()->
                whereIn('id', $value)->
                count();
            return $count == count($value);
        });

        \Validator::extend('valid_member', function($attributes, $value, $parameters, \Illuminate\Validation\Validator $validator) {
            $group = $validator->attributes()[$parameters[0]];
            $count = $group->members()->
                where('id', $value)->
                count();
            return $count == 1;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
