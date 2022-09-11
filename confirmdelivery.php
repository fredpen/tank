<?php
ob_start();
include_once "session_track.php";
?>


<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align="center" id="data-form">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">

	<?php
	require_once("lib/mfbconnect.php");

	?>

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1" novalidate>
		<h3><strong>
				Confirm Delivery
			</strong></h3>
		<?php
		if ($_SESSION['delivery'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$branch_code = "";
			$periodyear = $_SESSION['periodyear'];
			$periodmonth = $_SESSION['periodmonth'];
			$reqst_by = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$request = !isset($_REQUEST['request']) ? '' : $_REQUEST['request'];
			$company = !isset($_REQUEST['company']) ? '' : $_REQUEST['company'];
			$custno = !isset($_REQUEST['custno']) ? '' : $dbobject->test_input($_REQUEST['custno']);
			$ccompany = !isset($_REQUEST['ccompany']) ? '' : $dbobject->test_input($_REQUEST['ccompany']);
			$vehcno = !isset($_REQUEST['vehcno']) ? '' : $dbobject->test_input($_REQUEST['vehcno']);
			$slip_no = !isset($_REQUEST['slip_no']) ? '' : $dbobject->test_input($_REQUEST['slip_no']);
			$drivername = !isset($_REQUEST['drivername']) ? '' : $dbobject->test_input($_REQUEST['drivername']);
			$fieldtosearch = !isset($_REQUEST['fieldtosearch']) ? '' : $dbobject->test_input($_REQUEST['fieldtosearch']);
			$lookfor = !isset($_REQUEST['lookfor']) ? '' : $dbobject->test_input($_REQUEST['lookfor']);
			$delv_date  = !isset($_REQUEST['delv_date']) ? date("Y-m-d") : $_REQUEST['delv_date'];
			$reversed = !isset($_REQUEST['reversed']) ? 1 : $dbobject->test_input($_REQUEST['reversed']);
			$invoice_no = '';
			$invoice_dt = '';
			$salespsn = '';
			$deliveryaddress = '';

			$loccd = !isset($_REQUEST['loccd']) ? '' : $dbobject->test_input($_REQUEST['loccd']);
			$loc_name = !isset($_REQUEST['loc_name']) ? '' : $dbobject->test_input($_REQUEST['loc_name']);
			$rcvloc = !isset($_REQUEST['rcvloc']) ? '' : $dbobject->test_input($_REQUEST['rcvloc']);
			$rcv_locnm = !isset($_REQUEST['rcv_locnm']) ? '' : $dbobject->test_input($_REQUEST['rcv_locnm']);
			$item = !isset($_REQUEST['item']) ? '' : $dbobject->test_input($_REQUEST['item']);
			$load_start = !isset($_REQUEST['load_start']) ? '' : $dbobject->test_input($_REQUEST['load_start']);
			$load_end = !isset($_REQUEST['load_end']) ? '' : $dbobject->test_input($_REQUEST['load_end']);
			$subloc = !isset($_REQUEST['subloc']) ? '' : $dbobject->test_input($_REQUEST['subloc']);
			$rsubloc = !isset($_REQUEST['rsubloc']) ? '' : $dbobject->test_input($_REQUEST['rsubloc']);

			$ull_time = !isset($_REQUEST['ull_time']) ? '' : $dbobject->test_input($_REQUEST['ull_time']);
			$ull_name = !isset($_REQUEST['ull_name']) ? '' : $dbobject->test_input($_REQUEST['ull_name']);
			$seal_no = !isset($_REQUEST['seal_no']) ? '' : $dbobject->test_input($_REQUEST['seal_no']);

			$loadername = !isset($_REQUEST['loadername']) ? '' : $dbobject->test_input($_REQUEST['loadername']);
			$mtr_b4 = !isset($_REQUEST['mtr_b4']) ? 0 : $dbobject->test_input($_REQUEST['mtr_b4']);
			$mtr_after = !isset($_REQUEST['mtr_after']) ? 0 : $dbobject->test_input($_REQUEST['mtr_after']);
			$vol1 = !isset($_REQUEST['vol1']) ? 0 : $dbobject->test_input($_REQUEST['vol1']);
			$vol2 = !isset($_REQUEST['vol2']) ? 0 : $dbobject->test_input($_REQUEST['vol2']);
			$vol3 = !isset($_REQUEST['vol3']) ? 0 : $dbobject->test_input($_REQUEST['vol3']);
			$vol4 = !isset($_REQUEST['vol4']) ? 0 : $dbobject->test_input($_REQUEST['vol4']);
			$vol5 = !isset($_REQUEST['vol5']) ? 0 : $dbobject->test_input($_REQUEST['vol5']);
			$vol6 = !isset($_REQUEST['vol6']) ? 0 : $dbobject->test_input($_REQUEST['vol6']);
			$ullage1 = !isset($_REQUEST['ullage1']) ? 0 : $dbobject->test_input($_REQUEST['ullage1']);
			$ullage2 = !isset($_REQUEST['ullage2']) ? 0 : $dbobject->test_input($_REQUEST['ullage2']);
			$ullage3 = !isset($_REQUEST['ullage3']) ? 0 : $dbobject->test_input($_REQUEST['ullage3']);
			$ullage4 = !isset($_REQUEST['ullage4']) ? 0 : $dbobject->test_input($_REQUEST['ullage4']);
			$ullage5 = !isset($_REQUEST['ullage5']) ? 0 : $dbobject->test_input($_REQUEST['ullage5']);
			$ullage6 = !isset($_REQUEST['ullage6']) ? 0 : $dbobject->test_input($_REQUEST['ullage6']);

			$loseal_no1 = !isset($_REQUEST['loseal_no1']) ? 0 : $dbobject->test_input($_REQUEST['loseal_no1']);
			$loseal_no2 = !isset($_REQUEST['loseal_no2']) ? 0 : $dbobject->test_input($_REQUEST['loseal_no2']);
			$loseal_no3 = !isset($_REQUEST['loseal_no3']) ? 0 : $dbobject->test_input($_REQUEST['loseal_no3']);
			$loseal_no4 = !isset($_REQUEST['loseal_no4']) ? 0 : $dbobject->test_input($_REQUEST['loseal_no4']);
			$loseal_no5 = !isset($_REQUEST['loseal_no5']) ? 0 : $dbobject->test_input($_REQUEST['loseal_no5']);
			$loseal_no6 = !isset($_REQUEST['loseal_no6']) ? 0 : $dbobject->test_input($_REQUEST['loseal_no6']);
			$upseal_no1 = !isset($_REQUEST['upseal_no1']) ? 0 : $dbobject->test_input($_REQUEST['upseal_no1']);
			$upseal_no2 = !isset($_REQUEST['upseal_no2']) ? 0 : $dbobject->test_input($_REQUEST['upseal_no2']);
			$upseal_no3 = !isset($_REQUEST['upseal_no3']) ? 0 : $dbobject->test_input($_REQUEST['upseal_no3']);
			$upseal_no4 = !isset($_REQUEST['upseal_no4']) ? 0 : $dbobject->test_input($_REQUEST['upseal_no4']);
			$upseal_no5 = !isset($_REQUEST['upseal_no5']) ? 0 : $dbobject->test_input($_REQUEST['upseal_no5']);
			$upseal_no6 = !isset($_REQUEST['upseal_no6']) ? 0 : $dbobject->test_input($_REQUEST['upseal_no6']);
			$confirmed = !isset($_REQUEST['confirmed']) ? 0 : $dbobject->test_input($_REQUEST['confirmed']);


			$store_qty = !isset($_REQUEST['store_qty']) ? 0 : $dbobject->test_input($_REQUEST['store_qty']);
			$count_products = !isset($_REQUEST['count_products']) ? 0 : $dbobject->test_input($_REQUEST['count_products']);
			$thecount_products = !isset($_REQUEST['thecount_products']) ? 0 : $dbobject->test_input($_REQUEST['thecount_products']);
			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);


			if ($op == 'confirmdelivery') {
				if (trim($keyword) != '') {
					$saverecord = 1;

					$sql_invoiceno = "SELECT a.invoice_no,a.invoice_dt,a.approval1,a.approval,a.custno,a.ccompany, 
						  a.loc_name,a.loccd,a.rcv_locnm,a.rcvloc,a.station,a.deliveryaddress,a.bu,a.mv, 
						  a.vehcno,a.tcompany,b.request,a.prn,a.reversed,a.py, 
						  b.item,b.itemdesc,b.store_qty,b.price,b.disc,b.duprice,b.vatduprice, 
						  b.drivername,b.loadername,b.mtr_b4,b.mtr_after,b.load_start, 
						  b.load_end,b.ull_name,b.ull_time,b.vol1,b.vol2,b.vol3,b.vol4,b.vol5,b.vol6, 
						  b.ullage1,b.ullage2,b.ullage3,b.ullage4,b.ullage5,b.ullage6,b.upseal_no1, b.upseal_no2, b.upseal_no3, b.upseal_no4, b.upseal_no5, b.upseal_no6, 
						  b.loseal_no1, b.loseal_no2, b.loseal_no3, b.loseal_no4, b.loseal_no5, b.loseal_no6, 
						  b.slip_no,b.slip_date,c.contact,c.phone1,c.phone2, c.address1, c.address2 FROM invoice  a,  inv_detl  b,arcust c  
						  WHERE trim(a.slip_no) = trim(b.slip_no) and trim(a.custno) = trim(c.custno)  
						  and TRIM(a.invoice_no) !='' and TRIM(a.slip_no) = '$keyword'";

					//echo $sql_invoiceno	."<br/>";
					$result_invoiceno = mysqli_query($_SESSION['db_connect'], $sql_invoiceno);
					$check_count_products = mysqli_num_rows($result_invoiceno);


					if ($check_count_products != $thecount_products) {
						$saverecord = 0;
		?>
						<script>
							$('#item_error').html("<strong>Something went Wrong. Please try again</strong>");
						</script>
					<?php
					} else {
						for ($i = 0; $i < $check_count_products; $i++) {
							$theitem = $dbobject->test_input($_REQUEST['item' . $i]);
							$thedelv_qty = $dbobject->test_input($_REQUEST['delv_qty' . $i]);
							$thedelv_date = $dbobject->test_input($_REQUEST['delv_date' . $i]);
							$delv_datetosave = substr($thedelv_date, 8, 2) . "/" . substr($thedelv_date, 5, 2) . "/" . substr($thedelv_date, 0, 4);
							$rowmore = mysqli_fetch_array($result_invoiceno);
							$thevehcno = $rowmore['vehcno'];
							$theinvoiceno = $rowmore['invoice_no'];

							$QueryStr = "update inv_detl set delv_qty = $thedelv_qty, delv_date = '$delv_datetosave'  WHERE TRIM(slip_no) = '$keyword' and trim(item) = '$theitem'";
							$result_QueryStr = mysqli_query($_SESSION['db_connect'], $QueryStr);

							$Query_vehicle = "update tbvehc set outstanding = 0, oustanding_doc = '', oustanding_date = ''  WHERE TRIM(vehcno) = '$thevehcno'";
							$result_vehicle = mysqli_query($_SESSION['db_connect'], $Query_vehicle);

							$dbobject->apptrail($reqst_by, 'Confirm Delivery', $theinvoiceno, date('d/m/Y H:i:s A'), 'Delivery Confirmed');

							$confirmed = 1;
						}

						$dbobject->workflow($_SESSION['username_sess'], 'Loading Slip Created, Waybill Generated, Delivery Confirmed', $keyword, date('d/m/Y H:i:s A'), 0, 3, '');
					?>
						<script>
							$('#item_error').html("<strong>Delivery Confirmed</strong>");
						</script>
						<?php

					}
				}
			}

			$invoice_details = array();
			if ($op == 'searchkeyword') {
				if (trim($keyword) != '') {




					$sql_invoiceno = "SELECT a.invoice_no,a.invoice_dt,a.approval1,a.approval,a.custno,a.ccompany, 
						  a.loc_name,a.loccd,a.rcv_locnm,a.rcvloc,a.station,a.deliveryaddress,a.bu,a.mv, 
						  a.vehcno,a.tcompany,b.request,a.prn,a.reversed,a.py, 
						  b.item,b.itemdesc,b.store_qty,b.price,b.disc,b.duprice,b.vatduprice, 
						  b.drivername,b.loadername,b.mtr_b4,b.mtr_after,b.load_start,b.delv_qty, b.delv_date,
						  b.load_end,b.ull_name,b.ull_time,b.vol1,b.vol2,b.vol3,b.vol4,b.vol5,b.vol6, 
						  b.ullage1,b.ullage2,b.ullage3,b.ullage4,b.ullage5,b.ullage6,b.upseal_no1, b.upseal_no2, b.upseal_no3, b.upseal_no4, b.upseal_no5, b.upseal_no6, 
						  b.loseal_no1, b.loseal_no2, b.loseal_no3, b.loseal_no4, b.loseal_no5, b.loseal_no6, 
						  b.slip_no,b.slip_date,c.contact,c.phone1,c.phone2, c.address1, c.address2 FROM invoice  a,  inv_detl  b,arcust c  
						  WHERE trim(a.slip_no) = trim(b.slip_no) and trim(a.custno) = trim(c.custno)  
						  and TRIM(a.invoice_no) !='' and TRIM(a.slip_no) = '$keyword'";

					//echo $sql_invoiceno	."<br/>";
					$result_invoiceno = mysqli_query($_SESSION['db_connect'], $sql_invoiceno);
					$count_products = mysqli_num_rows($result_invoiceno);

					for ($w = 0; $w < $count_products; $w++) {
						$rowinv = mysqli_fetch_array($result_invoiceno);
						$invoice_details[$w]['invoice_no'] = $rowinv['invoice_no'];
						$invoice_details[$w]['invoice_dt'] = $rowinv['invoice_dt'];
						$invoice_details[$w]['approval1'] = $rowinv['approval1'];
						$invoice_details[$w]['approval'] = $rowinv['approval'];
						$invoice_details[$w]['custno'] = $rowinv['custno'];
						$invoice_details[$w]['ccompany'] = $rowinv['ccompany'];
						$invoice_details[$w]['phone1'] = $rowinv['phone1'];
						$invoice_details[$w]['phone2'] = $rowinv['phone2'];
						$invoice_details[$w]['contact'] = $rowinv['contact'];
						$invoice_details[$w]['loc_name'] = $rowinv['loc_name'];
						$invoice_details[$w]['loccd'] = $rowinv['loccd'];
						$invoice_details[$w]['rcv_locnm'] = $rowinv['rcv_locnm'];
						$invoice_details[$w]['rcvloc'] = $rowinv['rcvloc'];
						$invoice_details[$w]['station'] = $rowinv['station'];
						$invoice_details[$w]['deliveryaddress'] = $rowinv['deliveryaddress'];
						$invoice_details[$w]['bu'] = $rowinv['bu'];
						$invoice_details[$w]['mv'] = $rowinv['mv'];
						$invoice_details[$w]['vehcno'] = $rowinv['vehcno'];
						$invoice_details[$w]['tcompany'] = $rowinv['tcompany'];
						$invoice_details[$w]['delv_qty'] = $rowinv['delv_qty'];
						if ($rowinv['delv_qty'] > 0) {
							$confirmed = 1;
						?>
							<script>
								$('#item_error').html("<strong>Delivery already Confirmed</strong>");
							</script>
						<?php

							$thisday = substr($rowinv['delv_date'], 0, 2);
							$thismth = substr($rowinv['delv_date'], 3, 2);
							$thisY = substr($rowinv['delv_date'], 6, 4);

							$newd = $thismth . '/' . $thisday . '/' . $thisY;

							$delv_date = date('Y-m-d', strtotime($newd));
						} else {
							$delv_date = date("Y-m-d");
						}


						$invoice_details[$w]['request'] = $rowinv['request'];
						$invoice_details[$w]['prn'] = $rowinv['prn'];
						$invoice_details[$w]['reversed'] = $rowinv['reversed'];
						$invoice_details[$w]['py'] = $rowinv['py'];
						$invoice_details[$w]['item'] = $rowinv['item'];
						$invoice_details[$w]['itemdesc'] = $rowinv['itemdesc'];
						$invoice_details[$w]['store_qty'] = $rowinv['store_qty'];
						$invoice_details[$w]['price'] = $rowinv['price'];
						$invoice_details[$w]['disc'] = $rowinv['disc'];
						$invoice_details[$w]['duprice'] = $rowinv['duprice'];
						$invoice_details[$w]['vatduprice'] = $rowinv['vatduprice'];
						$invoice_details[$w]['drivername'] = $rowinv['drivername'];
						$invoice_details[$w]['loadername'] = $rowinv['loadername'];
						$invoice_details[$w]['mtr_b4'] = $rowinv['mtr_b4'];
						$invoice_details[$w]['mtr_after'] = $rowinv['mtr_after'];
						$invoice_details[$w]['load_start'] = $rowinv['load_start'];

						$invoice_details[$w]['load_end'] = $rowinv['load_end'];
						$invoice_details[$w]['ull_name'] = $rowinv['ull_name'];
						$invoice_details[$w]['ull_time'] = $rowinv['ull_time'];
						$invoice_details[$w]['vol1'] = $rowinv['vol1'];
						$invoice_details[$w]['vol2'] = $rowinv['vol2'];
						$invoice_details[$w]['vol3'] = $rowinv['vol3'];
						$invoice_details[$w]['vol4'] = $rowinv['vol4'];
						$invoice_details[$w]['vol5'] = $rowinv['vol5'];
						$invoice_details[$w]['vol6'] = $rowinv['vol6'];
						$invoice_details[$w]['ullage1'] = $rowinv['ullage1'];

						$invoice_details[$w]['ullage2'] = $rowinv['ullage2'];
						$invoice_details[$w]['ullage3'] = $rowinv['ullage3'];
						$invoice_details[$w]['ullage4'] = $rowinv['ullage4'];
						$invoice_details[$w]['ullage5'] = $rowinv['ullage5'];
						$invoice_details[$w]['ullage6'] = $rowinv['ullage6'];
						$invoice_details[$w]['slip_no'] = $rowinv['slip_no'];
						$invoice_details[$w]['slip_date'] = $rowinv['slip_date'];
						$invoice_details[$w]['address1'] = $rowinv['address1'];
						$invoice_details[$w]['address2'] = $rowinv['address2'];

						$invoice_details[$w]['upseal_no1'] = $rowinv['upseal_no1'];
						$invoice_details[$w]['upseal_no2'] = $rowinv['upseal_no2'];
						$invoice_details[$w]['upseal_no3'] = $rowinv['upseal_no3'];
						$invoice_details[$w]['upseal_no4'] = $rowinv['upseal_no4'];
						$invoice_details[$w]['upseal_no5'] = $rowinv['upseal_no5'];
						$invoice_details[$w]['upseal_no6'] = $rowinv['upseal_no6'];

						$invoice_details[$w]['loseal_no1'] = $rowinv['loseal_no1'];
						$invoice_details[$w]['loseal_no2'] = $rowinv['loseal_no2'];
						$invoice_details[$w]['loseal_no3'] = $rowinv['loseal_no3'];
						$invoice_details[$w]['loseal_no4'] = $rowinv['loseal_no4'];
						$invoice_details[$w]['loseal_no5'] = $rowinv['loseal_no5'];
						$invoice_details[$w]['loseal_no6'] = $rowinv['loseal_no6'];
					}


					if ($count_products == 0) {
						?>
						<script>
							$('#item_error').html("<strong>Loading Slip does not exist or Waybill not Generated</strong>");
						</script>
					<?php
					}
				} else {
					?>
					<script>
						$('#item_error').html("<strong>Keyword is empty</strong>");
					</script>
			<?php
				}
			}






			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="periodmonth" id="periodmonth" value="<?php echo $periodmonth; ?>" />
			<input type="hidden" name="periodyear" id="periodyear" value="<?php echo $periodyear; ?>" />
			<input type="hidden" name="count_products" id="count_products" value="<?php echo $count_products; ?>" />
			<input type="hidden" name="rcvloc" id="rcvloc" value="<?php echo $rcvloc; ?>" />
			<input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>" />
			<input type="hidden" name="ccompany" id="ccompany" value="<?php echo $ccompany; ?>" />
			<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="loadingslip" />
			<input type="hidden" name="get_file" id="get_file" value="confirmdelivery" />
			<div style="color:red;" id="item_error" align="center"></div>



			<table>
				<tr>
					<td colspan="2" style="padding:7px;">
						<b>Search by: <i>Name or Waybill or Loading Slip</i> </b>&nbsp;
					</td>
					<td colspan="2" style="padding:7px;">
						<div class="input-group">

							<input type="text" size="35px" id="search" placeholder="Search for Waybill" value="<?php echo $keyword; ?>" />
							<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />
							<input type="hidden" name="slip_no" id="slip_no" value="<?php echo $keyword; ?>" />
						</div>

					</td>

				</tr>
				<tr>
					<td align="center" colspan="3">
						<!-- Suggestions will be displayed in below div. -->

						<div id="display"></div>
					</td>


					<td>
						<?php $calledby = 'confirmdelivery';
						$reportid = 10;
						include("specificreportlink.php");  ?>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="4">

						<?php if ($count_products > 0) { ?>
							<div style="overflow-x:auto;">
								<table width="100%" border="0" style="border:1px solid black;padding:2px;border-collapse:separate;border-radius:15px">


									<tr>
										<td align="center" colspan="8">
											<table border="1" width="100%">
												<tr>
													<td nowrap="nowrap" width="20%">
														<b>Waybill No : </b>
													</td>
													<td width="30%">
														<?php echo $invoice_details[0]['invoice_no']; ?>
													</td>
													<td width="20%">
														<b>Waybill Date :</b>
													</td>
													<td width="30%">
														<?php echo $invoice_details[0]['invoice_dt']; ?>
														<input type="hidden" name="invoice_dt" id="invoice_dt" value="<?php echo $invoice_details[0]['invoice_dt']; ?>" />
													</td>
												</tr>
												<tr>
													<td nowrap="nowrap" width="20%">
														<b>Loading Slip No : </b>
													</td>
													<td width="30%">
														<?php echo $invoice_details[0]['slip_no']; ?>
													</td>
													<td width="20%">
														<b>Slip Date :</b>
													</td>
													<td width="30%">
														<?php echo $invoice_details[0]['slip_date']; ?>
													</td>
												</tr>
												<tr>
													<td nowrap="nowrap">
														<b>Customer : </b><br />
														<b>Address : </b><br />
														<b>Contact : </b><br />
														<b>Tel : </b>

													</td>
													<td>
														<?php echo $invoice_details[0]['ccompany'];
														echo  '<br />' . $invoice_details[0]['address1'];
														echo  '<br />' . $invoice_details[0]['contact'];
														echo  '<br />' . $invoice_details[0]['phone1'] . " " .  $invoice_details[0]['phone2'];
														?>
													</td>
													<td nowrap="nowrap">
														<b>Approval No :</b><br /><b>Supply location :</b><br /><b>Receiving Location :</b>
													</td>
													<td>
														<?php echo $invoice_details[0]['approval1'] . $invoice_details[0]['approval'] . '<br />' . $invoice_details[0]['loc_name'] . '<br />' . $invoice_details[0]['rcv_locnm']; ?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td align="center" colspan="8">
											<table border="1" width="100%">
												<tr>
													<td>
														<b>Product</b>
													</td>
													<td>
														<b>Waybill Qty</b>
													</td>
													<td>
														<b>Qty Delivered</b>
													</td>
													<td>
														<b>Date Delivered</b>
													</td>
												</tr>


												<?php $thetotalqty = 0;
												$thetotalcost = 0;
												for ($w = 0; $w < $count_products; $w++) { ?>
													<tr>
														<td>
															<?php echo $invoice_details[$w]['itemdesc']; ?>
															<input type="hidden" name="item<?php echo $w; ?>" id="item<?php echo $w; ?>" value="<?php echo $invoice_details[$w]['item']; ?>" />
														</td>
														<td>
															<input type="text" name="store_qty<?php echo $w; ?>" id="store_qty<?php echo $w; ?>" size="10px" value="<?php echo $invoice_details[$w]['store_qty']; ?>" style="background:transparent;border:none;" tabindex="-1" readonly />
														</td>
														<td>
															<input type="text" name="delv_qty<?php echo $w; ?>" id="delv_qty<?php echo $w; ?>" size="10px" value="<?php echo $invoice_details[$w]['delv_qty']; ?>" />
														</td>
														<td>
															<input type="date" name="delv_date<?php echo $w; ?>" id="delv_date<?php echo $w; ?>" value="<?php echo $delv_date; ?>" />
														</td>
													</tr>

												<?php $thetotalqty = $thetotalqty + $invoice_details[$w]['store_qty'];
													$thetotalcost = $thetotalcost + $invoice_details[$w]['store_qty'] * $invoice_details[$w]['price'];
												} ?>
												<tr>

													<td align="center" colspan="4">
														<b>Total Quantity</b> &nbsp;&nbsp;<?php echo $thetotalqty; ?>
														&nbsp;&nbsp;<?php echo " (" . $dbobject->convert_number_to_words($thetotalqty) . ")"; ?>

														&nbsp;&nbsp;&nbsp;&nbsp;
														<?php if ($count_products == 1 && $confirmed == 0) { ?>

															<input type="button" name="approvebutton" id="submit-button" title="Generate Way Bill/Invoice" value="Confirm Delivery" onclick="javascript: confirmdelivery();">

														<?php } ?>
													</td>
												</tr>


											</table>
										</td>
									</tr>

									<tr>
										<td align="center" colspan="8">
											<table border="1" width="100%">
												<tr>
													<td width="20%">
														<b>Truck No :</b>
													</td>
													<td width="30%">
														<?php echo $invoice_details[0]['vehcno']; ?>
													</td>
													<td nowrap="nowrap">
														<b>Loader's Name :</b>
													</td>
													<td width="30%">
														<?php echo $invoice_details[0]['loadername']; ?>
													</td>
												</tr>
												<tr>
													<td>
														<b>Driver's Name :</b>
													</td>
													<td>
														<?php echo $invoice_details[0]['drivername']; ?>
													</td>
													<td>
														<b>Meter Before:</b>
													</td>
													<td>
														<?php echo $invoice_details[0]['mtr_b4']; ?>
													</td>
												</tr>


												<tr>
													<td>
														<b>Transporter :</b>
													</td>
													<td>
														<?php echo $invoice_details[0]['tcompany']; ?>
													</td>
													<td>
														<b>Meter After:</b>
													</td>
													<td>
														<?php echo $invoice_details[0]['mtr_after']; ?>
													</td>
												</tr>

												<tr>
													<td nowrap="nowrap">
														<b>Ticket Number :</b>
													</td>
													<td>
														<?php echo substr($invoice_details[0]['slip_no'], 5, 2) . substr($invoice_details[0]['slip_no'], 7, 2) . substr($invoice_details[0]['slip_no'], 11); ?>
													</td>
													<td>
														<b>Time Loading Started:</b>
													</td>
													<td>
														<?php echo $invoice_details[0]['load_start']; ?>
													</td>
												</tr>
												<tr>
													<td colspan="2">

													</td>

													<td>
														<b>Time Loading Ended:</b>
													</td>
													<td>
														<?php echo $invoice_details[0]['load_end']; ?>
													</td>
												</tr>


											</table>
										</td>
									</tr>
									<tr>
										<td align="center" colspan="8">
											<table border="1" width="100%">
												<tr>
													<td>
														<b>Ullager's Name :</b>
													</td>
													<td colspan="2">
														<?php echo $invoice_details[0]['ull_name']; ?>
													</td>
													<td>
														<b>Ullage Time:</b>
													</td>
													<td colspan="3">
														<?php echo $invoice_details[0]['ull_time']; ?>
													</td>
												</tr>

												<tr>
													<td nowrap="nowrap">
														<b>Compactment No :</b>
													</td>
													<td align="center" width="13%">
														<b>1</b>
													</td>
													<td align="center" width="13%">
														<b>2</b>
													</td>
													<td align="center" width="13%">
														<b>3</b>
													</td>
													<td align="center" width="13%">
														<b>4</b>
													</td>
													<td align="center" width="13%">
														<b>5</b>
													</td>
													<td align="center" width="13%">
														<b>6</b>
													</td>
												</tr>
												<tr>
													<td nowrap="nowrap">
														<b>Volume in Litres :</b>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['vol1']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['vol2']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['vol3']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['vol4']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['vol5']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['vol6']; ?>
													</td>
												</tr>
												<tr>
													<td>
														<b>Ullage :</b>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['ullage1']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['ullage2']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['ullage3']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['ullage4']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['ullage5']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['ullage6']; ?>
													</td>
												</tr>
												<tr>
													<td>
														<b>Upper Seal No :</b>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['upseal_no1']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['upseal_no2']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['upseal_no3']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['upseal_no4']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['upseal_no5']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['upseal_no6']; ?>
													</td>
												</tr>

												<tr>
													<td>
														<b>Lower Seal No :</b>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['loseal_no1']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['loseal_no2']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['loseal_no3']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['loseal_no4']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['loseal_no5']; ?>
													</td>
													<td align="center">
														<?php echo $invoice_details[0]['loseal_no6']; ?>
													</td>
												</tr>
											</table>
										</td>
									</tr>



								</table>
							</div>
						<?php } ?>
					</td>
				</tr>

			</table>
			<br />



		<?php } ?>
	</form>
	<br />

	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('s_and_d.php?op=refresh','page');
				">
	<br />
