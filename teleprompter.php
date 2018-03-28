<?php 

/*
Horizontal Flip

-moz-transform: scale(-1, 1);
-webkit-transform: scale(-1, 1);
-o-transform: scale(-1, 1);
-ms-transform: scale(-1, 1);
transform: scale(-1, 1);

-------------------------

Vertical Flip

-moz-transform: scale(1, -1);
-webkit-transform: scale(1, -1);
-o-transform: scale(1, -1);
-ms-transform: scale(1, -1);
transform: scale(1, -1);
*/


if ($_POST['file']){
	$file = $_POST['file'];
	$Font_Color_Pref = $_POST['Font_Color_Pref'];
	$Font_Pref = $_POST['Font_Pref'];
	$Background_Color_Pref = $_POST['Background_Color_Pref'];
	$Font_Size_Pref = $_POST['Font_Size_Pref'];
} else {
	header("Location: index.php");
	exit();	
}

$fh = fopen($file,'r');
while ($line = fgets($fh)) {
   echo "<p>".$line."</p>";
}
fclose($fh);
?>



<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="logo/icon.jpg">
<title>Teleptompter</title>
<style>
body {
	/* Removes Text Highlighting*/
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
	
	
	/*will be set by session and user defaults*/
	background-color: <?php echo $Background_Color_Pref ?>;
	
	/*wraps words*/
	word-wrap: break-word;
}

button {
    position: fixed;
}

p {
  /*will be set by session and user defaults*/
  color: <?php echo $Font_Color_Pref ?>;


  /*will be set by session and user defaults*/
  font-family: "<?php echo $Font_Pref ?>";
  
  /*will be set by session and user defaults*/
  font-size: <?php echo $Font_Size_Pref ?>px;
  
  
  word-wrap: break-word;
}
</style>
</head>
<body onmousedown="mousedown(event)" onmouseup="mouseup(event)" onkeydown="keydown()">


<script>

//Disable right clci 
document.addEventListener('contextmenu', event => event.preventDefault());


var mousedownID = -1;  //Global ID of mouse down interval
var speed = 10; 
function mousedown(event) {
	if (speed == 0){ speed = 10; }
	if (event.button == 2){speed = speed * -1} 
	
  if(mousedownID==-1)  //Prevent multimple loops!
     mousedownID = setInterval(whilemousedown, 100 /*execute every 100ms*/);


}
function mouseup() {
	if (event.button == 2){speed = speed * -1} 
   if(mousedownID!=-1) {  //Only stop if exists
     clearInterval(mousedownID);
     mousedownID=-1;
   }

}
function whilemousedown() {
   window.scrollBy(0, speed);
}

// Arrow keys to change speed    
function keydown(e){
  e = e || window.event;
 if (e.keyCode == '38') {
        if (speed < 0) speed = speed - 10;
		else if (speed > 0) speed = speed + 10;
    }
    else if (e.keyCode == '40') {
      if (speed < 0) speed = speed + 10;
      else if (speed > 0) speed = speed - 10;
    }

}	
	

</script>

</body>
</html>
