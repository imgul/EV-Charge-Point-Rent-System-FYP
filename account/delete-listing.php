<?php
session_start();

// Global variables
$home_url = '../';

// Database connection
require_once '../includes/db_connection.php';

// Include config file
require_once '../includes/config.php';

// Check if user is logged in
$is_loggedin = is_loggedin();
if ($is_loggedin == false) {
    header("location: " . $home_url . "account/login.php");
    exit;
}

// Get listing id
$listing_id = $_GET['id'];

// Validate listing id
if (!empty($listing_id)) {
    $listing_id = test_input($listing_id);

    // check if listing exists
    $sql = "SELECT * FROM charge_points WHERE id = '$listing_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // Delete listing
        $sql2 = "DELETE FROM charge_points WHERE id = '$listing_id'";
        var_dump($sql2);
        if (mysqli_query($conn, $sql2)) {
            // Redirect to listings page
            header("location: " . $home_url . "account/my-listings.php");
            exit;
        }
    }
}
