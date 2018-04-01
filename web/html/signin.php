<?php
if(!empty($_POST)) {
        // Ensure that the user fills out fields
        if(empty($_POST['username'])) {
            die("Please enter a username.");
        }
        if(empty($_POST['password'])) {
            die("Please enter a password.");
        }
    }

    $data = array(
        'username' => $_POST['username'],
        'password' => $_POST['password'],
    );
    $url = 'http://auth:8080/signin';
    $ch = curl_init($url);
    $postString = http_build_query($data, '', '&');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    if($response == "fail"){
            die("Incorrect Credentials");
    }
    setcookie("skitter", $response, time() + (86400 * 30), "/");
    header("Location: home.php");

?>
