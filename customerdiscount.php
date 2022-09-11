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

	<?php
	require_once("lib/mfbconnect.php");
	?>



	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong>
				Customer Specific Discount
			</strong></h3>
		<?php
		if ($_SESSION['somasters'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$user = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $dbobject->test_input($_REQUEST['op']);
			$item = !isset($_REQUEST['item']) ? '' : $dbobject->test_input($_REQUEST['item']);
			$itemdesc = !isset($_REQUEST['itemdesc']) ? '' : $dbobject->test_input($_REQUEST['itemdesc']);

			if (isset($_REQUEST['custno'])) {
				$custno = $dbobject->test_input($_REQUEST['custno']);
				$company = $dbobject->test_input($_REQUEST['company']);
				$_SESSION['custno'] = $custno;
				$_SESSION['company'] = $company;
			} elseif (isset($_SESSION['custno'])) {
				$custno = $_SESSION['custno'];
				$company = $_SESSION['company'];
			} else {
				$custno = '';
				$company = '';
			}

			$vat = !isset($_REQUEST['vat']) ? 0 : $dbobject->test_input($_REQUEST['vat']);
			$disctype = !isset($_REQUEST['disctype']) ? 1 : $dbobject->test_input($_REQUEST['disctype']);
			$srvchg = !isset($_REQUEST['srvchg']) ? 0 : $dbobject->test_input($_REQUEST['srvchg']);
			$nfr = !isset($_REQUEST['nfr']) ? 0.00 : $dbobject->test_input($_REQUEST['nfr']);
			$dmargin = !isset($_REQUEST['dmargin']) ? 0.00 : $dbobject->test_input($_REQUEST['dmargin']);
			$misc = !isset($_REQUEST['misc']) ? 0.00 : $dbobject->test_input($_REQUEST['misc']);
			$slabid = !isset($_REQUEST['slabid']) ? '' : $dbobject->test_input($_REQUEST['slabid']);
			$netprice = !isset($_REQUEST['netprice']) ? 0.00 : $dbobject->test_input($_REQUEST['netprice']);
			$otprice = !isset($_REQUEST['otprice']) ? 0.00 : $dbobject->test_input($_REQUEST['otprice']);
			$selectitem = !isset($_REQUEST['selectitem']) ? '' : $dbobject->test_input($_REQUEST['selectitem']);


			$roleid = !isset($_REQUEST['roleid']) ? 0 : $_REQUEST['roleid'];

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$slabdef_var = array();
			$sql_slabdef = "select distinct * FROM slabdef WHERE 1=1 order by trim(slabdesc)";
			$result_slabdef = mysqli_query($_SESSION['db_connect'], $sql_slabdef);
			$count_slabdef = mysqli_num_rows($result_slabdef);

			$k = 0;
			while ($k < $count_slabdef) {
				$row = mysqli_fetch_array($result_slabdef);
				$slabdef_var[$k]['slabid'] = $row['slabid'];
				$slabdef_var[$k]['slabdesc'] = $row['slabdesc'];

				$k++;
			}

			$sql_item = "select distinct * FROM icitem WHERE 1=1 order by itemdesc";
			$result_item = mysqli_query($_SESSION['db_connect'], $sql_item);
			$count_item = mysqli_num_rows($result_item);



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

				if ($count_QueryStmt > 0) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$item    = $row['item'];
					$itemdesc   = $row['itemdesc'];
					$otprice   = $row['otprice'];
					$selectitem = trim($row['item']) . "*" . trim($row['itemdesc']);

					$sql_custpric = "select * from custpric where trim(custno)= '$custno' and trim(item)= '$item'";
					$result_custpric = mysqli_query($_SESSION['db_connect'], $sql_custpric);
					$count_custpric = mysqli_num_rows($result_custpric);
					if ($count_custpric > 0) {
						$row  = mysqli_fetch_array($result_custpric);

						$srvchg  = $row['srvchg'];
						$nfr  = $row['nfr'];
						$dmargin  = $row['dmargin'];
						$disctype  = $row['disctype'];
						$misc  = $row['misc'];
						$slabid  = $row['slabid'];
						$vat  = $row['vat'];
					}
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
					$otprice   = $row['otprice'];
					$selectitem = trim($row['item']) . "*" . trim($row['itemdesc']);

					$sql_custpric = "select * from custpric where trim(custno)= '$custno' and trim(item)= '$item'";
					$result_custpric = mysqli_query($_SESSION['db_connect'], $sql_custpric);
					$count_custpric = mysqli_num_rows($result_custpric);
					if ($count_custpric > 0) {
						$row  = mysqli_fetch_array($result_custpric);

						$srvchg  = $row['srvchg'];
						$nfr  = $row['nfr'];
						$dmargin  = $row['dmargin'];
						$disctype  = $row['disctype'];
						$misc  = $row['misc'];
						$slabid  = $row['slabid'];
						$vat  = $row['vat'];
					}
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Item does not exist</strong>");
					</script>
				<?php
				}
			}

			if ($op == 'delete') {

				$goahead = 1;

				if (trim($item) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Item ID</strong>");
					</script>
				<?php }




				//echo $goahead;
				if ($goahead == 1) { {

						$sql_delete_custpric = " delete from custpric 
							where trim(item) = '$item' and trim(custno) = '$custno'";
					}

					$result_delete_custpric = mysqli_query($_SESSION['db_connect'], $sql_delete_custpric);


					$dbobject->apptrail($user, 'Customer Special Discount', $company, date('d/m/Y H:i:s A'), 'Deleted');

				?>
					<script>
						$('#item_error').html("<strong>Customer Specific Discount Record Deleted</strong>");
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




				//echo $goahead;
				if ($goahead == 1) {
					$sql_custpric = "select * from custpric where trim(custno)= '$custno' and trim(item)= '$item'";
					$result_custpric = mysqli_query($_SESSION['db_connect'], $sql_custpric);
					$count_custpric = mysqli_num_rows($result_custpric);
					if ($count_custpric > 0) {

						$sql_save_custpric = " update custpric set 
										 srvchg  = $srvchg ,
										 nfr  = $nfr ,
										 disctype  = $disctype ,
										 dmargin  = $dmargin ,
										 misc  = $misc ,
										 vat  = $vat ,
										 slabid  = '$slabid' 
										 where trim(item) = '$item' and trim(custno) = '$custno'";

						$dbobject->apptrail($user, 'Customer Special Discount', $company, date('d/m/Y H:i:s A'), 'Modified');
					} else {
						$sql_save_custpric = " insert into custpric (custno, item, srvchg,dmargin, nfr,misc, vat,slabid,disctype )  
									  values ( '$custno','$item',$srvchg,$dmargin, $nfr, $misc, $vat,'$slabid',$disctype ) ";

						$dbobject->apptrail($user, 'Customer Special Discount', $company, date('d/m/Y H:i:s A'), 'Created');
					}
					$result_save_custpric = mysqli_query($_SESSION['db_connect'], $sql_save_custpric);


				?>
					<script>
						$('#item_error').html("<strong>Customer Specific Discount Record Saved</strong>");
					</script>
			<?php

				}
			}

			$holdmargin = $otprice + $srvchg - $dmargin + $nfr + $misc;
			$netprice = (($vat * $holdmargin) / 100) +  $holdmargin;
			//echo $selectedchart;

			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
			<input type="hidden" name="company" id="company" value="<?php echo $company; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="item" />
			<input type="hidden" name="get_file" id="get_file" value="customerdiscount" />

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
						<td colspan="4">
							<h3>
								<b>Customer ID : </b>
								&nbsp;&nbsp;<?php echo $custno; ?>

								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Customer Name : </b>&nbsp;&nbsp;
								<?php echo $company; ?>
							</h3>
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap">
							<b>Item ID : </b>
						</td>
						<td colspan="3">
							<?php echo $item; ?> <input type="hidden" name="item" id="item" value="<?php echo $item; ?>" />
						</td>



					</tr>
					<tr>

						<td>
							<b>Item Description : </b>
						</td>
						<td colspan="3">
							<?php echo $itemdesc; ?> <input type="hidden" name="itemdesc" id="itemdesc" value="<?php echo $itemdesc; ?>" />
						</td>

					</tr>
				</table>
				<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
					<tr>
						<td align="center">


							<input type="radio" name="disctype" id="cshflat" <?php if ($disctype == 1) {
																					echo 'checked';
																				} ?> onClick="javascript: disctyperefresh(this.id);" />&nbsp;&nbsp;Flat Discount
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="disctype" id="cshslab" <?php if ($disctype == 2) {
																					echo 'checked';
																				} ?> onClick="javascript: disctyperefresh(this.id);" />&nbsp;&nbsp;Slab Discount

						</td>


					</tr>
				</table>
				<div id="showflatdiv" <?php if ($disctype != 1) {
											echo 'style="display:none"';
										} ?>>
					<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
						<tr>
							<td>
								<b>Service Charge</b>
							</td>
							<td>
								<input type="number" id="srvchg" name="srvchg" value="<?php echo $srvchg; ?>" min="0" max="999999" onChange="javascript: refreshoption(); " />

							</td>
							<td>
								<b>Non Fuel Retail</b>
							</td>
							<td>
								<input type="number" id="nfr" name="nfr" value="<?php echo $nfr; ?>" min="0" max="999999" onChange="javascript: refreshoption(); " />

							</td>
						</tr>
						<tr>
							<td>
								<b>Margin</b>
							</td>
							<td>
								<input type="number" id="dmargin" name="dmargin" value="<?php echo $dmargin; ?>" min="0" max="999999" onChange="javascript: refreshoption();" />

							</td>
							<td>
								<b>Misc Charges</b>
							</td>
							<td>
								<input type="number" id="misc" name="misc" value="<?php echo $misc; ?>" min="0" max="999999" onChange="javascript: refreshoption(); " />

							</td>
						</tr>
						<tr>
							<td>
								<b>Vat</b>
							<td>
								<input type="number" id="vat" name="vat" value="<?php echo number_format($vat, 2); ?>" min="0" max="999999" onChange="javascript: refreshoption(); " />

							</td>
							<td>
								<b>Default Base Price</b><br />
								<b>Net Price</b>
							<td>
								<?php echo number_format($otprice, 2); ?> <input type="hidden" id="otprice" value="<?php echo number_format($otprice, 2); ?>" />
								<br />
								<input id="netprice" title="netprice = Base Price + Service Charge - Dealer Margin + Non Fuel Retail + Miscellaneous plus vat value" style="background-color:lightgray" type="number" name="netprice" value="<?php echo $netprice; ?>" readonly min="0" max="999999" />

							</td>
						</tr>
					</table>
				</div>
				<div id="showslabdiv" <?php if ($disctype != 2) {
											echo 'style="display:none"';
										} ?>>
					<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">


						<tr>
							<td>
								<b>Please Select Discount Slab Definition</b>
							</td>
							<td>
								<?php
								$k = 0;
								?>

								<select name="slabid" id="slabid">
									<option value=""></option>
									<?php

									while ($k < $count_slabdef) {


									?>
										<option value="<?php echo trim($slabdef_var[$k]['slabid']); ?>" <?php echo ($slabid == trim($slabdef_var[$k]['slabid']) ? "selected" : ""); ?>>
											<?php echo trim($slabdef_var[$k]['slabdesc']); ?>
										</option>

									<?php
										$k++;
									} //End If Result Test	
									?>
								</select>
							</td>
						</tr>


					</table>
				</div>
				<table>

					<tr>


						<td>

							<input type="button" name="refreshbutton" id="submit-button" value="Refresh" onclick="javascript: var $form_custno = $('#custno').val();var $form_company = $('#company').val();
						getpage('customerdiscount.php?&custno='+$form_custno+'&company='+$form_company,'page');" />

						</td>
						<td>
							<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('customers.php?','page');" />
						</td>

						<td>

							<input type="button" name="savebutton" id="submit-button" value="Save" onclick="savecustomerdiscount('save');" />

						</td>

						<td>

							<input type="button" name="deletebutton" id="submit-button" value="Delete" onclick="savecustomerdiscount('del');" />

						</td>
					</tr>

				</table>
			</div>

		<?php } ?>
	</form>
