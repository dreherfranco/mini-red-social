<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    //Relacion One to Many / Uno a muchos
    public function likes(){
        return $this->hasMany('\App\Like');
    }
    
    //Relacion One to Many / Uno a muchos
    public function comments(){
        return $this->hasMany('\App\Comment')->orderBy('id', 'desc');
    }
    
    //Relacion Many to one / Muchos a uno
    public function user(){
        return $this->belongsTo('\App\User', 'user_id');
    }
}
