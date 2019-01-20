<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 1/20/2019
 * Time: 1:32 AM
 */

require_once __DIR__ . '/../../lib/Site.php';
require_once __DIR__ . '/../../lib/Movies.php';

$site = new SpartahackV\Site();

$user_id = $_GET["user_id"];
$movie_id = $_GET["movie_id"];
$value = intval($_GET["value"]);

if ($user_id !== null and $movie_id !== null and $value !== null) {
    $table = new spartahackV\Movies($site);
    $table->react($user_id, $movie_id, $value);
}
