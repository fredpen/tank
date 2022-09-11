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
				Bank Definition
			</strong></h3>
		<?php
		if ($_SESSION['masters'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$user = $_SESSION['username_sess'];
			$reqst_by = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$bank_code = !isset($_REQUEST['bank_code']) ? '' : $_REQUEST['bank_code'];
			$bank_name = !isset($_REQUEST['bank_name']) ? '' : $dbobject->test_input($_REQUEST['bank_name']);
			$phone = !isset($_REQUEST['phone']) ? '' : $dbobject->test_input($_REQUEST['phone']);
			$bankaddr = !isset($_REQUEST['bankaddr']) ? '' : $dbobject->test_input($_REQUEST['bankaddr']);
			$bankbal = !isset($_REQUEST['bankbal']) ? '' : $dbobject->test_input($_REQUEST['bankbal']);


			$selectbank = !isset($_REQUEST['selectbank']) ? '' : $dbobject->test_input($_REQUEST['selectbank']);

			$roleid = !isset($_REQUEST['roleid']) ? 0 : $_REQUEST['roleid'];

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$sql_bank = "select distinct * FROM bank WHERE 1=1 order by bank_name";
			$result_bank = mysqli_query($_SESSION['db_connect'], $sql_bank);
			$count_bank = mysqli_num_rows($result_bank);
			//echo "dd_no ".$dd_no;



			if ($op == 'getselectbank') {
				$filter = "";

				$sql_Q = "SELECT * FROM bank where  ";
				$bank_code = '';
				if (trim($selectbank) <> '') {
					//echo $selectitem;
					$itemdetails = explode("*", $selectbank);
					$bank_code = $itemdetails[0];
				}

				$filter = "  upper(trim(bank_code)) = upper('$bank_code')  ";



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
					$bank_code    = $row['bank_code'];
					$bank_name   = $row['bank_name'];
					$phone = $row['phone'];
					$bankaddr  = $row['bankaddr'];
					$bankbal  = $row['bankbal'];
					$selectbank = trim($row['bank_code']) . "*" . trim($row['bank_name']);
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Bank does not exist</strong>");
					</script>
				<?php
				}
			}




			if ($op == 'searchkeyword') {
				$filter = " AND trim(bank_code) like '%$keyword%'   ";

				$sql_Q = "SELECT * FROM bank where ";
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
					$bank_code    = $row['bank_code'];
					$bank_name   = $row['bank_name'];
					$phone = $row['phone'];
					$bankaddr  = $row['bankaddr'];
					$bankbal  = $row['bankbal'];
					$selectbank = trim($row['bank_code']) . "*" . trim($row['bank_name']);
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Bank does not exist</strong>");
					</script>
				<?php
				}
			}

			if ($op == 'deletebank') {
				$goahead = 1;

				if (trim($bank_code) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Bank ID</strong>");
					</script>
					<?php
				} else {

					$sql_checkpayments =  "select * from payments where trim(bank_code) = '$bank_code'";
					$result_checkpayments = mysqli_query($_SESSION['db_connect'], $sql_checkpayments);
					$count_checkpayments = mysqli_num_rows($result_checkpayments);

					if ($count_checkpayments >= 1) {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>This Bank cannot be deleted because it has been used in transactions.</strong>");
						</script>
					<?php }
				}

				if ($goahead == 1) {
					$sql_deletevendor =  "delete from bank where trim(bank_code) = '$bank_code'";
					$result_deletevendor = mysqli_query($_SESSION['db_connect'], $sql_deletevendor);



					$dbobject->apptrail($reqst_by, 'Bank Definition', $bank_code . " " . $bank_name, date('d/m/Y H:i:s A'), 'Deleted');

					?>
					<script>
						$('#item_error').html("<strong>Bank Record Deleted</strong>");
					</script>
				<?php

				}
			}



			if ($op == 'saving') {

				$goahead = 1;

				if (trim($bank_code) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Bank ID</strong>");
					</script>
				<?php }


				if (trim($_REQUEST['bank_name']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Bank Name</strong>");
					</script>
				<?php }




				if (trim($_REQUEST['bankaddr']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Address</strong>");
					</script>
				<?php
				}




				//echo $goahead;
				if ($goahead == 1) {

					$sql_checkBank = "SELECT * FROM bank where upper(trim(bank_code)) = upper('$bank_code') ";
					$result_checkBank = mysqli_query($_SESSION['db_connect'], $sql_checkBank);
					$count_checkBank = mysqli_num_rows($result_checkBank);

					if ($count_checkBank > 0) {
						$sql_saveBank = " update bank set 
								 bank_name = '$bank_name', 
								 phone  = '$phone', 
								 bankaddr  = '$bankaddr' 
								 where trim(bank_code) = '$bank_code'";
					} else {
						$sql_saveBank = " insert into bank (  
								bank_code, bank_name,  phone, bankaddr ) 
								 values ('$bank_code', '$bank_name' ,  '$phone', '$bankaddr' ) ";
					}
					$result_saveBank = mysqli_query($_SESSION['db_connect'], $sql_saveBank);


					//echo $sql_QueryStmt;

					$dbobject->apptrail($reqst_by, 'Bank Definition', $bank_code . " " . $bank_name, date('d/m/Y H:i:s A'), 'Saved');

				?>
					<script>
						$('#item_error').html("<strong>Bank Record Saved</strong>");
					</script>
			<?php

				}
			}
			//****			


			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="bankdef" />
			<input type="hidden" name="get_file" id="get_file" value="bankdef" />
			<table border="0" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="input-group">
							<b>Search by: <i>Name or Code or Phone Number</i> </b>&nbsp;
							<input type="text" size="35px" id="search" placeholder="Search for Customer" />
							<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

						</div>
						<!-- Suggestions will be displayed in below div. -->
						<br />
						<div id="display"></div>
					</td>

				</tr>

			</table>
			<br />
			<div style="overflow-x:auto;">
				<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
					<tr>
						<td>
							<b>Bank ID : </b>
						</td>
						<td colspan="2">
							<input type="text" name="bank_code" id="bank_code" value="<?php echo $bank_code; ?>" <?php if ($bank_code != '') {
																														echo 'style="background-color:lightgray" readonly';
																													} ?> placeholder="Enter Bank ID" />
						</td>
						<td>

							<input type="button" name="refreshbutton" id="submit-button" value="Refresh" onclick="javascript:  getpage('bankdef.php?','page');" />

						</td>

					</tr>
					<tr>
						<td>
							<b>Bank Name : </b>
						</td>
						<td>
							<input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" placeholder="Enter Bank Name" />
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
							<input type="text" name="bankaddr" id="bankaddr" size="55%" value="<?php echo $bankaddr; ?>" placeholder="Enter Address" />
						</td>

					</tr>

				</table>
				<table>

					<tr>

						<td>

							<input type="button" name="deletebutton" id="submit-button" value="Delete" onclick="deletebank();" />

						</td>

						<td>

							<input type="button" name="savebutton" id="submit-button" value="Save" onclick="savevendor();" />

						</td>
						<td>

							<?php $calledby = 'bankdef';
							$reportid = 38;
							include("specificreportlink.php");  ?>

						</td>
					</tr>

				</table>
			</div>

		<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('finance.php?','page');
				">
	<br />
</div>

<script>
	function savevendor() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_bank_code = $('#bank_code').val();
			$form_bankaddr = $('#bankaddr').val();
			var $form_bank_name = $('#bank_name').val();
			var $form_phone = $('#phone').val();



			var $goahead = 1;

			if ($form_bank_code == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Bank ID ");
			}

			if ($form_bank_name == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Bank Name ");
			}

			if ($form_bankaddr == '') {
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
				getpage('bankdef.php?op=saving&bank_code=' + $form_bank_code +
					'&bank_name=' + $form_bank_name +
					'&phone=' + $form_phone + '&bankaddr=' + $form_bankaddr, 'page');
			}

		}
	}


	function deletebank() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_bank_code = $('#bank_code').val();
			$form_bankaddr = $('#bankaddr').val();
			var $form_bank_name = $('#bank_name').val();
			var $form_phone = $('#phone').val();



			var $goahead = 1;

			if ($form_bank_code == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Bank ID ");
			}


			if ($goahead == 1) {
				getpage('bankdef.php?op=deletebank&bank_code=' + $form_bank_code +
					'&bank_name=' + $form_bank_name +
					'&phone=' + $form_phone + '&bankaddr=' + $form_bankaddr, 'page');
			}

		}
	}
</script>