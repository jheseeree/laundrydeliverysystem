<?php
    session_start();

    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "db_laundry_delivery";

    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

    $required = false;
    $incorrect = false;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (empty($username) || empty($password)) {
            $required = true;
        } else {
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];

                if (password_verify($password, $hashedPassword)) {
                    $required = false;
                    $incorrect = false;
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;

                    $sql2 = "SELECT * FROM users WHERE username = '$username'";
                    $result2 = $conn->query($sql);
                    if ($result2->num_rows == 1) {
                        if($row['role_id'] == 1) {
                            header('Location: dashboard-superadmin.php');
                        }
                        if($row['role_id'] == 4) {
                            header('Location: dashboard-customer.php');
                        }
                        if($row['role_id'] == 5) {
                            header('Location: dashboard-rider.php');
                        }
                        if($row['role_id'] == 2) {
                            header('Location: dashboard-admin.php');
                        }
                    }
                } else {
                    $incorrect = true;
                }
            } else {
                $incorrect = true;
            }
        }
        $conn->close();
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
        <div class="card sign-up-card px-5 py-5">
            <?php
                if($required) {
            ?>
            <div class="alert alert-danger" role="alert">
                Fields are required!
            </div>
            <?php
                }
                if($incorrect) {
            ?>
            <div class="alert alert-danger" role="alert">
                Incorrect Username or Password!
            </div>
            <?php
                }
            ?>
            <h3 class="text-center mb-0">Login To Your</h3>
            <h3 class="text-center">UWUWash Account</h3>
            <form class="py-3" method="POST">
                <div class="form-group">    
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="form-group">    
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="d-flex flex-column align-items-center mt-3">
                <button type="submit" name="submit" class="btn btn-lg bg-m-green text-light font-weight-bold px-4 py-2 rounded-pill">
                        Login
                    </button>
                </div>
            </form>
            <div class="d-flex flex-column align-items-center pt-3">
                <span>Don't have an account yet?</span>
                <span><a href="register.php">Sign Up</a> here</span>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>