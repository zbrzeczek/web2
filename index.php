<?php 

session_start();

require_once('database.php'); 

try {
    $polaczenie = @new mysqli($hostName, $userName, $password, $databaseName);
        
    if ($polaczenie->connect_errno!=0){
        throw new Exeption(mysqli_connect_errno());
    }
    else{

        $i=0;
        //i is num of site 
        $j = $i*4;

        $postySQL = "SELECT * FROM posty ORDER BY dataa DESC ";

        if ($posty = $polaczenie->query($postySQL)){

            $liczbaPostow = $posty->num_rows;

            if ($liczbaPostow>0){

                for($p = 0; $p < 4; $p++){
                    $postSQL = "SELECT * FROM posty WHERE id=$p+$j";
                    $result = $polaczenie->query($postSQL);
                    $post = $result->fetch_assoc();

                    $_SESSION['tytul'] = $post['tytul'];
                    echo $tytul;
                    $_SESSION['tresc'] = $post['tresc'];
                    $dataa = $post['dataa'];
                    $img = $post['img'];
                }
            }
            else {
                $_SESSION['blad_post'] = '<p>Brak postów</p>';
            }
        }
        else{
            throw new Exception($polaczenie->error);
        }
    }
}
catch(Exeption $er){
    echo '<div style="color:red;">Błąd serwera</div>';
    echo '<br>Informacja developerska: '.$er;
}
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
            <div id='post'>
                <?php echo "<h2>".$_SESSION['tytul']."</h2>" ?>
                <p><?php echo $tresc ?></p>
            </div>
        </div>
        <div class="rightcolumn">
            <div class="formRok">
                <button class="2022" id="poprzedni" onclick="previous()">Poprzedni miesiąc</button>
                <button class="2023" id="nastepny" onclick="next()">Następny miesiąc</button>
            </div>
        </div>
    </div>
</div>

<!-- footer -->
<div id="footer">
    <p id="link"><a href="https://www.facebook.com/EwaPsalmisterWilk">Footer</p>
</div>

</body>
</html>