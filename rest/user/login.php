<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 1/19/2019
 * Time: 10:18 AM
 */

require_once __DIR__ . '/../../lib/Site.php';
require_once __DIR__ . '/../../lib/User.php';
require_once __DIR__ . '/../../lib/Users.php';

$site = new SpartahackV\Site();

$user = null;

$username = $_GET["username"];

if ($username !== null) {
    $table = new spartahackV\Users($site);
    $user = $table->login($username);
}

if ($user === null) {
    echo '<login success="false" error="Invalid login"></login>';
} else {
    echo '<login success="true">' . $user->as_xml() . '</login>';
}