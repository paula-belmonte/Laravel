<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $fillable = ['descripcion'];
    public function chocolates()
    {
        return $this->hasMany(Chocolate::class, 'codigotipo');
    }
}
