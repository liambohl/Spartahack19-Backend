<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 1/19/2019
 * Time: 3:36 PM
 */

require_once __DIR__ . '/../../lib/Site.php';
require_once __DIR__ . '/../../lib/Movie.php';
require_once __DIR__ . '/../../lib/Movies.php';

$site = new SpartahackV\Site();

$user_id = $_GET["user_id"];
$number_of_movies = intval($_GET["n"]);

$movies = [];

if ($user_id !== null and $number_of_movies !== null) {
    $table = new spartahackV\Movies($site);
    $movies = $table->new_movies($user_id, $number_of_movies);
}

if ($movies === []) {
    echo '<movies success="false" error="Invalid user or can\'t find movies"></movies>';
} else {
    echo '<movies success="true">';
    foreach ($movies as $movie) {
        echo $movie->as_xml();
    }
    echo '</movies>';
}