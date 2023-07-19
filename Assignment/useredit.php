<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    echo "Access denied. Please login as an admin.";
    exit();
}

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "SCDB";

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the user ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Error: User ID not provided.";
    exit();
}

// Fetch the user details from the "users" table
$user_id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Error: User not found.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$username = $row['username'];
$password = $row['password'];
$account_type = $row['user_type'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];
    $new_account_type = $_POST['account_type'];


    // Check if any changes are made to the user details
    $changes_made = false;

    if ($new_username !== $username) {
        $update_username_query = "UPDATE users SET username = '$new_username' WHERE id = $user_id";
        mysqli_query($conn, $update_username_query);
        $changes_made = true;
    }

    if ($new_account_type !== $account_type) {
        $update_account_type_query = "UPDATE users SET user_type = '$new_account_type' WHERE id = $user_id";
        mysqli_query($conn, $update_account_type_query);
        $changes_made = true;
    }

    if ($new_password !== "") {
        $encrypted_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_password_query = "UPDATE users SET password = '$encrypted_password' WHERE id = $user_id";
        mysqli_query($conn, $update_password_query);
        $changes_made = true;
    }

    if ($changes_made) {
    echo "<script>alert('Changes made successfully.'); window.location.href = 'editusers.php';</script>";
    exit();
	}
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit User</title>
    <link href="style.css" rel="stylesheet" type="text/css">
	<style>
	.dropdown {
 			 position: relative;
		}

		.dropdown-content {
 			 display: none;
 			 position: absolute;
			  background-color: #f9f9f9;
			  min-width: 160px;
 			 box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
 			 z-index: 1;
 			 top: 100%;
			  left: 0;
		}

		.dropdown:hover .dropdown-content {
 			 display: block;
		}

		.dropdown-content a {
  			display: block;
  			padding: 10px;
		  	text-decoration: none;
 			 color: #333;
		}

		.topnav-right {
 			 float: right;
		}
	</style>
</head>
<body>
    <div class="topnav">
        <div class="topnav-right">
            <?php
            if (isset($_SESSION['user_id'])) {

                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="login.php">Login</a>';
                echo ' / ';
                echo '<a href="register.php">Sign Up</a>';
            }
            ?>
        </div>
    </div>

    <header>
        <h1>Edit User</h1>
    </header>

    <nav>
        <ul>
            <li><a href="adminhome.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="offers.php">Offers</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li class="dropdown">
                <a href="#">Tools</a>
                <div class="dropdown-content">
                    <a href="editusers.php">Edit Users</a>
                    <a href="adminreg.php">Register Accounts</a>
                </div>
            </li>
        </ul>
    </nav>

    <section>
        <h2>User Details</h2>
        <form action="useredit.php?id=<?php echo $user_id; ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo str_repeat("*", strlen($password)); ?>">
            <br><br>

            <label for="account_type">Account Type:</label><br>
            <select id="account_type" name="account_type">
                <option value="admin" <?php echo ($account_type === 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="staff" <?php echo ($account_type === 'staff') ? 'selected' : ''; ?>>Staff</option>
            </select>
            <br><br>

            <label for="admin_pin">Enter Admin PIN:</label>
			<input type="password" id="admin_pin" name="admin_pin" required>
			<br><br>

	<input type="submit" value="Done">
        </form>
    </section>

    <script>
        function checkPin() {
            const pin = document.getElementById("admin_pin").value;
            if (pin === "12345") {
                // Submit the form after PIN validation
                document.querySelector('form').submit();
            } else {
                alert("Incorrect PIN. Please try again.");
            }
        }
    </script>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
