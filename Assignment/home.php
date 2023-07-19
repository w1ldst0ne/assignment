<?php
session_start();

// Check if user is logged in as an admin
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
    header("Location: adminhome.php");
    exit();
}
// Check if user is logged in as a staff member
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'staff') {
    header("Location: staffhome.php");
    exit();
}

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


// Close the database connection
$mysqli->close();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Signature Cuisine Restaurant</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="others.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
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
		<!-- Add the logo image in the header -->
    <img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
    <h1>Welcome to <?php echo "Signature Cuisine Restaurant"; ?></h1>
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

    <section class="intro-section">
        <h2>Our Restaurant</h2>
        <p>Welcome to Signature Cuisine Restaurant, where we take pride in serving you the most delicious and authentic dishes from around the world. Our talented chefs use only the finest ingredients to create culinary masterpieces that will tantalize your taste buds. Whether you're a food connoisseur or a casual diner, we guarantee a dining experience that will leave you craving for more.</p>
    </section>
	
	<section class="slideshow">
    <div class="slides-container">
        <img src="images/slideshow/img1.jpg" alt="Slideshow Image 1">
        <img src="images/slideshow/img2.jpg" alt="Slideshow Image 2">
        <img src="images/slideshow/img3.jpg" alt="Slideshow Image 3">
		<img src="images/slideshow/img4.jpg" alt="Slideshow Image 4">
		<img src="images/slideshow/img5.jpg" alt="Slideshow Image 5">
    </div>
	</section>
<script>
  const slidesContainer = document.querySelector(".slides-container");
  let currentSlide = 0;
  const slideCount = 4; // Number of slides

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slideCount; // Move to the next slide or back to the first slide after the last one
    slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`; // Slide to the appropriate image
  }

  // Move to the next slide every 10 seconds
  setInterval(nextSlide, 10000);
</script>
	<section class="features-section">
    <div class="feature-box" style="background-color: #4D4D4D;">
        <div class="icon-container">
            <img src="images/icons/img1.png" class="icon" alt="Icon 1">
            <img src="images/icons/img2.png" class="highlighted-icon" alt="Icon 1 Highlighted">
        </div>
        <h3>Best Food Quality</h3>
        <p>Maintaining the quality standard to the height of expectation is our main responsibility. We employ well experienced chefs who have been in the industry and well conversant with flavors and cousins, serving to the international clientele.</p>
    </div>

    <div class="feature-box" style="background-color: #4D4D4D;">
        <div class="icon-container">
            <img src="images/icons/img3.png" class="icon" alt="Icon 2">
            <img src="images/icons/img4.png" class="highlighted-icon" alt="Icon 2 Highlighted">
        </div>
        <h3>Friendly Atmosphere</h3>
        <p>Widely spacious, fully AC Environment, Easy access to all food stations. Friendly staff. Kids Play station, Ample parking, Serves Two food courts at the ground floor at the roof top.</p>
    </div>

    <div class="feature-box" style="background-color: #4D4D4D;">
        <div class="icon-container">
            <img src="images/icons/img5.png" class="icon" alt="Icon 3">
            <img src="images/icons/img6.png" class="highlighted-icon" alt="Icon 3 Highlighted">
        </div>
        <h3>Easy on your pocket</h3>
        <p>Sasha offers reasonable price structure to cater to a wider segment. Family parties’ events and tourist packages made our menus affordable to the expectations.</p>
    </div>
</section>
	

	 <script>
        const iconContainers = document.querySelectorAll('.icon-container');

        iconContainers.forEach((container) => {
            const icon = container.querySelector('.icon');
            const highlightedIcon = container.querySelector('.highlighted-icon');

            container.addEventListener('mouseover', () => {
                icon.style.display = 'none';
                highlightedIcon.style.display = 'block';
            });

            container.addEventListener('mouseout', () => {
                icon.style.display = 'block';
                highlightedIcon.style.display = 'none';
            });
        });
    </script>

    <section class="opening-hours">
        <h2>Opening Hours</h2>
        <p>Monday to Friday: 11:00 AM - 10:00 PM</p>
        <p>Saturday and Sunday: 10:00 AM - 11:00 PM</p>
        <p>We are open 7 days a week to serve you with the best dining experience.</p>
    </section>

    <section class="contact-info">
        <h2>Contact Us</h2>
        <p>Signature Cuisine Restaurant
		   123 Main Street, Colombo 00100,
		   Sri Lanka</p>
        <p>Email: info@signaturecuisine.com</p>
        <p>Phone: +1 (123) 456-7890</p>
    </section>


    <footer>
		<img src="images/logo/img1.jpg" alt="Signature Cuisine Logo">
        <p>&copy; 2023 Signature Cuisine Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>
