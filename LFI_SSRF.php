<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Website Status Checker (SSRF Lab)</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; }
        .container { border: 1px solid #ccc; padding: 20px; border-radius: 8px; background: #f9f9f9; }
        input[type="text"] { width: 70%; padding: 10px; font-size: 16px; }
        input[type="submit"] { padding: 10px 20px; font-size: 16px; background: #007bff; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background: #0056b3; }
        .output { background: #333; color: #0f0; padding: 15px; margin-top: 20px; white-space: pre-wrap; border-radius: 5px; overflow-x: auto;}
        h2 { color: #333; }
    </style>
</head>
<body>

<div class="container">
    <h2>🛠️ Công cụ kiểm tra Website (SSRF Lab)</h2>
    <p>Url input</p>
    
    <form method="GET" action="">
        <input type="text" name="url" placeholder="ex:https://google.com" required>
        <input type="submit" value="CHECK">
    </form>

    <?php
    if (isset($_GET['url'])) {
        $url = $_GET['url'];
        echo "<hr><h3>result: " . htmlspecialchars($url) . "</h3>";

        //tạo curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //ko in ra màn hình
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //cho phép các giao thức
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_ALL); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //tránh treo
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        //same với include
        $output = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        echo "<div class='output'>";
        if ($error) {
            echo "Lỗi cURL: " . $error;
        } else {
            // Dùng htmlspecialchars để tránh XSS khi hiển thị source code trang khác
            echo htmlspecialchars($output);
        }
        echo "</div>";
    }
    ?>
</div>
</body>
</html>