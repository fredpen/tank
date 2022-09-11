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
<div align="center" id="data-form_500">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form_500').hide();">

	<?php
	require_once("lib/mfbconnect.php");
	?>



	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong>
				Item At Sub Location
			</strong></h3>
		<?php
		if ($_SESSION['ivmasters'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$user = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$subloc = !isset($_REQUEST['subloc']) ? '' : $_REQUEST['subloc'];
			$loc_name = !isset($_REQUEST['loc_name']) ? '' : $dbobject->test_input($_REQUEST['loc_name']);
			$item = !isset($_REQUEST['item']) ? '' : $dbobject->test_input($_REQUEST['item']);
			$loccd = !isset($_REQUEST['loccd']) ? '' : $dbobject->test_input($_REQUEST['loccd']);
			$itemdesc = !isset($_REQUEST['itemdesc']) ? '' : $dbobject->test_input($_REQUEST['itemdesc']);
			$subloc = !isset($_REQUEST['subloc']) ? '' : $dbobject->test_input($_REQUEST['subloc']);
			$onhand = !isset($_REQUEST['onhand']) ? 0.00 : $dbobject->test_input($_REQUEST['onhand']);
			$mainstorage = !isset($_REQUEST['mainstorage']) ? "" : $dbobject->test_input($_REQUEST['mainstorage']);
			$selectsubloc = !isset($_REQUEST['selectsubloc']) ? '' : $dbobject->test_input($_REQUEST['selectsubloc']);

			$roleid = !isset($_REQUEST['roleid']) ? 0 : $_REQUEST['roleid'];

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$sql_subloc = "select a.*,b.itemdesc, c.loc_name from itemsubloc a, icitem b, lmf c where trim(a.item) = trim(b.item) and trim(a.loccd) = trim(c.loccd)";
			//echo $sql_subloc;
			$result_subloc = mysqli_query($_SESSION['db_connect'], $sql_subloc);
			$count_subloc = mysqli_num_rows($result_subloc);

			$sql_item = "select item,itemdesc from icitem  where 1=1";
			$result_item = mysqli_query($_SESSION['db_connect'], $sql_item);
			$count_item = mysqli_num_rows($result_item);

			$sql_loccd = "select loccd,loc_name from lmf  where 1=1";
			$result_loccd = mysqli_query($_SESSION['db_connect'], $sql_loccd);
			$count_loccd = mysqli_num_rows($result_loccd);




			if ($op == 'searchkeyword') {

				$filter = " AND trim(a.subloc) = '$keyword' ";


				$sql_Q = "select a.*,b.itemdesc, c.loc_name from itemsubloc a, icitem b, lmf c where trim(a.item) = trim(b.item) and trim(a.loccd) = trim(c.loccd)  ";
				if (strlen($keyword) != 0) {
					$sql_Q = $sql_Q . " and 1 = 1 ";
				} else {
					$sql_Q = $sql_Q . " and 1 = 2 ";
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
					$subloc    = $row['subloc'];
					$loc_name   = $row['loc_name'];
					$loccd   = $row['loccd'];
					$item = $row['item'];
					$itemdesc  = $row['itemdesc'];
					$subloc  = $row['subloc'];
					$onhand  = $row['onhand'];
					$mainstorage  = $row['mainstorage'];
					$selectsubloc = trim($row['subloc']) . "*" . trim($row['loc_name']);
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Sub Location does not exist</strong>");
					</script>
				<?php
				}
			}

			if ($op == 'deletelocation') {
				$goahead = 1;

				if (trim($subloc) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Sub Location ID</strong>");
					</script>
					<?php
				} else {



					if ($onhand > 0) {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>This Sub Location cannot be deleted because it has Stock.</strong>");
						</script>
					<?php }
				}

				if ($goahead == 1) {

					$sql_deletesublocation = " delete from itemsubloc where TRIM(item) = '$item'  
								and TRIM(loccd) = '$loccd' and TRIM(subloc) = '$subloc' and onhand = 0";

					$result_deletesublocation = mysqli_query($_SESSION['db_connect'], $sql_deletesublocation);


					$sql_checkitemloc = " select * from itemsubloc where TRIM(item) = '$item'  
								and TRIM(loccd) = '$loccd' ";

					$result_checkitemloc = mysqli_query($_SESSION['db_connect'], $sql_checkitemloc);
					$count_checkitemloc = mysqli_num_rows($result_checkitemloc);

					if ($count_checkitemloc == 0) {
						$sql_deleteitemloc = " delete from itemloc where TRIM(item) = '$item'  
								and TRIM(loccd) = '$loccd' ";

						$result_deleteitemloc = mysqli_query($_SESSION['db_connect'], $sql_deleteitemloc);
					}



					$dbobject->apptrail($user, 'Sub Location', $subloc, date('d/m/Y H:i:s A'), 'Deleted');

					?>
					<script>
						$('#item_error').html("<strong>Sub Inventory Location Record Deleted</strong>");
					</script>
				<?php

				}
			}



			if ($op == 'saving') {

				$goahead = 1;

				if (trim($subloc) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Sub Inventory Location ID</strong>");
					</script>
				<?php }



				if (trim($_REQUEST['item']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Item</strong>");
					</script>
				<?php
				}
				if (trim($_REQUEST['loccd']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Location Code</strong>");
					</script>
				<?php
				}

				if (trim($_REQUEST['mainstorage']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Main Storage</strong>");
					</script>
				<?php
				}





				//echo $goahead;
				if ($goahead == 1) {

					$sql_Checkitemloc = " select * from itemloc where TRIM(item) = '$item'  
								and TRIM(loccd) = '$loccd' ";

					$result_Checkitemloc = mysqli_query($_SESSION['db_connect'], $sql_Checkitemloc);
					$count_Checkitemloc = mysqli_num_rows($result_Checkitemloc);

					if ($count_Checkitemloc == 0) {
						$sql_Insertitemloc = " insert into itemloc ( item, loccd ) 
									values ('$item', '$loccd' ) ";

						$result_Insertitemloc = mysqli_query($_SESSION['db_connect'], $sql_Insertitemloc);
					}

					$sql_checksubloc = "SELECT * FROM itemsubloc where upper(trim(subloc)) = upper('$subloc') ";
					$result_checksubloc = mysqli_query($_SESSION['db_connect'], $sql_checksubloc);
					$count_checksubloc = mysqli_num_rows($result_checksubloc);

					if ($count_checksubloc > 0) {
						$sql_savesubloc = " update itemsubloc set 
								 loccd = '$loccd', 
								 item  = '$item', 
								 mainstorage  = ucase('$mainstorage') 
								 where trim(subloc) = '$subloc'";

						$dbobject->apptrail($user, 'Sub Location', $subloc, date('d/m/Y H:i:s A'), 'Modified');
					} else {
						$sql_savesubloc = " insert into itemsubloc ( subloc, loccd,item,mainstorage  ) 
								 values ('$subloc', '$loccd' , '$item', ucase('$mainstorage') ) ";

						$dbobject->apptrail($user, 'Sub Location', $subloc, date('d/m/Y H:i:s A'), 'Created');
					}
					$result_savesubloc = mysqli_query($_SESSION['db_connect'], $sql_savesubloc);
					//echo $sql_savesubloc;



				?>
					<script>
						$('#item_error').html("<strong>Sub inventory Location Record Saved</strong>");
					</script>
			<?php

				}
			}
			//****			


			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="sublocation" />
			<input type="hidden" name="get_file" id="get_file" value="itematsublocation" />

			<table border="0" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="input-group">
							<b>Search by: <i>Name or Code</i> </b>&nbsp;
							<input type="text" size="35px" id="search" placeholder="Search for Sub Location" />
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
							<b>Sub Location ID : </b>
						</td>
						<td>
							<input type="text" name="subloc" id="subloc" value="<?php echo $subloc; ?>" <?php if ($subloc != '') {
																											echo 'readonly';
																										} ?> placeholder="Enter Sub Location ID" />
						</td>

					</tr>

					<tr>
						<td>
							<b>Inventory Location : </b>
						</td>
						<td>
							<?php
							$k = 0;
							?>
							<select name="selectloccd" id="selectloccd">
								<option value=""></option>
								<?php

								while ($k < $count_loccd) {
									$row = mysqli_fetch_array($result_loccd);

								?>
									<option value="<?php echo trim($row['loccd']); ?>" <?php echo ($loccd == trim($row['loccd']) ? "selected" : ""); ?>>
										<?php echo trim($row['loc_name']); ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>
						</td>

					</tr>
					<tr>
						<td>
							<b>Item : </b>
						</td>
						<td>
							<?php
							$k = 0;
							?>
							<select name="selectitem" id="selectitem">
								<option value=""></option>
								<?php

								while ($k < $count_item) {
									$row = mysqli_fetch_array($result_item);

								?>
									<option value="<?php echo trim($row['item']); ?>" <?php echo ($item == trim($row['item']) ? "selected" : ""); ?>>
										<?php echo trim($row['itemdesc']); ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>
						</td>

					</tr>
					<tr>
						<td><b>Main Storage Name: </b></td>
						<td> <input type="text" id="mainstorage" placeholder="e.g. TANK1" title="Main Storage Name e.g. TANK1" value="<?php echo $mainstorage; ?>" /></td>

					</tr>
					<tr>
						<td><b>Stock Level: </b></td>
						<td align="center"><?php echo number_format($onhand, 2); ?> <input type="hidden" id="onhand" value="<?php echo $onhand; ?>" /></td>

					</tr>
				</table>
				<table>

					<tr>

						<td>

							<input type="button" name="refreshbutton" id="submit-button" value="Refresh" onclick="javascript:  getpage('itematsublocation.php?','page');" />

						</td>
						<td>

							<input type="button" name="deletebutton" id="submit-button" value="Delete" onclick="deletelocation();" />

						</td>

						<td>

							<input type="button" name="savebutton" id="submit-button" value="Save" onclick="savelocation();" />

						</td>

					</tr>

				</table>
			</div>

		<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('inventory.php?','page');
							">
	<br />
</div>

<script>
	function savelocation() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_loccd = $('#selectloccd').val();
			$form_subloc = $('#subloc').val();
			var $form_item = $('#selectitem').val();
			var $mainstorage = $('#mainstorage').val();


			var $goahead = 1;

			if ($form_subloc == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Sub Inventory Location ID ");
			}
			if ($form_loccd == '') {
				$goahead = $goahead * 0;
				alert("Please Specify Inventory Location");
			}
			if ($form_item == '') {
				$goahead = $goahead * 0;
				alert("Please Specify the Item");
			}
			if ($mainstorage == '') {
				$goahead = $goahead * 0;
				alert("Please Specify the Main Storage Name");
			}


			if ($goahead == 1) {
				getpage('itematsublocation.php?op=saving&subloc=' + $form_subloc +
					'&loccd=' + $form_loccd + '&mainstorage=' + $mainstorage +
					'&item=' + $form_item, 'page');
			}

		}
	}


	function deletelocation() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_loccd = $('#selectloccd').val();
			$form_subloc = $('#subloc').val();
			var $form_item = $('#selectitem').val();
			var $form_onhand = $('#onhand').val();


			var $goahead = 1;

			if ($form_subloc == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Sub Inventory Location ID ");
			}


			if (Number($form_onhand > 0)) {
				$goahead = $goahead * 0;
				alert("This Sub Inventory Location Cannot be deleted. ");
			}

			if ($goahead == 1) {
				getpage('itematsublocation.php?op=deletelocation&subloc=' + $form_subloc +
					'&onhand=' + $form_onhand + '&loccd=' + $form_loccd +
					'&item=' + $form_item, 'page');
			}

		}
	}
</script>