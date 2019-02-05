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
        $this->plot = $movie_array["plot"];
        $this->poster_filename = $movie_array["poster_filename"];
        $this->trailer_url = $movie_array["trailer_url"];
        $this->release_year = $movie_array["release_year"];
        $this->box_office = $movie_array["box_office"];
        $this->mpaa = $movie_array["mpaa"];
        $this->duration = $movie_array["duration"];
        $this->imdb = $movie_array["imdb"];
        $this->rotten_tomatoes = $movie_array["rotten_tomatoes"];

        // Add many-to-many relationships if any are given
        if (array_key_exists("directors", $movie_array)) {
            $this->directors = $movie_array["directors"];
            $this->writers = $movie_array["writers"];
            $this->actors = $movie_array["actors"];
            $this->genres = $movie_array["genres"];
        }
    }

    /**
     * Escapes XML special chracters (& < > " and ')
     * @param $str string in which to escape special characters
     * @return string XML representation with escaped special characters
     */
    private function escape_xml($str){
        $str = str_replace("&","&amp;", $str);
        $str = str_replace("\"","&&quot;", $str);
        $str = str_replace(">","&gt;", $str);
        $str = str_replace("<","&gt;", $str);
        return str_replace("'","&apos;", $str);
    }

    /**
     * Represent the movie as XML.
     * @return string XML representation
     */
    public function as_xml() {

        // Prepares movie attributes for xml by escaping characters (& < > " and ')
        $xml_name = $this->escape_xml($this->name);
        $xml_plot = $this->escape_xml($this->plot);
        $xml_poster_filename = $this->escape_xml($this->poster_filename);
        $xml_trailer_url = $this->escape_xml($this->trailer_url);

        // Open tag with attributes
        $xml = "<movie id=\"$this->id\" name=\"$xml_name\" plot=\"$xml_plot\" poster_filename=\"$xml_poster_filename\" " .
            "trailer_url=\"$xml_trailer_url\" release_year=\"$this->release_year\" " .
            "box_office=\"$this->box_office\" mpaa=\"$this->mpaa\" duration=\"$this->duration\" imdb=\"$this->imdb\" " .
            "rotten_tomatoes=\"$this->rotten_tomatoes\">";

        // Directors, writers, actors, genres as child elements
        foreach ($this->directors as $director) {
            $xml .= "<director name=\"$director\"></director>";
        }
        foreach ($this->writers as $writer) {
            $xml .= "<writer name=\"$writer\"></writer>";
        }
        foreach ($this->actors as $actor) {
            $xml .= "<actor name=\"$actor\"></actor>";
        }
        foreach ($this->genres as $genre) {
            $xml .= "<genre name=\"$genre\"></genre>";
        }

        // Close tag
        $xml .= "</movie>";

        return $xml;
    }

    /**
     * Add a director to the movie
     * @param $name string The director's name
     */
    public function add_director($name) {
        $this->directors[] = $name;
    }

    /**
     * Add a writer to the movie
     * @param $name string The writer's name
     */
    public function add_writer($name) {
        $this->writers[] = $name;
    }

    /**
     * Add an actor to the movie
     * @param $name string The actor's name
     */
    public function add_actor($name) {
        $this->actors[] = $name;
    }

    /**
     * Add a genre to the movie
     * @param $name string The genre to add
     */
    public function add_genre($name) {
        $this->genres[] = $name;
    }

    private $id;
    private $name;
    private $plot;
    private $poster_filename;
    private $trailer_url;
    private $release_year;
    private $box_office;
    private $mpaa;
    private $duration;
    private $imdb;
    private $rotten_tomatoes;

    private $directors = [];
    private $writers = [];
    private $actors = [];
    private $genres = [];
}