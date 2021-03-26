<?php
	if ($_SERVER['REQUEST_URI'] != '/')
	{
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "urlshortener";

		$conn = new mysqli($servername, $username, $password, $dbname);


		$URL_redirect = substr($_SERVER['REQUEST_URI'], 1);
		$hash = $conn->real_escape_string($URL_redirect);

		$sql = "SELECT * FROM urls WHERE shorten_hash='$hash'";
		
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();

			$link = $row["link"];
			$used = $row["used"];

			$sql_update = "UPDATE urls SET used='$used'+1 WHERE shorten_hash='$hash'";
			$conn->query($sql_update);

			echo "<script type=\"text/javascript\">window.location='$link';</script>";
     		exit();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>url shortener</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	
</head>
<body>

	<div class="main">
		<div class="box">
			<input id="search-bar" type="url">
			<input id="search-button" type="button" value="SHORTEN">

			<table id="links-table">
				
			</table>

			<div id="alert">
				
			</div>
		</div>
	</div>

	<script type="text/javascript" src="script.js"></script>
	
</body>
</html>