</div>

<script>
	function disctyperefresh(id) {


		var flatdiscount = document.getElementById('showflatdiv');
		var slabdiscount = document.getElementById('showslabdiv');

		if (id == "cshflat") {
			flatdiscount.style.display = "block";
			slabdiscount.style.display = "none";
		} else {
			flatdiscount.style.display = "none";
			slabdiscount.style.display = "block";
		}

	}

	function refreshoption() {
		var nfr = document.getElementById('nfr').value;
		var misc = document.getElementById('misc').value;
		var dmargin = document.getElementById('dmargin').value;
		var srvchg = document.getElementById('srvchg').value;
		var otprice = document.getElementById('otprice').value;
		var vat = document.getElementById('vat').value;
		var holdmargin = 0;
		var netprice = document.getElementById('netprice');


		holdmargin = Number(otprice) + Number(srvchg) - Number(dmargin) + Number(nfr) + Number(misc);
		netprice.value = ((Number(vat) * Number(holdmargin)) / 100) + Number(holdmargin);


	}


	function savecustomerdiscount(action) {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_item = $('#item').val();
			$form_custno = $('#custno').val();
			var $form_company = $('#company').val();
			var $form_itemdesc = $('#itemdesc').val();
			var $form_vat = $('#vat').val();
			var $form_srvchg = $('#srvchg').val();
			var $form_nfr = $('#nfr').val();
			var $form_dmargin = $('#dmargin').val();
			var $form_misc = $('#misc').val();
			var $form_slabid = $('#slabid').val();
			var $form_otprice = $('#otprice').val();

			var radiodisctype = document.getElementsByName('disctype');


			var $disctype = 0;
			for (i = 0; i < 2; i++) {
				if (radiodisctype[i].checked) {
					if (i == 0) {
						$disctype = 1;
					} else {
						$disctype = 2;
					}
				}



			}

			var $goahead = 1;

			if ($form_item.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Item ID ");
			}




			if ($goahead == 1) {
				if (action == 'save') {
					thegetpage = 'customerdiscount.php?op=saving&item=' + $form_item +
						'&custno=' + $form_custno + '&itemdesc=' + $form_itemdesc +
						'&company=' + $form_company +
						'&srvchg=' + $form_srvchg +
						'&nfr=' + $form_nfr + '&vat=' + $form_vat +
						'&dmargin=' + $form_dmargin + '&otprice=' + $form_otprice +
						'&disctype=' + $disctype + '&misc=' + $form_misc + '&slabid=' + $form_slabid;
				} else {
					thegetpage = 'customerdiscount.php?op=delete&item=' + $form_item +
						'&custno=' + $form_custno + '&itemdesc=' + $form_itemdesc +
						'&company=' + $form_company +
						'&srvchg=' + $form_srvchg +
						'&nfr=' + $form_nfr + '&vat=' + $form_vat +
						'&dmargin=' + $form_dmargin + '&otprice=' + $form_otprice +
						'&disctype=' + $disctype + '&misc=' + $form_misc + '&slabid=' + $form_slabid;
					//alert(thegetpage);					
				}

				getpage(thegetpage, 'page');
			}

		}
	}
</script>