<?php
/*
 * Connect four new user creation
 */
require_once "db.inc.php";
echo '<?xml version="1.0" encoding="UTF-8" ?>';

// Ensure the xml post item exists
if(!isset($_POST['xml'])) {
    echo '<user status="no" msg="missing XML" />';
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
        echo '<user status="no" msg="invalid XML" />';
        exit;
    }

    // Connect to the database
    $pdo = pdo_connect();

    // Read to the start tag
    while ($xml->read()) {
        if ($xml->nodeType == XMLReader::ELEMENT && $xml->name == "user") {
            // We have the user tag
            $magic = $xml->getAttribute("magic");
            if($magic != "xVec910lvL") {
                echo '<user status="no" msg="magic" />';
                exit;
            }

            $user = $xml->getAttribute("username");
            $password = $xml->getAttribute("pw");

            $userQ = $pdo->quote($user);
            $checkQuery = "SELECT password from connectfouruser where user=$userQ";

            $rows = $pdo->query($checkQuery);
            if($row = $rows->fetch()) {
                // We found the record in the database, so this username is already taken
                echo '<user status="no" msg="username taken" />';
                exit;
            }

            $query = "INSERT INTO connectfouruser (id, user, password) VALUES (0, '$user', '$password')";

            if(!$pdo->query($query)) {
                echo '<user status="no" msg="creation failed">' . $query . '</user>';
                exit;
            }

            echo '<user status="yes"/>';
            exit;
        }
    }

    echo '<user save="no" msg="invalid XML" />';
}

