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
<div align="center" id="data-form">

	<?php
	require_once("lib/mfbconnect.php");
	?>

	<?php require 'lib/aesencrypt.php';



	$user = $_SESSION['username_sess'];


	$refno = !isset($_REQUEST['refno']) ? '' : $dbobject->test_input($_REQUEST['refno']);
	$custno = !isset($_REQUEST['custno']) ? '' : $dbobject->test_input($_REQUEST['custno']);

	if ($custno == '') {

		$sql_receiptno = "select distinct a.refno,a.descriptn,a.amount,a.pmtdate,a.amtused,a.transdate,a.transby, b.custno,b.company , b.address1
				FROM payments a, arcust b WHERE trim(a.custno) = trim(b.custno) and trim(a.refno) = '$refno'   order by STR_TO_DATE(a.pmtdate, '%d/%m/%Y') desc ";
	} else {
		$sql_receiptno = "select distinct a.refno,a.descriptn,a.amount,a.pmtdate,a.amtused,a.transdate,a.transby, b.custno,b.company, b.address1 
				FROM payments a, arcust b WHERE trim(a.custno) = trim(b.custno) and trim(a.custno) = '$custno' and trim(a.refno) = '$refno'   order by STR_TO_DATE(a.pmtdate, '%d/%m/%Y') desc ";
	}

	//echo $sql_receiptno	."<br/>"	;

	$result_receiptno = mysqli_query($_SESSION['db_connect'], $sql_receiptno);
	$count_receiptno = mysqli_num_rows($result_receiptno);
	if ($count_receiptno > 0) {
		$row_receipt = mysqli_fetch_array($result_receiptno);
		$custno    = $row_receipt['custno'];
		$company   = $row_receipt['company'];

		$refno  = $row_receipt['refno'];
		$address  = $row_receipt['address1'];
		$amount = $row_receipt['amount'];
		$descriptn = $row_receipt['descriptn'];
		$pmtdate = $row_receipt['pmtdate'];
		$transby = $row_receipt['transby'];
		$transdate = $row_receipt['transdate'];
		$amountinwords = number_format($amount, 2)  . " (" . $dbobject->convert_number_to_words($amount) . ")";
	}

	?>

	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<form action="" method="get" id="form1">
		<h3 class="noprint"><strong>
				Print Receipt
			</strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false">Close Window</a>

		<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
		<input type="hidden" name="company" id="company" value="<?php echo $company; ?>" />
		<input type="hidden" name="bank_code" id="bank_code" value="<?php echo $bank_code; ?>" />
		<input type="hidden" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" />
		<input type="hidden" name="hidebankbox" id="hidebankbox" value="<?php echo $hidebankbox; ?>" />
		<input type="hidden" name="invoiceno" id="invoiceno" value="<?php echo $invoiceno; ?>" />
		<input type="hidden" name="address" id="address" value="<?php echo $address; ?>" />
		<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
		<input type="hidden" name="refno" id="refno" value="<?php echo $refno; ?>" />


		<?php if ($refno != '') { ?>
			<div id="print_table">
				<table id="recpt" width="60%">

					<tr>

						<td align='center' colspan="2">
							<h3><b><?php echo $_SESSION['corpaddr'] ?></b></h3>
							<b>Official Receipts</b><br>
							<?php echo $_SESSION['email']; ?><br />
							<?php echo $_SESSION['webaddress']; ?><br />
							<?php echo $_SESSION['telex']; ?><br />
							<hr>
						</td>
					</tr>
					<tr>
						<td> <b>Receipt No : </b></td>
						<td><?php echo $refno; ?></td>
					</tr>

					<tr>
						<td><b>Payment Date : </b></td>
						<td><?php echo $pmtdate; ?></td>
					</tr>
					<tr>
						<td>
							<b>Client :</b><br />
							<b>Address :</b><br />
							<b>The Sum of :</b><br />
							<b>Being for :</b><br />
							<b>Data Entry Officer :</b><br />
							<b>Data Entry Date :</b>
						</td>
						<td>
							<?php echo $custno . " - " .  $company; ?><br />
							<?php echo $address; ?><br />
							<?php echo $amountinwords; ?><br />
							<?php echo $descriptn; ?><br />
							<?php echo $transby; ?><br />
							<?php echo $transdate; ?><br />


						</td>
					</tr>

				</table>
			</div>
		<?php
		} ?>
	</form>
</div>


<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.addEventListener("DOMContentLoaded", function() {
		PrintPage();
	});
</script>