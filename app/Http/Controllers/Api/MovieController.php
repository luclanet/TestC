<?php

namespace App\Http\Controllers\Api;

use App\Helpers\TMDB;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends BaseController
{
    /**
     * Return movies from database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function movies(Request $request)
    {
        return $this->success(Movie::paginate(10));
    }

    /**
     * Return movies from database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function movie($id)
    {
        $movie = TMDB::id($id);
        return $this->success($movie);
    }
}