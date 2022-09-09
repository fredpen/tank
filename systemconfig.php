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
		
		<h3><strong><font size='12'>System Configuration Portal</font></strong></h3>
		
		<table border ="1" style="border-collapse: collapse;">
			<tr> 
				<td colspan="5" align="center">
					<b>Inventory Related</b>
				</td>
			</tr>
			<tr>
				<td colspan="5" align="center"><table><td>
					
					<td colspan="2">
						<input type="button" name="Searchcustno" id="submit-button" title="Define Inventory Locations"  value="Locations" onclick="javascript: getpage('locationmaster.php','page');">				
						
					</td>
					<td >
						<input type="button" name="item_master" id="submit-button"  title="Define Inventory Items"  value="Items Master" onclick="javascript: getpage('item_master.php','page');">				
						
					</td>
					<td >
						<input title="Define Items at Sub Location" type="button" name="Searchcustno" title="Define Inventory Sub Locations"  id="submit-button" value="Sub Locations" onclick="javascript: getpage('itematsublocation.php','page');">				
						
					</td>	
					<td >
						<input type="button" name="item_master" id="submit-button"  title="Gantry Meters"  value="Meters" onclick="javascript: getpage('gantrymeters.php','page');">				
						
					</td>
				</td></table></td>
			</tr>
			<tr> 
				<td colspan="5" align="center">
					<br /><b>Finance Related</b>
				</td>
			</tr>
			<tr>
				<td colspan="5" align="center"><table><td>
					<td colspan="3" >
						<input type="button" name="Searchcustno" id="submit-button" title="Define Vendors" value="Vendors" onclick="javascript:  getpage('vendors.php','page');">				
						
					</td>
					<td >
						<input type="button" name="Searchcustno" title="Define Customers" id="submit-button" value="Customer" onclick="javascript:  getpage('customers.php','page');">				
					</td>
					
					<td >
						<input type="button" title="Bank Definition" name="Searchcustno" id="submit-button" value="Banks" onclick="javascript:  getpage('bankdef.php','page');">				
					</td>
				</td></table></td>
			</tr>
			
			
			<tr>
				<td colspan="5" align="center">
					<br /><b>Sales and Distribution Related</b>
				</td>
			</tr>
			
			<tr> 
				<td colspan="5" align="center"><table><td>
					<td >
						<input type="button" name="customer" id="submit-button" title="Define Customers" value="Customers" onclick="javascript:  getpage('customers.php','page');">				
					</td>
					<td >
						<input type="button" name="Searchcustno" id="submit-button" title="Define Sales Person" value="Sales Person" onclick="javascript: getpage('salesperson.php','page');">				
					</td>
					
					<td >
						<input title="Slab Discount Definition" type="button" name="Searchcustno" id="submit-button" value="Slab Discount" onclick="javascript: getpage('slabdef.php','page');">				
					</td>
					<td>
						<input title="Transporters Definition" type="button" name="Searchcustno" id="submit-button" value="Transporter" onclick="javascript:getpage('transporters.php','page');">				
						
					</td>
					<td>
						<input  title="Trucks Definition" type="button" name="Searchcustno" id="submit-button" value="Trucks" onclick="javascript: getpage('brvdef.php','page');">					
						
					</td>
				</td></table></td>
			</tr>
			<tr> 
				<td colspan="5" align="center">
					<br /><b>General Ledger Related</b>
				</td>
			</tr>
			<tr>
				<td colspan="5" align="center"><table><td>
					<td colspan="2" >
						<input type="button" name="Searchcustno" id="submit-button" title="Define Chart Of Account"  value="Chart Of Account" onclick="javascript:  getpage('chartofaccount.php','page');">				
					</td>
					<td >
						<input type="button" name="Searchcustno" id="submit-button" title="Map Chat of Account to Modules"  value="Account Mapping" onclick="javascript: getpage('chartofaccountmap.php','page');">				
					</td>
					<td >
						<input type="button" name="Searchcustno" id="submit-button" title="Define Financial Calander"  value="Calendar" onclick="javascript:  getpage('fincalendar.php','page');">				
					</td>
					<td>
						<input type="button" name="Searchcustno" id="submit-button" title="Set Accounting Periods"  value="Accounting Periods" onclick="javascript:  getpage('finperiod.php','page');">					
					</td>
				</td></table></td>
			</tr>	
			
			

		</table>

		<br />
		<input type="button" name="Searchcustno" title="All Modules" id="submit-button" value="Back" onclick="javascript:  getpage('allmodules.php','page');">	
		<br />
	</form>
</div>

