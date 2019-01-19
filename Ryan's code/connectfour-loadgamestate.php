<?php
/*
 * Connect four user matching
 */
require_once "db.inc.php";
echo '<?xml version="1.0" encoding="UTF-8" ?>';

if(!isset($_GET['magic']) || $_GET['magic'] != "xVec910lvL") {
    echo '<game status="no" msg="magic" />';
    exit;
}

// Process in a function (userid)
process($_GET['player']);

/**
 * Process the query
 * @param $player: the player whose turn to look for
 */
function process($player) {
    // Connect to the database
    $pdo = pdo_connect();

    getGameState($pdo, $player);
}


function getGameState($pdo, $player) {
    // Does the user exist in the database?

    $playerQ = $pdo->quote($player);
    $query = "SELECT player, boardColumn, winner, surrender, board FROM connectfourgame WHERE id='0' AND player=$playerQ";

    $rows = $pdo->query($query);

    if($row = $rows->fetch()) {

        $name = $row["player"];
        $column = $row["boardColumn"];
        $winner = $row["winner"];
        $surrender = $row["surrender"];
        $board = $row["board"];

        echo "<game status='yes' name=\"$name\" column=\"$column\" winner=\"$winner\" surrender=\"$surrender\" board=\"$board\"/>\r\n";

        $queryRemove = "DELETE FROM connectfourgame WHERE id='0' AND player=$playerQ";
        $pdo->query($queryRemove);

        exit;
    }

    echo '<game status="no" msg="no update" />';
    exit;
}