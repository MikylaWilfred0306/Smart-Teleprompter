<?php 

$pageTitle = "Files";
$verification = 1;
 include ('header.php'); 
 include ('login_header.php'); 
 
 ?>

<input type="text" class="searchFiles" id="searcher" onkeyup="search()" placeholder="Search for File" title="Type in a name">

<ul id="searchlist" class = "fileList">
  <li><a href="textwriter.php?file=Scripts/test_script.txt">Test</a></li>
  <li><a href="#">Agnes</a></li>

  <li><a href="#">Billy</a></li>
  <li><a href="#">Bob</a></li>

  <li><a href="#">Calvin</a></li>
  <li><a href="#">Christina</a></li>
  <li><a href="#">Cindy</a></li>
</ul>


  <?php include ('footer.php'); ?>