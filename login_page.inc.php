<?php 
ob_start();
//session_start();

if ($errors != '') {
	echo "<div class='error'>$errors</div> ";
}

?>

<style>
/* Popup container - can be anything you want */
.popup {
    position: relative;
    display: inline-block;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* The actual popup */
.popup .popuptext {
    visibility: hidden;
    width: 300px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px 0;
    position: absolute;
    z-index: 1;
    bottom: -10%;
    left: 138%;
    margin-left: -80px;
}

/* Popup arrow */
.popup .popuptext::after {
    content: " ";
    position: absolute;
    top: 50%;
    right: 100%; /* To the left of the tooltip */
    margin-top: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent black transparent transparent;
}

/* Toggle this class - hide and show the popup */
.popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
    from {opacity: 0;} 
    to {opacity: 1;}
}

@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity:1 ;}
}
</style>


<script>

var capsLockEnabled = null;

function getChar(e) {

  if (e.which == null) {
    return String.fromCharCode(e.keyCode); // IE
  }
  if (e.which != 0 && e.charCode != 0) {
    return String.fromCharCode(e.which); // rest
  }

  return null;
}

document.onkeydown = function(e) {
  e = e || event;

  if (e.keyCode == 20 && capsLockEnabled !== null) {
    capsLockEnabled = !capsLockEnabled;
  }
}

document.onkeypress = function(e) {
  e = e || event;

  var chr = getChar(e);
  if (!chr) return; // special key

  if (chr.toLowerCase() == chr.toUpperCase()) {
    // caseless symbol, like whitespace 
    // can't use it to detect Caps Lock
    return;
  }

  capsLockEnabled = (chr.toLowerCase() == chr && e.shiftKey) || (chr.toUpperCase() == chr && !e.shiftKey);
}

/**
 * Check caps lock 
 */
function checkCapsWarning() {
  document.getElementById('pass1pop').style.visibility = capsLockEnabled ? 'visible' : 'hidden';
}

function removeCapsWarning() {
  document.getElementById('pass1pop').style.visibility = 'hidden';
}


</script>

		<br> 
		<br> 
		<br> 
		<div class="formHolder">
		<div class="header"> <h1>Log in! </h1> </div> 
		
			<form class="form" action="login.php" method="post">
			
			
			  <div class="labeler"> Email</div>
			  <input name="email" class="textbox" type="text" placeholder="Email">
			
				<br>
			<br>
			
		
			 <div class="labeler"> Password </div>
			    
		   
		 <div class="popup"><span id="pass1pop" class="popuptext">Warning: Caps Lock is on!</span>	
			  <input name="pass" id="pass" onkeyup="checkCapsWarning(event)" onfocus="checkCapsWarning(event)" onblur="removeCapsWarning()" class="textbox popup" type="password"  placeholder="Password">
		</div>
     
		   
		   
			
			<input type="hidden" name="submitted" value="TRUE" />
		
			<br>
			<br>
			
			  <button type="submit" name="submit"> Login</button>
			  
				<a href="changepassword.php"><button type="button">Change Password</button></a>
				<a href="createuser.php"><button type="button">Register</button></a>

			</form>
		</div>

 <?php include ('footer.php'); ?>