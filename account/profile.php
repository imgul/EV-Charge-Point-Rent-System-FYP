<!-- profile page -->
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
// Guest User cannot access this page
if ($is_loggedin == false) {
    header("location: " . $home_url . "account/login.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Access form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form data
    if (empty($name)) {
        $nameErr = "Please enter your name.";
    } else {
        $name = test_input($name);
    }

    if (empty($email)) {
        $emailErr = "Please enter your email address.";
    } else {
        $email = test_input($email);
    }

    if (empty($password)) {
        $passwordErr = "Please enter your password.";
    } else {
        $password = test_input($password);
    }

    if (empty($confirm_password)) {
        $confirm_passwordErr = "Please confirm your password.";
    } else {
        $confirm_password = test_input($confirm_password);
    }

    // Check if there are no errors
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirm_passwordErr)) {
        // check if email exists
        $sql = "SELECT id, name, email, password FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Check if password is correct
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                // Update user
                $sql = "UPDATE users
                        SET name = '$name'
                        WHERE id = '$row[id]'";
                if (mysqli_query($conn, $sql)) {
                    // Update session
                    $_SESSION['user_name'] = $name;
                    // Redirect to index page
                    header("location: ../index.php");
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
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

// Get user data
$sql = "SELECT id, name, email FROM users WHERE id = '$_SESSION[user_id]'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $email = $row['email'];
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>

<!-- profile form -->
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="text-center">Profile</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control <?php echo (!empty($nameErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                    <div class="invalid-feedback"><?php echo $nameErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control <?php echo (!empty($emailErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <div class="invalid-feedback"><?php echo $emailErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($passwordErr)) ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback"><?php echo $passwordErr; ?></div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_passwordErr)) ? 'is-invalid' : ''; ?>">
                    <div class="invalid-feedback"><?php echo $confirm_passwordErr; ?></div>
                </div>
                <div class="form-group my-2">
                    <input type="submit" value="Update" class="btn btn-outline-primary w-100">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Footer
require_once '../includes/footer.php';
?>