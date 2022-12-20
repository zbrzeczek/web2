<?php
    session_start();

    require_once('database.php'); 

	if (!isset($_SESSION['zalogowany'])){
        header('Location: index.php');
        exit();
    }

    try {
        $polaczenie = @new mysqli($hostName, $userName, $password, $databaseName);
        if ($polaczenie->connect_errno!=0){
            throw new Exeption(mysqli_connect_errno());
        }
        else{
            $id = $_GET['id'];
            $postSQL = "SELECT * FROM posty WHERE id=$id+1 ";
    
            if ($post = $polaczenie->query($postSQL)){
    
                $wierszpost = $post->fetch_assoc();
                $tresc = $wierszpost['tresc'];
                $tytul = $wierszpost['tytul'];
                $dataa = $wierszpost['dataa'];
            }
            else{
                throw new Exception($polaczenie->error);
            }

            if (isset($_POST['komTresc'])){
                if (isset($_SESSION['zalogowany'])){
                    try {
                        $polaczenie = new mysqli($hostName, $userName, $password, $databaseName);
                        
                        if ($polaczenie->connect_errno!=0) {
                            throw new Exeption(mysqli_connect_errno());
                        }
                        else {		
                            $klientID = $_SESSION['id'];
                            echo $klientID;
                            $nKomTresc = $_POST['komTresc'];
                            $dzis = date("Y-m-d");

                            if ($polaczenie->query("INSERT INTO komentarze VALUES (NULL, $klientID, '$nKomTresc', '$dzis', $id+1)")){
                                $output = '<div class="error">Dodano komentarz!</div>';
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
                }
                else {
                    $output = '<div class="error">Musisz byc zalogowany!</div>';
                    unset($_SESSION['komTresc']);
                }
            }

            $numKomSQL = "SELECT * FROM komentarze WHERE post = $id+1 ORDER BY dataa DESC ";

            if ($numKom = $polaczenie->query($numKomSQL)){

                $liczbaKom = $numKom->num_rows;

                
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
        <link rel="stylesheet" href="static/glowny.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Post</title>
</head>
<body>

<?php include('nav.php');?>

<div class="img">
    <h1>Skuteczna walka z bólem</h1>
</div>

<div class = "glowny">
    <div class="column"  id="text">
        <?php 
            echo '<h1 style="margin: 25px;">'.$tytul.'</h1>';
            echo '<p style="margin: 25px;">'.$dataa.'</p>';
            echo '<p style="margin: 25px;">'.$tresc.'</p>';
        ?>
        <div id="kom">
            </h2>Dodaj komentarz:</h2><br>
            <form method="post">
                <input type="text" name="komTresc" id="komTresc"><br>
                <input type="submit" value="dodaj" id="komButton"><br>
            </form>
            <h3><?php echo $output ?></h3>
            </h2">Liczba komentarzy: <?php echo $liczbaKom ?></h2><br>
            <?php
                for ($i = 0; $i < $liczbaKom; $i++){
                    $komSQL = "SELECT * FROM komentarze WHERE id=$liczbaKom-$i and post=$id+1";
                    $kom = $polaczenie->query($komSQL);
                    $komWiersz = $kom->fetch_assoc();
                    
                    $komTresc = $komWiersz['tresc'];
                    $komID = $komWiersz['id'];
                    $komKlient = $komWiersz['klient'];
                    $komDataa = $komWiersz['dataa'];
                   
                    $klient = $polaczenie->query("SELECT * FROM klienci WHERE id=$komKlient");
                    $klientWiersz = $klient->fetch_assoc();
                    
                    $kImie = $klientWiersz['imie'];
                    $kNazwisko = $klientWiersz['nazwisko'];
                    
                    echo '<div id="kom1">';
                    echo '<h2>'.$kImie.' '.$kNazwisko.'</h2>';
                    echo '<p>'.$komDataa.'</p>';
                    echo '<p>'.$komTresc.'</p>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</div>
</body>
</html>