</div>


<script>
	function confirmdelivery() {

		if (confirm('Are you sure the entries are correct?')) {

			var $goahead = 1;
			var productstring = '';
			var $count_products = $('#count_products').val();
			var $invoice_dt = $('#invoice_dt').val();

			var waybilldate = $invoice_dt.trim().substring(6, 10) + "-" + $invoice_dt.substring(3, 5) + "-" + $invoice_dt.substring(0, 2);

			var thewaybilldate = new Date(waybilldate);



			for (i = 0; i < $count_products; i++) {

				var delv_qty = document.getElementById('delv_qty' + i).value;
				var delv_date = document.getElementById('delv_date' + i).value;
				var store_qty = document.getElementById('store_qty' + i).value;
				var item = document.getElementById('item' + i).value;

				var thedelv_date = new Date(delv_date);

				if (thedelv_date < thewaybilldate) {
					$goahead = $goahead * 0;
					alert('Delivery Date is less than Waybill Date');

				}

				if (isNaN(delv_qty)) {
					$goahead = $goahead * 0;
					alert('Please Enter a Numeric Value for Deliverd Quantity');
				} else {
					if (Number(delv_qty) <= 0) {
						$goahead = $goahead * 0;
						alert('Please Enter a positive Numeric Value for Deliverd Quantity');
					}
				}


				if (Number(delv_qty) > Number(store_qty)) {
					if (!confirm('Delivered Quantity is greater than Waybill Quantity. Is this Correct')) {
						$goahead = $goahead * 0;
					}


				}

				productstring = productstring + '&item' + i + '=' + item + '&delv_qty' + i + '=' + delv_qty + '&delv_date' + i + '=' + delv_date;
			}


			var $keyword = $('#keyword').val();

			if ($goahead == 1) {
				//alert('confirmdelivery.php?op=confirmdelivery&keyword='+$keyword+'&thecount_products='+$count_products+productstring);
				getpage('confirmdelivery.php?op=confirmdelivery&keyword=' + $keyword + '&thecount_products=' + $count_products + productstring, 'page');
			} else {
				alert('Cannot Save This Confirmation');
			}

		}

	}
</script>