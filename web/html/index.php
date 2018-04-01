<?php ?>
<!DOCTYPE HTML>
<html>

<head>
  <div class="jumbotron text-center">
  <h1>Skitter</h1>
  <p>The secure Twitter!</p>
  </div>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<link rel="stylesheet" href="css/login.css">
<input type='checkbox' id='form-switch'>
<form id='login-form' action="/signin.php" method='post'>
  <input name="username" type="text" placeholder="Username" required>
  <input name="password" type="password" placeholder="Password" required>
  <button type='submit'>Login</button>
  <label for='form-switch'><span>Register</span></label>
</form>
<form id='register-form' action="/register.php" method='post'>
  <input name="username" type="text" placeholder="RIT Username (ex: abc1234)" required>
  <input name="email" type="email" placeholder="Email" required>
  <input name="name" type="text" placeholder="Display Name" required>
  <button type='submit'>Register</button>
  <label for='form-switch'>Login</label>
</form>
</html>
