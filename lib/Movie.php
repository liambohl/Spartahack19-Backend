<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 1/19/2019
 * Time: 11:40 AM
 */

namespace SpartahackV;

class Movie
{
    /**
     * Movie constructor.
     * @param $movie_array array All fields from the movie's database entry
     */
    public function __construct($movie_array) {
        $this->id = $movie_array["id"];
        $this->name = $movie_array["name"];
        $this->poster_filename = $movie_array["poster_filename"];
        $this->trailer_url = $movie_array["trailer_url"];
        $this->release_year = $movie_array["release_year"];
        $this->budget = $movie_array["budget"];
        $this->box_office = $movie_array["box_office"];
        $this->mpaa = $movie_array["mpaa"];
        $this->duration = $movie_array["duration"];
        $this->imdb = $movie_array["imdb"];
        $this->rotten_tomatoes = $movie_array["rotten_tomatoes"];

        // Fill in people and genre
    }

    /**
     * Represent the movie as XML.
     * @return string XML representation
     */
    public function as_xml() {
        // Open tag with attributes
        $xml = "<movie id=\"$this->id\" name=\"$this->name\" poster_filename=\"$this->poster_filename\" " .
            "trailer_url=\"$this->trailer_url\" release_year=\"$this->release_year\" budget=\"$this->budget\" " .
            "box_office=\"$this->box_office\" mpaa=\"$this->mpaa\" duration=\"$this->duration\" imdb=\"$this->imdb\" " .
            "rotten_tomatoes=\"$this->rotten_tomatoes\">";

        // Directors, writers, actors, genres as child elements
        foreach ($this->directors as $director) {
            $xml .= "<director name=$director->name></director>";
        }
        foreach ($this->writers as $writer) {
            $xml .= "<writer name=$writer->name></writer>";
        }
        foreach ($this->actors as $actor) {
            $xml .= "<actor name=$actor->name></actor>";
        }
        foreach ($this->genres as $genre) {
            $xml .= "<genre name=$genre->name></genre>";
        }

        // Close tag
        $xml .= "</movie>";

        return $xml;
    }

    public $id;
    public $name;
    public $poster_filename;
    public $trailer_url;
    public $release_year;
    public $budget;
    public $box_office;
    public $mpaa;
    public $duration;
    public $imdb;
    public $rotten_tomatoes;

    public $directors = [];
    public $writers = [];
    public $actors = [];
    public $genres = [];
}