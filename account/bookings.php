<?php
// booking page
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

// header
include_once '../includes/header.php';

// navigation
include_once '../includes/navigation.php';
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Bookings</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Charge Point</th>
                        <th>Price</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get bookings
                    $sql = "SELECT * FROM bookings WHERE user_id = '$_SESSION[user_id]'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $point_id = $row['charge_point_id'];
                            $price = $row['price'];
                            $booked_at = $row['created_at'];
                            // Get charge point address
                            $sql2 = "SELECT address FROM charge_points WHERE id = '$point_id'";
                            $result2 = mysqli_query($conn, $sql2);
                            if (mysqli_num_rows($result2) > 0) {
                                $row2 = mysqli_fetch_assoc($result2);
                                $address = $row2['address'];
                            }
                    ?>
                            <tr>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $booked_at; ?></td>
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
// footer
include_once '../includes/footer.php';
?>