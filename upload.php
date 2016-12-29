<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/7
 * Time: 14:46
 */
echo <<<_END
<html><head><title>PHP Form Upload</title></head><body>
<form method='post' action='upload.php' enctype='multipart/form-data'>
Select File:<input type='file' name='filename' size='10'>
<input type='submit' value='Upload'>
</form>
_END;

if ($_FILES)
{
    print_r($_FILES);
    $name = $_FILES['filename']['name'];
    $name=iconv("UTF-8","gbk", $name);

    switch ($_FILES['filename']['type'])
    {
        case 'image/jpeg':$ext = 'jpg'; break;
        case 'image/gif':$ext = 'gif';break;
        case 'image/png':$ext = 'png';break;
        case 'image/tiff':$ext = 'tiff';break;
        default:$ext = '';break;
    }
    if ($ext)
    {
        $true_name = substr($name,0,strrpos($name,'.'));
        $n = "image-$true_name.$ext";
        move_uploaded_file($_FILES['filename']['tmp_name'],$n);
        $name = iconv("gbk","utf-8",$name);
        $n = iconv("gbk","utf-8",$n);
        echo "Uploaded image '$name' as '$n':<br>'";
        echo "<img src='$n'>";
    }
    else echo "'$name' is not an accepted image file";

}
else echo "No image has been uploaded";
echo "</body></html>";
?>
