<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendasRealizada extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id',
    'nome_cliente',
    'email_cliente',
    'telefone_cliente',
    'valor',
    'produto',
    'quantidade',
    'data'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
