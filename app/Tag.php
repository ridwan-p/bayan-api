<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
    	'slug'
    ];

    public function qurans()
    {
    	return $this->belongsToMany(Player::class);
    }
}
