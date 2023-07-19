<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link href="others.css" rel="stylesheet" type="text/css">
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
<title>Signature Cuisine Restaurant - Menu</title>

<style>
    .menu-content {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .signature-dishes {
        flex-basis: 45%;
        border: 2px solid #CBD6E2;
        padding: 20px;
    }

    .menu-table {
        background-color: #CDC877;
        flex-basis: 45%;
        display: none;
        border: 2px solid #FFF;
        padding: 20px;
    }

    .show-more {
        cursor: pointer;
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
        left: 0; /* Adjust the left position */
        top: 100%; /* Align below the Tools button */
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
        .menu-content {
            flex-direction: column;
        }
        .menu-table {
            display: none; 
        }
    </style>

    <script>
        function toggleMenuTable() {
            var menuTable = document.getElementById('menu-table'); // Use the id of the menu-table section
            var showMore = document.querySelector('.show-more');

            if (menuTable.style.display === 'none') {
                menuTable.style.display = 'block';
                showMore.textContent = 'Show less ^';
            } else {
                menuTable.style.display = 'none';
                showMore.textContent = 'Show more v';
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>Our Menu</h1>
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
        <div class="menu-content">
            <div class="signature-dishes">
                <h3>Signature Dishes</h3>
                <ul>
                    <li>Grilled Salmon</li>
                    <li>Filet Mignon</li>
                    <li>Spaghetti Bolognese</li>
                    <li>Chicken Alfredo</li>
                </ul>
            </div>
			<section class="featured-dishes">
        <h2>Our Featured Dishes</h2>
        <div class="dish">
          <img src="images/menu/img1.jpg" alt="Grilled Salmon">
            <h3>Grilled Salmon</h3>
            <p>This grilled salmon is coated in a flavorful marinade then grilled until golden brown. A super easy dinner option that will earn you rave reviews! This salmon can also be baked, broiled, or pan-seared.</p>
        </div>
        <div class="dish">
          <img src="images/menu/img2.jpg" alt="Filet Mignon">
            <h3>Filet Mignon</h3>
            <p>Filet mignon is the smaller tip of tenderloin and one of the most expensive cuts of steak, due to its prized texture and that it's only about 2% of the total animal. Fun fact: When filet mignon isn’t riding solo on your plate, it can also be a part of another cut, the T-bone. The T-bone consists of strip steak on the bigger side of the bone, and filet mignon on the shorter side. If you can’t decide what you like, opt for a T-bone and you can have both!</p>
        </div>
		<div class="dish">
          <img src="images/menu/img3.jpg" alt="Speghetti Bolognese">
            <h3>Spaghetti Bolognese</h3>
            <p>Spaghetti bolognese consists of spaghetti (long strings of pasta) with an Italian ragù (meat sauce) made with minced beef, bacon and tomatoes, served with Parmesan cheese. Spaghetti bolognese is one of the most popular pasta dishes eaten outside of Italy.</p>
        </div>
    </section>
			

          <section id="menu-table" class="menu-table">
                <h3>Full Menu</h3>
                <table>
                    <?php
                    // Database configuration and query
                    $host = 'localhost';
                    $dbUsername = 'root';
                    $dbPassword = '';
                    $dbName = 'SCDB';

                    $mysqli = new mysqli($host, $dbUsername, $dbPassword, $dbName);
                    if ($mysqli->connect_error) {
                        die('Connection failed: ' . $mysqli->connect_error);
                    }

                    $sql = "SELECT * FROM Menu";
                    $result = $mysqli->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>".$row['food_item']."</td>";
                            echo "<td>".$row['contents']."</td>";
                            echo "<td>".$row['price']."</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan=\"3\">No menu items found.</td></tr>";
                    }

                    $mysqli->close();
                    ?>
                </table>
            </section>
        </div>
        <p class="show-more" onclick="toggleMenuTable()">Show more v</p>
    </section>

    <footer>
	  <img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
