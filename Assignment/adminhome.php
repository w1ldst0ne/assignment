<?php
session_start();

// Check if user is logged in as an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
  // Redirect to login page or show an error message
  echo "Access denied. Please login as an admin.";
  exit();
}
$restaurantName = "Signature Cuisine Restaurant";
$welcomeMessage = "Welcome to our admin panel!";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Home</title>
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
</style>
</head>

<body>
  <header>
    <div class="topnav">
      <div class="topnav-right">
        <a href="logout.php">Logout</a>
      </div>
    </div>
    <h1>Welcome to Signature Cuisine Restaurant</h1>
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
    <h2>Explore <?php echo $restaurantName; ?></h2>
    <p><?php echo $welcomeMessage; ?></p>
  </section>

  <footer>
	  <img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
    <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
  </footer>
</body>
</html>