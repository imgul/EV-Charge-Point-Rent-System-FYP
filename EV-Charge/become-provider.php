<?php
session_start();
// Global variables
$home_url = '../';
$nameErr = $emailErr = $passwordErr = "";
$name = $email = $password = "";

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
        // Update user info
        $sql = "UPDATE users SET is_owner = 1 WHERE id = '$_SESSION[user_id]'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            // Insert charge point info
            $sql2 = "INSERT INTO charge_points (user_id, address, latitude, longitude, price) VALUES ('$_SESSION[user_id]', '$address', '$latitude', '$longitude', '$price')";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {
                $alert_type = "success";
                $alert_message = "Your charge point has been listed.";
                // Redirect to my listings page
                header("location: " . $home_url . "account/my-listings.php");
            } else {
                $alert_type = "danger";
                $alert_message = "Something went wrong. Please try again.";
            }
        } else {
            $alert_type = "danger";
            $alert_message = "Something went wrong. Please try again.";
        }
    } else {
        $alert_type = "danger";
        $alert_message = "No user found.";
    }
}

// Header
require_once '../includes/header.php';

// Navigation
require_once '../includes/navigation.php';
?>

<div class="container">
    <div class="row my-5 col-6 mx-auto">

        <!-- Alert -->
        <?php if (!empty($alert_message)) : ?>
            <?php alert($alert_type, $alert_message); ?>
        <?php endif; ?>

        <div class="col">
            <h1>List Your Charge Point</h1>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="address" class="form-label">Full address</label>
                <input type="text" name="address" class="form-control" id="address" value="<?php echo $address; ?>" aria-describedby="addressHelp">
                <?php if (!empty($addressErr)) : ?>
                    <div id="addressHelp" class="form-text text-danger"><?php echo $addressErr; ?></div>
                <?php endif; ?>
            </div>
            <!-- GEO Locations: Latitude, Longitude -->
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" name="latitude" class="form-control" id="latitude" value="<?php echo $latitude; ?>" aria-describedby="latitudeHelp">
                <?php if (!empty($latitudeErr)) : ?>
                    <div id="latitudeHelp" class="form-text text-danger"><?php echo $latitudeErr; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" name="longitude" class="form-control" id="longitude" value="<?php echo $longitude; ?>" aria-describedby="longitudeHelp">
                <?php if (!empty($longitudeErr)) : ?>
                    <div id="longitudeHelp" class="form-text text-danger"><?php echo $longitudeErr; ?></div>
                <?php endif; ?>
            </div>
            <!-- Price / kWh -->
            <div class="mb-3">
                <label for="price" class="form-label">Price / kWh</label>
                <input type="text" name="price" class="form-control" id="price" value="<?php echo $price; ?>" aria-describedby="priceHelp">
                <?php if (!empty($priceErr)) : ?>
                    <div id="priceHelp" class="form-text text-danger"><?php echo $priceErr; ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Add Charge Point</button>
        </form>
    </div>
</div>

<?php
// Footer
require_once '../includes/footer.php';
?>