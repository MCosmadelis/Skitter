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

$null = NULL;

$file_size =$_FILES['image']['size'];
$file_type=$_FILES['image']['type'];
$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

$extensions= array("jpeg","jpg","png");

if(in_array($file_ext,$extensions)=== false){
    echo 'Extension not allowed, please choose a JPEG or PNG file';
}

if($file_size > 2097152){
    echo 'File size must be 2 MB or less';
}


if($stmt = $mysqli->prepare("select username from sessions where sessionid=?")){
    if($stmt->bind_param("s", $_COOKIE['skitter'])){
        if(!$stmt->execute()){
            die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
        }
        if($res = $stmt->get_result()){
            $row = $res->fetch_assoc();
            if($res->num_rows !== 1){
                die('Error - There is an issue with the database, contact your administrator');
            }else{
                $username = $row['username'];
            }
        }else{
             die("Error - Getting results: " . mysqli_error($mysqli));
        }
    }else{
         die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
    }
}else{
    die("Error - Issue preparing statement: " . mysqli_error($mysqli));
}
$up = true;
if($stmt = $mysqli->prepare("select img from images where username=?")){
    if($stmt->bind_param("s", $username)){
        if(!$stmt->execute()){
            die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
        }
        if($res = $stmt->get_result()){
            $row = $res->fetch_assoc();
            if($res->num_rows !== 1){
		$up = false;
            }else{
		$up = true;
            }
        }else{
             die("Error - Getting results: " . mysqli_error($mysqli));
        }
    }else{
         die("Error - Issue binding prepared statement: " . mysqli_error($mysqli));
    }
}else{
    die("Error - Issue preparing statement: " . mysqli_error($mysqli));
}

if ($up){
	if($stmt = $mysqli->prepare("UPDATE images set img=? where username=? ")){
		if($stmt->bind_param("bs", $null, $username)){
		    if ( $image = fopen($_FILES['image']['tmp_name'], 'rb')){
			while (!feof($image)){
			    $stmt->send_long_data(0, fread($image, 8192));
			}
		    }
		    else { die("Unable to open image"); }
		    if(!$stmt->execute()){
			die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
		    }
		if($stmt->close()){
		    echo 'Profile picture has beed updated';
		    $good = true;
		}else{
		    die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
		}
	}
	else { die("error binding");}

	}else{
	    die("Error - Issue preparing statement: " . mysqli_error($mysqli));
	}
}else{
	if($stmt = $mysqli->prepare("INSERT INTO images (username, img) VALUES (?,?)")){
		if($stmt->bind_param("sb", $username, $null)){
		    if ( $image = fopen($_FILES['image']['tmp_name'], 'rb')){
			while (!feof($image)){
			    $stmt->send_long_data(1, fread($image, 8192));
			}
		    }
		    else { die("unable to open img"); }
		    if(!$stmt->execute()){
			die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
		    }
		if($stmt->close()){
		    $good = true;
		    echo 'Profile picture has been uploaded';
		}else{
		    die("Error - Failed to close prepared statement" . mysqli_error($mysqli));
		}
	}
	else { die("error binding");}

	}else{
	    die("Error - Issue preparing statement: " . mysqli_error($mysqli));
	}

}
?>
