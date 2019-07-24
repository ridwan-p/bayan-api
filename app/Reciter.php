<?php

namespace App;

use App\Helpers\HasManyRelation;
use Illuminate\Database\Eloquent\Model;

class Reciter extends Model
{
	use HasManyRelation;
    protected $fillable = [
    	'name',
    	'description',
    	'address'
    ];

    public function qurans()
    {
    	return $this->hasMany(Reciter::class);
    }
}
