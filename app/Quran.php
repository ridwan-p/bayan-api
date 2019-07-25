<?php

namespace App;

use App\Helpers\BelongsToManyRelation;
use App\Helpers\HasManyRelation;
use Illuminate\Database\Eloquent\Model;

class Quran extends Model
{
	use BelongsToManyRelation, HasManyRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	// foregn key
    	'reciter_id',

    	// data
    	'surah',
    	'description',
    	'player',
    	'category'
    ];


    /**
     * Relation with reciters
     * @return [type] [description]
     */
    public function reciter()
    {
    	return $this->belongsTo(Reciter::class);
    }

    /**
     * Relation with tags
     * @return [type] [description]
     */
    public function tags()
    {
    	return $this->belongsToMany(Tag::class);
    }

    /**
     * Mutator player
     * @param \Illuminate\Http\UploadedFile $player
     */
    public function setPlayerAttribute($player)
    {
        $this->attributes['player'] = $player->store('players');
    }
}
