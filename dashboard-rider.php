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

if($user->role_id !== 5) {
    header('Location: 404.php');
}


if(isset($_POST['book'])) {
    $customer_id = $userInfo->id;
    $weight = 3.5;
    $price = 120.00;
    $delivery_time = "2023-05-23 10:00:00";
    $status = "new";
    $fulfillment_type = "Delivery";
    $timestamp = date("Y-m-d H:i:s");

    $sql = "INSERT INTO booking (customer_id, weight, price, delivery_time, status, fulfillment_type, timestamp) VALUES ('$customer_id', '$weight', '$price', '$delivery_time', '$status', '$fulfillment_type', '$timestamp')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
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
        <!-- <li class="nav-item">
            <a href="register-rider.php" class="btn btn-sm rounded-pill bg-m-green text-light font-weight-bold px-3 py-1 mr-2">
                Are you a Rider?
            </a>
        </li> -->
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
                        Welcome, John!
                    </h1>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <a id="dashbtn_1" class="btn btn-dash font-weight-bold px-4 py-2 mr-2 active-dash-btn">Active</a>
                                    <a id="dashbtn_2" class="btn btn-dash font-weight-bold px-4 py-2 mr-2">Out for Delivery</a>
                                    <a id="dashbtn_3" class="btn btn-dash font-weight-bold px-4 py-2">Completed</a>
                                </div>
                            </div>
                            <div class="col-12" id="active_list">
                                <div class="dash-card w-100 p-4 overflow-auto">
                                <?php 
                                    $sql = "SELECT * FROM booking INNER JOIN user ON booking.customer_id = user.id";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                    ?>
                                        <div class="card shadow-sm p-3 mb-3">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5>
                                                        <span class="badge badge-primary text-capitalize"><?php echo $row['status']; ?></span>
                                                    </h5>
                                                    <h5 class="card-title mb-1">
                                                        Booking No: <strong><?php echo $row['id']; ?></strong>
                                                    </h5>
                                                    <p class="mb-0 text-secondary">
                                                        <?php echo $row['created_on']; ?>
                                                    </p>
                                                    <p class="mb-0 text-secondary">
                                                        Customer: <?php echo $row['fname']; ?> <?php echo $row['lname']; ?>
                                                    </p>
                                                    <p class="mb-0 text-secondary">
                                                        Address: <?php echo $row['address']; ?>
                                                    </p>
                                                </div>
                                                <div class="align-self-end text-right">
                                                    <button class="btn btn-create text-light px-3 mt-4 mb-1" id="create_booking">
                                                        Booking Details
                                                    </button>
                                                </div>
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
                            <div class="col-12 d-none" id="delivery_list">
                                <div class="dash-card w-100 p-4">
                                    <div class="card shadow-sm p-3 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5>
                                                    <span class="badge badge-primary">For dispatch</span>
                                                </h5>
                                                <h5 class="card-title mb-1">
                                                    Booking No: <strong>23498712223</strong>
                                                </h5>
                                                <p class="mb-0 text-secondary">
                                                    May 23, 2023
                                                </p>
                                                <p class="mb-0 text-secondary">
                                                    Customer: Sample 2
                                                </p>
                                                <p class="mb-0 text-secondary">
                                                    Address: Sample Address Here
                                                </p>
                                            </div>
                                            <div class="align-self-end text-right">
                                                <button class="btn btn-create text-light px-3 mt-4 mb-1" id="create_booking">
                                                    Booking Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-none" id="completed_list">
                                <div class="dash-card w-100 p-4">
                                    <div class="card shadow-sm p-3 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5>
                                                    <span class="badge badge-primary">Delivered</span>
                                                </h5>
                                                <h5 class="card-title mb-1">
                                                    Booking No: <strong>23498712223</strong>
                                                </h5>
                                                <p class="mb-0 text-secondary">
                                                    May 23, 2023
                                                </p>
                                                <p class="mb-0 text-secondary">
                                                    Customer: Sample 3
                                                </p>
                                                <p class="mb-0 text-secondary">
                                                    Address: Sample Address Here
                                                </p>
                                            </div>
                                            <div class="align-self-end text-right">
                                                <button class="btn btn-create text-light px-3 mt-4 mb-1" id="create_booking">
                                                    Booking Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

<!-- <div class="modal-wrapper d-none" id="booking_modal">
    <div class="booking-modal modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Booking Details</h5>
        </div>
        <form method="POST" class="mb-0" id="bookingForm">
            <div class="modal-body p-4">
                <div>
                    <span>Customer Name:</span>
                </div>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <span>Wash</span>
                    <span>Php 50</span>
                </div>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="iron" value="iron">
                            <label class="form-check-label" for="iron">Iron</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="fold" value="fold">
                            <label class="form-check-label" for="fold">Fold</label>
                        </div>
                    </div>
                    <span>Php 0</span>
                </div>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="fullfilment1" value="delivery">
                            <label class="form-check-label" for="fullfilment1">For Delivery</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="fullfilment2" value="option2">
                            <label class="form-check-label" for="fullfilment2">For Pick-up</label>
                        </div>
                    </div>
                    <span>Php 0</span>
                </div>
                <hr>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold">TOTAL</span>
                    <span class="text-success font-weight-bold">Php 50</span>
                </div>
                <hr>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Enter Weight (kg)</label>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary" type="button">-</button>
                        <input class="weight-input mx-3" type="number" value="1" name="" id="">
                        <button class="btn btn-primary" type="button">+</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Deliver to another address</label>
                    <input type="text" class="form-control" name="" id="">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Notes (Optional)</label>
                    <input type="text" class="form-control" name="" id="" placeholder="Special requests, comments, etc">
                </div>
                <div class="mt-4">
                    <small><strong>Policy:</strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum tempora exercitationem, nemo nobis eaque accusantium.</small>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="close_booking_modal">Close</button>
            <button type="submit" name="book" class="btn btn-primary">Confirm Booking</button>
            </div>
        </form>
      </div>
    </div>
</div> -->

<div class="modal-wrapper d-none" id="booking_modal">
    <div class="booking-modal modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Booking Details</h5>
        </div>
        <form method="POST" class="mb-0" id="bookingForm">
            <div class="modal-body p-4">
                <div>
                    <span class="font-weight-bold">Customer Name:<hr></span>
                <div>
                    <span class="font-weight-bold">Payment Breakdown:</span>
                </div></div>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <span>Wash</span>
                    <span>Php 50</span>
                </div>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <span>Fold</span>
                    <span>Php 50</span>
                </div><div class="form-group d-flex justify-content-between align-items-center">
                    <span>Iron</span>
                    <span>Php 50</span>
                </div><div class="form-group d-flex justify-content-between align-items-center">
                    <span>Delivery Fee</span>
                    <span>Php 50</span>
                </div>
                
                <hr>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold">TOTAL</span>
                    <span class="text-success font-weight-bold">Php 50</span>
                </div>
                <hr>
                
                
                
                <div class="mt-4">
                    <small><strong>Policy:</strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum tempora exercitationem, nemo nobis eaque accusantium.</small>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="close_booking_modal">Close</button>
            <button type="submit" name="book" class="btn btn-primary">Accept Booking</button>
            </div>
        </form>
      </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function navigateTo(page) {
        switch(page) {
            case 1:
                $("#dashbtn_1").addClass("active-dash-btn");
                $("#dashbtn_2").removeClass("active-dash-btn");
                $("#dashbtn_3").removeClass("active-dash-btn");
                $("#dashbtn_4").removeClass("active-dash-btn");
                $("#active_list").removeClass("d-none");
                $("#delivery_list").addClass("d-none");
                $("#completed_list").addClass("d-none");
                break;
            case 2:
                $("#dashbtn_1").removeClass("active-dash-btn");
                $("#dashbtn_2").addClass("active-dash-btn");
                $("#dashbtn_3").removeClass("active-dash-btn");
                $("#dashbtn_4").removeClass("active-dash-btn");
                $("#active_list").addClass("d-none");
                $("#delivery_list").removeClass("d-none");
                $("#completed_list").addClass("d-none");
                break;
            case 3:
                $("#dashbtn_1").removeClass("active-dash-btn");
                $("#dashbtn_2").removeClass("active-dash-btn");
                $("#dashbtn_3").addClass("active-dash-btn");
                $("#dashbtn_4").removeClass("active-dash-btn");
                $("#active_list").addClass("d-none");
                $("#delivery_list").addClass("d-none");
                $("#completed_list").removeClass("d-none");
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

    $(document).on("click", "#dashbtn_3", function() {
        navigateTo(3);
    });

    $(document).on("click", "#create_booking", function() {
        createBooking();
    });

    $(document).on("click", "#close_booking_modal", function() {
        closeBookingModal();
    });


    $('#bookingForm').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Get the form data
        var formData = $(this).serialize();

        console.log(formData);

        // Make the AJAX request
        // $.ajax({
        //     type: 'POST',
        //     url: 'process_booking.php', // Replace with the URL of your PHP script to handle the booking
        //     data: formData,
        //     success: function(response) {
        //         // Handle the response from the server
        //         console.log(response); // You can do something with the response here
        //         alert('Booking successful!'); // Display a success message or perform other actions
        //     },
        //     error: function(xhr, status, error) {
        //         // Handle errors
        //         console.error(error); // Log the error for debugging
        //         alert('An error occurred. Please try again.'); // Display an error message to the user
        //     }
        // });
    });
});
</script>
    
</body>
</html>