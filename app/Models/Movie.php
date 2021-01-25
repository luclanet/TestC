<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'genre',
        'release_date',
        'details'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $cast = [
        'release_data' => 'date'
    ];

}
