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

// Fetch all queries from the database
$query = "SELECT * FROM queries";
$result = mysqli_query($conn, $query);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Query List</title>
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
        <h1>Query List</h1>
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
        <h2>All Queries</h2>
        <table>
            <tr>
                <th>Query ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Respond</th>
                <th>Responded</th>
                <th>View Response</th>
            </tr>
            <?php
            // Check if $result is defined before using it in the while loop
            if (isset($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>";
                    
                    // Check if there is already a response for this query
                    if ($row['responded'] === '1') {
                        // If responded, show the button as disabled
                        echo "<button disabled>Respond</button>";
                    } else {
                        // If not responded, show the button as active with link to response.php
                        echo "<a href='response.php?id=" . $row['id'] . "'><button>Respond</button></a>";
                    }
                    
                    echo "</td>";
                    echo "<td><input type='checkbox' disabled" . (($row['responded'] === '1') ? ' checked' : '') . "></td>";
                    echo "<td>";
                    if ($row['responded'] === '1') {
                        echo "<a href='viewresponse.php?id=" . $row['id'] . "'>View Response</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                // Display an error message if $result is not defined or there is no data
                echo "<tr><td colspan='7'>No queries found.</td></tr>";
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