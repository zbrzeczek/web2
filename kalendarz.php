<?php 

require_once('database.php');

session_start();

try {

    $polaczenie = new mysqli($hostName, $userName, $password, $databaseName);

    if ($polaczenie->connect_errno!=0) {
        throw new Exeption(mysqli_connect_errno());
    }
    else {

        $wizytySQL = $polaczenie->query("SELECT * FROM wizyty ORDER BY dataa ASC");

        if (!$wizytySQL) throw new Exeption($polaczenie->error);
  
        $wizyty = $wizytySQL->fetch_assoc();

        $numwizyt = $wizytySQL->num_rows();
        
        /*for ($i = 0; $i < $numwizyt;$i++){
            if 
        }
        $_SESSION['']*/
            
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
        <!-- Google Fonts -->
        <!-- Styling for public area -->
        <link rel="stylesheet" href="static/glowny.css">
        <meta charset="UTF-8">
        <title>O mnie</title>
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
            </tbody>
        </table>
        <br/>
        <div class="form-inline">
            <button class="poprzedni" id="poprzedni" onclick="previous()">Poprzedni miesiąc</button>
            <button class="nastepny" id="nastepny" onclick="next()">Następny miesiąc</button>
        </div>
        <br/>
        <form class="form-inline">

            <label class="miesiac" for="miesiac">Jump To: </label>
            <select class="miesiac" name="miesiac" id="miesiac" onchange="jump()">
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
            <select class="rok" name="rok" id="rok" onchange="jump()">
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
        </form>
    </div>
</div>
<script src="static/js.js"></script>
<!-- footer -->
<div id="footer">
    <p id="link"><a href="https://www.facebook.com/EwaPsalmisterWilk">Footer</p>
</div>

</body>
</html>