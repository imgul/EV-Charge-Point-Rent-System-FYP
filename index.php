<?php
session_start();
// Global variables
$home_url = './';

// Database connection
require_once 'includes/db_connection.php';

// Config
require_once 'includes/config.php';

$is_loggedin = is_loggedin();
if ($is_loggedin == false) {
    header("location: account/login.php");
    exit;
}

// Header
require_once 'includes/header.php';

// Navigation
require_once 'includes/navigation.php';

echo '<div class="container">
  <div class="row">
    <div class="col">
      <h1>Bootstrap demo</h1>
      <p class="lead">This is a demo of Bootstrap 5.2.3.</p>
    </div>
  </div>';

// Footer
require_once 'includes/footer.php';
