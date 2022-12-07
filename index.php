<?php
session_start();
// Global variables
$home_url = './';

// Database connection
require_once 'includes/db_connection.php';

// Config
require_once 'includes/config.php';

$is_loggedin = is_loggedin();

// Guest User cannot access Home page
if ($is_loggedin == false) {
  header("location: " . $home_url . "account/login.php");
  exit;
}

// Header
require_once 'includes/header.php';

// Navigation
require_once 'includes/navigation.php';
?>

<!-- Home page -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1>Available Charge Points</h1>
      <p>Welcome to EV-Charge, <?php echo $_SESSION['user_name']; ?>!</p>
    </div>
  </div>

  <!-- List all charge points with address, latitude, longitude, price, owner_name -->
  <div class="row">
    <!-- Php Loop -->
    <?php
    $sql = "SELECT * FROM charge_points";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $point_id = $row['id'];
        $address = $row['address'];
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $price = $row['price'];
        $user_id = $row['user_id'];
        $sql2 = "SELECT name FROM users WHERE id = '$user_id'";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {
          $row2 = mysqli_fetch_assoc($result2);
          $owner_name = $row2['name'];
        }
    ?>
        <div class="col-sm-4 my-2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Address: <?php echo $address; ?></h5>
              <p class="card-text">Latitude: <?php echo $latitude; ?></p>
              <p class="card-text">Longitude: <?php echo $longitude; ?></p>
              <p class="card-text">Price: <?php echo $price; ?></p>
              <p class="card-text">Owner: <?php echo $owner_name; ?></p>
              <a href="<?php echo $home_url ?>EV-Charge/book-charge-point.php?point=<?php echo $point_id ?>" class="btn btn-primary">Book Charge Point</a>
            </div>
          </div>
        </div>
    <?php
      }
    }
    ?>
  </div>

  <?php
  // Footer
  require_once 'includes/footer.php';
  ?>