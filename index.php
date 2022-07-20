<?php 

session_start();

require_once('database.php'); 

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Google Fonts -->
        <!-- Styling for public area -->
        <link rel="stylesheet" href="static/glowny.css">
        <meta charset="UTF-8">
        <title>Aktualnosci</title>
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
            <h1>Aktualności</h1>
            <?php echo "<h2>liczba postów: ".$_SESSION['liczbapostow']."</h2>" ?>
            <div id='post'>
                <h2><?php echo $_SESSION['tytul'] ?></h2>
                <p>sadsd</p>
            </div>
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