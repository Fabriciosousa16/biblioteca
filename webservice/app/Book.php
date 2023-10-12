<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'livro_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome_livro'
    ];

    public function rentals()
    {
        return $this->hasMany(Rent::class, 'livro_id', 'livro_id');
    }

}
