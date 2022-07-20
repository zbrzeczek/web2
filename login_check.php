<?php 

	session_start();

	require_once('database.php');

	if((!isset($_POST['email'])) || (!isset($_POST['haslo']))){
		header('Location: index.php');
		exit();
	}

	$email_log = $_POST['email'];
	$haslo_log = $_POST['haslo'];

	$email_log = htmlentities($email_log, ENT_QUOTES, "UTF-8");

	if ($result = @$conn->query(
		sprintf("SELECT klienci.* , loginy.* 
		FROM klienci
		INNER JOIN loginy ON klienci.log = loginy.id 
		WHERE loginy.email='%s'",
		mysqli_real_escape_string($conn,$email_log)))){

		$wynik = $result->num_rows;

		if ($wynik>0){

			$wiersz = $result->fetch_assoc();

			if (password_verify($haslo_log, $wiersz['haslo'])){
				
				$_SESSION['zalogowany'] = true;

				$_SESSION['id'] = $wiersz['id'];
				$_SESSION['imie'] = $wiersz['imie'];
				$_SESSION['nazwisko'] = $wiersz['nazwisko'];
				$_SESSION['diagnoza'] = $wiersz['diagnoza'];

				unset($_SESSION['blad_log']);
				$result->close();
				header('Location: afterlog.php');
			}
			else {
				$_SESSION['blad_log'] = '<p class="error">Nieprawidłowe hasło</p>';
				header('Location: login.php');
			}
		}
		else {

			$_SESSION['blad_log'] = '<p class="error">Brak konta o takim emailu</p>';
			header('Location: login.php');

		}
	}
	else {
		echo 'error trying to send query';
	}

?>