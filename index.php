<?php

session_start();

echo $_SESSION['loginid'];

	$link = mysqli_connect("localhost","cl57-example-d98","N/z.--4M.","cl57-example-d98");
	
	
	if (mysqli_connect_error()){
		
			 die("could not connect to database.");
		
		}

	
	$query = "UPDATE `users` SET `name` = 'Ian O\'neil' WHERE `id` = 1";
	
	mysqli_query($link,$query);

	
	$name="Ian O'neil";
	//mysqli_real_escape_string() can return string neglect the ÄÚ÷¬µÄÌØÊג·û÷Å£»
	$query = "SELECT name FROM users WHERE name = '".mysqli_real_escape_string($link,$name)."'";
	
	// then to run the query : two item first step connection to the database second step send out the query;
	if($result = mysqli_query($link,$query)) {
				//catch/fetch the array just taken place;
				//$row will be the array that contain the data got from the query;
				//mysqli_num_rows() return the number of how many rows we found
				echo mysqli_num_rows($result);
				
				while ($row = mysqli_fetch_array($result)){
				//echo "$row[1]"; 
				print_r($row);
	}
		} else {
			
				echo "it failed";
			
			}
		
		
?>