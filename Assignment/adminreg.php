<?php
session_start();

// Database connection code here
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "SCDB";

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle admin registration
if (isset($_POST['register_submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = $_POST['user_type'];

    // Add any additional validation or security checks here

    // Check if the username already exists in the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        // Username already exists, display an error message or redirect to an error page
        echo "Registration failed: Username already exists.";
    } else {
        // Username is unique, proceed with registration

        // Encrypt the password (using a suitable encryption method, e.g., bcrypt)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user information into the database
        $query = "INSERT INTO users (username, password, user_type) VALUES ('$username', '$hashed_password', '$user_type')";
        if (mysqli_query($conn, $query)) {
            // Registration successful
            echo "Registration successful. Redirecting to admin home page...";
            // Redirect to adminhome.php after 5 seconds
            header("refresh:5;url=adminhome.php");
        } else {
            // Registration failed, display an error message or redirect to an error page
            echo "Registration failed.";
        }
    }
}
// Close the database connection
mysqli_close($conn);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register Admin</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container">
        <h1 class="login-heading">Register Admin</h1>
        <form action="adminreg.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="user_type">User Type:</label>
                <select name="user_type" id="user_type" required>
                    <option value="customer">Customer</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="register_submit" value="Register">
            </div>
        </form>
    </div>
</body>
</html>