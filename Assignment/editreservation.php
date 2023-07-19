<?php
session_start();

// Check if user is logged in as a staff
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
  // Redirect to login page or show an error message
  echo "Access denied. Please login as a staff member.";
  exit();
}

// Check if reservation ID is provided in the URL
if (!isset($_GET['id'])) {
  echo "Error: Reservation ID not provided.";
  exit();
}

// Database configuration
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "SCDB";

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$reservation_id = $_GET['id'];

// Fetch reservation data based on the provided reservation ID
$query = "SELECT * FROM reservations WHERE id = $reservation_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
  echo "Error: Reservation not found.";
  exit();
}

// Fetch the reservation details
$reservation_data = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the edited values from the form
  $payment_status = $_POST['payment_status'];
  $status = $_POST['status'];

  // Update the reservation data in the database
  $update_query = "UPDATE reservations SET payment_status = '$payment_status', status = '$status' WHERE id = $reservation_id";

  if (mysqli_query($conn, $update_query)) {
    echo "<script>alert('Reservation updated successfully.'); window.location.href = 'staffreservation.php';</script>";
    exit();
  } else {
    echo "Error updating reservation: " . mysqli_error($conn);
  }
}

mysqli_close($conn);
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Reservation</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <header>
    <!-- Header content here -->
  </header>

  <nav>
    <!-- Navigation content here -->
  </nav>

  <section>
    <h2>Edit Reservation</h2>
    <form action="" method="POST">
      <label for="reservation-date">Reservation Date:</label>
      <input type="text" id="reservation-date" name="reservation_date" value="<?php echo $reservation_data['reservation_date']; ?>" readonly><br>

      <label for="reservation-time">Reservation Time:</label>
      <input type="text" id="reservation-time" name="reservation_time" value="<?php echo $reservation_data['reservation_time']; ?>" readonly><br>

      <label for="number-of-people">Number of People:</label>
      <input type="text" id="number-of-people" name="number_of_people" value="<?php echo $reservation_data['number_of_people']; ?>" readonly><br>

      <label for="special-requests">Special Requests:</label>
      <textarea id="special-requests" name="special_requests" readonly><?php echo $reservation_data['special_requests']; ?></textarea><br>

      <label for="contact-number">Contact Number:</label>
      <input type="text" id="contact-number" name="contact_number" value="<?php echo $reservation_data['contact_number']; ?>" readonly><br>

      <label for="customer-name">Customer Name:</label>
      <input type="text" id="customer-name" name="customer_name" value="<?php echo $reservation_data['customer_name']; ?>" readonly><br>

      <label for="payment-status">Payment Status:</label>
      <select id="payment-status" name="payment_status">
        <option value="paid" <?php echo ($reservation_data['payment_status'] === 'paid') ? 'selected' : ''; ?>>Paid</option>
        <option value="pending" <?php echo ($reservation_data['payment_status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
      </select><br>

      <label for="status">Status:</label>
      <select id="status" name="status">
        <option value="confirmed" <?php echo ($reservation_data['status'] === 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
        <option value="canceled" <?php echo ($reservation_data['status'] === 'canceled') ? 'selected' : ''; ?>>Canceled</option>
      </select><br>

      <input type="submit" value="Update">
    </form>
  </section>

  <footer>
	  <img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
    <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
  </footer>
</body>
</html>