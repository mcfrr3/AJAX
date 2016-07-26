<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 26.07.2016
 * Time: 09:06
 */

// clear any data saved in the session
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<title>AJAX Form Validation</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link href="validate.css" rel="stylesheet" type="text/css">
</head>
<body>
	Registration Successful!<br>
	<a href="index.php" title="Go back">&lt;&lt; Go back</a>
</body>
</html>
