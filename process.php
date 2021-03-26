<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "urlshortener";

	error_reporting(E_ALL ^ E_WARNING); 

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) 
	{	
		// debug
		$error_msg = "Connection failed: " . $conn->connect_error;
	  	echo json_encode(["error" => $error_msg]);
	}
	else if (isset($_POST))
	{	
		$link = $_POST["link"];

		if (substr($link, 0, 8) != "https://" && substr($link, 0, 7) != "http://")
			$link = "http://" . $link;

		$link = $conn->real_escape_string($link);
		$link = htmlentities($link);

		$seconds = time();

		$shorten_link = hash('ripemd160', $link.$seconds);
		$shorten_link = substr($shorten_link, 0, 10);


		$sql = "INSERT INTO urls (shorten_hash, link) VALUES ('$shorten_link', '$link')";

		if ($conn->query($sql) === TRUE) 
		{	
			// get last 5
			// $sql = "SELECT * FROM (SELECT * FROM urls WHERE link='$link' ORDER BY id DESC LIMIT 5) sub ORDER BY id ASC";
			// get all generate urls
			$sql = "SELECT * FROM urls WHERE link='$link'";

			$result = $conn->query($sql);

			$rows = [];

			while($row = $result->fetch_assoc()) 
			{
    			array_push($rows, 
    				[
    					'shorten_hash' => $row['shorten_hash'],
    					'link' => $link,
    					'used' => $row['used']
    				]
    			);
  			}

  			echo json_encode($rows);
		}
		else
			echo json_encode(["error" => "Error: " . $conn->error]);
		
		$conn->close();	
	}

	
?>