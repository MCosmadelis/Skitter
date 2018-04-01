<?php
if(!empty($_POST)) {
        // Ensure that the user fills out fields
        if(empty($_POST['username'])) {
            die("Please enter a username.");
        }
        if(empty($_POST['email'])) {
            die("Please enter a email.");
        }
        if(empty($_POST['name'])) {
            die("Please enter a display name.");
        }
    }

    $data = array(
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'name' => $_POST['name'],
    );
    $url = 'http://auth:8080/signup';
    $ch = curl_init($url);
    $postString = http_build_query($data, '', '&');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    if($response == "fail"){
            die("User account may already exist.");
    }
    header("Location: index.php");

?>
