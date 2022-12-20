<?php 

require_once('database.php');

session_start();

try {

    $polaczenie = new mysqli($hostName, $userName, $password, $databaseName);

    if ($polaczenie->connect_errno!=0) {
        throw new Exeption(mysqli_connect_errno());
    }
    else {
        if (isset($_POST['miesiac']) and isset($_POST['rok'])){
            $msc = $_POST['miesiac']+1;
            $rok = $_POST['rok'];
        }
        else {
            $msc = date("m");
            $rok = date("Y");
        }

        $dzisDzien = date("d");

        function iloscDni($miesiac, $rok){
            if ($miesiac == 1 or $miesiac == 3 or $miesiac == 5 or $miesiac == 7 or $miesiac == 8 or $miesiac == 10 or $miesiac == 12) return 31;
            elseif ($miesiac == 2 and $rok%4 == 0) return 29;
            elseif ($miesiac == 2 and $rok%4 != 0) return 28;
            else return 30;
        }

        $date = $rok.'-'.$msc.'-01';

        function kalendarz($miesiacKal, $rokKal, $date){

            $dzien = 1;
            
            $weekDay = date('w', strtotime($date));

            $dniMsc = iloscDni($miesiacKal, $rokKal);
            while ($dzien <= $dniMsc){
                echo '<tr>';
                for ($j = 0; $j < 7; $j++){
                    echo '<td>';
                    if  ($dzien <= 1 and $j > $weekDay-2){
                        echo '<p>'.$dzien.'</p>';
                        $dzien++;
                    }
                    else if ($dzien>1 and $dzien <= iloscDni($miesiacKal, $rokKal)){
                        echo '<p>'.$dzien.'</p>';
                        $dzien++;
                    }
                }
                echo '</td>';
            }   
            echo '</tr>';
        }
        $polaczenie->close();
    }
}
catch(Exeption $er){
    echo '<div style="color:red;">Błąd serwera</div>';
    echo '<br>Informacja developerska: '.$er;
}
// wyciagnij wszystkie posty w kolejnosci od najwczesniejszego i zapisz w kolumnie i zapisz zmienne session
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="static/glowny.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kalendarz</title>
</head>
<body>

<?php include('nav.php');?>

<div class="img">
    <h1>Skuteczna walka z bólem</h1>
</div>

<div class = "glowny">
    <div class="column"  id="text">
        <h1>Kalendarz</h1>
        <h2 style="text-align:center;" id="miesiacRok"></h2>
        <table class="table" id="calendar">
            <thead>
                <tr id="dniTyg">
                    <th>Pon</th>
                    <th>Wt</th>
                    <th>Śr</th>
                    <th>Czw</th>
                    <th>Pt</th>
                    <th>Sob</th>
                    <th>Ndz</th>
                </tr>
            </thead>
            <tbody id="tbody">
                <?php kalendarz($msc, $rok, $date) ?>
            </tbody>
        </table>
        <br/>
        <div class="form-inline">
            <button class="poprzedni" id="poprzedni" onclick="previous()">Poprzedni miesiąc</button>
            <button class="nastepny" id="nastepny" onclick="next()">Następny miesiąc</button>
        </div>
        <br/>
        <form class="form-inline" method="post">

            <label class="miesiac" for="miesiac">Jump To: </label>
            <select class="miesiac" name="miesiac" id="miesiac" onchange="jump(); return false">
                <option value=0>Styczeń</option>
                <option value=1>Luty</option>
                <option value=2>Marzec</option>
                <option value=3>Kwiecień</option>
                <option value=4>Maj</option>
                <option value=5>Czerwiec</option>
                <option value=6>Lipiec</option>
                <option value=7>Sierpień</option>
                <option value=8>Wrzesień</option>
                <option value=9>Padźiernik</option>
                <option value=10>Listopad</option>
                <option value=11>Grudzień</option>
            </select>

            <label for="rok"></label>
            <select class="rok" name="rok" id="rok" onchange="jump(); return false">
                <option value=2022>2022</option>
                <option value=2023>2023</option>
                <option value=2024>2024</option>
                <option value=2025>2025</option>
                <option value=2026>2026</option>
                <option value=2027>2027</option>
                <option value=2028>2028</option>
                <option value=2029>2029</option>
                <option value=2030>2030</option>
            </select>
            <input type="submit" value="Przejdź" id="loginbutton">
        </form>
    </div>
</div>
</body>
</html>