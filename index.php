<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="glowny.css">
        <script src="js.js"></script>
        <title><?php include($title); ?></title>
    </head>
    <body>
        <?php 
            $page = $_GET['page']; 

            if($page == null) {
                $page = 'index'; // Set page to index, if not set
            }
            
            switch ($page) {
                case 'index':
                    include('aktualnosci.php');
                    $title = "aktualnosci";
                    break;

                case 'omnie':
                    include('omnie.php');
                    $title = "omnie";
                    break;

                case 'oferta':
                    include('oferta.php');
                    $title = "oferta";
                    break;

                case 'kalendarz':
                    include('kalendarz.php');
                    $title = "kalendarz";
                    break;

                case 'login':
                    include('login.php');
                    $title = "login";
                    break;

                case 'umow':
                    include('umow.php');
                    $title = "umow";
                    break;
            }
        ?>
        <div id="footer">
            <?php echo "<p id='link'><a href='https://www.facebook.com/EwaPsalmisterWilk'>Footer</p>"; ?>
        </div>
    </body>
</html>