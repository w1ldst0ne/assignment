<?php
session_start();

// Check if user is logged in as a staff
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
  // Redirect to login page or show an error message
  echo "Access denied. Please login as a staff member.";
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

// Check if the query ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Error: Query ID not provided.";
    exit();
}

// Fetch the response for the provided query ID
$query_id = $_GET['id'];
$query = "SELECT response FROM response WHERE queryid = $query_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Error: Response not found for this query.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$response = $row['response'];

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>View Response</title>
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
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
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

        /* Additional styles for stacked dropdown menu */
        .dropdown-content a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        /* Remove the border styles from dropdown menu options */
        .dropdown-content a {
            border: none;
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
        <h1>View Response</h1>
    </header>

    <nav>
    <ul>
        <li><a href="staffhome.php">Home</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="offers.php">Offers</a></li>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li class="dropdown">
            <a href="#">Tools</a>
            <div class="dropdown-content">
                <a href="staffreservation.php">View Reservations</a>
                <a href="queries.php">Respond Queries</a>
            </div>
        </li>
    </ul>
</nav>

    <section>
        <h2>Query ID: <?php echo $query_id; ?></h2>
        <p>Response:</p>
        <div><?php echo $response; ?></div>
    </section>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
