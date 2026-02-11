<!DOCTYPE html>
<html>
<head><title>LFI Debugger</title></head>
<body>

<h1>PHP FILTER LAB</h1>
<hr>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (isset($_GET['page'])) {
    $file = $_GET['page'];
        include($file);
} else {
    echo "<font color='red'>NEED A PARAM</font>";
}
?>

</body>
</html>



