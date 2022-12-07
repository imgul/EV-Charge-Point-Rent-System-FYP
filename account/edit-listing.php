<?php
// Edit Listing
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Access form data
    $listing_id = $_POST['listing_id'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $price = $_POST['price'];

    // Validate form data
    if (empty($address)) {
        $addressErr = "Please enter your address.";
    } else {
        $address = test_input($address);
    }

    if (empty($latitude)) {
        $latitudeErr = "Please enter your latitude.";
    } else {
        $latitude = test_input($latitude);
    }

    if (empty($longitude)) {
        $longitudeErr = "Please enter your longitude.";
    } else {
        $longitude = test_input($longitude);
    }

    if (empty($price)) {
        $priceErr = "Please enter your price.";
    } else {
        $price = test_input($price);
    }

    // Check if there are no errors
    if (empty($addressErr) && empty($latitudeErr) && empty($longitudeErr) && empty($priceErr)) {
        // check if listing exists
        $sql = "SELECT * FROM charge_points WHERE id = '$listing_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Update listing
            $sql2 = "UPDATE charge_points SET address = '$address', latitude = '$latitude', longitude = '$longitude', price = '$price' WHERE id = '$listing_id'";
            if (mysqli_query($conn, $sql2)) {
                // Redirect to listings page
                header("location: " . $home_url . "account/my-listings.php");
                exit;
            }
        }
    }
}

// Header
include_once '../includes/header.php';

// Navigation
include_once '../includes/navigation.php';

// populate form with existing data
// Access url data
$listing_id = $_GET['id'];
// Validate form data
if (!empty($listing_id)) {
    $listing_id = test_input($listing_id);

    // check if listing exists
    $sql3 = "SELECT * FROM charge_points WHERE id = '$listing_id'";
    $result3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($result3) > 0) {
        // price
        $row = mysqli_fetch_assoc($result3);
        $address = $row['address'];
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $price = $row['price'];
    }
}
?>

<!-- Edit Listing -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit Listing</h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $listing_id; ?>" method="post">
                <!-- listing id hidden -->
                <input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
                <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                    <span class="help-block text-danger"><?php echo $address_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($latitude_err)) ? 'has-error' : ''; ?>">
                    <label>Latitude</label>
                    <input type="text" name="latitude" class="form-control" value="<?php echo $latitude; ?>">
                    <span class="help-block text-danger"><?php echo $latitude_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($longitude_err)) ? 'has-error' : ''; ?>">
                    <label>Longitude</label>
                    <input type="text" name="longitude" class="form-control" value="<?php echo $longitude; ?>">
                    <span class="help-block text-danger"><?php echo $longitude_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                    <label>Price</label>
                    <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                    <span class="help-block text-danger"><?php echo $price_err; ?></span>
                </div>
                <!-- wrap buttons -->
                <div class="form-group my-3 d-flex justify-content-center">
                    <a href="<?php echo $home_url; ?>account/my-listings.php" class="btn btn-default w-25">Cancel</a>
                    <input type="submit" class="btn btn-primary w-75" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Footer
include_once '../includes/footer.php';
?>