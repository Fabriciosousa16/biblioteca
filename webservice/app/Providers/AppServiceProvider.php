<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('livro_nao_alocado', function ($attribute, $value, $parameters, $validator) {
            list($livro_id, $data_hora) = $parameters;
        
            // Lógica de validação
            $count = DB::table('rentals')
                ->where('livro_id', $livro_id)
                ->where('dt_aluguel_ini', '<=', $data_hora)
                ->where('dt_aluguel_fim', '>=', $data_hora)
                ->count();
        
            return $count === 0; // Deve retornar true se a validação passar (ou seja, se o livro NÃO estiver alocado naquele momento)
        });
        
        
    }
}
