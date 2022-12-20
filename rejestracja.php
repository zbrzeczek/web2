<?php 

session_start();

if (isset($_SESSION['zalogowany'])){
    header('Location: index.php');
    exit();
}


if(isset($_POST['email'])){

    $walidacja_ok = true;

    $imie = $_POST['imie'];

    if (!preg_match('@^[a-zA-ZąęćżźńłóśĄĆĘŁŃÓŚŹŻ]+$@',$imie)){
        $walidacja_ok=false;
        $_SESSION['e_imie']="Imię powinno składac się z liter a-z i polskich znaków";
    }
    if ((strlen($imie) < 3) || (strlen($imie) > 20)) {
        $walidacja_ok = false;
        $_SESSION['e_imie'] = "Imię musi posiadać od 3 do 20 znaków!";
    }

    $nazwisko = $_POST['nazwisko'];

    if (!preg_match('@^[a-zA-ZąęćżźńłóśĄĆĘŁŃÓŚŹŻ]+$@',$nazwisko)){
        $walidacja_ok=false;
        $_SESSION['e_nazwisko']="Nazwisko powinno składac się z liter a-z i polskich znaków";
    }
    if ((strlen($nazwisko) < 3) || (strlen($nazwisko) > 30)) {
        $walidacja_ok = false;
        $_SESSION['e_nazwisko'] = "Nazwisko musi posiadać od 3 do 30 znaków!";
    }

    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $emailafter = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (filter_var($emailafter, FILTER_VALIDATE_EMAIL) == false || ($emailafter != $email)){
        $walidacja_ok == false;
        $_SESSION['e_email'] = "Podaj poprawny email!";
    }

    $haslo = $_POST['haslo'];
    $haslo2 = $_POST['haslo2'];

    if ((strlen($haslo) < 8) || (strlen($haslo) > 20)) {
        $walidacja_ok = false;
        $_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
    }
    if ($haslo != $haslo2) {
        $walidacja_ok = false;
        $_SESSION['e_haslo'] = "Hasła nie mogą się różnić";
    }

    $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

    require_once("database.php");
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {

        $polaczenie = new mysqli($hostName, $userName, $password, $databaseName);

        if ($polaczenie->connect_errno!=0) {
            throw new Exeption(mysqli_connect_errno());
        }
        else {

            $resultat = $polaczenie->query("SELECT id FROM loginy WHERE email='$email'");

            if (!$resultat) throw new Exeption($polaczenie->error);
      
            $ileMaili = $resultat->num_rows;

            if ($ileMaili > 0){
                $walidacja_ok = false;
                $_SESSION['e_email'] = "Konto z takim email już istnieje";
            }

            if ($walidacja_ok==true){			
				if ($polaczenie->query("INSERT INTO loginy (email, haslo) VALUES ('$email', '$haslo_hash')")){

                    $emailcheck = $email;

                    $lastID = $polaczenie->query("SELECT * FROM loginy WHERE email='$emailcheck'"); 
                    
                    $emailrow = $lastID->fetch_assoc();

                    $realID = $emailrow['id'];
                    $_SESSION['id'] = $emailrow['id'];

                    if ($polaczenie->query("INSERT INTO klienci VALUES (NULL, '$imie', '$nazwisko', '$realID', 1)")){
                        
                        $_SESSION['imie'] = $imie;
                        $_SESSION['nazwisko'] = $nazwisko;
                        $_SESSION['zalogowany']=true;
                        header('Location: afterlog.php');
                    }
                    else{
                        throw new Exception($polaczenie->error);
                    }
			    }
				else{
					throw new Exception($polaczenie->error);
				}
					
			}
				
            $polaczenie->close();
        }
    }
    catch(Exeption $er){
        echo '<div style="color:red;">Błąd serwera</div>';
        echo '<br>Informacja developerska: '.$er;
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="static/glowny.css">
        <link rel="stylesheet" href="static/login.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rejestracja</title>
        <script src="https://www.google.com/recaptcha/enterprise.js?render=6LcaIdQgAAAAAEPa6odo_wJf_ralUkPd58dYRhnn"></script>
        <script>
        grecaptcha.enterprise.ready(function() {
            grecaptcha.enterprise.execute('6LcaIdQgAAAAAEPa6odo_wJf_ralUkPd58dYRhnn', {action: 'login'}).then(function(token) {
            ...
            });
        });
        </script>
</head>
<body>

<?php include('nav.php');?>

<div class="img2"></div>

<div class="login" id="lin">
    <h1 id="logmain">Rejestracja</h1>
    <form method="post">
        <p id="log">Imię</p>
        <input type="text" name="imie" id="wpis"><br>
        <?php
        if(isset($_SESSION['e_imie'])){
            echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
            unset($_SESSION['e_imie']);
        }
        ?>

        <p id="log">Nazwisko</p>
        <input type="text" name="nazwisko" id="wpis"><br>
        <?php
        if(isset($_SESSION['e_nazwisko'])){
            echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
            unset($_SESSION['e_nazwisko']);
        }
        ?>

        <p id="log">Email</p>
        <input type="text" name="email" id="wpis"><br>
        <?php
        if(isset($_SESSION['e_email'])){
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }
        ?>

        <p id="log">Hasło</p>
        <input type="password" name="haslo" id="wpis"><br>
        <?php
        if(isset($_SESSION['e_haslo'])){
            echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
            unset($_SESSION['e_haslo']);
        }
        ?>

        <p id="log">Powtórz hasło</p>
        <input type="password" name="haslo2" id="wpis"><br>
        <input type="submit" value="Umów wizytę" id="loginbutton">
    </form>
</div>
</body>
</html>