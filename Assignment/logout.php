<?php
session_start();

// Destroy the session and redirect to the login page
session_destroy();
header("Location: index.html");
exit();
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