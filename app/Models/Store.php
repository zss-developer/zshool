<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    
    protected $table = 'files';

   	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'mime', 'original_filename'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];


    protected $appends = ['icon'];
	/**
	 * @param $input
	 * @return mixed
	 */
	public function createStore($input) {
        return $this->insertGetId($input);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    public function getIconAttribute()
    {
        return mimeToIcon($this->mime);
    }
}