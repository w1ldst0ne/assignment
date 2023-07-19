<?php
session_start();
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
    <title>Signature Cuisine Restaurant - About Us</title>
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
    </style>
</head>

<body>
    <header>
        <h1>About Us</h1>
    </header>

    <nav>
        <ul>
            <?php if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] === 'customer') { ?>
                <li><a href="home.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
			    <li><a href="makereservation.php">Make a Reservation</a></li>
                <li><a href="offers.php">Offers</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="aboutus.php">About Us</a></li>
            <?php } elseif ($_SESSION['user_type'] === 'staff') { ?>
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
            <?php } elseif ($_SESSION['user_type'] === 'admin') { ?>
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
            <?php } ?>
        </ul>
    </nav>

    <section>
        <h2>About Us</h2>
        <div>
            <h3>Welcome to Signature Cuisine Restaurant</h3>
            <p>
                We are a premier dining destination in Colombo, Sri Lanka. Our mission is to provide our guests
                with a memorable dining experience through our delicious cuisine, warm hospitality, and elegant ambiance.
            </p>
        </div>
        <div>
            <h3>Contact Information</h3>
            <ul>
                <li>Phone: +94 123 4567</li>
                <li>Email: info@signaturecuisine.com</li>
                <li>Address: 123 Main Street, Colombo, Sri Lanka</li>
            </ul>
        </div>
    </section>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
