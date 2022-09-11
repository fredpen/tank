<?php
ob_start();
include_once "session_track.php";
?>


<style>
	td {
		padding: 5px;
	}
</style>

<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align="center" id="data-form">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">

	<?php
	require_once("lib/mfbconnect.php");
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong>
				Sales Person
			</strong></h3>
		<?php
		if ($_SESSION['somasters'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$user = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$salespsn = !isset($_REQUEST['salespsn']) ? '' : $dbobject->test_input($_REQUEST['salespsn']);
			$salespsnname = !isset($_REQUEST['salespsnname']) ? '' : $dbobject->test_input($_REQUEST['salespsnname']);
			$salespsnphone = !isset($_REQUEST['salespsnphone']) ? '' : $dbobject->test_input($_REQUEST['salespsnphone']);
			$salespsnemail = !isset($_REQUEST['salespsnemail']) ? '' : $dbobject->test_input($_REQUEST['salespsnemail']);

			$selectclient = !isset($_REQUEST['selectclient']) ? '' : $dbobject->test_input($_REQUEST['selectclient']);
			$bu = !isset($_REQUEST['bu']) ? '' : $dbobject->test_input($_REQUEST['bu']);
			$category = !isset($_REQUEST['category']) ? '' : $dbobject->test_input($_REQUEST['category']);

			$roleid = !isset($_REQUEST['roleid']) ? 0 : $_REQUEST['roleid'];

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$sql_client = "select distinct * FROM salesperson WHERE 1=1 order by salespsnname";
			$result_client = mysqli_query($_SESSION['db_connect'], $sql_client);
			$count_client = mysqli_num_rows($result_client);

			$sql_for_report = "select * from reptable where reportid = 53";
			$result_for_report = mysqli_query($_SESSION['db_connect'], $sql_for_report);
			$count_for_report = mysqli_num_rows($result_for_report);

			if ($count_for_report > 0) {
				$rowreport = mysqli_fetch_array($result_for_report);
			}




			if ($op == 'getselectclient') {
				$filter = "";

				$sql_Q = "SELECT * FROM salesperson where  ";
				$salespsn = '';
				if (trim($selectclient) <> '') {
					//echo $selectitem;
					$itemdetails = explode("*", $selectclient);
					$salespsn = $itemdetails[0];
				}

				$filter = "  upper(trim(salespsn)) = upper('$salespsn')  ";



				$orderby = "   ";
				$orderflag	= " ";
				$order = $orderby . " " . $orderflag;
				$sql_QueryStmt = $sql_Q . $filter . $order . " limit 1";

				//echo "<br/> sql_Q ".$sql_Q;	
				//echo "<br/>".$sql_QueryStmt."<br/>";
				$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
				$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

				if ($count_QueryStmt >= 1) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$salespsn    = $row['salespsn'];
					$salespsnname   = $row['salespsnname'];
					$salespsnphone = $row['salespsnphone'];
					$salespsnemail = $row['salespsnemail'];
					$selectclient = trim($row['salespsn']) . "*" . trim($row['salespsnname']);
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Sales Person does not exist</strong>");
					</script>
				<?php
				}
			}




			if ($op == 'searchkeyword') {
				$filter = " AND trim(salespsn) = '$keyword'  ";


				$sql_Q = "SELECT * FROM salesperson where ";
				if (strlen($keyword) != 0) {
					$sql_Q = $sql_Q . " 1 = 1 ";
				} else {
					$sql_Q = $sql_Q . " 1 = 2 ";
				}
				$orderby = "   ";
				$orderflag	= " ";
				$order = $orderby . " " . $orderflag;
				$sql_QueryStmt = $sql_Q . $filter . $order . " limit 1";

				//echo "<br/> sql_Q ".$sql_Q;	
				//echo "<br/>".$sql_QueryStmt;
				$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
				$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

				if ($count_QueryStmt >= 1) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$salespsn    = $row['salespsn'];
					$salespsnname   = $row['salespsnname'];
					$salespsnphone = $row['salespsnphone'];
					$salespsnemail = $row['salespsnemail'];

					$selectclient = trim($row['salespsn']) . "*" . trim($row['salespsnname']);
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Sales Person does not exist</strong>");
					</script>
				<?php
				}
			}

			if ($op == 'deleteCustomer') {
				$goahead = 1;

				if (trim($salespsn) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify SalesPerson ID</strong>");
					</script>
					<?php
				} else {

					$sql_checktrans =  "select * from headdata where trim(salespsn) = '$salespsn'";
					$result_checktrans = mysqli_query($_SESSION['db_connect'], $sql_checktrans);
					$count_checktrans = mysqli_num_rows($result_checktrans);

					if ($count_checktrans >= 1) {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>This Sales Person cannot be deleted because it has been used in transactions.</strong>");
						</script>
					<?php }
				}

				if ($goahead == 1) {
					$sql_deleteSalesperson =  "delete from salesperson where trim(salespsn) = '$salespsn'";
					$result_deleteSalesperson = mysqli_query($_SESSION['db_connect'], $sql_deleteSalesperson);


					$dbobject->apptrail($user, 'Sales Person', $salespsn . " " . $salespsnname, date('d/m/Y H:i:s A'), 'Deleted');

					?>
					<script>
						$('#item_error').html("<strong>Sales Person Record Deleted</strong>");
					</script>
				<?php

				}
			}



			if ($op == 'saving') {

				$goahead = 1;

				if (trim($salespsn) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify SalesPerson ID</strong>");
					</script>
				<?php }


				if (trim($_REQUEST['salespsnname']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Sales Person Name</strong>");
					</script>
				<?php }





				if (empty($salespsnemail)) {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Email is required</strong>");
					</script>
					<?php
				} else {

					if (!filter_var($salespsnemail, FILTER_VALIDATE_EMAIL)) {

						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>Invalid email format.</strong>");
						</script>
					<?php
					}
				}





				//echo $goahead;
				if ($goahead == 1) {

					$sql_checkCustomer = "SELECT * FROM salesperson where upper(trim(salespsn)) = upper('$salespsn') ";
					$result_checkCustomer = mysqli_query($_SESSION['db_connect'], $sql_checkCustomer);
					$count_checkCustomer = mysqli_num_rows($result_checkCustomer);

					if ($count_checkCustomer > 0) {
						$sql_saveCustomer = " update salesperson set 
								 salespsnname = '$salespsnname', 
								 salespsnphone  = '$salespsnphone', 
								 salespsnemail  = '$salespsnemail'  
								 where trim(salespsn) = '$salespsn'";

						$dbobject->apptrail($user, 'Sales Person', $salespsn . " " . $salespsnname, date('d/m/Y H:i:s A'), 'Modified');
					} else {
						$sql_saveCustomer = " insert into salesperson (salespsn, salespsnname, salespsnphone, salespsnemail ) 
								 values ('$salespsn', '$salespsnname' ,  '$salespsnphone',  '$salespsnemail') ";

						$dbobject->apptrail($user, 'Sales Person', $salespsn . " " . $salespsnname, date('d/m/Y H:i:s A'), 'Created');
					}
					$result_saveCustomer = mysqli_query($_SESSION['db_connect'], $sql_saveCustomer);



					?>
					<script>
						$('#item_error').html("<strong>Sales Person Record Saved</strong>");
					</script>
			<?php

				}
			}
			//****			


			?>
			<input type="hidden" name="thetablename" id="thetablename" value="salespsn" />
			<input type="hidden" name="get_file" id="get_file" value="salesperson" />
			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />

			<table border="0" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="input-group">
							<b>Search by: <i>Name or Code or Phone Number</i> </b>&nbsp;
							<input type="text" size="35px" id="search" placeholder="Search for Sales Person" />
							<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

						</div>
						<!-- Suggestions will be displayed in below div. -->

						<div id="display"></div>
					</td>

				</tr>

				<tr>
					<td colspan="2">
						<b>Sales Person</b>&nbsp;&nbsp;


						<?php
						$k = 0;
						?>
						<select name="selectclient" id="selectclient" onChange="javascript: 
									var $form_selectclient = $('#selectclient').val();  
								
										getpage('salesperson.php?op=getselectclient&selectclient='+$form_selectclient
										,'page')
							
								">
							<option value=""></option>
							<?php

							while ($k < $count_client) {
								$row = mysqli_fetch_array($result_client);
								$theselectedclient = trim($row['salespsn']) . "*" . trim($row['salespsnname']);
							?>
								<option value="<?php echo $theselectedclient; ?>" <?php echo ($selectclient == $theselectedclient ? "selected" : ""); ?>>
									<?php echo $theselectedclient; ?>
								</option>

							<?php
								$k++;
							} //End If Result Test	
							?>
						</select>

					</td>
				</tr>
			</table>
			<br />
			<div style="overflow-x:auto;">
				<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
					<tr>
						<td nowrap="nowrap">
							<b>SalesPerson ID : </b>
						</td>
						<td>
							<input type="text" name="salespsn" id="salespsn" value="<?php echo $salespsn; ?>" <?php if ($salespsn != '') {
																													echo "style='color:gray'";
																													echo 'readonly';
																												} ?> placeholder="Enter SalesPerson ID" />
						</td>

						<td>

							<input type="button" name="refreshbutton" id="submit-button" value="Refresh" onclick="javascript:  getpage('salesperson.php?','page');" />

						</td>

					</tr>
					<tr>

						<td>
							<b>Sales Person Name : </b>
						</td>
						<td colspan="2">
							<input type="text" size="50%" name="salespsnname" id="salespsnname" value="<?php echo $salespsnname; ?>" placeholder="Enter Sales Person Name" />
						</td>
					</tr>

					<tr>
						<td>
							<b>Email : </b>
						</td>
						<td colspan="2">
							<input type="salespsnemail" name="salespsnemail" id="salespsnemail" value="<?php echo $salespsnemail; ?>" placeholder="Enter Sales Person Email" />
						</td>
					</tr>

					<tr>

						<td>
							<b>Phone : </b>
						</td>
						<td colspan="2">
							<input type="tel" name="salespsnphone" id="salespsnphone" value="<?php echo $salespsnphone; ?>" placeholder="Enter Conatct Phone Number" pattern="[0-9]{4,12}" title="Only Digits" />
						</td>
					</tr>

				</table>

				<table>

					<tr>


						<td>

							<input type="button" name="deletebutton" id="submit-button" value="Delete" onclick="deletecustomer();" />

						</td>

						<td>

							<input type="button" name="savebutton" id="submit-button" value="Save" onclick="savecustomer();" />

						</td>
						<?php if ($count_for_report > 0) { ?>
							<td nowrap="nowrap">

								<input type="hidden" id="the_reportname" value="<?php echo trim($rowreport['procname']); ?>" />
								<input type="hidden" id="the_reportdesc" value="<?php echo trim($rowreport['reportdesc']); ?>" />
								<input type="hidden" id="thestartdate" value="<?php echo trim($rowreport['startdate']); ?>" />
								<input type="hidden" id="the_location" value="<?php echo trim($rowreport['location']); ?>" />
								<input type="hidden" id="the_product" value="<?php echo trim($rowreport['product']); ?>" />
								<input type="hidden" id="the_purchaseorder" value="<?php echo trim($rowreport['purchaseorder']); ?>" />
								<input type="hidden" id="the_vendor" value="<?php echo trim($rowreport['vendor']); ?>" />
								<input type="hidden" id="the_customer" value="<?php echo trim($rowreport['customer']); ?>" />
								<input type="hidden" id="the_salesperson" value="<?php echo trim($rowreport['salespsn']); ?>" />



								<input type="button" name="closebutton" id="submit-button" value="Report" onclick="javascript: 
							var reportname = $('#the_reportname').val();var reportdesc = $('#the_reportdesc').val();
							var startdate = $('#the_startdate').val();var location = $('#the_location').val();
							var product = $('#the_product').val();var purchaseorder = $('#the_purchaseorder').val();
							var vendor = $('#the_vendor').val();var customer = $('#the_customer').val();var salespsn = $('#the_salespsn').val();
							
						getpage('reportheader.php?calledby=salesperson&reportname='+reportname+'&reportdesc='+reportdesc+'&thestartdate='+startdate+'&location='+location+'&product='+product+'&purchaseorder='+purchaseorder+'&vendor='+vendor+'&customer='+customer+'&salesperson='+salespsn,'page');" />
							</td>
						<?php } ?>
					</tr>

				</table>
			</div>

		<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('s_and_d.php?','page');" />
	<br />
</div>

<script>
	function savecustomer() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_salespsn = $('#salespsn').val();
			var $form_salespsnname = $('#salespsnname').val();
			var $form_salespsnemail = $('#salespsnemail').val();
			var $form_salespsnphone = $('#salespsnphone').val();

			var $goahead = 1;

			if ($form_salespsn.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter SalesPerson ID ");
			}

			if ($form_salespsnname.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Sales Person Name ");
			}



			if ($form_salespsnphone.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter a Phone Number");
			} else {
				if (isNaN($form_salespsnphone)) {
					$goahead = $goahead * 0;
					alert("Please Enter a Valid Phone Number");

				}

			}


			if ($form_salespsnemail.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Email");
			} else {
				if (!IsValidEmail($form_salespsnemail)) {
					$goahead = $goahead * 0;
					alert("Invalid email address!");
				}
			}

			if ($goahead == 1) {
				thegetpage = 'salesperson.php?op=saving&salespsn=' + $form_salespsn +
					'&salespsnname=' + $form_salespsnname +
					'&salespsnphone=' + $form_salespsnphone +
					'&salespsnemail=' + $form_salespsnemail;
				//alert(thegetpage);	
				getpage(thegetpage, 'page');
			}

		}
	}


	function deletecustomer() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_salespsn = $('#salespsn').val();
			var $form_salespsnname = $('#salespsnname').val();
			var $form_salespsnemail = $('#salespsnemail').val();
			var $form_salespsnphone = $('#salespsnphone').val();



			var $goahead = 1;

			if ($form_salespsn == '') {
				$goahead = $goahead * 0;
				alert("Please Enter SalesPerson ID ");
			}


			if ($goahead == 1) {

				getpage('salesperson.php?op=deleteCustomer&salespsn=' + $form_salespsn +
					'&salespsnname=' + $form_salespsnname +
					'&salespsnphone=' + $form_salespsnphone + '&salespsnemail=' + $form_salespsnemail, 'page');
			}

		}
	}


	function IsValidEmail(email) {
		var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		return expr.test(email);
	}
</script>