<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('regla_fechas',function($attribute,$value,$parameters,$validator){
            $start = $validator->getdata()[$parameters[0]];
            $end = $validator->getdata()[$parameters[1]];

            if ($start != null and $end != null) {
                //verificar que el start <= endal en ese caso retornar true sino retornar false
                if (strtotime($start) <= strtotime($end)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        },'Verificar que el inicio sea menor o igual al final');
    }
}
