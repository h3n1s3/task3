<?php
// 1. Giả lập hành vi của OS
$fake_env_file = "/var/www/html/proc/self/environ";
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Ghi đè User-Agent vào file fake
file_put_contents($fake_env_file, "DOCUMENT_ROOT=/var/www/html HTTP_USER_AGENT=" . $user_agent . " REMOTE_ADDR=127.0.0.1");
if (isset($_GET['page'])) {
    echo "<h3>LFI Environ</h3>";
    include($_GET['page']);
} else {
    echo "Try something";
}
?>


