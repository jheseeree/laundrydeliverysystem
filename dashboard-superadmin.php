<?php
session_start();

if(!isset($_SESSION['loggedin'])) {
    header('Location: /awebdes_finals/login.php');
    exit;
}

$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "db_laundry_delivery";

$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

// $sql = "SELECT * FROM users WHERE username = '$username' INNER JOIN bookings ON users.user_id=bookings.user_id";
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user'] = (object) $row;
}

$user = $_SESSION['user'];

$sql = "SELECT * FROM user_info WHERE user_id = '$user->user_id'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user_info'] = (object) $row;
}

$user_info = $_SESSION['user_info'];

if($user->role_id !== 1) {
    header('Location: 404.php');
}

?>

<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
  </div>
</nav>

<div class="position-relative overflow-hidden bg-light hero-background">
    <div class="hero-bg-trans p-3 p-md-5 h-100">
        <div class="container-fluid h-100">
        <div class="h-100 d-flex flex-column align-items-center justify-content-center">
            <div class="mb-5">
                <h1 class="text-light">
                    Welcome, <?php echo $user_info->fname; ?>!
                </h1>
            </div>
            <div class="row w-100">
                <div class="col-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <a id="dashbtn_1" class="btn btn-dash active-dash-btn font-weight-bold px-4 py-2 mr-2">
                                    Active
                                </a>
                                <a id="dashbtn_2" class="btn btn-dash font-weight-bold px-4 py-2">
                                    Completed
                                </a>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dash-card w-100 p-4 overflow-auto">
                                <?php 
                                    $sql = "SELECT *
                                    FROM bookings
                                    JOIN services ON bookings.service_id = services.service_id
                                    JOIN deliveries ON bookings.booking_id = deliveries.booking_id
                                    JOIN user_info ON bookings.user_id = user_info.user_id";

                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                    ?>
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body d-flex justify-content-between">
                                                <div>
                                                    <h5><span class="badge badge-primary text-capitalize"><?php echo $row['status']; ?></span></h5>
                                                    <h5 class="card-title mb-1">
                                                        <strong>Booking No:</strong> <?php echo $row['booking_id']; ?>
                                                    </h5>
                                                    <p class="mb-0">
                                                        <strong>Customer:</strong> <?php echo $row['fname'].' '.$row['lname']; ?>
                                                    </p>
                                                    <p class="mb-0">
                                                        <strong>Address:</strong> <?php echo $row['address']; ?>
                                                    </p>
                                                    <small class="mb-0 text-secondary">
                                                        <strong>Created:</strong> <?php echo $row['created_on']; ?>
                                                    </small>
                                                    <br>
                                                    <small class="mb-0 text-info">
                                                        <strong class="text-secondary">Notes:</strong> <?php echo ($row['notes'] ? $row['notes'] : 'None'); ?>
                                                    </small>
                                                </div>
                                                <div class="align-self-center text-right">
                                                    <h4 class="text-success font-weight-bold mb-0">
                                                        Php <?php echo $row['price']; ?>
                                                    </h4>
                                                    <small class="text-secondary"><?php echo $row['name']; ?></small>
                                                    <h5 class="text-secondary"><?php echo $row['weight']; ?> kg</h5>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-end">
                                                <button class="btn btn-secondary btn-sm mr-2">Edit</button>
                                                <a href="deletebooking.php?id=<?php echo $row['booking_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-create text-light px-4" id="create_booking">
                            Create Booking
                        </button>
                    </div>
                    <div class="card p-4 w-100">
                        <h5 class="card-title">
                            <img class="navbar-logo" src="assets/bLogo.png" alt="logo">
                            Price List
                        </h5>
                        <hr>
                        <div class="d-flex justify-content-between p-3">
                            <span class="font-weight-bold">
                                Wash & Fold
                            </span>
                            <span>
                                Php 120/kg
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between p-3">
                            <span class="font-weight-bold">
                                Wash & Fold
                            </span>
                            <span>
                                Php 120/kg
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between p-3">
                            <span class="font-weight-bold">
                                Wash & Fold
                            </span>
                            <span>
                                Php 120/kg
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        </div>
    </div>
