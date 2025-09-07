<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DinheiroEmprestado extends Model
{
        use HasFactory; // <- precisa estar aqui
    protected $table = 'dinheiro_emprestado';
    protected $fillable = [ 'user_id',
    'nome_cliente',
    'email_cliente',
    'telefone_cliente',
    'valor',
    'descricao',
    'data'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

