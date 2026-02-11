<?php
ini_set('allow_url_include', '0');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
$file = $_GET['file'];
if(isset($file)){
        include($file);

}
else
{
        echo "Wellcome!";
}
?>
<!DOCTYPE html>
<html>
<h1> LFI2RCE via logpoision </h1>
</html>
