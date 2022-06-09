<?php require_once('database.php') ?>

<?php $title = 'Aktualności'; 
$page = 'aktualnosci';
?>
<!-- head -->
<?php require_once('head.php'); ?>

<title><?php echo $title; ?></title>
</head>

<!-- navbar -->
<?php include('nav.php'); ?>
<!-- img -->
<?php include('img.php'); ?>
<!-- main body -->
<div class = "glowny">
    <?php 
        if ($page == 'aktualnosci'){
            include('aktualnosci.php');
        }
        else if ($page == 'omnie'){
            include('omnie.php');
        }
        else if ($page == 'oferta'){
            include('oferta.php');
        }
        else if ($page == 'kalendarz'){
            include('kalendarz.php');
        }
        else if ($page == 'login'){
            include('login.php');
        }
        else if ($page == 'umow'){
            include('umow.php');
        }
    ?>
</div>

<!-- footer -->
<?php include('footer.php') ?>

<?php include('database.php'); ?>