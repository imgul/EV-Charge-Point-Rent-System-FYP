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
// Only Guest user can access this page
if ($is_loggedin == true) {
    header("location: " . $home_url . "index.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Access form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate form data
    if (empty($name)) {
        $nameErr = "Please enter your full name.";
    } else {
        $name = test_input($name);
    }

    if (empty($email)) {
        $emailErr = "Please enter a valid email address.";
    } else {
        $email = test_input($email);
    }

    if (empty($password)) {
        $passwordErr = "Please enter a password.";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Check if there are no errors
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr)) {
        // check if email already exists
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $emailErr = "Email already exists. Try with another email or login instead.";
        } else {
            // Insert data into database
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            if (mysqli_query($conn, $sql)) {
                // Redirect to login page with success message
                $_SESSION['register_success'] = "You have successfully registered. Please login to continue.";
                header("location: login.php");
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}

// Header
require_once '../includes/header.php';

// Navigation
require_once '../includes/navigation.php';
?>

<div class="container">
    <div class="row my-5 col-6 mx-auto">
        <div class="col">
            <h1>Welcome to <?php echo $title; ?></h1>
            <p class="lead">Please fill in your correct info to Register.</p>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" id="name" value="<?php echo $name; ?>" aria-describedby="nameHelp">
                <?php if (!empty($nameErr)) : ?>
                    <div id="nameHelp" class="form-text text-danger"><?php echo $nameErr; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo $email; ?>" aria-describedby="emailHelp">
                <?php if (!empty($emailErr)) : ?>
                    <div id="emailHelp" class="form-text text-danger"><?php echo $emailErr; ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordHelp">
                <?php if (!empty($passwordErr)) : ?>
                    <div id="passwordHelp" class="form-text text-danger"><?php echo $passwordErr; ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
            <span class="mx-2">
                Already have and account? <a href="login.php">Login Here</a>
            </span>
        </form>
    </div>
</div>

<?php
// Footer
require_once '../includes/footer.php';
?>