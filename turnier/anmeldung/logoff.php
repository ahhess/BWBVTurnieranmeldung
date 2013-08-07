<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Ausgeloggt.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
if (session_destroy()) print "Sie haben sich soeben ausgeloggt.<p>Auf Wiedersehen!<p>";
?>
<p>Zum <a href="index.php">Login</a></p>
</body>
</html>
