<?php
ob_start();
include_once "session_track.php";
require_once("lib/mfbconnect.php");
if (session_id() == "") {
	session_start();
}


include "basicparameters.php";

$thestartdate = !isset($_REQUEST['thestartdate']) ? 0 : $dbobject->test_input($_REQUEST['thestartdate']);
$location = !isset($_REQUEST['location']) ? 0 : $dbobject->test_input($_REQUEST['location']);
$product = !isset($_REQUEST['product']) ? 0 : $dbobject->test_input($_REQUEST['product']);
$purchaseorder = !isset($_REQUEST['purchaseorder']) ? 0 : $dbobject->test_input($_REQUEST['purchaseorder']);
$vendor = !isset($_REQUEST['vendor']) ? 0 : $dbobject->test_input($_REQUEST['vendor']);
$customer = !isset($_REQUEST['customer']) ? 0 : $dbobject->test_input($_REQUEST['customer']);
$salesperson = !isset($_REQUEST['salesperson']) ? 0 : $dbobject->test_input($_REQUEST['salesperson']);
$calledby = !isset($_REQUEST['calledby']) ? '' : $dbobject->test_input($_REQUEST['calledby']);

$query = "select * from reptable where 1=1 order by reportdesc";
$result = mysqli_query($_SESSION['db_connect'], $query);
$numrows = mysqli_num_rows($result);
$reportgrp = !isset($_SESSION['reportgrp']) ? "" : $_SESSION['reportgrp'];
?>
<script type="text/javascript" src="js/dynamic_search.js"></script>
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" type="text/css" href="css/style.css">

<input type="hidden" name="calledby" id="calledby" value="<?php echo $calledby; ?>" />

<!--<link rel="stylesheet" type="text/css" href="datatables/datatables.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
-->
<script type="text/javascript" src="js/tablehighlight.js"></script>
<div align="center" id="data-form">

	<form name="form1" id="form1">
		<h3><strong>Report Portal</strong></h3>

		<table>
			<tr>
				<td colspan="4">
					<div id="display"></div>
				</td>
			</tr>

			<tr>
				<td colspan="4" align="center"><b>Search for Applicable Parameters</b></td>
			</tr>
			<tr>
				<td align="right" nowrap="nowrap">Start Date:</td>
				<td align="left">
					<input type="date" name="startdate" id="startdate" value="<?php echo $startdate; ?>" class="required-text" <?php echo ($thestartdate == 0) ? "readonly" : ""; ?>>

				</td>

				<td align="right" nowrap="nowrap">End Date: </td>
				<td><input type="date" name="enddate" id="enddate" value="<?php echo $enddate; ?>" class="required-text" <?php echo ($thestartdate == 0) ? "readonly" : ""; ?>></td>

			</tr>
			<tr>
				<td align="right">Customer ID:</td>
				<td align="left" colspan="1">
					<input type="text" name="custno" onKeyup="javascript: suggestentry(this.id,'customer'); blurrall();" id="custno" value="<?php echo $custno; ?>" <?php echo ($customer == 0) ? "readonly" : ""; ?>>
					<div id="custnodisplay"></div>
				</td>
				<td align="right">Product ID:</td>
				<td align="left" colspan="1">
					<input type="text" name="item" onKeyup="javascript: suggestentry(this.id,'item'); blurrall();" id="item" value="<?php echo $item; ?>" <?php echo ($product == 0) ? "readonly" : ""; ?>>
					<div id="itemdisplay"></div>
				</td>

			</tr>
			<tr>
				<td align="right">Sales Person:</td>
				<td align="left" colspan="1">
					<input type="text" name="salespsn" onKeyup="javascript: suggestentry(this.id,'salespsn'); blurrall();" id="salespsn" value="<?php echo $salespsn; ?>" <?php echo ($salespsn == 0) ? "readonly" : ""; ?>>
					<div id="salespsndisplay"></div>
				</td>
				<td align="right">Vendor ID:</td>
				<td align="left" colspan="1">
					<input type="text" name="vendorno" onKeyup="javascript: suggestentry(this.id,'vendor');blurrall(); " id="vendorno" value="<?php echo $vendorno; ?>" <?php echo ($vendor == 0) ? "readonly" : ""; ?>>
					<div id="vendornodisplay"></div>
				</td>

			</tr>
			<tr>
				<td align="right" nowrap="nowrap">Location:</td>
				<td align="left">
					<input type="text" name="loccd" onKeyup="javascript: suggestentry(this.id,'location'); blurrall();" id="loccd" value="<?php echo $loccd; ?>" <?php echo ($location == 0) ? "readonly" : ""; ?>>
					<div id="loccddisplay"></div>
				</td>

				<td align="right" nowrap="nowrap">Purchase Order No: </td>
				<td><input type="text" name="purchaseorderno" onKeyup="javascript: suggestentry(this.id,'purchaseorderno'); blurrall();" id="purchaseorderno" value="<?php echo $purchaseorderno; ?>" class="required-text" <?php echo ($purchaseorder == 0) ? "readonly" : ""; ?>>
					<div id="purchaseordernodisplay"></div>
				</td>

			</tr>
			<tr>
				<td align="right">Period Year:</td>
				<td align="left">
					<input type="text" name="periodyear" id="periodyear" value="<?php echo $periodyear; ?>">
				</td>

				<td align="right">Period Month:</td>
				<td align="left">
					<input type="text" name="periodmonth" id="periodmonth" value="<?php echo $periodmonth; ?>">
				</td>

			</tr>
			<tr>
				<td colspan="4"> <br /> </td>
			</tr>
			<tr>
				<td align="right" colspan="2"><b><?php echo $reportdesc; ?> </b></td>
				<td>
					<input type="submit" name="PrintReceipt" class="PrintButton" id="submit-button" formtarget="_blank" value="Get Report" formaction="<?php echo $_SESSION['applicationbase'] . $reportname . '.php' ?>" />
				</td>
				<td>
					<input type='hidden' name='reportgrp' id='reportgrp' value="<?php echo $reportgrp; ?>">
					<?php if ($calledby == '') { ?>
						<input type="button" name="getreport" id="submit-button" value="Back" onclick="javascript: 
								var reportgrp = $('#reportgrp').val();
							getpage('reportlist.php?reportgrp='+reportgrp,'page');">
					<?php } else { ?>
						<input type="button" name="getreport" id="submit-button" value="Back" onclick="javascript: 
								var calledby = $('#calledby').val();
							getpage(calledby+'.php','page');">
					<?php } ?>
				</td>
			</tr>
		</table>

	</form>
</div>
<script>
	function blurrall() {
		$('#purchaseordernodisplay').hide();
		$('#loccddisplay').hide();
		$('#vendornodisplay').hide();
		$('#salespsndisplay').hide();
		$('#itemdisplay').hide();
		$('#custnodisplay').hide();
	}
</script>