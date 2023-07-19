<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    // Redirect to login page or show an error message
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

if (!isset($_GET['id'])) {
    echo "Error: User ID not provided.";
    exit();
}

// Fetching the user details from the users table and delete
$user_id = $_GET['id'];

$delete_query = "DELETE FROM users WHERE id = $user_id";
if (mysqli_query($conn, $delete_query)) {
    header("Location: editusers.php");
    exit();
} else {
    echo "Error: Unable to remove the user.";
}
mysqli_close($conn);
?>
