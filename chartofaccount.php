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
<div align="center" id="data-form_rptheader">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form_rptheader').hide();">

	<?php


	?>

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong>
				Chart of Account
			</strong></h3>
		<?php
		if ($_SESSION['glmasters'] == 1) {

			require_once("lib/mfbconnect.php");

			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$branch_code = "";

			$sysuserid = !isset($_SESSION['username_sess']) ? '' : $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$selectitem = !isset($_REQUEST['selectitem']) ? '' : $dbobject->test_input($_REQUEST['selectitem']);
			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input($_REQUEST['keyword']);
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$chartcode = !isset($_REQUEST['chartcode']) ? '' : $_REQUEST['chartcode'];
			$description = !isset($_REQUEST['description']) ? '' : $_REQUEST['description'];
			$accounttype = !isset($_REQUEST['accounttype']) ? '' : $_REQUEST['accounttype'];
			$financialstatement = !isset($_REQUEST['financialstatement']) ? '' : $_REQUEST['financialstatement'];
			$bs_stmt = !isset($_REQUEST['bs_stmt']) ? '' : $_REQUEST['bs_stmt'];


			$itemtodel = !isset($_REQUEST['itemtodel']) ? '' : $_REQUEST['itemtodel'];

			$sql_items = "select distinct  * FROM chart_of_account WHERE 1=1 order by description";
			$result_items = mysqli_query($_SESSION['db_connect'], $sql_items);
			$count_items = mysqli_num_rows($result_items);

			if ($op == 'searchkeyword') {

				//get list of jobs
				$executeQueries = 1;
				$filter = " AND trim(chartcode) like '%$keyword%'   ";

				$sql_Q = "SELECT * FROM chart_of_account where 1 = 1 ";
				$orderby = "   ";
				$orderflag	= " ";
				$order = $orderby . " " . $orderflag;
				$sql_QueryStmt = $sql_Q . $filter . $order . " limit 1";


				//echo $sql_QueryStmt;
				$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
				$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

				if ($count_QueryStmt >= 1) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$chartcode    = $row['chartcode'];
					$description   = $row['description'];
					$accounttype    = $row['accounttype'];
					$financialstatement   = $row['financialstatement'];
					$bs_stmt    = $row['bs_stmt'];
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Chart does not exist</strong>");
					</script>
				<?php
				}
			}



			if ($op == 'getselectitem') {
				$filter = "";

				$sql_Q = "SELECT * FROM chart_of_account where  ";
				$chartcode = '';
				if (trim($selectitem) <> '') {
					//echo $selectitem;
					$itemdetails = explode("*", $selectitem);
					$chartcode = $itemdetails[0];
				}

				$filter = "  trim(chartcode) = '$chartcode'  ";



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
					$chartcode    = $row['chartcode'];
					$description   = $row['description'];
					$accounttype    = $row['accounttype'];
					$financialstatement   = $row['financialstatement'];
					$bs_stmt    = $row['bs_stmt'];
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Chart does not exist</strong>");
					</script>
				<?php
				}
			}






			if ($op == 'deleterecord') {

				$sql_delete = "delete from chart_of_account where trim(chartcode) = '$chartcode'";
				$result_delete = mysqli_query($_SESSION['db_connect'], $sql_delete);


				?>
				<script>
					$('#item_error').html("<strong> <?php echo trim($chartcode) ?> Deleted </strong>");
				</script>
				<?php

				$dbobject->apptrail($sysuserid, 'Chart Of Account', $chartcode, date('d/m/Y H:i:s A'), 'Deleted');
			}




			if ($op == 'saving') {
				$goahead = 1;
				if (trim($_REQUEST['chartcode']) == '') {
					$goahead = 0;

				?>
					<script>
						$('#item_error').html("<strong>Please specify Chart Of Account ID</strong>");
					</script>
				<?php }

				if (trim($_REQUEST['description']) == '') {
					$goahead = 0;

				?>
					<script>
						$('#item_error').html("<strong>Please specify Chart Description</strong>");
					</script>
				<?php }

				if (trim($_REQUEST['financialstatement']) == '') {
					$goahead = 0;

				?>
					<script>
						$('#item_error').html("<strong>Please specify Financial Statement</strong>");
					</script>
				<?php }

				if (trim($_REQUEST['accounttype']) == '') {
					$goahead = 0;
				?>

					<script>
						$('#item_error').html("<strong>Please select Account Type</strong>");
					</script>
					<?php }



				//save if all is ok
				if ($goahead == 1) {


					$sql_save = "select * from chart_of_account where trim(chartcode) = '$chartcode'";

					$result_save = mysqli_query($_SESSION['db_connect'], $sql_save);
					$count_save = mysqli_num_rows($result_save);




					if ($count_save >= 1) {
						$sql_update = " UPDATE chart_of_account SET  
								description = '$description',
								accounttype = '$accounttype',
								financialstatement = '$financialstatement' 
								where trim(chartcode) = '$chartcode'";


						$dbobject->apptrail($sysuserid, 'Chart Of Account', $chartcode, date('d/m/Y H:i:s A'), 'Modified');
						//echo $sql_update;
						$result_update = mysqli_query($_SESSION['db_connect'], $sql_update);

					?> <script>
							$('#item_error').html("<strong>Record Updated</strong>");
						</script> <?php
								} else {
									$sql_insert = " insert into chart_of_account 
									( chartcode, description,accounttype, financialstatement ) 
									 values ('$chartcode','$description','$accounttype','$financialstatement')";;

									$dbobject->apptrail($sysuserid, 'Chart Of Account', $chartcode, date('d/m/Y H:i:s A'), 'Created');

									$result_insert = mysqli_query($_SESSION['db_connect'], $sql_insert);

									//echo $sql_insert."<br/>";

									?> <script>
							$('#item_error').html("<strong>New Record Created</strong>");
						</script> <?php
								}
							}
						}
						//****		


									?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="chartofaccount" />
			<input type="hidden" name="get_file" id="get_file" value="chartofaccount" />
			<table border="0" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<div class="input-group">
							<b>Search by: <i>Name or Code</i> </b>&nbsp;
							<input type="text" size="35px" id="search" placeholder="Search for Account" />
							<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

						</div>
						<!-- Suggestions will be displayed in below div. -->

						<div id="display"></div>
					</td>

				</tr>

			</table>

			<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">

				<tr>

					<td align="left">
						<b>Chart ID :</b>
					</td>
					<td>
						<input type="text" name="chartcode" id="chartcode" value="<?php echo $chartcode; ?>" <?php if ($chartcode != '') {
																													echo "style='color:lightgray'";
																													echo 'readonly';
																												} ?> class="required-text" />
					</td>
				</tr>
				<tr>
					<td align="left">
						<b>Description :</b>
					</td>
					<td>
						<input type="text" name="description" id="description" value="<?php echo $description; ?>" class="required-text" />
					</td>
				</tr>
				<tr>

					<td align="left">
						<b>Acct Type: </b>
					</td>
					<td>

						<select name="accounttype" id="accounttype">
							<option value=""></option>
							<option value="Asset" <?php echo ($accounttype == 'Asset' ? "selected" : ""); ?>>Asset</option>
							<option value="Liability" <?php echo ($accounttype == 'Liability' ? "selected" : ""); ?>>Liability</option>
							<option value="Equity" <?php echo ($accounttype == 'Equity' ? "selected" : ""); ?>>Equity</option>
							<option value="Revenue" <?php echo ($accounttype == 'Revenue' ? "selected" : ""); ?>>Revenue</option>
							<option value="Expense" <?php echo ($accounttype == 'Expense' ? "selected" : ""); ?>>Expense</option>

						</select>
					</td>
				</tr>
				<tr>
					<td align="left">
						<b>Financial Statement: </b>
					</td>
					<td>

						<select name="financialstatement" id="financialstatement">
							<option value=""></option>
							<option value="Balance Sheet" <?php echo ($financialstatement == 'Balance Sheet' ? "selected" : ""); ?>>Balance Sheet</option>
							<option value="Income Statement" <?php echo ($financialstatement == 'Income Statement' ? "selected" : ""); ?>>Income Statement</option>

						</select>
					</td>
				</tr>

			</table>
			<table>

				<tr>


					<td colspan="3">

						<?php $calledby = 'chartofaccount';
						$reportid = 56;
						include("specificreportlink.php");  ?>

					</td>
				</tr>
				<tr>
					<td>
						<input type="button" name="refreshbutton" id="submit-button" value="Refresh" onclick="javascript:  getpage('chartofaccount.php?','page');" />
					</td>
					<td align="right" nowrap="nowrap">
						<input type="button" name="testsave" id="submit-button" value="Save" onclick="javascript: 
						if (confirm('Are you sure of this action?')) {
									var $form_chartcode = $('#chartcode').val();
									var $form_description = $('#description').val();  var $form_accounttype = $('#accounttype').val();
									var $form_financialstatement= $('#financialstatement').val(); 
									
						getpage('chartofaccount.php?op=saving&chartcode='+$form_chartcode+'&description='+$form_description+'&accounttype='+$form_accounttype
						+'&financialstatement='+$form_financialstatement,'page');}">
					</td>
					<td>
						<input type="button" name="deleterecord" id="submit-button" value="Delete" onclick="javascript:
							if (confirm('Are you sure of this action?')) {
									var $form_chartcode = $('#chartcode').val();
								getpage('chartofaccount.php?op=deleterecord&chartcode='+$form_chartcode,'page');
							}	
						">
					</td>


				</tr>
			</table>

		<?php } ?>
	</form>
	<br />

	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('glmodule.php?','page');" />

	<br />
</div>