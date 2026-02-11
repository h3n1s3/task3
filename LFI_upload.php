<!DOCTYPE html>
<html>
<body>
    <h1>Upload Avatar & LFI Lab</h1>

    <div style="border: 1px solid black; padding: 10px;">
        <h3> Upload your Avatar </h3>
        <form action="" method="post" enctype="multipart/form-data">
            hehe: <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>

    <br>
<?php
if(isset($_POST["submit"]))
{
$dir = "uploads/";
$file = $dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$type = strtolower(pathinfo($file ,PATHINFO_EXTENSION));
        if($type == "php"){
                echo "only allow png/jpg";
                $uploadOk = 0;
        }
        if($uploadOk == 1){
                if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"] , $file)){
                        echo "Upload successfully " . $file;
                }
                else{ echo "error"; }
        }
}
if(isset($_GET['page'])){
        $page = $_GET['page'];
        include($page);
}
?>
</body>
</html>

