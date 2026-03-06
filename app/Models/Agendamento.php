<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente_id',
        'funcionario_id',
        'data',
        'hora',
    ];

    public function cliente(){
        return $this->belongsTo('Cliente::class');
    }
    public function profissional(){
        return $this->belongsTo('Profissional::class');
    }
    public function servico(){
        return $this->belongsTo('Servico::class');
    }
    public function agendamento(){
        return $this->hasMany('Agendamento::class');
    }
}
