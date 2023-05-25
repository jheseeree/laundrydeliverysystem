<?php
    session_start();

    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "db_laundry_delivery";

    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>

<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>UWU Wash Delivery</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
<img class="navbar-logo" src="assets/bLogo.png" alt="logo">

  <a class="navbar-brand font-weight-bold custom-green" href="index.php">UWU Wash Delivery</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item">
            <a href="register-rider.php" class="btn btn-sm rounded-pill bg-m-green text-light font-weight-bold px-3 py-1 mr-2">
                Are you a Rider?
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="register.php">Sign Up</a>
        </li>
    </ul>
  </div>
</nav>

<div class="position-relative overflow-hidden bg-light hero-background">
    <div class="hero-bg-trans d-flex justify-content-center align-items-center p-3 p-md-5 h-100">
        <div>
            <h1 class="text-light text-center">
                Access Denied!
            </h1>
        </div>
    </div>
</div>
    
</body>
</html>