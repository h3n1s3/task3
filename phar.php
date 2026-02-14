<?php
class Logger {
    public $logFile;
    public $initMessage;

    function __destruct() {
        system($this->initMessage); 
    }
}
$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true); // Tự tạo thư mục nếu chưa có

$msg = "";
if (isset($_POST['upload'])) {
    $target_file = $upload_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Chỉ cho phép upload ảnh
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "phar") {
        $msg = "❌ Chỉ chấp nhận file ảnh (JPG, JPEG, PNG)!";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $msg = "✅ Upload thành công: <b>" . realpath($target_file) . "</b>";
        } else {
            $msg = "❌ Lỗi upload.";
        }
    }
}

//checking
$check_result = "";
if (isset($_POST['check_file'])) {
    $file_path = $_POST['file_path'];
    try {
        $phar = new Phar($file_path);
        $meta = $phar->getMetadata();
        $check_result = "Metadata loaded";
    } catch (Exception $e) {
        $check_result = "Error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Phar Deserialization Lab</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        .box { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type=text] { width: 80%; padding: 5px; }
        code { background: #eee; padding: 2px 5px; color: #d63384; }
    </style>
</head>
<body>

    <h1>💣 Phar Deserialization Demo</h1>

    <div class="box">
        <h3>Bước 1: Upload Ảnh</h3>
        <p><?php echo $msg; ?></p>
        <form method="post" enctype="multipart/form-data">
            Chọn file ảnh:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="upload">
        </form>
    </div>
    <div class="box">
        <h3>Bước 2: Kiểm tra File (Trigger RCE)</h3>
        <form method="post">
            Nhập đường dẫn file (Có thể dùng <code>phar://</code>):<br>
            <input type="text" name="file_path" placeholder="/var/www/html/uploads/evil.jpg">
            <input type="submit" value="Kiểm tra" name="check_file">
        </form>
        <p><b>Kết quả:</b> <?php echo $check_result; ?></p>
    </div>

</body>
</html>