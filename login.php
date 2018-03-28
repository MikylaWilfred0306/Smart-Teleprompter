<?php
$pageTitle = "Login";
$verification = 0;
 include ('header.php'); 
		
$errors = "";
if (isset($_POST['submit'])) {
	
		$email_post = $_POST['email'];
		$pass = $_POST['pass'];
		// Retrieve the user's information:
		$q = "SELECT * FROM `users` WHERE UPPER(email)='".strtoupper($email_post)."'";	
		$r = @mysqli_query ($dbc, $q);
		
		
			if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.
				$q2 = "SELECT * FROM `users` Left Join company on Company_Id = Belongs_To WHERE email='$email_post' AND password=SHA1('$pass')";	


				$r2 = @mysqli_query ($dbc, $q2);
			
			
				if (mysqli_num_rows($r2) == 1) { // Valid user ID, show the form.
				
				// Set the session data:
				session_start();
				
				// Get the user's information:
				$row = mysqli_fetch_array ($r2, MYSQLI_NUM);
				
				$_SESSION['user_email'] = strtolower($email_post);
				$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
				

				// Create the form:
				$_SESSION['name']=$row[3] . " " . $row[4];
				$_SESSION['id']=$row[0];
				$_SESSION['Font_Pref']= $row[5];
				$_SESSION['Font_Size_Pref']= $row[6];
				$_SESSION['Font_Color_Pref']= $row[7];
				$_SESSION['Background_Color_Pref']= $row[8];
				$_SESSION['Belongs_To']= $row[14];
				$_SESSION['In_Charge_Of_Company']= $row[11];
				$_SESSION['Verification_Code']= $row[12];
				
				
				$url = 'index.php';
				header("Location: $url"); 
				exit();			
			} else { // Unsuccessful!
				$errors = "Wrong Password";
			}
		}else { // Unsuccessful!
			$errors = "Wrong Email";
		}
		

} // End of the main submit conditional.

include ('login_page.inc.php');
?>