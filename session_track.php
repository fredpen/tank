<?php
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	if(session_id() == "")
	{
	@session_start();
	}
	$user= isset($_SESSION['username_sess'])?$_SESSION['username_sess']:"";
	if($user=="")header("Location:http://localhost:8012/bizmaap/");
?>
