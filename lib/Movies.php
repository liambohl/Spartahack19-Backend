<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 1/19/2019
 * Time: 12:21 PM
 */

namespace spartahackV;

require_once __DIR__ . '/Table.php';

class Movies extends Table
{
    /**
     * Table constructor
     * @param Site, $site The site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, 'movie');
    }

    /**
     * Show the user one or more new movies to rate
     * @param $user_id integer Id of the user requesting new movies
     * @param $number_of_movies integer Number of new movies to find
     * @return array Selected movies ordered from best to worst
     */
    public function newMovies($user_id, $number_of_movies)
    {
        $pdo = $this->site->getPdo();

        // Get movie info
        $sql =<<<SQL
SELECT * from $this->tableName
ORDER BY rotten_tomatoes DESC
LIMIT ?;
SQL;
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $number_of_movies, \PDO::PARAM_INT);
        $statement->execute();

        // Create and return movies
        $movies = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $movie_array) {
            $movie = new Movie($movie_array);
            $movies[] = $movie;
        }
        return $movies;
    }

    /**
     * Accept a user's reaction to a movie
     * @param $user_id integer Id of user reacting
     * @param $movie_id integer Id of the movie which the user is reacting to
     * @param $reaction integer User's rating of the movie on a scale of -1 to 2
     */
    public function react($user_id, $movie_id, $reaction) {

    }

    /**
     * Get the movies a user has starred, i.e. rated 2 on a scale of -1 to 2
     * @param $user_id integer Id of the user requesting their starred movies
     * @return array Movies which the user has starred, from most to least recent
     */
    public function starred($user_id) {
        return [];
    }

    /**
     * Add a movie to the database
     * @param $movie array Associative array with data for the movie to add, which may or may not already be in the database
     */
    public function add_to_database($movie) {
        $pdo = $this->site->getPdo();

        // Check if movie exists; if so, stop
        $sql =<<<SQL
SELECT * from $this->tableName
where name=?;
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($movie["name"]));

        if($statement->rowCount() !== 0) {
            return;
        }

        // Add movie
        $sql = <<<SQL
INSERT INTO $this->tableName(name, poster_filename, trailer_url, release_year, budget, box_office, mpaa, duration, imdb, rotten_tomatoes)
VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($movie["name"], $movie["poster_filename"], $movie["trailer_url"],
                $movie["release_year"], $movie["budget"], $movie["box_office"], $movie["mpaa"], $movie["duration"],
                $movie["imdb"], $movie["rotten_tomatoes"])
        );
        $movie_id = $pdo->lastInsertId();

        // Add directors, writers, actors, genres, and their relationships to the movie
    }
}