<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryStore extends Model
{
    
    protected $table = 'temporary_files';

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

    public function getIconAttribute()
    {
        return mimeToIcon($this->mime);
    }
}