<?php
namespace App\Helpers;

trait BelongsToManyRelation{

	/**
     * Store data belongs to many
     * @param  array $relations
     *
     */
	public function storeBelongsToMany($relations)
	{
		$this->save();

		foreach($relations as $key => $items) {
            $this->{$key}()->sync($items);
        }
	}
}