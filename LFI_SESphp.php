<?php
session_start();
if(isset($_POST['username']))
{
        $_SESSION['username']=$_POST['username'];
        $message = "Đã lưu tên của bạn: " . htmlspecialchars($_SESSION['username']);
}
if(isset($_GET['file']))
{
        $file = $_GET['file'];
        include($file);
        exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Demo PHP Session Poisoning</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .box { border: 1px solid #ccc; padding: 20px; margin-top: 10px; border-radius: 5px; }
        .highlight { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Trang Hồ Sơ Cá Nhân (Profile)</h1>

    <?php if (isset($message)) echo "<p class='highlight'>$message</p>"; ?>

    <div class="box">
        <form method="POST" action="">
            <label>Nhập tên của bạn:</label><br>
            <input type="text" name="username" style="width: 300px;" placeholder="Input your name">
            <input type="submit" value="SAVE">
        </form>
    </div>

</body>
</html>

