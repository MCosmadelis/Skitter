<?php

if(!isset($_COOKIE["skitter"])){
        header('Location: index.php');
}

include("common.php");

if(!isAuthenticated($_COOKIE['skitter'])){
        header("Set-Cookie: skitter=deleted; expires=Thu, 01 Jan 1970 00:00:00 GMT");
        header("Location: /index.php");
    exit();
}

$timeNow = time();
if($stmt = $mysqli->prepare("delete from sessions where sessionid=?")){
    if($stmt->bind_param("s", $_COOKIE['skitter'])){
        if(!$stmt->execute()){
            die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
        }
    }
    if($stmt->close()){
        header("Set-Cookie: skitter=deleted; expires=Thu, 01 Jan 1970 00:00:00 GMT");
        header("Location: /index.php");
    }
    else{
        die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
    }
}

?>
