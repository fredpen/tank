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

	<style>
	body {
	  background-image: linear-gradient(to right,rgba(0,0,0,.5),rgba(0,0,0,.5)),url('images/business.jpg');
	  background-repeat: no-repeat;
	  background-attachment: fixed; 
	  background-size: 100% 100%;
	}
	
	#indexdiv {
	  background-image: url('images/bizmaap.png');
	  background-repeat: no-repeat;
	  background-size: auto auto;
	  position: relative;
	  margin-left: 31%; 
		margin-right: 31%;
	}
	
	#logindiv {
	  position: relative;
	  margin-left: 15%; 
		margin-right: 15%;
	}	
	#formid {
	  width: 580px;
	  position: relative;
	  padding: 15px 0 0 0;
	  background: #9ACD32;
	}
	</style>

</head>
<body>

	<?php
	//include("commonheader.html") ;
	?>
	<div align="center">
			
			<table id="myradio" > 
				<tr >
					<td   align="center">
						<h2><b>Please! Select a Channel</b></h2>
					</td>
				</tr>
							<tr >
					<td  >
						<input type = "radio" name = "trantype" id = "cashmodule" value = "1" checked>Cash &nbsp; &nbsp; 
						<input type = "radio" name = "trantype" id = "creditmodule" value = "2">Credit &nbsp; &nbsp;
						<input type = "radio" name = "trantype" id = "ownusemodule" value = "3">Own Use&nbsp; &nbsp; 
						<input type = "radio" name = "trantype" id = "ptnmodule" value = "4">Product Transfer
					</td>
				</tr>
			</table>
	</div>
	<br/>
	
	<div id="indexdiv" align="center" >

	<form id="form1" name="form1" class="form-signin" method="POST" action ="" >
		<br/><br/><br/><br/><br/><br/>
		<!--	<h2 class="form-signin-heading">Please Login</h2>-->
			
			<?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
			
			
			<div id="logindiv">
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">@</span>
					<input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
				</div>
				<br/>
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
				
			<!--	<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>-->
				<input  name="Button" type="image" value="Button" src="images/button.jpg" onclick="javascript: return checklogin('mainmenu.php');"/>
			</div>
			<br/><br/><br/><br/>
			
			<table>
				<tr>
					<td nowrap="nowrap" ><a href="forgotpassword.php">Forgot password?</a> </td>
					<td nowrap="nowrap" ><a href="https://iyallasoft.com.ng"> &nbsp;&nbsp;&nbsp;Powered by IyallaSoft</a> </td>
				</tr>
				
			</table>
			<span id="error_label_login" style="color:red;font-weight: bold;"></span>
			
	 </form>
 
		<br/><br/><br/><br/><br/>
  </div>

</body>
</html>