<?php
$title = 'Chargion';
$description = 'Chargion is a self-hosted, and easy-to-use charging station management system.';
$keywords = 'Chargion, charging station, charging station management, charging station management system, charging station software, charging station software management, charging station software management system, charging station software system, charging station system, charging station system management, charging station system management software, charging station system software, charging station system software management, charging station system software management system, charging station system software system, charging station system system, charging station system system management, charging station system system management software, charging station system system management software system, charging station system system software, charging station system system software management, charging station system system software management system, charging station system system software system, charging station system system system, charging station system system system management, charging station system system system management software, charging station system system system management software system, charging station system system system software, charging station system system system software management, charging station system system system software management system, charging station system system system software system, charging station system system system system, charging station system system system system management, charging station system system system system management software, charging station system system system system management software system, charging station system system system system software, charging station system system system system software management, charging station system system system system software management system, charging station system system system system software system, charging station system system system system system, charging station system system system system system management, charging station system system system system system management software, charging station system system system system system management software system, charging station system system system system system software, charging station system system system system system software management, charging station system system system system system software management system, charging station system system system system system software system, charging station system system system system system system, charging station system system system system system system management, charging station system system system system system system management software, charging station system system system system system system management software system, charging station system system system system system system software, charging station system system system system system system software management, charging station system system system system system system software management system, charging station system system system system system system software system, charging station system system system system system system system, charging station system system system system system system system management, charging station system system system system system system system management software, charging station system system system system system system system management software system, charging station system system system system system system system software, charging station system system system system system system system software management, charging station';
$author = 'My name';

// Sanitize input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// alert 
function alert($alert_type, $alert_message)
{
    echo '
    <div class="alert alert-' . $alert_type . ' alert-dismissible fade show" role="alert">
        ' . $alert_message . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
}

// Check if the user is logged in, if not then redirect him to login page
function is_loggedin()
{
    if (isset($_SESSION["user_id"]) || $_SESSION["loggedin"] == true) {
        return true;
    }
}
