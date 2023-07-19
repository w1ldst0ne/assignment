<?php
// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, display the logout button
    echo '<div class="topnav-right" style="margin-top: 10px;"><a href="logout.php">Logout</a></div>';
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
</body>
</html>
