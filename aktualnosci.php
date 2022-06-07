<?php 
    include('database.php');
    $sql = "SELECT * from posty";

    if ($result = mysqli_query($conn, $sql)) {
        $iloscpostow = mysqli_num_rows($result);
    }

?>
<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="glowny.css">
</head>

<body>
    <div class="nav">
        <?php include('nav.php'); ?>
    </div>

    <div class="img">
        <h1>Skuteczna walka z bolem</h1>
    </div>

    <div class="glowny">
        <div class="column" >
            <div class="leftcolumn">
                <h1>Aktualności</h1>
                <?php 
                    for ($x = 1; $x <= $iloscpostow; $x++){
                        $tytul = mysqli_query($conn, "SELECT 'tytul' FROM 'posty' WHERE 'id' = 1 ");
                        $tresc = mysqli_query($conn, "SELECT 'tresc' FROM 'posty' WHERE 'id' = $x ");
                        $data = mysqli_query($conn, "SELECT 'dataa' FROM 'posty' WHERE 'id' = $x");
                        $img = mysqli_query($conn, "SELECT 'img' FROM 'posty' WHERE 'id' = $x ");
                        echo "<div id='post'>
                            <img src=''>
                            <h2>" .$tytul."</h2>
                            <p>".$tresc."</p>
                            </div>";
                    }
                ?>
            </div>
            <div class="rightcolumn">
                <?php 
                echo '<h2>Rok</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit..</p>';
                 ?>
            </div>
        </div>
        <div id="footer">
            <p id="link"><a href="https://www.facebook.com/EwaPsalmisterWilk">Footer</p>
        </div>
    </div>
</body>