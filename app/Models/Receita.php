<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    use HasFactory;

    protected $table = 'receitas';
    public $timestamps = false;

    protected $fillable = [
        'id_usuarios',
        'id_categorias',
        'nome',
        'tempo_preparo_minutos',
        'porcoes',
        'modo_preparo',
        'ingredientes',
        'criado_em',
        'alterado_em'
    ];

    protected $casts = [
        'criado_em' => 'datetime',
        'alterado_em' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuarios');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categorias');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($receita) {
            $receita->criado_em = now();
            $receita->alterado_em = now();
        });

        static::updating(function ($receita) {
            $receita->alterado_em = now();
        });
    }
}
