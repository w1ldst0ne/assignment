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

// Handle login
if (isset($_POST['login_submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Add any additional validation or security checks here

    // Query to check if user exists and validate credentials
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type'];

            // Redirect to appropriate page based on user type
            if ($row['user_type'] == 'admin') {
                header("Location: adminhome.php");
                exit();
            } elseif ($row['user_type'] == 'staff') {
                header("Location: staffhome.php");
                exit();
            } elseif ($row['user_type'] == 'customer') {
                header("Location: home.php");
                exit();
            }
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
// Close the database connection
mysqli_close($conn);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="container">
    <h1 class="login-heading">Login</h1>
    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <input type="submit" name="login_submit" value="Login">
      </div>
      <div class="form-group">
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
      </div>
    </form>
  </div>
</body>
</html>