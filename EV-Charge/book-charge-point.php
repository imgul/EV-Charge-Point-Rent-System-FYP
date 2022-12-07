<?php
session_start();
// Global variables
$home_url = '../';

// Database connection
require_once '../includes/db_connection.php';

// Config
require_once '../includes/config.php';

$is_loggedin = is_loggedin();
// Guest User cannot access this page
if ($is_loggedin == false) {
    header("location: " . $home_url . "account/login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Access url data
    $charge_point_id = $_GET['point'];

    // Validate form data
    if (!empty($charge_point_id)) {
        $charge_point_id = test_input($charge_point_id);

        // check if charge point exists
        $sql = "SELECT * FROM charge_points WHERE id = '$charge_point_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // price
            $row = mysqli_fetch_assoc($result);
            $price = $row['price'];
            // Book charge point
            $sql2 = "INSERT INTO bookings (user_id, charge_point_id, price) VALUES ('$_SESSION[user_id]', '$charge_point_id', '$price')";
            if (mysqli_query($conn, $sql2)) {
                // Redirect to bookings page
                header("location: " . $home_url . "account/bookings.php");
                exit;
            }
        }
    }
}
