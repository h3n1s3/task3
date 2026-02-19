<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$file = $_GET['file'];
if(stripos(file_get_contents($file) , '<?') !== false){
        die("attack detected");
}
include($file);
?>







