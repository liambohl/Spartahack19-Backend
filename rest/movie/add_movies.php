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

$json = file_get_contents('php://input');
$movies = json_decode($json, true);
$table = new spartahackV\Movies($site);

foreach ($movies as $movie_array) {
    $table->add_to_database($movie_array);
}