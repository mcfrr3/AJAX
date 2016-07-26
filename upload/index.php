<?php
/**
 * Created by IntelliJ IDEA.
 * User: Michael
 * Date: 26.07.2016
 * Time: 14:26
 */

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>AJAX Upload</title>
	<script src="scripts/jquery-3.0.0.js"></script>
	<script src="scripts/upload.js"></script>
	<link href="style/upload.css" rel="stylesheet" type="text/css">
</head>
<body>
	<h2>AJAX Upload</h2>
	<div id="uploadprogress">
		Uploading...
		<img src="images/loader.gif">
	</div>
	<div id="uploadform">
		<form action="upload.php" method="post" id="form" enctype="multipart/form-data">
			<label for="file">File</label>
			<input name="file" id="file" type="file">
			<br>
			<input type="submit" id="upload" value="Upload">
			<span id="result"></span>
		</form>
	</div>
</body>
</html>
