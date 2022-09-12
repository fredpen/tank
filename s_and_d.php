<?php
ob_start();
include_once "session_track.php";
?>


<div align="center" id="data-form">


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<input type="button" name="closebutton" id="submit-button" title="Close" value="X" onclick="javascript:  $('#data-form').hide();">
<!--		<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">-->
		<br />
		<h3><strong>Sales and Distribution Portal</strong></h3>



		<table border="1" width="95%" style="border-collapse: collapse;">

			<tr>
				<th colspan="4">
					<b>SETUP</b>
				</th>
			</tr>

			<tr>
				<td>
					<input type="button" name="customer" id="submit-button" title="Define Customers" value="Customers" onclick="javascript:  getpage('customers.php','page');">
				</td>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" title="Define Sales Person" value="Sales Person" onclick="javascript: getpage('salesperson.php','page');">
				</td>

				<td>
					<input title="Slab Discount Definition" type="button" name="Searchcustno" id="submit-button" value="Slab Discount" onclick="javascript: getpage('slabdef.php','page');">
				</td>
			</tr>
			<tr>
				<td>
					<input title="Customer Category Pricing Plan" type="button" name="Searchcustno" id="submit-button" value="Pricing Policy" onclick="javascript:  getpage('group_price_policy.php','page');">
				</td>
				<td>
					<input type="button" name="customer" id="submit-button" title="Define Transporters" value="Transporters" onclick="javascript:  getpage('transporters.php','page');">

				</td>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" title="Define Bulk Road Vehicles" value="Trucks" onclick="javascript: getpage('brvdef.php','page');">
				</td>
			</tr>


			<tr>
				<th colspan="4">
					<b>TRANSACTIONS</b>
				</th>
			</tr>
			<tr>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" title="Raise Customer Request/Order" value="Requisition" onclick="javascript: getpage('makerequisition.php','page');">
				</td>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" title="Approve Customer Request" value="Req. Approval" onclick="javascript: getpage('fastapproval.php','page');">

				</td>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" value="LoadingSlip" title="Generate Loading Slip" onclick="javascript: getpage('generateloadingslip.php','page');">

				</td>
			</tr>
			<tr>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" title="Reverse unconverted Loading Slip" value="Rev LoadingSlip" onclick="javascript: getpage('reverseloadingslip.php','page');">

				</td>

				<td>
					<input type="button" name="Searchcustno" id="submit-button" value="Void Req Bal" title="Void Requisition Balance" onclick="javascript: getpage('voidreqbalance.php','page');">

				</td>
				<td>
					<input type="button" name="Searchcustno" title="Generate Waybill" id="submit-button" value="WayBill" onclick="javascript: getpage('brvloading.php','page');">

				</td>
				<td>
					<input type="button" name="Searchcustno" title="Confirm Delivery" id="submit-button" value="Confirm Delvery" onclick="javascript: getpage('confirmdelivery.php','page');">

				</td>

			</tr>


			<tr>
				<th colspan="4">
					<b>REPORTS</b>
				</th>
			</tr>
			<tr>
				<td>
					<input type="button" name="Searchcustno" title="Print Loading Slip" id="submit-button" value="Print Slip" onclick="javascript: getpage('printloadingslip.php','page');">
				</td>
				<td>
					<input type="button" name="Searchcustno" title="Print WayBill" id="submit-button" value="Print Waybill" onclick="javascript: getpage('printwaybill.php','page');">
				</td>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" title="Print Invoices or Receipts" value="Print" onclick="javascript: getpage('print_inv_rcpt.php','page');">
				</td>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" value="Reports" onclick="javascript: getpage('reportlist.php?reportgrp=3','page');">

				</td>
			</tr>

		</table>
		<br />
		<input type="button" name="Searchcustno" title="All Modules" id="submit-button" value="Back" onclick="javascript:  getpage('allmodules.php','page');">
		<br />
	</form>
</div>