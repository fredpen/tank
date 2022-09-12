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
		<h3><strong>Product Inventory Portal</strong></h3>

		<table border="1" width="95%" style="border-collapse: collapse;">

			<tr>
				<td>
					<h3>SETUP</b> </h3>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" title="Define Inventory Locations" value="Locations" onclick="javascript: getpage('locationmaster.php','page');">

				</td>
				<td>
					<input title="Define Items at Sub Location" type="button" name="Searchcustno" title="Define Inventory Sub Locations" id="submit-button" value="Sub Locations" onclick="javascript: getpage('itematsublocation.php','page');">

				</td>
				<td>
					<input type="button" name="item_master" id="submit-button" title="Define Inventory Items" value="Items Master" onclick="javascript: getpage('item_master.php','page');">

				</td>
			</tr>

			<tr>
				<td>
					<h3>TRANSACTION</h3>
				</td>

				<td colspan="2">
					<input type="button" class="btn1" name="Searchcustno" id="submit-button" title="Miscellenous Product Receipt" value="Receive Product" onclick="javascript: getpage('inventory_receipt.php','page');">
				</td>
				<td><input type="button" class="btn1" name="Searchcustno" id="submit-button" title="Miscellenous Product Issue" value="Issue Product" onclick="javascript: getpage('inventory_issues.php','page');">
				</td>

			</tr>

			<tr>
				<td colspan="3">
					<h3>REPORTS</h3>
				</td>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" value="Reports" onclick="javascript: getpage('reportlist.php?reportgrp=2','page');">

				</td>
			</tr>
		</table>
		<br />
		<input type="button" name="Searchcustno" title="All Modules" id="submit-button" value="Back" onclick="javascript:  getpage('allmodules.php','page');">
		<br />
	</form>
</div>