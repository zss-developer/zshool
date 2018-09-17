<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class StorageSection extends  Model
{
    protected $table = 'storage_sections';

    protected $fillable = ['code','name', 'full_name'];


}