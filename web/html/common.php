<?php
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
