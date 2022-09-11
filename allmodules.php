<?php
ob_start();
include_once "session_track.php";
?>


<div align="center" id="data-form">



	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">


		<div style="overflow-x:auto;" align="center">
			<tr>
				<td colspan="3" align="center">
					<h3><strong>Select a Module to get started</strong></h3>
				</td>
			</tr>

			<div class="modules">
				<td>
					<input class="d-block" type="button" title="Sales and Distribution" name="Searchcustno" id="submit-button" value="Sales" onclick="javascript:  getpage('s_and_d.php','page');">
				</td>
				<td>
					<input class="d-block" type="button" title="System Setup and Masters Configuration" name="Searchcustno" id="submit-button" value="Setup" onclick="javascript:  getpage('systemconfig.php','page');">
				</td>
				<td>
					<input class="d-block" type="button" name="Searchcustno" id="submit-button" title="Finance" value="Finance" onclick="javascript: getpage('finance.php','page');">
				</td>
				<td>
					<input class="d-block" type="button" title="Inventory" name="Searchcustno" id="submit-button" value="Inventory" onclick="javascript:  getpage('inventory.php','page');">
				</td>

				
				<td>
					<input class="d-block" type="button" name="Searchcustno" title="General Ledger" id="submit-button" value="Gen. Ledger" onclick="javascript: getpage('glmodule.php','page');">
				</td>
			</div>



			<table border="0" width="95%">

				<tr>
					<td>
						<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">
					</td>
				</tr>

			</table>
		</div>
	</form>
</div>