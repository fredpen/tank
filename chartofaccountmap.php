<?php
ob_start();
include_once "session_track.php";
?>

<style>
	td {
		padding: 5px;
	}
</style>

<script type="text/javascript" src="js/dynamic_search.js"></script>
<div align="center" id="data-form">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="X" onclick="javascript:  $('#data-form').hide();">
<!--	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">-->

	<?php
	require_once("lib/mfbconnect.php");
	?>



	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong>
				Chart Of Account Map
			</strong></h3>
		<?php
		if ($_SESSION['glmasters'] == 1) {

			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$branch_code = "";
			$user = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$selectmodule = !isset($_REQUEST['selectmodule']) ? '' : $dbobject->test_input($_REQUEST['selectmodule']);
			$selectchart = !isset($_REQUEST['selectchart']) ? '' : $dbobject->test_input($_REQUEST['selectchart']);
			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input($_REQUEST['keyword']);
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);
			$chartcode = !isset($_REQUEST['chartcode']) ? '' : $_REQUEST['chartcode'];
			$description = !isset($_REQUEST['description']) ? '' : $_REQUEST['description'];
			$themodule = !isset($_REQUEST['themodule']) ? '' : $_REQUEST['themodule'];
			$theacctno = !isset($_REQUEST['theacctno']) ? '' : $_REQUEST['theacctno'];
			$theacctnodescription = !isset($_REQUEST['theacctnodescription']) ? '' : $_REQUEST['theacctnodescription'];
			$credit_or_debit = !isset($_REQUEST['credit_or_debit']) ? '' : $_REQUEST['credit_or_debit'];

			$itemtodel = !isset($_REQUEST['itemtodel']) ? '' : $_REQUEST['itemtodel'];
			$itemtoedit = !isset($_REQUEST['itemtoedit']) ? '' : $_REQUEST['itemtoedit'];

			$sql_items = "select distinct  * FROM themodules WHERE 1=1 order by module_description";
			$result_items = mysqli_query($_SESSION['db_connect'], $sql_items);
			$count_items = mysqli_num_rows($result_items);

			$sql_chart = "select distinct  * FROM chart_of_account WHERE 1=1 order by description";
			$result_chart = mysqli_query($_SESSION['db_connect'], $sql_chart);
			$count_chart = mysqli_num_rows($result_chart);

			if ($op == 'searchitem') {

				//get list of jobs
				$executeQueries = 1;
				$filter = "";
				if ($searchin == "Item Code") {
					if ($keyword != '') {
						$filter = " AND trim(themodule) like '%$keyword%'   ";
					}
				} else {
					if ($keyword != '') {
						$filter = " AND trim(module_description) like '%$keyword%'   ";
					}
				}



				$sql_Q = "SELECT * FROM themodules where 1 = 1 ";
				$orderby = "   ";
				$orderflag	= " ";
				$order = $orderby . " " . $orderflag;
				$sql_QueryStmt = $sql_Q . $filter . $order . " limit 1";


				//echo $sql_QueryStmt;
				$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
				$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

				if ($count_QueryStmt >= 1) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$themodule    = $row['themodule'];
					$module_description   = $row['module_description'];
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Item does not exist</strong>");
					</script>
				<?php
				}
			}



			if ($op == 'getselectitem') {
				$filter = "";

				$sql_Q = "SELECT * FROM themodules where  ";
				$filter = "  trim(themodule) = '$themodule'  ";



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
					$themodule    = $row['themodule'];
					$module_description   = $row['module_description'];
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Item does not exist</strong>");
					</script>
				<?php
				}
			}

			if ($op == 'getselectchart') {
				if (trim($selectchart) <> '') {
					//echo $selectmodule;
					$itemdetails = explode("*", $selectchart);
					$chartcode = $itemdetails[0];
					$description = $itemdetails[1];
				}
			}

			if ($op == 'additem') {
				$goahead = 1;
				if (trim($chartcode) == '') {
					$goahead = 0;
				?>
					<script>
						$('#item_error').html("<strong>Please select a Account ID</strong>");
					</script>
				<?php
				}

				if (trim($themodule) == '') {
					$goahead = 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Module</strong>");
					</script>
				<?php
				}

				if (trim($credit_or_debit) == '') {
					$goahead = 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Account Operation</strong>");
					</script>
					<?php
				}


				if ($goahead == 1) {
					//check if range already exist
					$sql_range_exist = "select theacctno from account_mapping where trim(theacctno) = trim('$chartcode')
										and trim(themodule) = trim('$themodule')";

					//echo $sql_range_exist;

					$result_range_exist = mysqli_query($_SESSION['db_connect'], $sql_range_exist);
					$count_range_exist = mysqli_num_rows($result_range_exist);
					//echo $sql_range_exist;
					if ($count_range_exist >= 1) {
						$sql_save = " update account_mapping set
											credit_or_debit = '$credit_or_debit',
											theacctnodescription = '$description'
											where trim(theacctno) = trim('$chartcode') 
											and trim(themodule) = trim('$themodule')";


						$dbobject->apptrail($user, 'Chart Of Account Mapping', $themodule . " " . $description, date('d/m/Y H:i:s A'), 'Modified');
					?>
						<script>
							$('#item_error').html("<strong>Map Updated</strong>");
						</script>
					<?php
					} else {
						$sql_save = " insert into account_mapping 
												( themodule , theacctno ,credit_or_debit ,theacctnodescription  ) 
												values ('$themodule','$chartcode','$credit_or_debit','$description')";

						$dbobject->apptrail($user, 'Chart Of Account Mapping', $themodule . " " . $description, date('d/m/Y H:i:s A'), 'Created');

					?>
						<script>
							$('#item_error').html("<strong>New Map Created</strong>");
						</script>
				<?php


					}

					$result_have_access = mysqli_query($_SESSION['db_connect'], $sql_save);
					//echo $sql_save;
				}
			}





			if ($op == 'removemap') {

				$sql_delete = "delete from account_mapping where trim(theacctno) = '$chartcode' and trim(themodule) = trim('$themodule')";
				$result_delete = mysqli_query($_SESSION['db_connect'], $sql_delete);


				?>
				<script>
					$('#item_error').html("<strong> <?php echo trim($theacctno) ?> Deleted </strong>");
				</script>
			<?php


				$dbobject->apptrail($user, 'Chart Of Account Mapping', $themodule . " " . $description, date('d/m/Y H:i:s A'), 'Delected');
			}




			//****		
			$gridclause = ($themodule == "") ? " 1 = 2 " : "  trim(a.themodule) = trim(b.themodule) and trim(a.themodule) =  trim('$themodule') ";

			$sql_checkforgrid = " select * from themodules a, account_mapping b where " . $gridclause;

			$result_forgrid = mysqli_query($_SESSION['db_connect'], $sql_checkforgrid);

			$numrows_forgrid = mysqli_num_rows($result_forgrid);

			//echo $sql_checkforgrid;
			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="chartcode" id="chartcode" value="<?php echo $chartcode; ?>" />
			<input type="hidden" name="description" id="description" value="<?php echo $description; ?>" />
			<input type="hidden" name="themodule" id="themodule" value="<?php echo $themodule; ?>" />
			<table class="tableb">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>

				<tr>
					<td colspan="2">
						<b>Select Module</b>&nbsp;&nbsp;


						<?php
						$k = 0;
						?>
						<select name="selectmodule" id="selectmodule" onChange="javascript: 
									var $form_selectmodule = $('#selectmodule').val();  
								
										getpage('chartofaccountmap.php?op=getselectitem&themodule='+$form_selectmodule
										,'page')
							
								">
							<option value=""></option>
							<?php

							while ($k < $count_items) {
								$row = mysqli_fetch_array($result_items);
								$theselecteditem = trim($row['themodule']) . "*" . str_replace("&", "and", trim($row['module_description']));
							?>
								<option value="<?php echo trim($row['themodule']); ?>" <?php echo ($themodule == trim($row['themodule']) ? "selected" : ""); ?>>
									<?php echo str_replace("&", "and", trim($row['module_description'])); ?>
								</option>

							<?php
								$k++;
							} //End If Result Test	
							?>
						</select>
						&nbsp;&nbsp;&nbsp;
						<?php $calledby = 'chartofaccountmap';
						$reportid = 57;
						include("specificreportlink.php");  ?>
						&nbsp;&nbsp;&nbsp;
						<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('glmodule.php?','page');" />
					</td>
				</tr>

			</table>
			<br />

			<table style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
				<tr>
					<td colspan="5">
						<table border="0">
							<tr>
								<td>
									<b>Select Account</b>
								</td>
								<td>

									<input type="text" name="selectchart" id="selectchart" placeholder="Search for Account by Name or Code" size="60px" onKeyup="javascript: suggestentry(this.id,'journaladjustment'); $('#selectchartdisplay').hide();" value="<?php echo $selectchart; ?>">
									<div id="selectchartdisplay"></div>

								</td>

							</tr>
							<tr>

								<td align="left">


									<b>Operation: </b>
								</td>
								<td>
									<select name="credit_or_debit" id="credit_or_debit">
										<option value=""></option>
										<option value="CREDIT" <?php echo ($credit_or_debit == 'CREDIT' ? "selected" : ""); ?>>CREDIT</option>
										<option value="DEBIT" <?php echo ($credit_or_debit == 'DEBIT' ? "selected" : ""); ?>>DEBIT</option>
									</select>
									<input type="button" name="additem" id="submit-button" value="Add or Modify" onclick="javascript: addmodifymap();
										">
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap">
									<b>Number of Records :</b> &nbsp;&nbsp;<?php echo $numrows_forgrid; ?>
									<input type="hidden" name="numrows_forgrid" id="numrows_forgrid" value="<?php echo $numrows_forgrid; ?>" />


								</td>
								<td>

								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<th>Sn</th>
					<th>Chart Code</th>
					<th>Description</th>
					<th>Operation</th>
					<th></th>
				</tr>

				<?php
				$k = 0;

				while ($k < $numrows_forgrid) {
					$row = mysqli_fetch_array($result_forgrid);
					$k++;

				?>

					<tr>
						<td><?php echo $k; ?></td>
						<td><?php echo $row['theacctno']; ?> </td>

						<td><?php echo $row['theacctnodescription']; ?> </td>
						<td><?php echo $row['credit_or_debit']; ?></td>

						<td>


							<a href="javascript:

									var $form_selectmodule = $('#selectmodule').val();
									var $form_themodule= $('#themodule').val(); 
									
								getpage('chartofaccountmap.php?op=getselectchart&chartcode='+'<?php echo $row['theacctno']; ?>'
									+'&credit_or_debit='+'<?php echo trim($row['credit_or_debit']); ?>'+'&themodule='+$form_themodule
									+'&selectchart='+'<?php echo trim($row['theacctno']) . "*" . str_replace("&", "and", trim($row['theacctnodescription'])); ?>'
									+'&selectmodule='+$form_selectmodule,'page');
							
								
								">Edit
							</a>

							&nbsp;&nbsp;
							<a href="javascript:
								if (confirm('Are you sure the entries are correct?')) {
									
									var $form_selectmodule = $('#selectmodule').val();
									var $form_themodule= $('#themodule').val();  
									
								getpage('chartofaccountmap.php?op=removemap&chartcode='+'<?php echo $row['theacctno']; ?>'
									+'&credit_or_debit='+'<?php echo trim($row['credit_or_debit']); ?>'+'&themodule='+$form_themodule
									+'&selectchart='+'<?php echo trim($row['theacctno']) . "*" . str_replace("&", "and", trim($row['theacctnodescription'])); ?>'
									+'&selectmodule='+$form_selectmodule,'page');

									
									}	
								
								
								">Remove
							</a>
						</td>
					</tr>
				<?php

				} //End If Result Test	

				?>


			</table>

		<?php } ?>

	</form>
