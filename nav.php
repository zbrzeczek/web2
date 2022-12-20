<?php 

session_start();

require_once('database.php'); 

?>

<div class="nav">
    <h2 id='logo'>Skuteczna walka z bólem</h2>
    <a href='index.php' class="navcolor" id='base'>Aktualności</a>
    <a href='omnie.php' class="navcolor" id='base'>O mnie</a>
    <a href='oferta.php' class="navcolor" id='base'>Oferta</a>
    <a href='kalendarz.php' class="navcolor" id='base'>Kalendarz</a>
    <?php
        if($_SESSION['zalogowany'] == true) {
            echo "<a href='afterlog.php' class='navcolor' id='login'>Moje konto</a>";
        }
        else {
            echo "<a href='login.php' class='navcolor' id='login'>Zaloguj</a>";
            echo "<a href='rejestracja.php' class='navcolor' id='login'>Rejestracja</a>";
        }
    ?>
</div>