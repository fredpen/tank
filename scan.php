<style>

 #data-form  {
    background-color:#F2F7F9;
	width:650px;
    padding:10px;
    margin: 10px auto;    
    border: 6px solid #8FB5C1;
    -moz-border-radius:15px;
    -webkit-border-radius:15px;
    border-radius:15px;
    position:relative;
}
</style>
<div align ="center" id="data-form" style=""> 
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{	
		include "printheader.php";
	?>

	<a href="#" class="noprint" onclick="window.close();return false"><h3><font size='12'>Close Window</font></h3></a>
	
	<?php

	
	$refno = $_POST["lpo_no"];
	//echo $refno;
	$allowed_image_extension = array(
				"png",
				"jpg",
				"bmp",
				"jpeg"
			);
			
	
	// Get image file extension
	$thefileextention = '';
	$file_extension = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));
	if (! in_array($file_extension, $allowed_image_extension)) 
	{
		if ($_FILES['fileToUpload']["type"] !="application/pdf") {
			
			echo 'Selected file is not valid. Only PNG, BMP, JPEG and PDF are allowed';
		}else {$thefileextention = 'pdf';}
	  
	}else {$thefileextention = 'jpg';}
	
	//$target_dir = $_SERVER['DOCUMENT_ROOT']."/tmpfolder/";
	$target_dir = $_SESSION['tmp_target_dir'];
	$target_file = $target_dir . md5($refno).".pdf";
	$target_picture_file = $target_dir . md5($refno).".jpg";
	
	
	if (file_exists($target_file)) 
	{
		//delete it
		unlink($target_file);
	}
	if (file_exists($target_picture_file)) 
	{
		//delete it
		unlink($target_picture_file);
	}
			

	
	if ($thefileextention == 'pdf'){
		
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){ echo "<h3><font size='8'>Document Verified<font></h3>";}
	}elseif ($thefileextention == 'jpg'){
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_picture_file)){ echo "<h3><font size='8'>Document Verified<font></h3>";}
	}
	
		
	
}
else { header("location:index.php"); }
?></div>	