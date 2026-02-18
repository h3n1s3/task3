<?php
if (ob_get_level()) ob_end_clean();

ob_implicit_flush(1);

phpinfo();

flush();

if(isset($_GET["file"])) {
    include($_GET["file"]);
}
?>
