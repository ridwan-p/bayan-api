<?php

namespace App;

use App\Helpers\BelongsToManyRelation;
use Illuminate\Database\Eloquent\Model;

class Quran extends Model
{
	use BelongsToManyRelation;

    protected $fillable = [
    	// foregn key
    	'reciter_id',

    	// data
    	'surah',
    	'description',
    	'player',
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
