<?php 

session_start();

if (!isset($_SESSION['zalogowany'])){
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Google Fonts -->
        <!-- Styling for public area -->
        <link rel="stylesheet" href="static/glowny.css">
        <meta charset="UTF-8">
        <title>Konto</title>
</head>
<body>

<!-- navbar -->
<?php include('nav.php');?>

<!-- img -->
<div class="img">
    <h1>Skuteczna walka z bolem</h1>
</div>

<!-- main body -->
<div class = "glowny">
    <div class="column" >
        <div class="leftcolumn">
            <?php echo "<h2>Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko']."</h2>" ?>
            <h2> asdasd </h2>
            <?php echo "<a href='logout.php' style='color:black'>Wyloguj się</a>"?>
        </div>
        <div class="rightcolumn">
            <h2>Rok</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>
        </div>
    </div>
</div>

<!-- footer -->
<div id="footer">
    <p id="link"><a href="https://www.facebook.com/EwaPsalmisterWilk">Footer</p>
</div>

</body>
</html>