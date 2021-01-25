<?php

namespace App\Helpers;

use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;

class TMDB
{

    /**
     * Retrieve movies from a particular date
     *
     * @return $movies
     */

    public static function retrieveByReleasedDate(Carbon $date)
    {
        $page = 0;
        $tot_pages = 1;
        $movies_data = [];

        while ($page < $tot_pages) {
            $page++;

            $query = [
                "primary_release_date.gte" => $date->format("Y-m-d"),
                "primary_release_date.lte" => $date->format("Y-m-d"),
                "page" => $page
            ];

            $data = self::executeRequest("/discover/movie", $query);

            $tot_pages = $data["total_pages"];

            $movies_data = array_merge($movies_data, $data["results"]);
        }

        return $movies_data;
    }

    /**
     * Retrieve list of genres
     *
     * @return $movies
     */

    public static function genres()
    {
        $genres = self::executeRequest("/genre/movie/list");
        return $genres["genres"];
    }

    /**
     * Retrieve single movie from id
     *
     * @return $movie
     */

    public static function id($id)
    {
        $movie = self::executeRequest("/movie/".$id);
        return $movie;
    }

    /**
     * Internal model to execute request to API
     *
     * @return $json reponse
     */

    private static function executeRequest($url, $query = [])
    {
        $query["api_key"] = env("TMDB_API_KEY");
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', env("TMDB_API_ENDPOINT") . $url,
                [
                    "query" => $query
                ]
            );
        } catch (RequestException $e) {
            throw new \Exception("Error on request TMDB ".PHP_EOL.$e->getMessage());
        }

        return json_decode($response->getBody(), true);
    }

}