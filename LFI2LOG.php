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
/*
setup trên linux
- tạo index: sudo nano /var/www/html/index.php
- start    : sudo systemctl start apache2 
-set quyền : sudo chmod 775 /var/log/apache2
             sudo chmod 644 /var/log/apache2/access.log

*/