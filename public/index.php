<?php
require 'include/include_all.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Osamah Instagram</title>
    <link rel="stylesheet" href="css/bulma.css">
    <link rel="stylesheet" href="css/croppie.css">
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script> -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/croppie.min.js"></script>

</head>

<body>
    <!-- NAV BAR  -->
    <nav class="navbar" role="navigation" aria-label="main navigation" style="margin-bottom: 10px;">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">
                <img src="img/logo.png">
            </a>
        </div>
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="/index.php">
                    Home
                </a>
                <a class="navbar-item" href="/index.php?analytics">
                    Analytics
                </a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-primary" href="/index.php?upload">
                            <strong>Upload New Photo</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- NAV BAR -->
    <div class="container">

    <?php
        if (isset($_GET['analytics'])){
            include_once "view/analytics.view.php";
        } elseif (isset($_GET['upload'])){
            include_once "view/upload.view.php";
        }else{
            include_once "view/home.view.php";
        }
        
        ?>

    </div>
</body>

</html>



<?php  
//       $pdo = (new OSASQL(true));
//       if ($pdo != null)
//     echo 'Connected to the SQLite database successfully!';
// else
//     echo 'Whoops, could not connect to the SQLite database!';
// var_dump($pdo->connect_error);
?>