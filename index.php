<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 2) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffeeph</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/fav-icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="css/design.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="css/styles.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;
0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400
..900;1,400..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body> 
    
<section id="main">

    <?php include('navbar.php'); ?>

        <header>     
          <div class="container p-4 px-lg-12 my-5 rounded" style="background: #3B3030;">
              <div class="text-center text-light">
                <h1 class="display-5 fw-bolder">Welcome to Coffee PH</h1>
                <p class="lead fw-normal text-light-50 mb-0">Brewing Happiness, One Cup at a Time.</p>
              </div>
            </div>
        </header>

    <?php include('best_seller.php'); ?>

</section>

    <?php include('menu.php'); ?>



  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>

</body>
</html>