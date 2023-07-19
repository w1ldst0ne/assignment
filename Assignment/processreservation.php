<?php
session_start();

// Check if user is logged in as a customer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    $_SESSION['error_message'] = 'Please log in as a customer to make a reservation.';
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database configuration
    $host = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'SCDB';

    // Create a database connection
    $mysqli = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    // Retrieve the form data
    $reservationDate = $_POST['reservation_date'] ?? '';
    $reservationTime = $_POST['reservation_time'] ?? '';
    $numberOfPeople = $_POST['number_of_people'] ?? '';
    $specialRequests = $_POST['special_requests'] ?? '';
    $contactNumber = $_POST['contact_number'] ?? '';
    $customerName = $_POST['customer_name'] ?? '';

    // Get the logged-in username
    $username = $_SESSION['username'];

    // Generate a unique table number
    $tableNumber = generateUniqueTableNumber($mysqli);

    // Prepare the SQL statement
    $stmt = $mysqli->prepare("INSERT INTO reservations (reservation_date, reservation_time, number_of_people, special_requests, contact_number, customer_name, username, table_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters to the statement
    $stmt->bind_param("ssissssi", $reservationDate, $reservationTime, $numberOfPeople, $specialRequests, $contactNumber, $customerName, $username, $tableNumber);

    // Execute the statement
    if ($stmt->execute()) {
        // Reservation is successfully added to the database
        $_SESSION['success_message'] = 'Reservation successfully created.';
        header("Location: home.php");
        exit();
    } else {
        // Failed to add the reservation
        $_SESSION['error_message'] = 'Error: ' . $stmt->error;
        header("Location: makereservation.php");
        exit();
    }

    // Close the statement and database connection
    $stmt->close();
    $mysqli->close();
}

// Function to generate a unique table number below 100
function generateUniqueTableNumber($mysqli) {
    $tableNumber = mt_rand(1, 99);

    // Check if the generated table number already exists in the reservations table
    $stmt = $mysqli->prepare("SELECT * FROM reservations WHERE table_number = ?");
    $stmt->bind_param("i", $tableNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the table number already exists, generate a new one recursively
    if ($result->num_rows > 0) {
        $stmt->close();
        return generateUniqueTableNumber($mysqli);
    }

    $stmt->close();
    return $tableNumber;
}
?>
?>