<?php
clearBrowserCache();
function clearBrowserCache()
{
	header("Pragma: no-cache");
	header("Cache: no-cache");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
}

if (session_id() == "") {
	session_start();
}
require_once("session_track.php");
if (!isset($_SESSION['username_sess'])) {
	//	alert("user session not set");
	exit();
}

require_once("lib/mfbconnect.php");
require_once("lib/dbfunctions.php");
$dbobject = new dbfunction();


//get inactivity time in minutes
$inact_min = 5;
//convert by multiplying by 1000
$inact_val = $inact_min * 1000;


//if(($_SESSION['role_name_sess']!="Administrator")&&($_SESSION['role_name_sess']!="System Administrator"))
//{
//echo "Yes";
$time = @date("H:i:s");
$all = explode(':', $time);
$h = $all[0];
$m = $all[1];
$s = $all[2];
//}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> Tank-Farm</title>


	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>

	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<script type="text/ecmascript" src="jquery-ui-1.7.2/development-bundle/ui/ui.core.js"></script>
	<script type="text/ecmascript" src="jquery-ui-1.7.2/development-bundle/ui/ui.dialog.js"></script>
	<script type="text/ecmascript" src="jquery-ui-1.7.2/development-bundle/ui/ui.datepicker.js"></script>
	<script type="text/ecmascript" src="jquery-ui-1.7.2/development-bundle/ui/ui.draggable.js"></script>
	<script type="text/javascript" src="jquery-ui-1.7.2/development-bundle/ui/ui.resizable.js"></script>
	<script type="text/javascript" src="jquery-ui-1.7.2/development-bundle/ui/effects.core.js"></script>
	<script type="text/javascript" src="jquery-ui-1.7.2/development-bundle/ui/effects.highlight.js"></script>
	<script type="text/javascript" src="jquery-ui-1.7.2/development-bundle/external/bgiframe/jquery.bgiframe.js"></script>
	<script type="text/javascript" src="js/jquery.blockUI.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/sorttable.js"></script>
	<script type="text/javascript" src="js/jquery.table2csv.0.1.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.idle-timer.js"></script>
	<script type="text/javascript" src="js/timeout-dialog.js"></script>
	<script type="text/javascript" src="jquery-ui-1.7.2/development-bundle/ui/ui.accordion.js"></script>
	<script type="text/javascript" src="js/chat.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<link rel="shortcut icon" href="images/favicon.ico" />


	<script type="text/javascript">
		//function for timeout
		(function($) {
			// var timeout = <?php echo $inact_val; ?>;

			var timeout = 1200000;

			$(document).bind("idle.idleTimer", function() {

				//	$.timeoutDialog({ timeout: 1, countdown: 10, keep_alive_url: 'mainmenu.php', logout_redirect_url: 'logoff.php', restart_on_yes: true });
				var logusers = getpage('logoff.php', 'page');
			});
			$.idleTimer(timeout);
		})(jQuery);
	</script>
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
	<link type="text/css" href="jquery-ui-1.7.2/development-bundle/themes/base/ui.all.css" rel="stylesheet" />
	<link rel="stylesheet" media="screen" type="text/css" href="jquery-ui-1.7.2/css/ui-lightness/jquery-ui-1.7.2.custom.css" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<link rel="stylesheet" type="text/css" href="script/anylink.css" />
	<link type="text/css" href="jquery-ui-1.7.2/development-bundle/demos/demos.css" rel="stylesheet" />

</head>
<style>
	@media screen {
		td {
			padding: 5px;
		}

		.tableb {
			border-radius: 15px 50px;
			border-collapse: separate;
			border: 5px solid olive;
		}

		#print_table {
			display: none;
		}

		#data-form {
			background-color: #F2F7F9;
			width: 650px;
			padding: 10px;
			margin: 10px auto;
			border: 6px solid #8FB5C1;
			-moz-border-radius: 15px;
			-webkit-border-radius: 15px;
			border-radius: 15px;
			position: relative;
			display: block;
		}

	}

	@media print {

		#print,
		#head-inner,
		#smoothmenu1,
		.tableb,
		.noprint,
		.PrintButton {
			display: none;
		}

		#print_table {
			display: block;
		}

		#recpt {
			display: block;
			border-radius: 10px;
			border: 2px solid olive;
		}

	}
</style>