<?php
/*
 * Connect four user login
 */
require_once "db.inc.php";
echo '<?xml version="1.0" encoding="UTF-8" ?>';

if(!isset($_GET['magic']) || $_GET['magic'] != "xVec910lvL") {
    echo '<user status="no" msg="magic" />';
    exit;
}

// Process in a function (userid, pw)
process( $_GET['user'], $_GET['pw']);

/**
 * Process the query
 * @param $user: the user to look for
 * @param $password: the user password
 */
function process($user, $password) {
    // Connect to the database
    $pdo = pdo_connect();

    if(getUser($pdo, $user, $password)) {
        echo '<user status="yes">';
    }
}

/**
 * Ask the database for the user ID. If the user exists, the password
 * must match.
 * @param $pdo: PHP Data Object
 * @param $user: the user username
 * @param $password: the users password
 * @return true if the user exists and the passwords match
 */
function getUser($pdo, $user, $password) {
    // Does the user exist in the database?
    $userQ = $pdo->quote($user);
    $query = "SELECT password from connectfouruser where user=$userQ";

    $rows = $pdo->query($query);
    if($row = $rows->fetch()) {
        // We found the record in the database
        // Check the password
        if($row['password'] != $password) {
            echo '<user status="no" msg="password error" />';
            exit;
        }
        else{
            $queryOnline = "UPDATE connectfouruser SET online = '1' WHERE user = $userQ;";
            $pdo->query($queryOnline);
            return true;
        }
    }

    echo '<user status="no" msg="user error" />';
    exit;
}

