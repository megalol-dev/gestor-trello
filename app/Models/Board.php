<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function tareasPendientes()
    {
        return $this->tasks()
            ->where('estado', 'pendiente');
    }

    public function tareasProgreso()
    {
        return $this->tasks()
            ->where('estado', 'progreso');
    }

    public function tareasHechas()
    {
        return $this->tasks()
            ->where('estado', 'hecho');
    }

}
