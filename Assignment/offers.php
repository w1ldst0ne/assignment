<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
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
    <title>Signature Cuisine Restaurant - Offers</title>
    
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
            padding: 8px 0;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            display: block;
            padding: 4px 8px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>

<body>
    <header>
        <h1>Our Offers</h1>
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
                        <a href="viewreservations.php">View Reservations</a>
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
        <h2>Special Offers</h2>
        <p>Check out our latest offers:</p>
        <ul>
            <li>Happy Hour: Buy one get one free on selected drinks.</li>
            <li>Lunch Special: Enjoy a 3-course meal for only $15.</li>
            <li>Weekend Buffet: All-you-can-eat buffet for $25 per person.</li>
        </ul>
    </section>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
