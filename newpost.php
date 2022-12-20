<?php
    session_start();

    require_once('database.php'); 

    try {
        $polaczenie = @new mysqli($hostName, $userName, $password, $databaseName);
        if ($polaczenie->connect_errno!=0){
            throw new Exeption(mysqli_connect_errno());
        }
        else{
            if (isset($_POST['postTytul']) and isset($_POST['postTresc'])){
                if (isset($_SESSION['zalogowany'])){	
                    $postTytul = $_POST['postTytul'];
                    $postTresc = $_POST['postTresc'];
                    $dzis = date("Y-m-d");
                    if ($polaczenie->query("INSERT INTO posty (tytul, tresc, dataa) VALUES ('$postTytul', '$postTresc', '$dzis')")){
                        echo '<div class="error">Dodano post!</div>';
                        header('Location: index.php');
                        exit();
                    }
                    else{
                        throw new Exception($polaczenie->error);
                    }                 
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
        <link rel="stylesheet" href="static/login.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wstaw post</title>
</head>
<body>

<?php include('nav.php');?>

<div class="img">
    <h1>Skuteczna walka z bólem</h1>
</div>

<div class = "glowny">
    <div class="column"  id="text">
        </h2>Dodaj post:</h2>
        <div id="kom">
            <form method="post">
                <h3>Tytuł:</h3>
                <input type="text" name="postTytul" id="postTytul"><br>
                <h3>Treść:</h3>
                <textarea type="text" name="postTresc" id="postTresc"></textarea>
                <input type="submit" value="dodaj" id="loginbutton"><br>
            </form>
        </div>
    </div>
</div>
</body>
</html>