<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
	$db_host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "SCDB";

	$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieving the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $query = "INSERT INTO queries (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Your query has been submitted successfully.';
    } else {
        $_SESSION['error_message'] = 'Error: ' . $conn->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Redirect back to the "contact.php" page
    header("Location: contact.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
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
<meta charset="utf-8">
<title>Signature Cuisine Restaurant - Contact</title>
<link href="style.css" rel="stylesheet" type="text/css">
	<style>
  /* Add a fixed width to the "Name" input element */
  #name {
    width: 250px;
  }
</style>
</head>

<body>
    <header>
        <h1>Contact Us</h1>
    </header>

    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="makereservation.php">Make a Reservation</a></li>
            <li><a href="offers.php">Offers</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="aboutus.php">About Us</a></li>
        </ul>
    </nav>

    <section>
        <h2>Contact Information</h2>
        <p>For reservations or inquiries, please contact us:</p>
        <?php if (isset($_SESSION['success_message'])) { ?>
            <p class="success"><?php echo $_SESSION['success_message']; ?></p>
            <?php unset($_SESSION['success_message']); ?>
        <?php } ?>

        <?php if (isset($_SESSION['error_message'])) { ?>
            <p class="error"><?php echo $_SESSION['error_message']; ?></p>
            <?php unset($_SESSION['error_message']); ?>
        <?php } ?>
        <form action="contact.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea><br>

            <input type="submit" value="Submit">
        </form>
    </section>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
