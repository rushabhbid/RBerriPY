<?php
include_once("includes/connection.php");
include_once("includes/functions.php");

if(!isset($_SESSION['loggedInUser'])){
   //send the user to login page
   header("location:home.php");
}

session_start();
$type = $_POST["type"];
$description = $_POST["desc"];
$sev = $_POST["sev"];
$user = "yash";
$status='Issue Reported';
$nfreviews='1';
$lat= $_POST["lat"];
$lon= $_POST["lon"];
$ward='thane';

$issue = "INSERT INTO issue(user,description,type,lat,lon,ward,timestamp,sev,status,nfreviews)
			VALUES
			('$user',
        '$description',
        '$type',
  			'$lat',
      '$lon',
			'$ward',
		 CURRENT_TIMESTAMP(),
     '$sev',
     '$status',
     '$nfreviews')";

$result = mysqli_query($conn,$issue);
?>