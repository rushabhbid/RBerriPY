<?php
session_start();

if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:home.php");
}

include_once("includes/connection.php");
include_once("includes/functions.php");

$sql="SELECT * FROM issue";
$res=mysqli_query($conn,$sql);
$n=mysqli_num_rows($res);
$i=1;

for($j=0;$j<$n;$j++,$i++) {
	$q="SELECT * from issue where id='$i' ";
	$res=mysqli_query($conn,$q);
	if($res) {
		$row=mysqli_fetch_assoc($res);
		echo '<br>'.$row['type'].'<br>';
		$in=$i."_com_".$j;
		echo '
<form method="POST" action="comment.php">
		<br><input type="text" id= "$in" name="$in" placeholder="Enter a comment..">
		<input type = "hidden" id ="num" name = "num" value = "'.$in.'	">
		<button type="submit" name="sub" id="sub">Submit</button></form>
		<script> 
			var x=getElementsById["$in"];
		document.cookie=x; </script>'?>
		<?php
		if(isset($_POST['sub'])) {
			//$com= $_POST['comment'];
			$var=$_POST['$in'];
			$num=$_POST['num'];
			//echo $num;
			if($in==$num) {
				$qu="INSERT INTO comment(id,comment) values ('$i','$var')";
				if(mysqli_query($conn,$qu)) {
					//echo $i;
					echo '<br><h2>'.$var.'</h2>';
				}
			}
		}
	}
}