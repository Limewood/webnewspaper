<?php
include("../config.php");
$target_path = $uploaddir . basename($_FILES['submit_image_upload']['name']);
 
move_uploaded_file($_FILES['submit_image_upload']['tmp_name'], $target_path);
 
echo "<script language=\"javascript\" type=\"text/javascript\">".
	"window.top.window.uploadedImage('".basename($target_path)."');".
	"</script>";
?>