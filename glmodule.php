<?php
ob_start();
include_once "session_track.php";
?>


<div align="center" id="data-form">


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">
		<br />


		<h3><strong>General Ledger Portal</strong></h3>


		<div style="overflow-x:auto;">
			<table border="1" width="95%" style="border-collapse: collapse;">

				<tr>
					<td>
						<h3>SETUP</h3>
					</td>
					<td>
						<input type="button" name="Searchcustno" id="submit-button" title="Define Chart Of Account" value="Chart Of Account" onclick="javascript:  getpage('chartofaccount.php','page');">
					</td>
					<td>
						<input type="button" name="Searchcustno" id="submit-button" title="Map Chat of Account to Modules" value="Account Mapping" onclick="javascript: getpage('chartofaccountmap.php','page');">
					</td>
					<td>
						<input type="button" name="Searchcustno" id="submit-button" title="Define Financial Calander" value="Calendar" onclick="javascript:  getpage('fincalendar.php','page');">
					</td>
					<td>
						<input type="button" name="Searchcustno" id="submit-button" title="Set Accounting Periods" value="Accounting Periods" onclick="javascript:  getpage('finperiod.php','page');">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<h3>TRANSACTION</h3>
					</td>
					<td>
						<input type="button" name="Searchcustno" id="submit-button" title="Journal Adjustment" value="Journal Entry" onclick="javascript:  getpage('journaladjustment.php','page');">
					</td>
					<td>
						<input type="button" name="Searchcustno" id="submit-button" title="Upload Journal Adjustment" value="Upload Journal Entry" onclick="javascript:  getpage('journaladjustmentwithupload.php','page');">
					</td>

					<td>
						<input type="button" name="Searchcustno" id="submit-button" title="Post to General Ledger" value="GL Posting" onclick="javascript:  getpage('glposting.php','page');">

					</td>
				</tr>

				<tr>
					<td colspan="4">
						<h3>REPORTS</h3>
					</td>
					<td>
						<input type="button" name="Searchcustno" id="submit-button" value="Reports" onclick="javascript: getpage('reportlist.php?reportgrp=6','page');">

					</td>
				</tr>

			</table>
		</div>
		<br />
		<input type="button" name="Searchcustno" title="All Modules" id="submit-button" value="Back" onclick="javascript:  getpage('allmodules.php','page');">
		<br />
	</form>
</div>