<?php 
	ob_start();
	include_once "session_track.php";
?>


<div align ="center" id="data-form" > 


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		
		<input type="button" name="closebutton" id="submit-button" title="Close"  value="Close" onclick="javascript:  $('#data-form').hide();">	
		<br />
		
		<h3><strong><font size='12'>Finance Portal</font></strong></h3>
		
	
		<table border ="1" width="95%" style="border-collapse: collapse;">
	
			<tr> 
				<td ><h3>SETUP</h3> 
				</td>
				<td >
					<input type="button" name="Searchcustno" title="Define Customers" id="submit-button" value="Customer" onclick="javascript:  getpage('customers.php','page');">				
				</td>
				<td >
					<input type="button" name="Searchcustno" title="Define Vendors/Suppliers" id="submit-button" value="Vendors" onclick="javascript:  getpage('vendors.php','page');">				
					
				</td>
				<td >
					<input type="button" title="Bank Definition" name="Searchcustno" id="submit-button" value="Banks" onclick="javascript:  getpage('bankdef.php','page');">				
				</td>
				
				
			</tr>
			<tr> 
				<td ><h3>TRANSACTION</h3> 
				</td>
				<td>
					<input type="button" name="Searchcustno" id="submit-button" title="Capture Payments by Customer" value="Cash Receipt" onclick="javascript: getpage('cshpayments.php','page');">				
					
				</td>
				<td>
					<input type="button" name="Searchcustno" title="Payments on General Expenditures" id="submit-button" value="Expenditure" onclick="javascript: getpage('generalexpenditure.php','page');">					
					
				</td>
				
				<td>
					<input type="button" name="Searchcustno" title="Capture any other Income other than Sales Related"  id="submit-button" value="Other Income" onclick="javascript: getpage('otherincome.php','page');">				
					
				</td>
				
				
			</tr>
			<tr> 
				<td  colspan="3"><h3>REPORTS</h3> </td>
				
				<td >
					<input type="button" name="Searchcustno" id="submit-button" value="Reports" onclick="javascript: getpage('reportlist.php?reportgrp=4','page');">				
					
				</td>
			</tr>

		</table>
		

		<br />
		<input type="button" name="Searchcustno" title="All Modules" id="submit-button" value="Back" onclick="javascript:  getpage('allmodules.php','page');">	
		<br />
	</form>
</div>

