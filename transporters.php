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
				Transporters Definition
			</strong></h3>
		<?php
		if ($_SESSION['somasters'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$user = $_SESSION['username_sess'];
			$reqst_by = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$trasno = !isset($_REQUEST['trasno']) ? '' : $_REQUEST['trasno'];
			$company = !isset($_REQUEST['company']) ? '' : $dbobject->test_input($_REQUEST['company']);
			$phone = !isset($_REQUEST['phone']) ? '' : $dbobject->test_input($_REQUEST['phone']);
			$address = !isset($_REQUEST['address']) ? '' : $dbobject->test_input($_REQUEST['address']);



			$roleid = !isset($_REQUEST['roleid']) ? 0 : $_REQUEST['roleid'];

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$sql_transporter = "select distinct * FROM tbtras WHERE 1=1 order by company";
			$result_transporter = mysqli_query($_SESSION['db_connect'], $sql_transporter);
			$count_transporter = mysqli_num_rows($result_transporter);
			//echo "dd_no ".$dd_no;

			$sql_for_report = "select * from reptable where reportid = 30";
			$result_for_report = mysqli_query($_SESSION['db_connect'], $sql_for_report);
			$count_for_report = mysqli_num_rows($result_for_report);

			if ($count_for_report > 0) {
				$rowreport = mysqli_fetch_array($result_for_report);
			}


			if ($op == 'getselecttransporter') {
				$filter = "";

				$sql_Q = "SELECT * FROM tbtras where  ";


				$filter = "  upper(trim(trasno)) = upper('$trasno')  ";



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
					$trasno    = $row['trasno'];
					$company   = $row['company'];
					$phone = $row['phone'];
					$address  = $row['address'];
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Transporter does not exist</strong>");
					</script>
				<?php
				}
			}




			if ($op == 'searchkeyword') {

				$filter = " AND trim(trasno) like '%$keyword%'   ";

				$sql_Q = "SELECT * FROM tbtras where ";
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
					$trasno    = $row['trasno'];
					$company   = $row['company'];
					$phone = $row['phone'];
					$address  = $row['address'];
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Transporter does not exist</strong>");
					</script>
				<?php
				}
			}

			if ($op == 'deletetrasno') {
				$goahead = 1;

				if (trim($trasno) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Transporter ID</strong>");
					</script>
					<?php
				} else {

					$sql_checkusage =  "select * from invoice where trim(trasno) = '$trasno'";
					$result_checkusage = mysqli_query($_SESSION['db_connect'], $sql_checkusage);
					$count_checkusage = mysqli_num_rows($result_checkusage);

					if ($count_checkusage >= 1) {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>This Transporter cannot be deleted because it has been used in transactions.</strong>");
						</script>
					<?php }
				}

				if ($goahead == 1) {
					$sql_deletetrans =  "delete from tbtras where trim(trasno) = '$trasno'";
					$result_deletetrans = mysqli_query($_SESSION['db_connect'], $sql_deletetrans);


					$dbobject->apptrail($reqst_by, 'Transporter', $trasno . " " . $company, date('d/m/Y H:i:s A'), 'Deleted');

					?>
					<script>
						$('#item_error').html("<strong>Transporter Record Deleted</strong>");
					</script>
				<?php

				}
			}



			if ($op == 'saving') {

				$goahead = 1;

				if (trim($trasno) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Transporter ID</strong>");
					</script>
				<?php }


				if (trim($_REQUEST['company']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Transporter Name</strong>");
					</script>
				<?php }




				if (trim($_REQUEST['address']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Address</strong>");
					</script>
				<?php
				}




				//echo $goahead;
				if ($goahead == 1) {

					$sql_checktrans = "SELECT * FROM tbtras where upper(trim(trasno)) = upper('$trasno') ";
					$result_checktrans = mysqli_query($_SESSION['db_connect'], $sql_checktrans);
					$count_checktrans = mysqli_num_rows($result_checktrans);

					if ($count_checktrans > 0) {
						$sql_savetrans = " update tbtras set 
								 company = '$company', 
								 phone  = '$phone', 
								 address  = '$address' 
								 where trim(trasno) = '$trasno'";
						$dbobject->apptrail($reqst_by, 'Transporter', $trasno . " " . $company, date('d/m/Y H:i:s A'), 'Modified');
					} else {
						$sql_savetrans = " insert into tbtras (  
								trasno, company,  phone, address ) 
								 values ('$trasno', '$company' ,  '$phone', '$address' ) ";

						$dbobject->apptrail($reqst_by, 'Transporter', $trasno . " " . $company, date('d/m/Y H:i:s A'), 'Created');
					}
					$result_savetrans = mysqli_query($_SESSION['db_connect'], $sql_savetrans);


					//echo $sql_QueryStmt;



				?>
					<script>
						$('#item_error').html("<strong>Transporter Record Saved</strong>");
					</script>
			<?php

				}
			}
			//****			


			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="transporters" />
			<input type="hidden" name="get_file" id="get_file" value="transporters" />

			<table border="0" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="input-group">
							<b>Search by: <i>Name or Code</i> </b>&nbsp;
							<input type="text" size="35px" id="search" placeholder="Search for Transporter" />
							<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

						</div>
						<!-- Suggestions will be displayed in below div. -->

						<div id="display"></div>
					</td>

				</tr>

			</table>
			<br />
			<div style="overflow-x:auto;">
				<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
					<tr>
						<td>
							<b>Transporter ID : </b>
						</td>
						<td colspan="2">
							<input type="text" name="trasno" id="trasno" value="<?php echo $trasno; ?>" <?php if ($trasno != '') {
																											echo 'style="background-color:lightgray" readonly';
																										} ?> placeholder="Enter Transporter ID" />
						</td>
						<td>

							<input type="button" name="refreshbutton" id="submit-button" value="Refresh" onclick="javascript:  getpage('transporters.php?','page');" />
						</td>

					</tr>
					<tr>
						<td>
							<b>Transporter Name : </b>
						</td>
						<td>
							<input type="text" name="company" id="company" value="<?php echo $company; ?>" placeholder="Enter Transporter Name" />
						</td>
						<td>
							<b>Phone : </b>
						</td>
						<td>
							<input type="tel" name="phone" id="phone" value="<?php echo $phone; ?>" placeholder="Enter Phone Number" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Address : </b>
						</td>
						<td colspan="3">
							<input type="text" name="address" id="address" size="55%" value="<?php echo $address; ?>" placeholder="Enter Address" />
						</td>

					</tr>

				</table>
				<table>

					<tr>


						<td>

							<input type="button" name="deletebutton" id="submit-button" value="Delete" onclick="deletetrasno();" />

						</td>

						<td>

							<input type="button" name="savebutton" id="submit-button" value="Save" onclick="savetrasno();" />

						</td>
						<?php if ($count_for_report > 0) { ?>

							<td>
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
							
						getpage('reportheader.php?calledby=transporters&reportname='+reportname+'&reportdesc='+reportdesc+'&thestartdate='+startdate+'&location='+location+'&product='+product+'&purchaseorder='+purchaseorder+'&vendor='+vendor+'&customer='+customer+'&salesperson='+salespsn,'page');" />
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
	function savetrasno() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_transno = $('#trasno').val();
			$form_address = $('#address').val();
			var $form_company = $('#company').val();
			var $form_phone = $('#phone').val();



			var $goahead = 1;

			if ($form_transno == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Transporter ID ");
			}

			if ($form_company == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Transporter Name ");
			}

			if ($form_address == '') {
				$goahead = $goahead * 0;
				alert("Please specify the Address");
			}

			if ($form_phone.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter a Phone Number");
			} else {
				if (isNaN($form_phone)) {
					$goahead = $goahead * 0;
					alert("Please Enter a Valid Phone Number");

				}

			}

			if ($goahead == 1) {
				getpage('transporters.php?op=saving&trasno=' + $form_transno +
					'&company=' + $form_company +
					'&phone=' + $form_phone + '&address=' + $form_address, 'page');
			}

		}
	}


	function deletetrasno() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_transno = $('#trasno').val();
			$form_address = $('#address').val();
			var $form_company = $('#company').val();
			var $form_phone = $('#phone').val();



			var $goahead = 1;

			if ($form_transno == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Transporter ID ");
			}


			if ($goahead == 1) {
				getpage('transporters.php?op=deletetrasno&trasno=' + $form_transno +
					'&company=' + $form_company +
					'&phone=' + $form_phone + '&address=' + $form_address, 'page');
			}

		}
	}
</script>