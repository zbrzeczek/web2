<?php 

session_start();

require_once('database.php');

if (isset($_SESSION['zalogowany'])){
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="static/glowny.css">
        <link rel="stylesheet" href="static/login.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
</head>
<body>

<?php include('nav.php');?>

<div class="img2"></div>

<div class="login" id="lin">
    <h1 id="logmain">Logowanie</h1>
    <form action="login_check.php" method="post">
        <p id="log">Email</p>
        <input type="text" name="email" id="wpis"><br>
        <p id="log">Hasło</p>
        <input type="password" name="haslo" id="wpis"><br>
        <?php
        if(isset($_SESSION['blad_log'])) {
            echo $_SESSION['blad_log'];
        }
        ?>
        <input type="submit" value="Zaloguj się" id="loginbutton">
    </form>
</div>
</body>
</html>