</div>

<script>
	function addmodifymap() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_selectchart = $('#selectchart').val();
			var $form_description = $('#description').val();
			var $form_themodule = $('#themodule').val();
			var $form_credit_or_debit = $('#credit_or_debit').val();
			var $form_selectmodule = $('#selectmodule').val();



			const myArrayOfItems = $form_selectchart.split("*");
			var thechartcode = myArrayOfItems[0];
			var thedescription = myArrayOfItems[1];


			var $goahead = 1;

			if (thechartcode == '') {
				$goahead = $goahead * 0;
				alert("Please Select a Chart");
			}
			if (thedescription == undefined) {
				$goahead = $goahead * 0;
				alert("Please Select a Chart");
			}

			if ($form_credit_or_debit == '') {
				$goahead = $goahead * 0;
				alert("Please Indicate Operation ");
			}

			if ($form_selectmodule == '') {
				$goahead = $goahead * 0;
				alert("Please Select a Module ");
			}

			if ($goahead == 1) {
				getpage('chartofaccountmap.php?op=additem&chartcode=' + thechartcode +
					'&description=' + thedescription + '&selectmodule=' + $form_selectmodule +
					'&themodule=' + $form_themodule + '&credit_or_debit=' + $form_credit_or_debit, 'page');
			}
		}

	}
</script>