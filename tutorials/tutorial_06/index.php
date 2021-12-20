<?php
$foldername = $_POST["foldername"];
$location = $foldername . "/";
$fileName = $_FILES["file"]["name"];
$tmp = $_FILES["file"]["tmp_name"];
$type = $_FILES["file"]["type"];
if (isset($fileName)) { 
    $structure = "./" . $foldername;
    if (!mkdir($structure)) {
        echo "Folder Already Existed.<br>";
    }
    if (!empty($fileName)) {
        if ($type = "jpg" || $type = "jpeg" || $type = "png") {
            if (move_uploaded_file($tmp, $location . $fileName)) {
                echo "File Uploaded to " . $foldername;
            } else {
                echo "Not Uploaded  " . $foldername;
            }
        }
    }
}
?>