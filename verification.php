<?php 

$pageTitle = "Verification";
$verification = 0;
 include ('header.php'); 
 $a = $_GET['a'];
 $id = $_GET['id'];
 ?>

 <br>
  <?php 
  
	$q_company = "SELECT * FROM users WHERE Verification_Code = '". $a . "' and User_Id ='". $id . "'";
	$r_company = mysqli_query ($dbc, $q_company) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

	if (mysqli_num_rows($r_company) == 1) {
		
		//Check if company exists and add to dropdown and make this user the head of it
		$q = "UPDATE `users` SET `Verification_Code` = '1' WHERE Verification_Code = '". $a . "' and User_Id ='". $id . "' ";
		$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if ($r) {
				
				if (isset($_SESSION['id']) AND ($_SESSION['id'] == $id)) {
					$_SESSION['Verification_Code']= '1';
				}
				
				
				echo "<div class='success'><strong>Thank you for for verifying your email.</strong></div> "; }
			else {echo "<div class='error'>There was an error on our end. Please refresh and try again.</div> ";}
	} else{
		echo "<div class='error'>Invalid Verification Code</div> ";
	}
  ?>
 
  <?php include ('footer.php'); ?>


