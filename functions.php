<?php 

include ('database.php');

function getPublishedPosts() {
	$sql = "SELECT * FROM posty";
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $posts;
}

?>