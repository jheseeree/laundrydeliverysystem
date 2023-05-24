<?php
session_start();

if(!isset($_SESSION['loggedin'])) {
    header('Location: /awebdes_finals/login.php');
    exit;
}

$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "laundry_delivery";

$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user_info'] = (object) $row;
}

$userInfo = $_SESSION['user_info'];

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
                    Welcome, <?php echo $userInfo->fname; ?>!
                </h1>
            </div>
            <div class="row">
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
                                    $sql = "SELECT *, booking.id AS bookingid FROM booking JOIN user on booking.customer_id = user.id";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                    ?>
                                        <div class="card shadow-sm p-3 mb-3">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5><span class="badge badge-primary text-capitalize"><?php echo $row['status']; ?></span></h5>
                                                    <h5 class="card-title mb-1">
                                                        Booking No: <strong><?php echo $row['bookingid']; ?></strong>
                                                    </h5>
                                                    <h5 class="card-title mb-1">
                                                    <strong>Customer: </strong><?php echo $row['fname'].' '.$row['lname'] ; ?>
                                                    </h5>
                                                    <h6 class="card-title mb-1">
                                                    <strong>Address: </strong><?php echo $row['address']; ?>
                                                    </h6>
                                                    <h6 class="card-title mb-1">
                                                    <strong>Notes: </strong><?php echo $row['notes']; ?>
                                                    </h6>
                                                    <p class="mb-0 text-secondary">
                                                        Booked on: <?php echo $row['created_on']; ?>
                                                    </p>
                                                </div>
                                                <div class="align-self-center text-right">
                                                    <h5 class="text-secondary"><?php echo $row['weight']; ?> kg</h5>
                                                    <h5 class="text-success font-weight-bold mb-0">
                                                        Php <?php echo $row['price']; ?>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button onclick="editBooking()" class="btn btn-sm btn-info mr-2">
                                                    Edit
                                                </button>
                                                <a href="/awebdes_finals/deletebooking.php?id=<?php echo $row['bookingid']; ?>" class="btn btn-sm btn-danger">
                                                    Delete
                                                </a>
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
                    <label for="exampleFormControlSelect1">Customer</label>
                    <select class="form-control" name="user_id" id="">
                        <?php 
                        $sql = "SELECT * FROM user WHERE role='customer'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['fname'].' '.$row['lname']; ?></option>
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
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="iron" id="iron" value="iron">
                        <label class="form-check-label" for="iron">Iron</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="fold" id="fold" value="fold">
                        <label class="form-check-label" for="fold">Fold</label>
                    </div>
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
                    <label for="exampleFormControlSelect1">Deliver to another address</label>
                    <input type="text" class="form-control" name="other_address" id="other_address" placeholder="Enter new address">
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

<div class="modal-wrapper d-none" id="edit_modal">
    <div class="booking-modal modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create a Booking</h5>
        </div>
        <form method="POST" class="mb-0">
            <div class="modal-body p-4">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Enter Weight (kg)</label>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary" type="button" onclick="removeWeight()">-</button>
                        <input class="weight-input mx-3" type="number" min="1" name="laundry_weight" id="laundry_weight">
                        <button class="btn btn-primary" type="button" onclick="addWeight()">+</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="iron" id="iron" value="iron">
                        <label class="form-check-label" for="iron">Iron</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="fold" id="fold" value="fold">
                        <label class="form-check-label" for="fold">Fold</label>
                    </div>
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
                    <label for="exampleFormControlSelect1">Deliver to another address</label>
                    <input type="text" class="form-control" name="other_address" id="other_address" placeholder="Enter new address">
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
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Close</button>
                <button type="submit" name="submit" class="btn btn-primary">Confirm Booking</button>
            </div>
        </form>
      </div>
    </div>
</div>

<?php

if(isset($_POST['submit'])) {

    $baseWashAmount = 70;
    $baseIronPrice = 40;
    $baseFoldPrice = 40;
    $baseDeliveryPrice = 40;

    $iron = false;
    $fold = false;

    if(isset($_POST['iron'])) {
        $iron = true;
    }

    if(isset($_POST['fold'])) {
        $iron = true;
    }

    $fulfillment = $_POST['fulfillment'];
    $laundryWeight = $_POST['laundry_weight'];

    $weightMultiplier = ceil($laundryWeight / 7);
    $washAmount = $baseWashAmount * $weightMultiplier;
    $ironPrice = $baseIronPrice * $weightMultiplier;
    $foldPrice = $baseFoldPrice * $weightMultiplier;
    $deliveryPrice = $baseDeliveryPrice * $weightMultiplier;

    $additionalPrice = 0;

    if ($iron) {
        $additionalPrice += $ironPrice;
    }

    if ($fold) {
        $additionalPrice += $foldPrice;
    }

    $fulfillmentPrice = 0;

    if ($fulfillment === 'delivery') {
        $fulfillmentPrice = $deliveryPrice;
    }

    $totalAmount = $washAmount + $additionalPrice + $fulfillmentPrice;


    $customer_id = $_POST['user_id'];
    $weight = $_POST['laundry_weight'];
    $price = $totalAmount;
    $status = "new";
    $otherAddress = $_POST['other_address'];
    $notes = $_POST['notes'];
    $fulfillment_type = $_POST['fulfillment'];

    $sql = "INSERT INTO booking (customer_id, weight, price, status, other_address, notes, fulfillment_type) VALUES ('$customer_id', '$weight', '$price', '$status', '$otherAddress', '$notes', '$fulfillment_type')";

    if ($conn->query($sql) === TRUE) {
        header('Location: /awebdes_finals/dashboard-customer.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>


<script>

    let baseWashAmount = 70;
    let baseIronPrice = 40;
    let baseFoldPrice = 40;
    let baseDeliveryPrice = 40;

    let iron = false;
    let fold = false;
    let fulfillment = 'delivery';
    let laundryWeight = 1;
    let otherAddress = '';
    let notes = '';

    const weightField = document.getElementById("laundry_weight");
    const totalPriceElement = document.getElementById("totalPrice");

    weightField.value = laundryWeight;

    calculatePrices();

    function calculatePrices() {
        let weightMultiplier = Math.ceil(laundryWeight / 7);
        let washAmount = baseWashAmount * weightMultiplier;
        let ironPrice = baseIronPrice * weightMultiplier;
        let foldPrice = baseFoldPrice * weightMultiplier;
        let deliveryPrice = baseDeliveryPrice * weightMultiplier;

        let additionalPrice = 0;

        if (iron) {
            additionalPrice += ironPrice;
        }

        if (fold) {
            additionalPrice += foldPrice;
        }

        let fulfillmentPrice = 0;

        if (fulfillment === 'delivery') {
            fulfillmentPrice = deliveryPrice;
        }

        let totalAmount = washAmount + additionalPrice + fulfillmentPrice;

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

    function editBooking() {
        $("#edit_modal").removeClass("d-none");
    }

    function closeBookingModal() {
        $("#booking_modal").addClass("d-none");
    }

    function closeEditModal() {
        $("#edit_modal").addClass("d-none");
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