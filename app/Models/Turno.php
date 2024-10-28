<?php

namespace App\Models;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;
    
    protected $fillable = ['paciente', 'fecha', 'hora', 'estado'];

    // En el modelo Turno
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

}
