<?php
     ob_start();
	 
	 clearBrowserCache();
	function clearBrowserCache() {
		header("Pragma: no-cache");
		header("Cache: no-cache");
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	 
	 
	if(session_id()=="")
	{
	@session_start();
	
	include("lib/dbfunctions.php");
     $dbobject = new dbfunction();
	 $operation="0UT";
	 $audit = $dbobject->doAuditTrail($operation);
	 //echo $audit;
	
	}
	session_destroy();
	//header("Location:index.php");
	include("lib/applicationbase.php");
	echo "<script> window.location='$applicationbase'; </script>";
?>