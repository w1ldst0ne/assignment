<?php
session_start();

// Check if user is logged in as a staff
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    // Redirect to login page or show an error message
    echo "Access denied. Please login as an admin.";
    exit();
}

// Database configuration
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "SCDB";

// Create a database connection
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all users from the database
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Users</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
	<div class="topnav">
            <div class="topnav-right">
                <?php
                // Check if user is logged in
                if (isset($_SESSION['user_id'])) {
                    // User is logged in, display the logout button
                    echo '<a href="logout.php">Logout</a>';
                } else {
                    // User is not logged in, display the login and sign-up buttons
                    echo '<a href="login.php">Login</a>';
                    echo ' / ';
                    echo '<a href="register.php">Sign Up</a>';
                }
                ?>
            </div>
        </div>
</head>
<body>
    <header>
        <h1>Edit Users</h1>
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
    <h2>All Users</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Password</th>
            <th>User Type</th>
            <th>Edit User Credentials</th>
            <th>Remove User</th> 
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . str_repeat("*", strlen($row['password'])) . "</td>";
            echo "<td>" . $row['user_type'] . "</td>";
            echo "<td><a href='useredit.php?id=" . $row['id'] . "'>Edit</a></td>";
            echo "<td><a href='removeuser.php?id=" . $row['id'] . "'>Remove</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</section>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
</html>
