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
        <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="login.php">Log in</a>
        </li>
    </ul>
  </div>
</nav>

<div class="position-relative overflow-hidden bg-light hero-background">
    <div class="hero-bg-trans d-flex align-items-center p-3 p-md-5 h-100">
        <div class="container-fluid h-100">
            <div class="h-100 d-flex flex-column align-items-start justify-content-center">
                <h1 class="hero-header text-light font-weight-bold mb-0">
                    UWU Wash Laundry Delivery
                </h1>
                <h3 class="hero-desc text-light w-50 py-3">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat ipsam neque, eum aspernatur ut tempore possimus
                </h3>
                <div class="d-flex align-items-center">
                    <a class="btn rounded-pill font-weight-bold bg-m-green white-text px-4 btn-lg btn-hover mr-3" href="login.php">Book Now</a>
                    <a class="btn rounded-pill font-weight-bold bg-light text-m-green px-4 btn-lg btn-hover" href="register.php">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>