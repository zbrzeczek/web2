<?php 

	session_start();

	require_once('database.php');

	$sql = "SELECT * FROM posty";

	if ($result = @$conn->query($sql)){

		$_SESSION['liczbapostow'] = $result->num_rows;

		if ($_SESSION['liczbapostow']>0){

			$wiersz = $result->fetch_assoc();

			$_SESSION['tytul'] = $wiersz['tytul'];
			$_SESSION['tresc'] = $wiersz['tresc'];
			$_SESSION['dataa'] = $wiersz['dataa'];
			$_SESSION['img'] = $wiersz['img'];

			$result->close();
			header('Location: posty.php');
		}
		else {

			$_SESSION['blad_post'] = '<p>Brak postów</p>';
			header('Location: posty.php');

		}
	}
	else {
		echo 'error trying to send query';
	}

?>