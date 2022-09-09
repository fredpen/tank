<?php
session_start();
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>
<html>
<head>
	<?php
	require("headerinfo.html");
	?>

	<script type="text/javascript">
	// <![CDATA[
	$(document).ready(function(){		
		//$('#error_label_login').html('<img src="images/loading.gif" alt="" /> Please login . . .');
		
	});
	// ]]>
	
	
	</script>


</head>
<body>

	<?php
	include("commonheader.html") ;
	?>




        <form class="form-signin" action="useraccount.php" method="post">
			<table ><tr><td align="center" >
				<p>Enter the Email associated with your Account to Reset New Password</p>
				<?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>		
				<div class="input-group">
					<input type="email" name="email" class="form-control"  placeholder="EMAIL" required="">
					</br>
					<input type="submit" name="forgotSubmit"  class="btn btn-lg btn-primary btn-block" value="CONTINUE">
				</div>
			</td></tr></table>
        </form>
