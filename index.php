<?php
session_start();
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';
if (!empty($sessData['status']['msg'])) {
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
		$(document).ready(function() {
			//$('#error_label_login').html('<img src="images/loading.gif" alt="" /> Please login . . .');

		});
		// ]]>
	</script>

	<style>
		body {
			/* background-image: linear-gradient(to right, rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url('images/business.jpg'); */
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: 100% 100%;
		}

		#indexdiv {
			/* background-image: url('images/bizmaap.png'); */
			background-repeat: no-repeat;
			background-size: auto auto;
			/* position: relative;
			margin-left: 31%;
			margin-right: 31%; */
		}

		#logindiv {
			width: 80%;
			margin: 0 auto;
		}

		#formid {
			width: 580px;
			position: relative;
			padding: 15px 0 0 0;
			background: red;
		}
	</style>

</head>

<body>

	<?php
	//include("commonheader.html") ;
	?>
	<!-- <div align="center">

		<table id="myradio">
			<tr>
				<td align="center">
					<h2><b>Please! Select a Channel</b></h2>
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="trantype" id="cashmodule" value="1" checked>Cash &nbsp; &nbsp;
					<input type="radio" name="trantype" id="creditmodule" value="2">Credit &nbsp; &nbsp;
					<input type="radio" name="trantype" id="ownusemodule" value="3">Own Use&nbsp; &nbsp;
					<input type="radio" name="trantype" id="ptnmodule" value="4">Product Transfer
				</td>
			</tr>
		</table>
	</div>
	<br /> -->

	<div id="indexdiv">
		<br />
		<form id="form1" name="form1" class="form-signin" method="POST" action="">
			<div style="display:flex; justify-content: center;margin:15px 0;">
				<img src="./images/logo copy.png" />
			</div>

			<?php echo !empty($statusMsg) ? '<p class="' . $statusMsgType . '">' . $statusMsg . '</p>' : ''; ?>
			<div id="logindiv">
				<p>Sign in to get started</p>
				<br /><br />

				<!-- error box -->
				<span id="error_label_login" style="color:red;font-weight: bold;display:flex; justify-content:center;padding: 20px 0;letter-spacing: 1.1px;"></span>

				<div>
					<p style="text-align: center;">Select a Channel</p>
					<div style="display:flex;align-items:flex-start;">
						<input type="radio" name="trantype" id="cashmodule" value="1" checked>&nbsp;<label for="cashmodule" style="font-weight:400;">Cash</label> &nbsp; &nbsp;
						<input type="radio" name="trantype" id="creditmodule" value="2">&nbsp;<label for="creditmodule" style="font-weight:400;">Credit</label> &nbsp; &nbsp;
						<input type="radio" name="trantype" id="ownusemodule" value="3">&nbsp;<label for="ownusemodule" style="font-weight:400;">Own Use</label>&nbsp; &nbsp;
						<input type="radio" name="trantype" id="ptnmodule" value="4">&nbsp;<label for="ptnmodule" style="font-weight:400;">Product Transfer</label>
					</div>
				</div>
				<br />
				<div class="">
					<label>Username</label>
					<input type="text" name="username" id="username" class="form-control" placeholder="John Dow" required>
				</div>
				<br />
				<div>
					<label>Password</label>
					<input type="password" name="password" id="inputPassword" class="form-control" placeholder="John password" required>
				</div>
				<br />

				<!--	<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>-->
				<button type="submit" class="signin_button" onclick="javascript: return checklogin('mainmenu.php');">
					Sign in
				</button>
			</div>
			<br />

			<p nowrap="nowrap" style="text-align: center;"><a href="forgotpassword.php">Forgot password?</a> </p>

		</form>

		<br /><br />
	</div>

</body>

</html>