<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $table = 'rentals';
    protected $primaryKey = 'aluguel_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'livro_id', 'usuario_id', 'dt_aluguel_ini', 'dt_aluguel_fim'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'usuario_id');
    }

    // Relação muitos-para-um com Livro
    public function books()
    {
        return $this->belongsTo(Book::class, 'livro_id', 'livro_id');
    }

}
