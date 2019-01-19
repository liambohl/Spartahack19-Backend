<?php
/*
 * Connect four game state updating
 */
require_once "db.inc.php";
echo '<?xml version="1.0" encoding="UTF-8" ?>';

// Ensure the xml post item exists
if(!isset($_POST['xml'])) {
    echo '<game status="no" msg="missing XML" />';
    exit;
}

processXml(stripslashes($_POST['xml']));

/**
 * Process the XML query
 * @param $xmltext the provided XML
 */
function processXml($xmltext)
{
    // Load the XML
    $xml = new XMLReader();
    if (!$xml->XML($xmltext)) {
        echo '<game status="no" msg="invalid XML" />';
        exit;
    }

    // Connect to the database
    $pdo = pdo_connect();

    // Read to the start tag
    while ($xml->read()) {
        if ($xml->nodeType == XMLReader::ELEMENT && $xml->name == "gameState") {
            // We have the user tag
            $magic = $xml->getAttribute("magic");
            if($magic != "xVec910lvL") {
                echo '<game status="no" msg="magic" />';
                exit;
            }

            $player = $xml->getAttribute("player");
            $column= $xml->getAttribute("boardColumn");
            $winner = $xml->getAttribute("winner");
            $surrender = $xml->getAttribute("surrender");
            $board = $xml->getAttribute("board");

            $query = "REPLACE INTO connectfourgame (id, player, boardColumn, winner, surrender, board) VALUES (0, '$player', '$column', '$winner', '$surrender', '$board')";

            if(!$pdo->query($query)) {
                echo '<game status="no" msg="update failed">' . $query . '</game>';
                exit;
            }

            echo '<game status="yes"/>';
            exit;
        }
    }

    echo '<game save="no" msg="invalid XML" />';
}


