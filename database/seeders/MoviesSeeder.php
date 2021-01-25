<?php

namespace Database\Seeders;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Helpers\TMDB;

class MoviesSeeder extends Seeder
{
    /**
     * Run the movie seeders.
     *
     * @return void
     */
    public function run()
    {
        $definition_genres = $this->genres();

        $movies = TMDB::retrieveByReleasedDate(new Carbon());

        foreach ($movies as $movie) {
            // Define genres
            $genres = [];
            foreach ($movie["genre_ids"] as $genre_id) {
                $genres[] = $definition_genres[$genre_id];
            }

            $movie = Movie::create([
                "name" => $movie["title"],
                "genre" => implode(",", $genres),
                "release_date" => $movie["release_date"],
                "details" => '<a href="javascript:void('.$movie["id"].')">Full Info</a>'
            ]);
        }
    }

    /**
     * Retrieve genres by Id
     *
     * @return array
     */
    private function genres() {
        $genres = TMDB::genres();
        $return = [];
        foreach ($genres as $genre) {
            $return[$genre["id"]] = $genre["name"];
        }
        return $return;
    }
}