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

$query_id = $_GET['id'];

// Fetch the query details from the "queries" table
$query = "SELECT * FROM queries WHERE id = $query_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Error: Query not found.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$email = $row['email'];
$message = $row['message'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the response from the form
    $response = $_POST['response'];

    // Prepare the SQL statement to insert the response into the "response" table using a prepared statement
    $insert_query = "INSERT INTO response (queryid, response) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "is", $query_id, $response);
        if (mysqli_stmt_execute($stmt)) {
            // Update the "responded" status in the "queries" table to indicate the query has been responded to
            $update_query = "UPDATE queries SET responded = '1' WHERE id = $query_id";
            if (mysqli_query($conn, $update_query)) {
                echo "<script>alert('Response submitted successfully.'); window.location.href = 'queries.php';</script>";
                exit();
            } else {
                echo "Error updating query status: " . mysqli_error($conn);
            }
        } else {
            echo "Error submitting response: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Respond to Query</title>
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
        <h1>Respond to Query</h1>
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
        <h2>Query Details</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly><br>

        <label for="message">Message:</label>
        <textarea id="message" name="message" readonly><?php echo $message; ?></textarea><br>

        <h2>Response</h2>
        <p>Replying by email</p>
        <form action="response.php?id=<?php echo $query_id; ?>" method="POST">
            <textarea name="response" rows="8" cols="80" required></textarea><br>
            <input type="submit" value="Submit Response">
        </form>
    </section>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>