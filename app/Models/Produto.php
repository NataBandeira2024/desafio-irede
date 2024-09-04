<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

     protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'data_validade',
        'imagem',
        'categoria_id',
    ];

    protected $dates = ['data_validade'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
