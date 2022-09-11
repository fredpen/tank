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
				Item Master
			</strong></h3>
		<?php
		if ($_SESSION['ivmasters'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$user = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$item = !isset($_REQUEST['item']) ? '' : $_REQUEST['item'];
			$itemdesc = !isset($_REQUEST['itemdesc']) ? '' : $dbobject->test_input($_REQUEST['itemdesc']);
			$unitofmeasure = !isset($_REQUEST['unitofmeasure']) ? '' : $dbobject->test_input($_REQUEST['unitofmeasure']);
			$itemtype = !isset($_REQUEST['itemtype']) ? '' : $dbobject->test_input($_REQUEST['itemtype']);
			$chartcode = !isset($_REQUEST['chartcode']) ? '' : $dbobject->test_input($_REQUEST['chartcode']);
			$description = !isset($_REQUEST['description']) ? '' : $dbobject->test_input($_REQUEST['description']);
			$volfactor = !isset($_REQUEST['volfactor']) ? '' : $dbobject->test_input($_REQUEST['volfactor']);
			$pack = !isset($_REQUEST['pack']) ? '' : $dbobject->test_input($_REQUEST['pack']);
			$reqst_by = $_SESSION['username_sess'];
			$selectitem = !isset($_REQUEST['selectitem']) ? '' : $dbobject->test_input($_REQUEST['selectitem']);


			$roleid = !isset($_REQUEST['roleid']) ? 0 : $_REQUEST['roleid'];

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$sql_item = "select distinct * FROM icitem WHERE 1=1 order by itemdesc";
			$result_item = mysqli_query($_SESSION['db_connect'], $sql_item);
			$count_item = mysqli_num_rows($result_item);

			$sql_chart_of_account = "select * from chart_of_account where TRIM(UCASE(description)) like '%INVENTORY%' ";
			$result_chart_of_account = mysqli_query($_SESSION['db_connect'], $sql_chart_of_account);
			$count_chart_of_account = mysqli_num_rows($result_chart_of_account);


			if ($op == 'getselectitem') {
				$filter = "";

				$sql_Q = "SELECT * FROM icitem where  ";
				$item = '';
				if (trim($selectitem) <> '') {
					//echo $selectitem;
					$itemdetails = explode("*", $selectitem);
					$item = $itemdetails[0];
				}

				$filter = "  upper(trim(item)) = upper('$item')  ";



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
					$item    = $row['item'];
					$itemdesc   = $row['itemdesc'];
					$unitofmeasure = $row['unitofmeasure'];
					$pack = $row['pack'];
					$itemtype  = $row['itemtype'];
					$chartcode  = $row['chartcode'];
					$description  = $row['description'];
					$volfactor  = $row['volfactor'];

					$selectitem = trim($row['item']) . "*" . trim($row['itemdesc']);
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Item does not exist</strong>");
					</script>
				<?php
				}
			}




			if ($op == 'searchkeyword') {

				$filter = " AND trim(item) like '%$keyword%'   ";


				$sql_Q = "SELECT * FROM icitem where ";
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
					$item    = $row['item'];
					$itemdesc   = $row['itemdesc'];
					$unitofmeasure = $row['unitofmeasure'];
					$pack = $row['pack'];
					$itemtype  = $row['itemtype'];
					$chartcode  = $row['chartcode'];
					$description  = $row['description'];

					$volfactor  = $row['volfactor'];


					$selectitem = trim($row['item']) . "*" . trim($row['itemdesc']);
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Item does not exist</strong>");
					</script>
				<?php
				}
			}

			if ($op == 'deleteitem') {
				$goahead = 1;

				if (trim($item) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Item ID</strong>");
					</script>
					<?php
				} else {

					$sql_checktransaction =  "select * from loadings where trim(item) = '$item'";
					$result_checktransaction = mysqli_query($_SESSION['db_connect'], $sql_checktransaction);
					$count_checktransaction = mysqli_num_rows($result_checktransaction);

					if ($count_checktransaction >= 1) {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>This Item cannot be deleted because it has been used in transactions.</strong>");
						</script>
					<?php }
				}

				if ($goahead == 1) {
					$sql_deleteitem =  "delete from icitem where trim(item) = '$item'";
					$result_deleteitem = mysqli_query($_SESSION['db_connect'], $sql_deleteitem);


					$dbobject->apptrail($user, 'Item Master', $itemdesc, date('d/m/Y H:i:s A'), 'Deleted');
					?>
					<script>
						$('#item_error').html("<strong>Customer Record Deleted</strong>");
					</script>
				<?php

				}
			}



			if ($op == 'saving') {

				$goahead = 1;

				if (trim($item) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Item ID</strong>");
					</script>
				<?php }


				if (trim($_REQUEST['itemdesc']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Item Description</strong>");
					</script>
				<?php }




				if (trim($_REQUEST['volfactor']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the volume Factor</strong>");
					</script>
				<?php }

				if (trim($_REQUEST['itemtype']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Item Type</strong>");
					</script>
				<?php
				}

				if (trim($_REQUEST['unitofmeasure']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Unit of Measurement</strong>");
					</script>
				<?php
				}

				if (empty($pack)) {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>pack is required</strong>");
					</script>
				<?php
				}

				if (empty($chartcode)) {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Material Account is required</strong>");
					</script>
				<?php
				}


				//echo $goahead;
				if ($goahead == 1) {

					$sql_checkIcitem = "SELECT * FROM icitem where upper(trim(item)) = upper('$item') ";
					$result_checkIcitem = mysqli_query($_SESSION['db_connect'], $sql_checkIcitem);
					$count_checkIcitem = mysqli_num_rows($result_checkIcitem);

					if ($count_checkIcitem > 0) {
						$sql_saveIcitem = " update icitem set 
								 itemdesc = '$itemdesc', 
								 volfactor  = '$volfactor', 
								 unitofmeasure  = '$unitofmeasure', 
								 itemtype  = '$itemtype', 
								 pack  = '$pack',  
								 chartcode = '$chartcode', 
								 description  = '$description' where trim(item) = '$item'";

						$dbobject->apptrail($user, 'Item Master', $itemdesc, date('d/m/Y H:i:s A'), 'Created');
					} else {
						$sql_saveIcitem = " insert into icitem (  
								item, itemdesc, volfactor, unitofmeasure, 
								pack, itemtype, chartcode, description ) 
								 values ('$item', '$itemdesc' , '$volfactor', '$unitofmeasure',  '$pack', 
								 '$itemtype' , '$chartcode', '$description') ";

						$dbobject->apptrail($user, 'Item Master', $itemdesc, date('d/m/Y H:i:s A'), 'Modified');
					}
					$result_saveIcitem = mysqli_query($_SESSION['db_connect'], $sql_saveIcitem);



				?>
					<script>
						$('#item_error').html("<strong>Item Record Saved</strong>");
					</script>
			<?php

				}
			}

			$selectedchart = trim($chartcode) . "*" . trim($description);
			//echo $selectedchart;

			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="item" />
			<input type="hidden" name="get_file" id="get_file" value="item_master" />
			<table border="0" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="input-group">
							<b>Search by: <i>Name or Code</i> </b>&nbsp;
							<input type="text" size="35px" id="search" placeholder="Search for Product" />
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
						<td nowrap="nowrap">
							<b>Item ID : </b>
						</td>
						<td colspan="2">
							<input type="text" name="item" id="item" value="<?php echo $item; ?>" <?php if ($item != '') {
																										echo "style='color:'";
																										echo 'readonly';
																									} ?> placeholder="Enter Item ID" />
						</td>
						<td>

							<input type="button" name="refreshbutton" id="submit-button" value="Refresh" onclick="javascript:  getpage('item_master.php?','page');" />

						</td>


					</tr>
					<tr>

						<td>
							<b>Item Description : </b>
						</td>
						<td colspan="3">
							<input type="text" size="50%" name="itemdesc" id="itemdesc" value="<?php echo $itemdesc; ?>" placeholder="Enter Item Description" />
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<b>Volume Factor: </b>

							<input type="number" name="volfactor" id="volfactor" value="<?php echo $volfactor; ?>" placeholder="Enter Volume Factor" />
						</td>
						<td colspan="2">
							<b>Unit of Measure : </b>
							&nbsp;&nbsp;
							<select name="unitofmeasure" id="unitofmeasure">
								<option></option>
								<option value="Kilogram" <?php echo ($unitofmeasure == 'Kilogram' ? "selected" : ""); ?>>Kilogram</option>
								<option value="Litres" <?php echo ($unitofmeasure == 'Litres' ? "selected" : ""); ?>>Litres</option>
								<option value="Each" <?php echo ($unitofmeasure == 'Each' ? "selected" : ""); ?>>Each</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<b>Item Type : </b>
						</td>
						<td>
							<input type="text" name="itemtype" id="itemtype" size="5px" value="<?php echo $itemtype; ?>" placeholder="Enter Item Type" />
						</td>
						<td>
							<b>Package Type : </b>
						</td>
						<td>
							<input type="pack" name="pack" id="pack" value="<?php echo $pack; ?>" size="5px" placeholder="Enter Packaging Type " />
						</td>
					</tr>
					<tr>

						<td align="center" colspan="4">
							<b>Material Account: </b>
							<?php
							$k = 0;
							?>
							<select name="selectedchart" id="selectedchart" onChange="javascript: getchartdescription();">
								<option value=""></option>
								<?php

								while ($k < $count_chart_of_account) {
									$row = mysqli_fetch_array($result_chart_of_account);
									$theselectedchart = trim($row['chartcode']) . "*" . trim($row['description']);
								?>
									<option value="<?php echo $theselectedchart; ?>" <?php echo ($selectedchart == $theselectedchart ? "selected" : ""); ?>>
										<?php echo $theselectedchart; ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>



							<input type="hidden" name="chartcode" id="chartcode" value="<?php echo $chartcode; ?>" readonly />
							<input type="hidden" name="description" id="description" value="<?php echo $description; ?>" readonly />
						</td>

					</tr>

				</table>

				<table>

					<tr>

						<td nowrap="nowrap">

							<input type="button" name="itemsetting" id="submit-button" value="Item Setting" onclick="javascript:  getpage('item_settings.php?','page');">

						</td>
						<td nowrap="nowrap">

							<input type="button" name="spedisc" id="submit-button" value="Item Pricing" onclick="javascript:  getpage('item_pricing.php?','page');">

						</td>

						<td>

							<input type="button" name="deletebutton" id="submit-button" value="Delete" onclick="deleteitem();" />

						</td>

						<td>

							<input type="button" name="savebutton" id="submit-button" value="Save" onclick="saveicitem();" />

						</td>

					</tr>

				</table>
			</div>

		<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('inventory.php?','page');" />
	<br />

</div>

<script>
	function getchartdescription() {
		var x = $('#selectedchart').val();

		if (x != '') {

			const myArrayOfChart = x.split("*");
			var $form_chartcode = myArrayOfChart[0];
			var $form_description = myArrayOfChart[1];
			document.getElementById("chartcode").value = $form_chartcode;
			document.getElementById("description").value = $form_description;
		} else {
			document.getElementById("chartcode").value = "";
			document.getElementById("description").value = "";
		}

	}



	function specialdisc() {
		var $form_item = $('#item').val();
		var $goahead = 1;

		if ($form_item.trim() == '') {
			$goahead = $goahead * 0;
			alert("Please Enter Customer ID ");
		}
	}

	function saveicitem() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_item = $('#item').val();
			$form_itemtype = $('#itemtype').val();
			var $form_itemdesc = $('#itemdesc').val();

			var $form_chartcode = $('#chartcode').val();
			var $form_pack = $('#pack').val();
			var $form_description = $('#description').val();

			var $form_volfactor = $('#volfactor').val();
			var $form_unitofmeasure = $('#unitofmeasure').val();

			var $goahead = 1;

			if ($form_item.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Item ID ");
			}

			if ($form_itemdesc.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Item Name ");
			}

			if ($form_itemtype.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please specify the Item Type");
			}


			if ($form_unitofmeasure == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Unit of measurement");
			}

			if ($form_volfactor == '') {
				$goahead = $goahead * 0;
				alert("Please Enter a volume factor");
			}

			if ($form_chartcode == '') {
				$goahead = $goahead * 0;
				alert("Please Select Material Account");
			}

			if ($form_pack == '') {
				$goahead = $goahead * 0;
				alert("Please Enter pack");
			}


			if ($goahead == 1) {
				thegetpage = 'item_master.php?op=saving&item=' + $form_item +
					'&itemdesc=' + $form_itemdesc +
					'&volfactor=' + $form_volfactor + '&unitofmeasure=' + $form_unitofmeasure + '&itemtype=' + $form_itemtype + '&chartcode=' + $form_chartcode +
					'&pack=' + $form_pack +
					'&description=' + $form_description + '&pack=' + $form_pack;
				//alert(thegetpage);	
				getpage(thegetpage, 'page');
			}

		}
	}


	function deleteitem() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_item = $('#item').val();
			$form_itemtype = $('#itemtype').val();
			var $form_itemdesc = $('#itemdesc').val();
			var $form_chartcode = $('#chartcode').val();
			var $form_pack = $('#pack').val();
			var $form_description = $('#description').val();
			var $form_volfactor = $('#volfactor').val();
			var $form_unitofmeasure = $('#unitofmeasure').val();



			var $goahead = 1;

			if ($form_item == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Customer ID ");
			}


			if ($goahead == 1) {

				getpage('item_master.php?op=deleteitem&item=' + $form_item +
					'&itemdesc=' + $form_itemdesc +
					'&volfactor=' + $form_volfactor + '&unitofmeasure=' + $form_unitofmeasure + '&pack=' + $form_pack + '&chartcode=' + $form_chartcode +
					'&description=' + $form_description + '&pack=' + $form_pack, 'page');
			}

		}
	}


	function IsValidpack(pack) {
		var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		return expr.test(pack);
	}
</script>