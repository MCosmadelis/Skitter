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
	  <a href="/home.php">Home</a>
	  <a href="/profile.php">Profile</a>
	  <a class="active" href="/settings.php">Settings</a>
	  <div class="search-container">
	    <form action="/search.php">
	      <input type="text" placeholder="Search.." name="search">
	      <button type="submit">Submit</button>
	    </form>
	  </div>
	</div>
        
        <div class="container">
            <form action="/changeDisplayName.php" method="POST">
                <input name="displayname" type="text" placeholder="Change Display Name" required>
            </form>
            <form action="/changeEmail.php" method="POST">
                <input name="email" type="email" placeholder="Change Email" required>
            </form>
            <button onclick="myFunction()">Try it</button>

           <form enctype="multipart/form-data" action="/changeProfileImage.php" method="post">
            <input id="image" type="file" name="image" />
	      <button type="submit">Submit</button>
            </form> 
	</div>


    </body>



</html>
';
?>
