<?php 
$myfile = fopen("newfile.txt1", "a") or die("Unable to open file!");
$txt = date("Y-m-d H:i:s");

fwrite($myfile, $txt);
fclose($myfile);