<?php
session_start();


// Check if user is logged in as staff
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    $_SESSION['error_message'] = 'Please log in as staff to view reservations.';
    header("Location: login.php");
    exit();
}

// Database configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'SCDB';

// Create a database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch all reservations from the database
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Staff Home</title>
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
    <h1>Reservations</h1>
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
        <h2>All Reservations</h2>
        <?php if (isset($_SESSION['success_message'])) { ?>
            <p class="success"><?php echo $_SESSION['success_message']; ?></p>
            <?php unset($_SESSION['success_message']); ?>
        <?php } ?>
        <?php if (isset($_SESSION['error_message'])) { ?>
            <p class="error"><?php echo $_SESSION['error_message']; ?></p>
            <?php unset($_SESSION['error_message']); ?>
        <?php } ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Number of People</th>
                <th>Special Requests</th>
                <th>Contact Number</th>
                <th>Customer Name</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
            <?php if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['reservation_date']; ?></td>
                        <td><?php echo $row['reservation_time']; ?></td>
                        <td><?php echo $row['number_of_people']; ?></td>
                        <td><?php echo $row['special_requests']; ?></td>
                        <td><?php echo $row['contact_number']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['payment_status']; ?></td>
                        <td><a href="editreservation.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="10">No reservations found.</td>
                </tr>
            <?php } ?>
        </table>
    </section>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
