<?php

$dbhost = 'sqlserv';
$dbuser = 'root';
$dbpass = 'password';
$dbname = 'skitter';
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    die( "Sorry, this website is experiencing problems.");
}

function isAuthenticated($sessionID){
    $data = array(
        'sessid' => $sessionID,
    );
    $url = 'http://auth:8080/isAuthenticated';
    $ch = curl_init($url);
    $postString = http_build_query($data, '', '&');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    if ($response == "invalid"){
        die("User not authenticated");
    }
    return true;
}


?>
