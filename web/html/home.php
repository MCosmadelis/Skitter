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



if($stmt = $mysqli->prepare("select name from users inner join sessions on users.username = sessions.username where sessions.sessionid=?")){
    if($stmt->bind_param("s", $_COOKIE['skitter'])){
        if(!$stmt->execute()){
	    die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
        }
        if($res = $stmt->get_result()){
	    $row = $res->fetch_assoc();
	    if($res->num_rows !== 1){
	        die('Error - There is an issue with the database, contact your administrator');
	    }else{
	        $username = $row['name'];
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

if($stmt = $mysqli->prepare("select img from images inner join sessions on images.username = sessions.username where sessions.sessionid=?")){
    if($stmt->bind_param("s", $_COOKIE['skitter'])){
        if(!$stmt->execute()){
	    die("Error - Issue executing prepared statement: " . mysqli_error($mysqli));
        }
        if($res = $stmt->get_result()){
	    $row = $res->fetch_assoc();
	    if($res->num_rows !== 1){
		$bimage=NULL;
	        //die('Error - There is an issue with the database, contact your administrator');
	    }else{
	        $bimage = base64_encode( $row['img'] );
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


echo '
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Skitter</title>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/css/uikit.min.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/css/uikit.gradient.min.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/css/components/tooltip.gradient.min.css">
	<link rel="stylesheet" href="/css/custom.css">
     </head>


    <body>

	<div class="topnav">
	  <a class="navbar-brand" href="/home.php">Skitter</a>
	  <a class="active" href="/home.php">Home</a>
	  <a href="/profile.php">Profile</a>
          <a href="/settings.php">Settings</a>
          <a href="/logout.php">Logout</a>
	  <div class="search-container">
	    <form action="/search.php">
	      <input type="text" placeholder="Search.." name="search">
	      <button type="submit">Submit</button>
	    </form>
	  </div>
	</div>
	<div class="container">
	<div class="left">
	<img style="width:300px; border-radius:50%" alt="Avatar" src="data:image/jpeg;base64,'.$bimage.'"/>
		<br><h2 style:"margin-left:-50px;">' . $username . '</h2>
	</div>
        <div class="center">
            <form action="/newSkit.php">
                <textarea id="subject" name="subject" placeholder="What\'s on your mind?" style="height:75px;width:440px;resize:none"></textarea>
                <br>
                <button style="float:right;" type="submit">Submit</button>
            </form>
            <p>Skits go here</p>
        </div>
	</div>


    </body>



</html>
';
?>