</div>

<div class="modal-wrapper d-none" id="booking_modal">
    <div class="booking-modal modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create a Booking</h5>
        </div>
        <form method="POST" class="mb-0">
            <div class="modal-body p-4">
                <div class="form-group">
                    <select class="form-control" name="user_id" id="">
                        <?php 

                        $sql = "SELECT * FROM users
                        JOIN user_info ON users.user_id = user_info.user_id
                        WHERE users.role_id=4";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row['user_id']; ?>"><?php echo $row['fname'].' '.$row['lname']; ?></option>
                        <?php
                            }
                        } else {
                            ?>
                            <option value="" disabled>No customers</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Enter Weight (kg)</label>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary" type="button" onclick="removeWeight()">-</button>
                        <input class="weight-input mx-3" type="number" min="1" name="laundry_weight" id="laundry_weight">
                        <button class="btn btn-primary" type="button" onclick="addWeight()">+</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="service_type">Service Type</label>
                    <select class="form-control" name="service_type" id="service_type">
                        <option value="1">Wash</option>
                        <option value="2">Wash & Fold</option>
                        <option value="3">Wash, Fold & Iron</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fulfillment" id="fulfillment1" value="delivery" checked>
                        <label class="form-check-label" for="fulfillment1">For Delivery</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="fulfillment" id="fulfillment2" value="pickup">
                        <label class="form-check-label" for="fulfillment2">For Pick-up</label>
                    </div>
                </div>
                <hr>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold">TOTAL</span>
                    <span id="totalPrice" class="text-success font-weight-bold"></span>
                </div>
                <hr>
                <div class="form-group" id="other_address_form">
                    <label for="exampleFormControlSelect1">Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter address">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Notes (Optional)</label>
                    <input type="text" class="form-control" name="notes" id="notes" placeholder="Special requests, comments, etc">
                </div>
                <div class="mt-4">
                    <small><strong>Policy:</strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum tempora exercitationem, nemo nobis eaque accusantium.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close_booking_modal">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Confirm Booking</button>
            </div>
        </form>
      </div>
    </div>
</div>

<?php

if(isset($_POST['submit'])) {

    $selectedUserId = $_POST['user_id'];
    $laundryWeight = $_POST['laundry_weight'];
    $service_id = $_POST['service_type'];
    $address = $_POST['address'];
    $notes = $_POST['notes'];

    $baseWashAmount = 70;
    $baseWashFoldAmount = 110;
    $baseWashFoldIronAmount = 150;
    $baseDeliveryPrice = 40;

    global $baseWashAmount, $baseWashFoldAmount, $baseWashFoldIronAmount, $baseDeliveryPrice;

    $weightMultiplier = ceil($laundryWeight / 7);
    $washPrice = $baseWashAmount * $weightMultiplier;
    $washFoldPrice = $baseWashFoldAmount * $weightMultiplier;
    $washFoldIronPrice = $baseWashFoldIronAmount * $weightMultiplier;
    $deliveryPrice = $baseDeliveryPrice * $weightMultiplier;

    $additionalPrice = 0;

    if ($_POST['service_type'] == 1) {
        $additionalPrice += $washPrice;
    }

    if ($_POST['service_type'] == 2) {
        $additionalPrice += $washFoldPrice;
    }

    if ($_POST['service_type'] == 3) {
        $additionalPrice += $washFoldIronPrice;
    }

    $fulfillmentPrice = 0;

    if ($_POST['fulfillment'] === 'delivery') {
        $fulfillmentPrice = $deliveryPrice;
    }

    $totalAmount = $additionalPrice + $fulfillmentPrice;

    $createBooking = "INSERT INTO bookings (user_id, service_id, weight, address, notes, total_payment) VALUES ('$selectedUserId', '$service_id', '$laundryWeight', '$address', '$notes', '$totalAmount')";

    if ($conn->query($createBooking) === TRUE) {
        $createDelivery = "INSERT INTO deliveries (booking_id, status) VALUES ('$conn->insert_id', 'pending')";
            if ($conn->query($createDelivery) === TRUE) {
                return true;
            }
        // echo 'Success!';
    } else {
        echo "Error: " . $createBooking . "<br>" . $conn->error;
    }

    $conn->close();
}

?>


<script>
    let baseWashAmount = 70;
    let baseWashFoldAmount = 110;
    let baseWashFoldIronAmount = 150;
    let baseDeliveryPrice = 40;

    let iron = false;
    let fold = false;
    let fulfillment = 'delivery';
    let laundryWeight = 1;
    let otherAddress = '';
    let notes = '';

    const weightField = document.getElementById("laundry_weight");
    const serviceField = document.getElementById("service_type");
    const totalPriceElement = document.getElementById("totalPrice");

    weightField.value = laundryWeight;

    calculatePrices();

    function calculatePrices() {
        let weightMultiplier = Math.ceil(laundryWeight / 7);
        let washPrice = baseWashAmount * weightMultiplier;
        let washFoldPrice = baseWashFoldAmount * weightMultiplier;
        let washFoldIronPrice = baseWashFoldIronAmount * weightMultiplier;
        let deliveryPrice = baseDeliveryPrice * weightMultiplier;

        let additionalPrice = 0;

        if(serviceField.value == 1) {
            additionalPrice += washPrice;
        }

        if(serviceField.value == 2) {
            additionalPrice += washFoldPrice;
        }

        if(serviceField.value == 3) {
            additionalPrice += washFoldIronPrice;
        }

        console.log(additionalPrice);

        let fulfillmentPrice = 0;

        if (fulfillment === 'delivery') {
            fulfillmentPrice = deliveryPrice;
        }

        let totalAmount = additionalPrice + fulfillmentPrice;

        totalPriceElement.innerText = "Php " + totalAmount.toString();
    }

    function addWeight() {
        laundryWeight += 1;
        weightField.value = laundryWeight;
        calculatePrices();
    }

    function removeWeight() {
        if (laundryWeight > 1) {
            laundryWeight -= 1;
            weightField.value = laundryWeight;
            calculatePrices();
        }
    }

    document.getElementById("service_type").addEventListener("change", function () {
        calculatePrices();
    });

    document.getElementById("fulfillment1").addEventListener("change", function () {
        fulfillment = 'delivery';
        document.getElementById("other_address_form").classList.remove("d-none");
        calculatePrices();
    });

    document.getElementById("fulfillment2").addEventListener("change", function () {
        fulfillment = 'pickup';
        document.getElementById("other_address_form").classList.add("d-none");
        calculatePrices();
    });

    function navigateTo(page) {
        switch(page) {
            case 1:
                $("#dashbtn_1").addClass("active-dash-btn");
                $("#dashbtn_2").removeClass("active-dash-btn");
                $("#dashbtn_3").removeClass("active-dash-btn");
                $("#dashbtn_4").removeClass("active-dash-btn");
                break;
            case 2:
                $("#dashbtn_1").removeClass("active-dash-btn");
                $("#dashbtn_2").addClass("active-dash-btn");
                $("#dashbtn_3").removeClass("active-dash-btn");
                $("#dashbtn_4").removeClass("active-dash-btn");
                break;
        }
    }

    function createBooking() {
        $("#booking_modal").removeClass("d-none");
    }

    function closeBookingModal() {
        $("#booking_modal").addClass("d-none");
    }

    $(document).on("click", "#dashbtn_1", function() {
        navigateTo(1);
    });

    $(document).on("click", "#dashbtn_2", function() {
        navigateTo(2);
    });

    $(document).on("click", "#create_booking", function() {
        createBooking();
    });

    $(document).on("click", "#close_booking_modal", function() {
        closeBookingModal();
    });


</script>
    
</body>
</html>