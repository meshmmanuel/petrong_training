<?php
    $connect = mysqli_connect('localhost:3306', 'root', '', 'petrong_training');
	if(!$connect){
		die("Could not connect to database: " . mysqli_error($connect));
    }
?>