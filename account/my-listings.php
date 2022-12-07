<?php
// My Listings
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

// Header
include_once '../includes/header.php';

// Navigation
include_once '../includes/navigation.php';
?>

<!-- My Listings -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">My Listings</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Charge Point</th>
                        <th>Address</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get all charge points
                    $sql = "SELECT * FROM charge_points WHERE user_id = '$_SESSION[user_id]'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $address = $row['address'];
                            $price = $row['price'];
                    ?>
                            <tr>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $price; ?></td>
                                <td>
                                    <a href="<?php echo $home_url; ?>account/edit-listing.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>
                                    <a href="<?php echo $home_url; ?>account/delete-listing.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
// Footer
include_once '../includes/footer.php';
?>