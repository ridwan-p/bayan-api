<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quran extends Model
{
    protected $fillable = [
    	// foregn key
    	'reciter_id',

    	// data
    	'surah',
    	'description',
    	'mp3',
    	'category'
    ];

    public function reciter()
    {
    	return $this->belongsTo(Reciter::class);
    }

    public function tags()
    {
    	return $this->belongsToMany(Tag::class);
    }
}
