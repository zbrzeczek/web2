<?php 

session_start();

if (!isset($_SESSION['zalogowany'])){
    header('Location: index.php');
    exit();
}

require_once('database.php'); 

    try {
        $polaczenie = @new mysqli($hostName, $userName, $password, $databaseName);
        if ($polaczenie->connect_errno!=0){
            throw new Exeption(mysqli_connect_errno());
        }
        else{
            // for user to make an appointment
            if (isset($_POST['powod']) and isset($_POST['data']) and isset($_POST['godzina'])){
                $klient = $_SESSION['id'];
                $powod = $_POST['powod'];
                $dataa = $_POST['data'];
                $godzina = $_POST['godzina'].':00:00';
                if ($polaczenie->query("INSERT INTO poczekalnia (klient, powod, dataa, godzina) VALUES ('$klient', '$powod', '$dataa', '$godzina')")){
                    echo '<div class="error">Wysłano wizyte, prosze czekać na potwierdzenie</div>';
                }
                else{
                    throw new Exception($polaczenie->error);
                }                 
            }

            /*for admin to submit
            if (isset($_POST['potwierdz'])){
                $id = $_SESSION['zmiennaWizyt'];
                echo $id;
                if ($poczekalniaID = $polaczenie->query('SELECT * FROM poczekalnia WHERE id = "$id"')){
                    $poczekalniaWiersz = $poczekalnia->fetch_assoc();
                    echo $id;
                    $dataa = $poczekalniaWiersz['dataa'];
                    echo $dataa;
                    $godzina = $poczekalniaWiersz['godzina'];
                    echo $godzina;
                    $powod = $poczekalniaWiersz['powod'];
                    echo $powod;
                    if ($polaczenie->query("INSERT INTO przyszlewizyty (klient, dataa, godzina, powod) VALUES ('$id', '$dataa', '$godzina', '$powod')")){
                        echo 2;
                        if ($polaczenie->query("DELETE FROM poczekalnia WHERE id = '$id'")){
                            echo 3;
                            echo '<div class="error">Potwierdzono</div>';
                        }
                        else{
                            throw new Exception($polaczenie->error);
                        } 
                    }
                    else{
                        throw new Exception($polaczenie->error);
                    } 
                }
                else{
                    throw new Exception($polaczenie->error);
                }
            }
            else if (isset($_POST['odrzuc'])){
                if ($polaczenie->query("DELETE FROM poczekalnia WHERE id = $zmienna")){
                    echo '<div class="error">Odrzucono</div>';
                }
                else{
                    throw new Exception($polaczenie->error);
                } 
            }
            */
            $poczekalniaSQL = "SELECT * FROM poczekalnia ";

            if ($poczekalnia = $polaczenie->query($poczekalniaSQL)){
                $liczbaWizyt = $poczekalnia->num_rows;
                $wizytyWiersz = $poczekalnia->fetch_assoc();
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
        <title>Konto</title>
</head>
<body>

<?php include('nav.php');?>

<div class="img">
    <h1>Skuteczna walka z bólem</h1>
</div>

<div class = "glowny">
    <div class="column" >
        <div class="leftcolumn">
            <?php echo "<h2>Witaj ".$_SESSION['imie']." ".$_SESSION['nazwisko']."</h2>" ?>
            <?php 
            if ($_SESSION['id'] == 1){
                echo "<h2>Zaległe wizyty</h2>";
                $dzis = date("Y-m-d");
                for ($zmiennai = 0; $zmiennai <= $liczbaWiz+1; $zmiennai++){
                    $zalegle = $polaczenie->query("SELECT * FROM przyszlewizyty WHERE dataa = '$dzis' ORDER BY godzina ASC LIMIT 1 OFFSET $zmiennai");
                    $liczbaZalegle = $zalegle->num_rows;
                    $zalegleWiersz = $zalegle->fetch_assoc();
                    $idimie = $zalegleWiersz['klient'];
                    $imie = "SELECT * FROM klienci WHERE id = '$idimie'";
                    $klientImie = $polaczenie->query($imie);
                    $imieWiersz = $klientImie->fetch_assoc();
                    echo "<div id='wizyta'>";
                    echo "<h2>".$imieWiersz['imie']." ".$imieWiersz['nazwisko']." ".$zalegleWiersz['powod']."</h2>";
                    echo "<p>".$zalegleWiersz['dataa']."</p>";
                    echo "<p>".$zalegleWiersz['godzina']."</p>";
                    echo "<p>".$zalegleWiersz['wynik']."</p>";
                    echo "</div>";
                    echo "<br>";
                }
            }
            else {
                echo "<h2>Twoje wizyty</h2>";
                $idklient = $_SESSION['id'];
                if ($pol = $polaczenie->query("SELECT * FROM wizyty WHERE klient = '$idklient' ORDER BY dataa DESC")){
                    $liczbaWiz = $pol->num_rows;
                    $wizWiersz = $pol->fetch_assoc();
                    for ($z = 0; $z < $liczbaWiz; $z++){
                        echo "<div id='wizyta'>";
                        echo "<h2>".$wizWiersz['opis']."</h2>";
                        echo "<p>".$wizWiersz['wynik']."</p>";
                        echo "</div>";
                    }
                }
                else{
                    throw new Exception($polaczenie->error);
                }
            }
            ?>
            <br>
            <a href='logout.php' style='color:black'>Wyloguj się</a><br>
            <?php 
                if ($_SESSION['id'] == 1){
                    echo "<br>";
                    echo "<a href='newpost.php' style='color:black'>Dodaj post</a>";
                }
                ?>
        </div>
        <div class="rightcolumn">
            <?php 
                if ($_SESSION['id'] == 1){
                    echo '<h2>Prośby z wizytami</h2>';
                    for ($i = 0; $i<$liczbaWizyt;$i++){

                        echo '<div>';
                        echo '<h3>'.$wizytyWiersz['powod'].'</h3>';
                        echo '<p>'.$wizytyWiersz['dataa'].' '.$wizytyWiersz['godzina'].'</p>';
                        echo '<form method="post">
                                <input type="submit" name="potwierdz" value="Potwierdź" id="loginbutton" onclick='.$_SESSION['zmienna']=$i.'>
                                <input type="submit" name="odrzuc" value="Odrzuć" id="loginbutton" onclick='.$_SESSION['zmienna']=$i.'><br>
                              </form>';
                        echo '</div>';
                    }
                    
                }
                else {
                    echo '<h2>Zaplanuj wizytę</h2>';
                    echo '<form method="post">
                            <h3>Powód wizyty</h3>
                            <input type="text" name="powod" id="postTytul"><br>
                            <h3>Proponnowana data:</h3>
                            <input type="date" name="data" value="data" id="loginbutton"><br>
                            <h3>Godzina:</h3>
                            <select class="godzina" name="godzina" id="loginbutton">
                                <option value=08>8:00</option>
                                <option value=09>9:00</option>
                                <option value=10>10:00</option>
                                <option value=11>11:00</option>
                                <option value=12>12:00</option>
                                <option value=13>13:00</option>
                                <option value=14>14:00</option>
                                <option value=15>15:00</option>
                            </select><br><br>
                            <input type="submit" value="Potwierdź" id="loginbutton"><br>
                          </form>';
                }
                ?>
        </div>
    </div>
</div>
</body>
</html>