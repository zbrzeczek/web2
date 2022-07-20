<?php 

session_start();

require_once('database.php'); 

?>

<div class="nav">
    <h2 id='logo'>Skuteczna walka z bólem</h2>
    <a href='index.php' id='base'>Aktualności</a>
    <a href='omnie.php' id='base'>O mnie</a>
    <a href='oferta.php' id='base'>Oferta</a>
    <a href='kalendarz.php' id='base'>Kalendarz</a>
    <?php
        if($_SESSION['zalogowany'] == true) {
            echo "<a href='afterlog.php' id='login'>Moje konto</a>";
        }
        else {
            echo "<a href='login.php' id='login'>Zaloguj</a>";
            echo "<a href='rejestracja.php' id='login'>Rejestracja</a>";
        }
    ?>
</div>