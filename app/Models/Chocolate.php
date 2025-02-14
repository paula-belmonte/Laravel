<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chocolate extends Model
{
    protected $fillable = ['nombre', 'marca', 'porcentaje', 'codigotipo'];
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'codigotipo');
    }
}
