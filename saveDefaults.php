<?php
session_start(); // Access the existing session.
	// get the q parameter from URL
	$Font_Size_Pref = $_GET["q"];
	$Font_Color_Pref = "#" . $_GET["r"];
	 $Background_Color_Pref = "#" . $_GET["s"];
	$Font_Pref = $_GET["t"];
	
	$_SESSION['Font_Pref']= $Font_Pref ;
	$_SESSION['Font_Size_Pref']= $Font_Size_Pref;
	$_SESSION['Font_Color_Pref']= $Font_Color_Pref;
	$_SESSION['Background_Color_Pref']= $Background_Color_Pref;


$con = mysqli_connect('localhost','root','container','x_test_teleprompter');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"x_test_teleprompter");
$sql="UPDATE `users` SET `Font_Pref`='".$Font_Pref."',`Font_Size_Pref`='".$Font_Size_Pref."',`Font_Color_Pref`='".$Font_Color_Pref."',`Background_Color_Pref`='".$Background_Color_Pref."' WHERE User_Id =" . $_SESSION['id'];
$result = mysqli_query($con, $sql);
	if($result) {
		echo 'saved';
	}
?>