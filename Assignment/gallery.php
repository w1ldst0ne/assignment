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
<title>Signature Cuisine Restaurant - Gallery</title>
<link href="style.css" rel="stylesheet" type="text/css">
<style>
        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
        }

        .gallery-item {
            flex-basis: calc(33.33% - 10px); /* Adjust the size based on your preference */
            margin-bottom: 20px;
            border: 2px solid #CBD6E2;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
        }
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
        <h1>Our Gallery</h1>
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
        <h2>Photo Gallery</h2>
        <div class="gallery-container">
            <div class="gallery-item">
                <img src="images/gallery/img1.jpg" alt="Image 1">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img2.jpg" alt="Image 2">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img3.jpg" alt="Image 3">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img4.jpg" alt="Image 4">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img5.jpg" alt="Image 5">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img6.jpg" alt="Image 6">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img7.jpg" alt="Image 7">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img8.jpg" alt="Image 8">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img9.jpg" alt="Image 9">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img10.jpg" alt="Image 10">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img11.jpg" alt="Image 11">
            </div>
            <div class="gallery-item">
                <img src="images/gallery/img12.jpg" alt="Image 12">
            </div>
        </div>
    </section>

    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
