<?php
session_start();
include 'logout-button.php';

// Check if user is logged in as a customer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    $_SESSION['error_message'] = 'Please log in as a customer to make a reservation.';
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Signature Cuisine Restaurant - Make Reservation</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <h1>Make Reservation</h1>
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
        <h2>Reservation Details</h2>
        <?php if (isset($_SESSION['error_message'])) { ?>
            <p class="error"><?php echo $_SESSION['error_message']; ?></p>
            <?php unset($_SESSION['error_message']); ?>
        <?php } ?>
        <form action="processreservation.php" method="POST">
            <label for="reservation-date">Date:</label>
            <input type="date" id="reservation-date" name="reservation_date" required><br>

            <label for="reservation-time">Time:</label>
            <input type="time" id="reservation-time" name="reservation_time" required><br>

            <label for="number-of-people">Number of People:</label>
            <input type="number" id="number-of-people" name="number_of_people" required><br>

            <label for="special-requests">Special Requests:</label>
            <textarea id="special-requests" name="special_requests"></textarea><br>

            <label for="contact-number">Contact Number:</label>
            <input type="text" id="contact-number" name="contact_number" required><br>

            <label for="customer-name">Customer Name:</label>
            <input type="text" id="customer-name" name="customer_name" required><br><br><br>

            <input type="submit" value="Make Reservation">
        </form>
    </section>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
