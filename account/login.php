<?php
session_start();
// Global variables
$home_url = '../';
$emailErr = $passwordErr = "";
$email = $password = "";
$alert_type = "";
$alert_message = "";


// Database connection
require_once '../includes/db_connection.php';

// Config
require_once '../includes/config.php';

$is_loggedin = is_loggedin();
if ($is_loggedin == true) {
    header("location: ../index.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Access form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate form data
    if (empty($email)) {
        $emailErr = "Please enter your email address.";
    } else {
        $email = test_input($email);
    }

    if (empty($password)) {
        $passwordErr = "Please enter your password.";
    }

    // Check if there are no errors
    if (empty($emailErr) && empty($passwordErr)) {
        // check if email exists
        $sql = "SELECT id, name, email, password FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Check if password is correct
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                // Create session
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                // Redirect to index page
                header("location: ../index.php");
                exit;
            } else {
                $passwordErr = "Password does not match.";
            }
        } else {
            $emailErr = "Email does not exist. Please register instead.";
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
        <!-- Alert -->
        <?php
        if (isset($_SESSION['register_success'])) {
            $alert_type = "success";
            $alert_message = $_SESSION['register_success'];
            unset($_SESSION['register_success']);
        }
        if (!empty($alert_message)) {
            alert($alert_type, $alert_message);
        }
        ?>
        <div class="col">
            <h1>Welcome Back</h1>
            <p class="lead">Please fill in your credentials to login.</p>
        </div>
        <form action="login.php" method="post">
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
            <button type="submit" class="btn btn-primary">Login</button>
            <span class="mx-2">
                New to <?php echo $title; ?>? <a href="register.php">Register new account.</a>
            </span>
        </form>
    </div>
</div>

<?php
// Footer
require_once '../includes/footer.php';

// Close connection
mysqli_close($conn);
?>