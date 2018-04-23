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
if(isset($_POST['displayname'])){
        if($stmt = $mysqli->prepare("SELECT username from sessions where sessionid=?")){
        if($stmt->bind_param("s", $_COOKIE['skitter'])){
            if(!$stmt->execute()){
                die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
            }
            if($res = $stmt->get_result()){
                $row = $res->fetch_assoc();
                if($res->num_rows != 1){
                    die("Failed");
                }
                $prep = "UPDATE users SET name=? WHERE username=?";
                if($stmt = $mysqli->prepare($prep)){
                    if($stmt->bind_param("ss", htmlspecialchars($_POST['displayname']), $row['username'])){
                        if(!$stmt->execute()){
                            die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
                        }
                    }else{
                        die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
                    }
                    if($stmt->close()){
                        echo "Value updated succesfully";
                        header("Location: /home.php");
                    }else{
                        die("Error - Failed to close prepared statement " . mysqli_error($mysqli));
                    }
                }else{
                    die("Error - Issue preparing statement: " . mysqli_error($mysqli));
                }

            }

        }

    }

}

?>
