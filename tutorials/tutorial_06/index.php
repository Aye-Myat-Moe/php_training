<?php
$folder_name=$_POST['createfolder'];
{
    @mkdir($output_dir . $folder_name, 0777);
    $img_name=$_FILES['img_upload']['name'];
    $tmp_img_name=$_FILES['img_upload']['tmp_name'];
    $folder='';
    move_uploaded_file($tmp_img_name,$img_name);
    echo "Folder Created";
}
?>