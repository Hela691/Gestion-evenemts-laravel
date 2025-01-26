<?php

namespace App\Models;
use HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
   

    protected $fillable = ['name', 'description', 'event_date', 'capacity'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }
}
