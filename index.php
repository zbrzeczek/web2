<?php 

session_start();

require_once('database.php'); 

try {
    $polaczenie = @new mysqli($hostName, $userName, $password, $databaseName);
    if ($polaczenie->connect_errno!=0){
        throw new Exeption(mysqli_connect_errno());
    }
    else{
        $numOfSite=0; 
        $j = $numOfSite*4;

        $postySQL = "SELECT * FROM posty ORDER BY dataa DESC ";

        if ($posty = $polaczenie->query($postySQL)){
            $liczbaPostow = $posty->num_rows;

            if ($liczbaPostow < 4){
                $variable = $liczbaPostow;
            }
            else $variable = 4;
        }
        else{
            throw new Exception($polaczenie->error);
        }

        if(isset($_POST['previous'])){
            if ($numOfSite >0){
                $numOfSite--;
                $j = $numOfSite*4;
                unset($_POST['previous']);
            }
        }
        else if (isset($_POST['next'])){
            $numOfSite++;
            $j = $numOfSite*4;
            if ($liczbaPostow - $j < 4){
                $variable = $liczbaPostow - $j;
            }
            unset($_POST['previous']);
        }
        else if (isset($_POST['rok'])){
            $rok = $_POST['rok'];
            $postyrokSQL = "SELECT * FROM posty WHERE year(dataa) = $rok";

            if ($postyrok = $polaczenie->query($postyrokSQL)){
                $liczbaPostow = $postyrok->num_rows;

                if ($liczbaPostow < 4){
                    $variable = $liczbaPostow;
                }
                else $variable = 4;
            }
            else{
            throw new Exception($polaczenie->error);
            }
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
        <title>Aktualnosci</title>
</head>
<body>

<?php include('nav.php');?>

<div class="img">
    <h1>Skuteczna walka z bólem</h1>
</div>

<div class = "glowny">
    <div class="column" >
        <div class="leftcolumn">
            <h1>Aktualności</h1>
            <?php 
                if ($liczbaPostow>0){
                    for($p = 0; $p < $variable; $p++){
                        $r = $p+$j;
                        $postSQL = "SELECT * FROM posty WHERE id=$r+1";
                        $result = $polaczenie->query($postSQL);
                        $post = $result->fetch_assoc();

                        $_SESSION['tytul'] = $post['tytul'];
                        $_SESSION['postID'] = $post['id'];
                        $_SESSION['tresc'] = $post['tresc'];
                        $_SESSION['dataa'] = $post['dataa'];
                        $img = $post['img'];

                        echo '<div id="post">';
                        echo '<a href="post.php?id='.$r.'" id="posthref">'.$_SESSION['tytul'].'</a>';
                        echo '<p>'.$_SESSION['tresc'].'</p>';
                        echo '</div>';
                    }
                }
                else {
                    echo 'brak postow';
                }
            ?>
        </div>
        <div class="rightcolumn">
            <form method="post">
                <br>
                <button id="loginbutton" name="previous">Poprzednia strona</button>
                <button id="loginbutton" name="next">Nastepna strona</button>
                <br><br>
                <label for="rok">Filtruj według roku</label><br>
                <select class="rok" name="rok" id="rok">
                    <option value=2021>2021</option>
                    <option value=2022>2022</option>
                    <option value=2023>2023</option>
                </select><br>
                <input type="submit" value="Przejdź" id="loginbutton">
            </div>
        </div>
    </div>
</div>
</body>
</html>