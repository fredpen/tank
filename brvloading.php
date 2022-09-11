<?php
ob_start();
include_once "session_track.php";
?>


<div align="center" id="data-form">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">

	<?php
	require_once("lib/mfbconnect.php");

	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/dynamic_search_script.js"></script>
	<form action="" method="get" id="form1" novalidate>
		<h3><strong>
				Way Bill
			</strong></h3>
		<?php
		if ($_SESSION['genwaybill'] == 1) {
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
			$deliveryaddress1 = !isset($_REQUEST['deliveryaddress1']) ? "" : $dbobject->test_input($_REQUEST['deliveryaddress1']);
			$reversed = !isset($_REQUEST['reversed']) ? 1 : $dbobject->test_input($_REQUEST['reversed']);
			$invoice_no = '';

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

			$store_qty = !isset($_REQUEST['store_qty']) ? 0 : $dbobject->test_input($_REQUEST['store_qty']);
			$count_products = !isset($_REQUEST['count_products']) ? 0 : $dbobject->test_input($_REQUEST['count_products']);
			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$trantype = !isset($_SESSION['trantype']) ? 0 : $_SESSION['trantype'];

			if ($op == 'generateinvoice') {

				$goahead = 1;

				if ($count_products == 0) {
					$goahead = 0;
				}

				//check if sub locations were specified
				for ($i = 0; $i < $count_products; $i++) {
					if (trim($_REQUEST['subloc' . $i]) == '') {
						$goahead = 0;
		?>
						<script>
							$('#item_error').html("<strong>Supply Sub Inventory Location not provided</strong>");
						</script>
						<?php

					}
					if ($rcvloc != '') {
						if (trim($_REQUEST['rsubloc' . $i]) == '') {
							$goahead = 0;
						?>
							<script>
								$('#item_error').html("<strong>Supply Sub Inventory Location not provided</strong>");
							</script>
							<?php

						}
					}
				}

				if ($goahead == 1) {

					$sql_get_invoice_header = "SELECT * FROM invoice where reversed = 0 and trim(invoice_no) = '' and upper(trim(slip_no)) = upper('$slip_no')  ";
					$result_get_invoice_header = mysqli_query($_SESSION['db_connect'], $sql_get_invoice_header);
					$count_get_invoice_header = mysqli_num_rows($result_get_invoice_header);


					if ($count_get_invoice_header > 0) {
						$row_get_invoice_header = mysqli_fetch_array($result_get_invoice_header);
						$py = $row_get_invoice_header['py'];
						if (trim($row_get_invoice_header['rcvloc']) != '')


							//check sub inventory stock level
							for ($i = 0; $i < $count_products; $i++) {

								$item = $_REQUEST['theitem' . $i];
								$thesubinv = $_REQUEST['subloc' . $i];
								$sql_subloc_supply_check = "select * from itemsubloc where trim(loccd) = '$loccd' and trim(item) = '$item' and trim(subloc) = '$thesubinv' ";
								//echo $sql_subloc_supply_check.'<br/>';
								$result_subloc_supply_check = mysqli_query($_SESSION['db_connect'], $sql_subloc_supply_check);
								$count_subloc_supply_check = mysqli_num_rows($result_subloc_supply_check);
								$subqty = 0;
								if ($count_subloc_supply_check > 0) {
									$row_subloc_supply_check = mysqli_fetch_array($result_subloc_supply_check);
									$subqty = $row_subloc_supply_check['useable_onhand'];
								}

								if ($subqty == 0) {
									$goahead = 0;
							?>
								<script>
									$('#item_error').html("<strong>Supply Sub Inventory Location Onhand is Zero</strong>");
								</script>
							<?php
								}

								if ($subqty < $_REQUEST['theqty_booked' . $i]) {
									$goahead = 0;
							?>
								<script>
									$('#item_error').html("<strong>You do not have enough onhand value to prosecute this transaction</strong>");
								</script>
							<?php
								}
							}

						if (($vol1 + $vol2 + $vol3 + $vol4 + $vol5 + $vol6) != $store_qty) {
							$goahead = 0;

							?>
							<script>
								$('#item_error').html("<strong>The Compartments volumes do not correspond with the volume loaded</strong>");
							</script>
						<?php
						}
						$theload_start = substr($load_start, 8, 2) . '/' . substr($load_start, 5, 2) . '/' . substr($load_start, 0, 4) . ' ' . substr($load_start, 11);
						$theload_end = substr($load_end, 8, 2) . '/' . substr($load_end, 5, 2) . '/' . substr($load_end, 0, 4) . ' ' . substr($load_end, 11);
						$theull_time = substr($ull_time, 8, 2) . '/' . substr($ull_time, 5, 2) . '/' . substr($ull_time, 0, 4) . ' ' . substr($ull_time, 11);
						//	echo $theload_start;

						if ($goahead == 1) {
							$next_inv_no = 1;
							//obtain invoice number
							$sql_get_invoice_no = "select * from const where 1=1";
							$result_get_invoice_no = mysqli_query($_SESSION['db_connect'], $sql_get_invoice_no);
							$count_get_invoice_no = mysqli_num_rows($result_get_invoice_no);
							if ($count_get_invoice_no >= 1) {
								$row  = mysqli_fetch_array($result_get_invoice_no);
							}

							if (trim($rcvloc) == '') {

								$next_inv_no = $row['next_inv_no'];
								if ($next_inv_no > 999) {
									$next_inv_no = 1;
								}



								$invoice_no = 'INV' . date("d") . date("m") . date("Y") . $next_inv_no;

								//check usage
								$sql_check_usage = "select * from invoice where trim(invoice_no) = '$invoice_no'";
								$result_check_usage = mysqli_query($_SESSION['db_connect'], $sql_check_usage);
								$count_check_usage = mysqli_num_rows($result_check_usage);
								if ($count_check_usage >= 1) {
									$Reqno_in_use = 1;
									while ($Reqno_in_use == 1) {
										$next_inv_no++;
										$invoice_no = 'INV' . date("d") . date("m") . date("Y") . $next_inv_no;
										$sql_check_usage_again = "select * from invoice where trim(invoice_no) = '$invoice_no'";
										$result_check_usage_again = mysqli_query($_SESSION['db_connect'], $sql_check_usage_again);
										$count_check_usage_again = mysqli_num_rows($result_check_usage_again);
										if ($count_check_usage_again == 0) {
											$Reqno_in_use = 0;
										}
									}
								}

								$sql_update_nextno = " update const set next_inv_no = $next_inv_no + 1 where 1 =1 ";
								$result_update_nextno = mysqli_query($_SESSION['db_connect'], $sql_update_nextno);
							} else {
								$next_inv_no = $row['next_ptn_no'];
								if ($next_inv_no > 999) {
									$next_inv_no = 1;
								}



								$invoice_no = 'PTN' . date("d") . date("m") . date("Y") . $next_inv_no;

								//check usage
								$sql_check_usage = "select * from invoice where trim(invoice_no) = '$invoice_no'";
								$result_check_usage = mysqli_query($_SESSION['db_connect'], $sql_check_usage);
								$count_check_usage = mysqli_num_rows($result_check_usage);
								if ($count_check_usage >= 1) {
									$Reqno_in_use = 1;
									while ($Reqno_in_use == 1) {
										$next_inv_no++;
										$invoice_no = 'PTN' . date("d") . date("m") . date("Y") . $next_inv_no;
										$sql_check_usage_again = "select * from invoice where trim(invoice_no) = '$invoice_no'";
										$result_check_usage_again = mysqli_query($_SESSION['db_connect'], $sql_check_usage_again);
										$count_check_usage_again = mysqli_num_rows($result_check_usage_again);
										if ($count_check_usage_again == 0) {
											$Reqno_in_use = 0;
										}
									}
								}

								$sql_update_nextno = " update const set next_ptn_no = $next_inv_no + 1 where 1 =1 ";
								$result_update_nextno = mysqli_query($_SESSION['db_connect'], $sql_update_nextno);
							}

							$sql_update_invoice = " update invoice set  
								 deliveryaddress = '$deliveryaddress1',periodmonth = '$periodmonth', periodyear = '$periodyear',invoice_no = '$invoice_no', invoice_dt = '" . date("d/m/Y h:i:s A") .
								"', invoice_am = (select sum(cost) cost from inv_detl where TRIM(slip_no) = '$slip_no') 
								  where TRIM(slip_no) = '$slip_no'";



							$result_update_invoice = mysqli_query($_SESSION['db_connect'], $sql_update_invoice);
							//echo $sql_update_invoice.'<br/>';			


							//2022-04-21T09:42:00
							if (trim($rcvloc) != '') {
								for ($i = 0; $i < $count_products; $i++) {

									$theitem = $_REQUEST['theitem' . $i];
									$thesubinv = $_REQUEST['subloc' . $i];
									$thestore_qty = $_REQUEST['theqty_booked' . $i];

									$sql_update_icitem = "update icitem set onhand = onhand + $thestore_qty, useable_onhand = useable_onhand + $thestore_qty
												 WHERE TRIM(item) = '$theitem'";

									$result_update_icitem = mysqli_query($_SESSION['db_connect'], $sql_update_icitem);


									$sql_update_itemloc = "update itemloc set onhand = onhand + $thestore_qty
												, useable_onhand = useable_onhand + $thestore_qty
												 WHERE TRIM(item) = '$theitem' and  TRIM(loccd) = '$rcvloc'";

									$result_update_itemloc = mysqli_query($_SESSION['db_connect'], $sql_update_itemloc);


									$sql_update_itemsubloc = "update itemsubloc set onhand = onhand + $thestore_qty
												, useable_onhand = useable_onhand + $thestore_qty
												 WHERE TRIM(item) = '$theitem' and  
													TRIM(loccd) = '$rcvloc' and 
													TRIM(subloc) = '$thesubinv'";

									$result_update_itemsubloc =	mysqli_query($_SESSION['db_connect'], $sql_update_itemsubloc);
								}
							}



							//***deducting from inventory
							for ($i = 0; $i < $count_products; $i++) {

								$theitem = $_REQUEST['theitem' . $i];
								$thesubinv = $_REQUEST['subloc' . $i];
								$thestore_qty = $_REQUEST['theqty_booked' . $i];

								$sql_update_icitem = "update icitem set onhand = onhand - $thestore_qty, useable_onhand = useable_onhand - $thestore_qty
												 WHERE TRIM(item) = '$theitem'";

								$result_update_icitem = mysqli_query($_SESSION['db_connect'], $sql_update_icitem);

								//echo $sql_update_icitem.'<br/>';
								$sql_update_itemloc = "update itemloc set onhand = onhand - $thestore_qty
											, useable_onhand = useable_onhand - $thestore_qty
											 WHERE TRIM(item) = '$theitem' and  TRIM(loccd) = '$loccd'";

								$result_update_itemloc = mysqli_query($_SESSION['db_connect'], $sql_update_itemloc);
								//echo $sql_update_itemloc.'<br/>';

								$sql_update_itemsubloc = "update itemsubloc set onhand = onhand - $thestore_qty
											, useable_onhand = useable_onhand - $thestore_qty
											 WHERE TRIM(item) = '$theitem' and  
												TRIM(loccd) = '$loccd' and 
												TRIM(subloc) = '$thesubinv'";

								$result_update_itemsubloc =	mysqli_query($_SESSION['db_connect'], $sql_update_itemsubloc);
								//echo $sql_update_itemsubloc.'<br/>';
							}



							for ($i = 0; $i < $count_products; $i++) {

								$theitem = $_REQUEST['theitem' . $i];
								$thesubinv = $_REQUEST['subloc' . $i];
								if (trim($rcvloc) != '') {
									$rthesubinv = $_REQUEST['rsubloc' . $i];
								} else {
									$rthesubinv = '';
								}

								$thestore_qty = $_REQUEST['theqty_booked' . $i];

								$sql_update_inv_detl = " update inv_detl set  
									periodmonth = '$periodmonth', periodyear = '$periodyear',subloc = '$thesubinv'
									, store_qty = $thestore_qty , load_start = '$theload_start', load_end = '$theload_end', mtr_b4 = $mtr_b4 
									, mtr_after = $mtr_after, loadername = '$loadername', ull_name = '$ull_name', seal_no = '$seal_no'
									, rsubloc = '$rthesubinv', ull_time = '$theull_time', vol1 = $vol1 , vol2 = $vol2 , vol3 = $vol3 
									, vol4 = $vol4 , vol5 = $vol5 , vol6 = $vol6, ullage1 = $ullage1 , ullage2 = $ullage2 
									, ullage3 = $ullage3 , ullage4 = $ullage4 , ullage5 = $ullage5 , ullage6 = $ullage6 
									, upseal_no1 = '$upseal_no1' , upseal_no2 = '$upseal_no2' , upseal_no3 = '$upseal_no3' , upseal_no4 = '$upseal_no4' , upseal_no5 = '$upseal_no5' , upseal_no6 = '$upseal_no6' 
									, loseal_no1 = '$loseal_no1' , loseal_no2 = '$loseal_no2' , loseal_no3 = '$loseal_no3' , loseal_no4 = '$loseal_no4' , loseal_no5 = '$loseal_no5' , loseal_no6 = '$loseal_no6'
									 where TRIM(slip_no) = '$slip_no' and TRIM(item) = '$theitem'";

								$result_update_inv_detl = mysqli_query($_SESSION['db_connect'], $sql_update_inv_detl);
								//echo $sql_update_inv_detl.'<br/>';
							}



							$sql_products_detl =  "SELECT *  FROM inv_detl 
									 where trim(slip_no) = '" . trim($slip_no) . "'  ";


							$result_products_detl = mysqli_query($_SESSION['db_connect'], $sql_products_detl);
							$count_products_detl = mysqli_num_rows($result_products_detl);
							for ($i = 0; $i < $count_products_detl; $i++) {
								$row_products_detl = mysqli_fetch_array($result_products_detl);

								for ($y = 0; $y < $count_products; $y++) {
									if (trim($row_products_detl['item']) == trim($_REQUEST['theitem' . $y])) {
										$item = $_REQUEST['theitem' . $y];
										$subloc = $_REQUEST['subloc' . $y];
										if (trim($rcvloc) != '') {
											$rthesubinv = $_REQUEST['rsubloc' . $i];
										} else {
											$rthesubinv = '';
										}
										$thestore_qty = $_REQUEST['theqty_booked' . $y];
									}
								}

								$sql_icitem = " select * from icitem where TRIM(item) = '$item'";
								$result_icitem = mysqli_query($_SESSION['db_connect'], $sql_icitem);
								$count_icitem = mysqli_num_rows($result_icitem);

								if ($count_icitem > 0) {
									$row = mysqli_fetch_array($result_icitem);
									$chartcode = $row['chartcode'];
									$description = $row['description'];
									$avgcost = $row['avgcost'];
								}


								if ($py == 'CR') {

									$sql_crsales = " insert into crsales ( 
										 request, custno,invoice_no, invoice_am,transby ,transdate ) 
										 values 
										 ('" . $row_products_detl['request'] . "','$custno', '$invoice_no',
										 (select sum(cost) cost from inv_detl where TRIM(slip_no) = '$slip_no'),'$reqst_by','" . date("d/m/Y h:i:s A") . "')";

									$result_crsales = mysqli_query($_SESSION['db_connect'], $sql_crsales);
								}


								if (trim($rcvloc) != '') {
									$sql_rec_invent = " insert into rec_invent 
											(purchaseorderno,item,qtyreceived,unitprice,totalcost,itemdesc,prodcost,tax,taxpercent,  
											periodmonth,periodyear,loccd,subloc,inv_recpt_no,receivd_dt,vendorno,company,chartcode,description,receivd_by) 
											 values ( '$invoice_no','$item',$thestore_qty ," . $row_products_detl['price'] . " ," .
										$row_products_detl['cost'] . " ,'" . $row_products_detl['itemdesc'] . "'," .
										$row_products_detl['cost'] . " ," . $row_products_detl['vatduprice'] . "," .
										$row_products_detl['disc'] . ", '$periodmonth','$periodyear','$rcvloc','$rsubloc','$invoice_no','" .
										date("d/m/Y h:i:s A") . "','$custno','Stock Transfer','$chartcode','$description','$reqst_by')";

									$result_rec_invent = mysqli_query($_SESSION['db_connect'], $sql_rec_invent);


									//		** creating journal entry
									$sql_CreateJournal_rec_invent = "call CreateJournalEntries('INVENTORYRECV','$chartcode','$description - " . $row_products_detl['itemdesc'] . "'," . $row_products_detl['cost'] . ",'" . date('d/m/Y H:i:s A') . "','$periodmonth','$periodyear')";

									$result_CreateJournal_rec_invent = mysqli_query($_SESSION['db_connect'], $sql_CreateJournal_rec_invent);

									//JournalCreation = THISFORM.CreateJournalEntries("INVENTORYRECV", ALLT(icitem.chartcode), ALLT(icitem.description),icitem.avgcost * THISFORM.STORE_QTY.VALUE)

								}


								$sql_inv_issues = " insert into inv_issues (  
									 item, qtyissued,loccd, issue_no,issued_dt ,issued_by,subloc,periodmonth, periodyear  ) 
									 values ('$item',$thestore_qty, '$loccd','$invoice_no','" . date("d/m/Y h:i:s A") .
									"','$reqst_by','$subloc','$periodmonth','$periodyear')";

								$result_inv_issues = mysqli_query($_SESSION['db_connect'], $sql_inv_issues);


								if ($trantype <> 4) {
									//** creating journal entry
									//JournalCreation = THISFORM.CreateJournalEntries("COSTOFGOODSSOLD", ALLT(icitem.chartcode), ALLT(icitem.description),icitem.avgcost *THISFORM.STORE_QTY.VALUE)

									$sql_CreateJournal_costofgoods = "call CreateJournalEntries('COSTOFGOODSSOLD','$chartcode','$description - " . $row_products_detl['itemdesc'] . "'," . $avgcost * $thestore_qty . ",'" . date('d/m/Y H:i:s A') . "','$periodmonth','$periodyear')";

									$result_CreateJournal_costofgoods = mysqli_query($_SESSION['db_connect'], $sql_CreateJournal_costofgoods);

									//JournalCreation = THISFORM.CreateJournalEntries("CASHSALES", ALLT(icitem.chartcode), ALLT(icitem.description),THISFORM.STORE_QTY.VALUE * invoiceamount.cost)
									$sql_CreateJournal_cashsales = "call CreateJournalEntries('SALESREVENUE','$chartcode','$description - " . $row_products_detl['itemdesc'] . "'," . $row_products_detl['cost'] * $thestore_qty . ",'" . date('d/m/Y H:i:s A') . "','$periodmonth','$periodyear')";

									$result_CreateJournal_cashsales = mysqli_query($_SESSION['db_connect'], $sql_CreateJournal_cashsales);

									if ($py  != 'CA') {

										//JournalCreation = THISFORM.CreateJournalEntries("CREDITSALES", ALLT(icitem.chartcode), ALLT(icitem.description),THISFORM.STORE_QTY.VALUE * invoiceamount.cost)
										$sql_CreateJournal_creditsales = "call CreateJournalEntries('RECEIVABLES','$chartcode','$description - " . $row_products_detl['itemdesc'] . "'," . $row_products_detl['cost'] * $thestore_qty . ",'" . date('d/m/Y H:i:s A') . "','$periodmonth','$periodyear')";

										$result_CreateJournal_creditsales = mysqli_query($_SESSION['db_connect'], $sql_CreateJournal_creditsales);
									}
								}
							}



							$savetrail = $dbobject->apptrail($_SESSION['username_sess'], 'Loading Slip', $slip_no, date("d/m/Y h:i:s A"), 'Waybill Generated');
							$dbobject->workflow($_SESSION['username_sess'], 'Loading Slip Created, Waybill Generated, Delivery Confirmation Required', $slip_no, date('d/m/Y H:i:s A'), 6, 3, 'confirmdelivery');
						?>
							<script>
								$('#item_error').html("<strong>Invoice Generated</strong>");
							</script>
					<?php
						}
					}
				}
			}


			$products_icitem_var = array();
			$productArray = array();

			$sql_slipno = "select distinct * FROM invoice WHERE reversed = 0 and trim(invoice_no) = '' and trantype = $trantype order by substr(slip_no,4) desc limit 1000";


			$result_slipno = mysqli_query($_SESSION['db_connect'], $sql_slipno);
			$count_slipno = mysqli_num_rows($result_slipno);

			$k = 0;
			while ($k < $count_slipno) {
				$row = mysqli_fetch_array($result_slipno);
				$slipno_var[$k]['slip_no'] = $row['slip_no'];
				$slipno_var[$k]['ccompany'] = $row['ccompany'];

				$k++;
			}






			if ($op == 'getselectslipno') {
				$filter = "";

				$sql_Q = "SELECT * FROM invoice where  ";

				$filter = "  upper(trim(slip_no)) = upper('$slip_no') and  trantype = $trantype ";



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
					$slip_no    = $row['slip_no'];
					$ccompany   = $row['ccompany'];
					$invoice_no    = $row['invoice_no'];
					$reversed   = $row['reversed'];
					$vehcno   = $row['vehcno'];
					$loc_name   = $row['loc_name'];
					$loccd   = $row['loccd'];
					$rcv_locnm   = $row['rcv_locnm'];
					$rcvloc   = $row['rcvloc'];
					$request   = $row['request'];
					$deliveryaddress1   = $row['deliveryaddress1'];
				} else {
					?>
					<script>
						$('#item_error').html("<strong>LoadingSlip does not exist</strong>");
					</script>
					<?php
				}
			}

			if ($op == 'searchkeyword') {
				if (trim($keyword) != '') {

					$sql_request = "select *  from invoice where trim(slip_no) =  '$keyword' and  trantype = $trantype ";
					//echo $sql_request."<br />";
					$result_request = mysqli_query($_SESSION['db_connect'], $sql_request);
					$count_request = mysqli_num_rows($result_request);
					//echo "<br/>".$sql_request."<br/>";
					if ($count_request >= 1) {
						$row = mysqli_fetch_array($result_request);
						$slip_no    = $row['slip_no'];
						$ccompany   = $row['ccompany'];
						$invoice_no    = $row['invoice_no'];
						$reversed   = $row['reversed'];
						$vehcno   = $row['vehcno'];
						$loc_name   = $row['loc_name'];
						$loccd   = $row['loccd'];
						$request   = $row['request'];
						$deliveryaddress1   = $row['deliveryaddress1'];
					} else {
					?>
						<script>
							$('#item_error').html("<strong>Loading Slip does not exist</strong>");
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










			// retrieve product		

			$sql_products =  "SELECT a.drivername,a.item,a.itemdesc,  sum(a.qty_asked) qty_asked, sum(a.qty_booked) qty_booked  FROM invoice b, inv_detl a" .
				" where trim(b.slip_no) = trim(a.slip_no) and trim(b.slip_no) = '" . trim($slip_no) . "' group by a.item,a.itemdesc,a.drivername  ";



			//echo $sql_products."<br/>";
			$show_void_button = 1;
			$result_products = mysqli_query($_SESSION['db_connect'], $sql_products);
			$count_products = mysqli_num_rows($result_products);
			for ($i = 0; $i < $count_products; $i++) {
				$row = mysqli_fetch_array($result_products);
				$productArray[$i]['item'] = $row['item'];
				$item = $productArray[$i]['item'];
				$productArray[$i]['itemdesc'] = $row['itemdesc'];
				$productArray[$i]['drivername'] = $row['drivername'];
				$productArray[$i]['qty_booked'] = $row['qty_booked'];
			}


			if ($request != "MULTIPLE_APPR") {
				//check if original approval was refused
				$sql_check_refused = "SELECT * FROM headdata  WHERE trim(request) = '$request'";
				$result_check_refused = mysqli_query($_SESSION['db_connect'], $sql_check_refused);
				$count_check_refused = mysqli_num_rows($result_check_refused);
				if ($count_check_refused > 0) {
					$row = mysqli_fetch_array($result_check_refused);
					if (trim($row['refuse']) == 1) {
						$show_void_button = $show_void_button * 0;
					?>
						<script>
							$('#item_error').html("<strong>The approval for this Slip was refused</strong>");
						</script>
					<?php
					}
				}

				if ($count_products > 1) {
					$show_void_button = $show_void_button * 0;
					?>
					<script>
						$('#item_error').html("<strong>Sorry! Please use the Multiple Products Invoicing option</strong>");
					</script>
					<?php
				}
			} else {
				//multiple approvals in loading slip
				//check if any of the requisitions was refused
				$sql_check_refused1  = "SELECT distinct request FROM inv_detl  WHERE trim(slip_no) = '$slip_no'";
				$result_check_refused1 = mysqli_query($_SESSION['db_connect'], $sql_check_refused1);
				$count_check_refused1 = mysqli_num_rows($result_check_refused1);
				if ($count_check_refused1 > 0) {
					for ($i = 0; $i < $count_check_refused1; $i++) {
						$row1 = mysqli_fetch_array($result_check_refused1);
						//check if original approval was refused
						$sql_check_refused = "SELECT * FROM headdata  WHERE trim(request) = '" . $row1['request'] . "'";
						$result_check_refused = mysqli_query($_SESSION['db_connect'], $sql_check_refused);
						$count_check_refused = mysqli_num_rows($result_check_refused);
						if ($count_check_refused > 0) {
							$row = mysqli_fetch_array($result_check_refused);
							if (trim($row['refuse']) == 1) {
								$show_void_button = $show_void_button * 0;
					?>
								<script>
									$('#item_error').html("<strong>One of the approvals refrenced in this Slip was refused </strong>");
								</script>
			<?php
							}
						}
					}
				}
			}



			if (trim($invoice_no) != '') {
				$show_void_button = $show_void_button * 0;
			}
			if ($reversed == 1) {
				$show_void_button = $show_void_button * 0;
			}

			$supply_subloc_array = array();
			$sql_subloc_supply = "select a.*,b.itemdesc, c.loc_name from itemsubloc a, icitem b, lmf c where trim(a.item) = trim(b.item) and trim(a.loccd) = trim(c.loccd) and trim(a.loccd) = '$loccd' and trim(a.item) = '$item' ";
			//echo $sql_subloc;
			$result_subloc_supply = mysqli_query($_SESSION['db_connect'], $sql_subloc_supply);
			$count_subloc_supply = mysqli_num_rows($result_subloc_supply);
			for ($i = 0; $i < $count_subloc_supply; $i++) {
				$row = mysqli_fetch_array($result_subloc_supply);
				$supply_subloc_array[$i]['subloc'] = $row['subloc'];
				$supply_subloc_array[$i]['useable_onhand'] = $row['useable_onhand'];
			}


			$rcv_subloc_array = array();
			$sql_subloc_rcv = "select a.*,b.itemdesc, c.loc_name from itemsubloc a, icitem b, lmf c where trim(a.item) = trim(b.item) and trim(a.loccd) = trim(c.loccd) and trim(a.loccd) = '$rcvloc' and trim(a.item) = '$item' ";
			//echo $sql_subloc;
			$result_subloc_rcv = mysqli_query($_SESSION['db_connect'], $sql_subloc_rcv);
			$count_subloc_rcv = mysqli_num_rows($result_subloc_rcv);
			for ($i = 0; $i < $count_subloc_rcv; $i++) {
				$row = mysqli_fetch_array($result_subloc_rcv);
				$rcv_subloc_array[$i]['subloc'] = $row['subloc'];
				$rcv_subloc_array[$i]['useable_onhand'] = $row['useable_onhand'];
			}



			$sql_store_qty =  "SELECT SUM(qty_booked)  as qty_booked FROM inv_detl  WHERE trim(slip_no) = '$slip_no'";
			$result_store_qty = mysqli_query($_SESSION['db_connect'], $sql_store_qty);
			$count_store_qty = mysqli_num_rows($result_store_qty);

			if ($count_store_qty > 0) {
				$row = mysqli_fetch_array($result_store_qty);
				$store_qty = $row['qty_booked'];
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
			<input type="hidden" name="get_file" id="get_file" value="brvloading" />

			<div style="color:red;" id="item_error" align="center"></div>


			<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">

				<tr>
					<td colspan="5" style="padding:7px;">
						<b>Search by: <i>Name or Loading Slip</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Loading Slip" value="<?php echo $keyword; ?>" />
						<input name="keyword" type="hidden" placeholder="Enter a keyword" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />
						<!-- Suggestions will be displayed in below div. -->

						<div id="display"></div>
					</td>
				</tr>


				<tr>
					<td valign="top">
						<b>Select Slip Number</b>
					</td>
					<td colspan="4">

						<?php
						$k = 0;
						?>
						<select name="selectslipno" id="selectslipno" onChange="javascript: 
									var $form_selectslipno = $('#selectslipno').val();  
										
										getpage('brvloading.php?op=getselectslipno&slip_no='+$form_selectslipno
										,'page')
							
								">
							<option value=""></option>
							<?php

							while ($k < $count_slipno) {

							?>
								<option value="<?php echo trim($slipno_var[$k]['slip_no']); ?>" <?php echo ($slip_no == trim($slipno_var[$k]['slip_no']) ? "selected" : ""); ?>>
									<?php echo trim($slipno_var[$k]['slip_no'] . ' ' . $slipno_var[$k]['ccompany']); ?>
								</option>

							<?php
								$k++;
							} //End If Result Test	
							?>
						</select>

					</td>
				</tr>
				<tr>
					<td colspan="5">
						<hr>
					</td>
				</tr>
				<tr>
					<td>
						<b>Slip Number</b>
					</td>
					<td>
						<b><?php echo $slip_no; ?> </b><input type="hidden" name="slip_no" id="slip_no" value="<?php echo $slip_no; ?>" />
					</td>
					<td>
						<?php
						if ($invoice_no != '') {
						?>
							<input type="submit" name="PrintButton" class="PrintButton" title="Print Waybill" id="submit-button" formtarget="_blank" value="Print Waybill" formaction="<?php echo $_SESSION['applicationbase'] . 'appwaybill.php'; ?>" />

						<?php

						}
						?>
					</td>
					<td>
						<?php
						if ($invoice_no != '') {
						?>

							<?php echo '<b>' . $invoice_no . '</b>'; ?>

						<?php

						}
						?>
					</td>

				</tr>


			</table>
			<style>
				td {
					padding: 1px;
				}
			</style>
			<br />
			<table width="90%" border="0">
				<?php if (trim($vehcno) != '') { ?>
					<tr>
						<td width="20%">
							<b>Bulk Road Vehicle</b>
						</td>
						<td width="30%">
							<?php echo trim($vehcno); ?>
						</td>
						<td width="20%">
							<b>Driver Name</b>
						</td>
						<td width="30%">
							<?php if (isset($productArray[0]["drivername"])) {
								echo trim($productArray[0]["drivername"]);
							} ?>
						</td>
					</tr>
				<?php }  ?>
				<tr>
					<td>
						<b>Supply Location</b>
					</td>
					<td>
						<?php echo $loccd . " " . $loc_name; ?> <input type="hidden" id="loccd" value="<?php echo $loccd; ?>" />
					</td>
					<td>
						<?php if (trim($rcvloc) != '') {
							echo '	<b>Receiving Location</b>';
						} ?><input type="hidden" id="rcvloc" value="<?php echo $rcvloc; ?>" />
					</td>
					<td>
						<?php if (trim($rcvloc) != '') {
							echo $rcvloc . " " . $rcv_locnm;
						} ?>
					</td>
				</tr>
				<tr>
					<td>
						<b>Delivery Address</b>
					</td>
					<td colspan="3">
						<textarea cols="52" name="deliveryaddress1" id="deliveryaddress1"><?php echo $deliveryaddress1; ?> </textarea>

					</td>
				</tr>
				<tr>
					<td colspan="4">
						<hr>
					</td>
				</tr>
				<tr title="Click a Header : Product or Loading or Ullage">
					<td align="right"><b>Click A header >></b></td>
					<td align="center" id="pro" onclick=" selectpage(this.id);" style="background-color:#C39BD3;">
						<b>Product</b>
					</td>

					<td align="center" id="loa" onclick=" selectpage(this.id);" style="background-color:#FCF3CF;">
						<b>Loading</b>
					</td>
					<td align="center" id="ull" onclick=" selectpage(this.id);" style="background-color:#FCF3CF;">
						<b>Ullage</b>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<hr>
					</td>
				</tr>
			</table>


			<br>
			<div id="prosection" style="display:block">
				<div style="overflow-x:auto;">
					<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
						<thead>
							<tr class="right_backcolor">
								<th nowrap="nowrap" class="Corner">&nbsp;</th>
								<th nowrap="nowrap" class="Odd">S/N</th>
								<th nowrap="nowrap" class="Odd">Item</th>
								<th nowrap="nowrap" class="Odd">Description</th>
								<th nowrap="nowrap" class="Odd">Qty Booked</th>
								<th class="Odd">Supply Subloc</th>
								<?php if (trim($rcvloc) != '') { ?>
									<th class="Odd">Receiving Subloc</th>
								<?php } ?>

								<th nowrap="nowrap">&nbsp;</th>
							</tr>
						</thead>
						<?php
						$k = 0;


						while ($k < $count_products) {
							$k++;
							$i = $k - 1;

						?>

							<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
								<td nowrap="nowrap">&nbsp;</td>
								<td nowrap="nowrap"><?php echo $k; ?></td>

								<td nowrap="nowrap"><?php echo $productArray[$i]['item']; ?>
									<input type="hidden" id="theitem<?php echo $i; ?>" value="<?php echo $productArray[$i]['item']; ?>" />
								</td>
								<td nowrap="nowrap"><?php echo $productArray[$i]["itemdesc"]; ?></td>
								<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["qty_booked"], 2); ?>
									<input type="hidden" id="theqty_booked<?php echo $i; ?>" value="<?php echo $productArray[$i]['qty_booked']; ?>" />
								</td>
								<td>
									<?php
									$q = 0;
									?>
									<br />
									<select name="subloc" title="Select Sub Inventory Location" id="subloc<?php echo $i; ?>">
										<option value=""></option>
										<?php

										while ($q < $count_subloc_supply) {

										?>
											<option value="<?php echo trim($supply_subloc_array[$q]['subloc']); ?>">
												<?php echo trim($supply_subloc_array[$q]['subloc']) . ' Qty ' . number_format($supply_subloc_array[$q]['useable_onhand'], 2); ?>
											</option>

										<?php
											$q++;
										} //End If Result Test	
										?>
									</select>
								</td>
								<?php if (trim($rcvloc) != '') { ?>
									<td>
										<?php
										$w = 0;
										?>
										<br />
										<select name="rsubloc" title="Select Sub Inventory Location" id="rsubloc<?php echo $i; ?>">
											<option value=""></option>
											<?php

											while ($w < $count_subloc_rcv) {

											?>
												<option value="<?php echo trim($rcv_subloc_array[$w]['subloc']); ?>">
													<?php echo trim($rcv_subloc_array[$w]['subloc']) . ' Qty ' . number_format($rcv_subloc_array[$w]['useable_onhand'], 2); ?>
												</option>

											<?php
												$w++;
											} //End If Result Test	
											?>
										</select>

									</td>
								<?php } ?>

								<td nowrap="nowrap"></td>
							</tr>


						<?php

							//End For Loop
						} //End If Result Test	
						?>
					</table>
				</div>
			</div>

			<div id="loasection" style="display:none">

				<table cellpadding="15px">
					<tr>
						<td><b>Started</b> </td>
						<td><input type="datetime-local" id="load_start" value="<?php echo $load_start; ?>" title="Time Loading Started" /></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Completed</b></td>
						<td><input type="datetime-local" id="load_end" value="<?php echo $load_end; ?>" title="Time Loading Completed" /></td>
					</tr>
					<tr>
						<td><b>Loader's Name</b></td>
						<td><input type="text" id="loadername" value="<?php echo $loadername; ?>" /></td>
						<td align="right"><b>Qty To Load</b></td>
						<td align="center"><?php echo number_format($store_qty, 2); ?><input type="hidden" id="store_qty" value="<?php echo $store_qty; ?>" readonly /></td>
					</tr>
					<tr>
						<td><b>Meter Before</b></td>
						<td><input type="text" size="7" id="mtr_b4" value="<?php echo $mtr_b4; ?>" onChange="javascript: checkreadings(this.id);" /></td>
						<td align="right"> <b>Meter After</b></td>
						<td align="center"><input type="text" size="7" id="mtr_after" value="<?php echo $mtr_after; ?>" onChange="javascript: checkreadings(this.id); " /></td>
					</tr>
				</table>

			</div>
			<div id="ullsection" style="display:none">

				<div style="overflow-x:auto;">
					<table width="95%">
						<tr>
							<td align="left" width="20%"><b>Ullage Time</b></td>
							<td><input type="datetime-local" id="ull_time" value="<?php echo $ull_time; ?>" /></td>
							<td colspan="2" align="right" nowrap="nowrap"><b>Ullager'S Name</b></td>
							<td><input type="text" size="7" id="ull_name" value="<?php echo $ull_name; ?>" /></td>


						</tr>
					</table>
				</div>
				<br />
				<table width="95%">

					<tr align="center">
						<td align="left" width="20%"><b>Compartment No</b></td>
						<td>1</td>
						<td>2</td>
						<td>3</td>
						<td>4</td>
						<td>5</td>
						<td>6</td>
					</tr>
					<tr>
						<td width="20%"><b>Volume in Litres</b></td>
						<td><input type="text" size="7" id="vol1" value="<?php echo $vol1; ?>" onChange="javascript: checkvol(this.id); " /></td>
						<td><input type="text" size="7" id="vol2" value="<?php echo $vol2; ?>" onChange="javascript: checkvol(this.id); " /></td>
						<td><input type="text" size="7" id="vol3" value="<?php echo $vol3; ?>" onChange="javascript: checkvol(this.id); " /></td>
						<td><input type="text" size="7" id="vol4" value="<?php echo $vol4; ?>" onChange="javascript: checkvol(this.id); " /></td>
						<td><input type="text" size="7" id="vol5" value="<?php echo $vol5; ?>" onChange="javascript: checkvol(this.id); " /></td>
						<td><input type="text" size="7" id="vol6" value="<?php echo $vol6; ?>" onChange="javascript: checkvol(this.id); " /></td>
					</tr>
					<tr>
						<td width="20%"><b>Ullage</b></td>
						<td><input type="text" size="7" id="ullage1" value="<?php echo $ullage1; ?>" onChange="javascript: checkull(this.id); " /></td>
						<td><input type="text" size="7" id="ullage2" value="<?php echo $ullage2; ?>" onChange="javascript: checkull(this.id); " /></td>
						<td><input type="text" size="7" id="ullage3" value="<?php echo $ullage3; ?>" onChange="javascript: checkull(this.id); " /></td>
						<td><input type="text" size="7" id="ullage4" value="<?php echo $ullage4; ?>" onChange="javascript: checkull(this.id); " /></td>
						<td><input type="text" size="7" id="ullage5" value="<?php echo $ullage5; ?>" onChange="javascript: checkull(this.id); " /></td>
						<td><input type="text" size="7" id="ullage6" value="<?php echo $ullage6; ?>" onChange="javascript: checkull(this.id); " /></td>
					</tr>
					<tr>
						<td width="20%"><b>Upper Seal No</b></td>
						<td><input type="text" size="7" id="upseal_no1" value="<?php echo $upseal_no1; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="upseal_no2" value="<?php echo $upseal_no2; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="upseal_no3" value="<?php echo $upseal_no3; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="upseal_no4" value="<?php echo $upseal_no4; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="upseal_no5" value="<?php echo $upseal_no5; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="upseal_no6" value="<?php echo $upseal_no6; ?>" onChange="javascript: checksealno(this.id); " /></td>
					</tr>
					<tr>
						<td width="20%"><b>Lower Seal No</b></td>
						<td><input type="text" size="7" id="loseal_no1" value="<?php echo $loseal_no1; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="loseal_no2" value="<?php echo $loseal_no2; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="loseal_no3" value="<?php echo $loseal_no3; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="loseal_no4" value="<?php echo $loseal_no4; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="loseal_no5" value="<?php echo $loseal_no5; ?>" onChange="javascript: checksealno(this.id); " /></td>
						<td><input type="text" size="7" id="loseal_no6" value="<?php echo $loseal_no6; ?>" onChange="javascript: checksealno(this.id); " /></td>
					</tr>
				</table>

			</div>


			<br />


			<table>
				<tr>

					<?php if ($show_void_button == 1) { ?>
						<td align="right" nowrap="nowrap">

							<input type="button" name="approvebutton" id="submit-button" title="Generate Way Bill/Invoice" value="Gen.Waybill" onclick="javascript: generateinvoice();">

						</td>
					<?php } ?>


					<td>
						<?php $calledby = 'brvloading';
						$reportid = 40;
						include("specificreportlink.php");  ?>
					</td>
				</tr>

			</table>

		<?php } ?>
	</form>
	<br />

	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('s_and_d.php?op=refresh','page');
				">

	<br />
</div>


<script>
	function checksealno(thisid) {
		var curid = document.getElementById(thisid);
		var theid = thisid.substring(9);
		var thevol = document.getElementById("vol" + theid);


		if (thevol.value == 0) {
			curid.value = 0;
			alert("The corresponding Volume Compartment is zero");
		}


	}

	function checkull(thisid) {
		var curid = document.getElementById(thisid);
		var theid = thisid.substring(6);
		var thevol = document.getElementById("vol" + theid);

		if (isNaN(curid.value)) {
			curid.value = 0;
			alert("Please Enter a Valid  Ullage");
		}

		if (Number(curid.value) < 0) {
			curid.value = 0;
		}
		if (thevol.value == 0) {
			curid.value = 0;
			alert("The corresponding Volume Compartment is zero");
		}


	}

	function checkvol(thisid) {
		var vol1 = document.getElementById("vol1");
		var vol2 = document.getElementById("vol2");
		var vol3 = document.getElementById("vol3");
		var vol4 = document.getElementById("vol4");
		var vol5 = document.getElementById("vol5");
		var vol6 = document.getElementById("vol6");
		var store_qty = document.getElementById("store_qty");
		var curid = document.getElementById(thisid);


		if (isNaN(vol1.value) || isNaN(vol2.value) || isNaN(vol3.value) || isNaN(vol4.value) || isNaN(vol5.value) || isNaN(vol6.value)) {

			alert("Please Enter a Valid Number");
			curid.value = 0;
		}

		if ((Number(vol1.value) + Number(vol2.value) + Number(vol3.value) + Number(vol4.value) + Number(vol5.value) + Number(vol6.value)) > Number(store_qty.value)) {

			alert("Current Entry will exceed Quantity to load.");
			curid.value = 0;
		}
	}


	function checkreadings(thisid) {
		var mtr_b4 = document.getElementById("mtr_b4");
		var mtr_after = document.getElementById("mtr_after");
		var store_qty = document.getElementById("store_qty");
		var resetmtr = 0;

		if (isNaN(mtr_b4.value) || isNaN(mtr_after.value)) {
			mtr_b4.value = 0;
			resetmtr = 1;
			alert("Please Enter a Valid Meter Ticket Number");
		}

		if (Number(mtr_b4.value) < 0 || Number(mtr_after.value) < 0) {
			mtr_b4.value = 0;
			resetmtr = 1;
		}

		if (Number(mtr_b4.value) >= Number(mtr_after.value)) {
			resetmtr = 1;
		}
		if (Number(mtr_after.value) - (Number(mtr_b4.value)) > Number(store_qty.value)) {
			alert('Meter Difference should not be more than quantity to Load');
			resetmtr = 1;
		}

		if (resetmtr == 1) {
			mtr_after.value = Number(store_qty.value) + Number(mtr_b4.value);
		}

	}

	function selectpage(theid) {

		var proheader = document.getElementById("pro");
		var ullheader = document.getElementById("ull");
		var loaheader = document.getElementById("loa");

		var prosection = document.getElementById("prosection");
		var ullsection = document.getElementById("ullsection");
		var loasection = document.getElementById("loasection");

		proheader.style = "background-color:#FCF3CF;";
		ullheader.style = "background-color:#FCF3CF;";
		loaheader.style = "background-color:#FCF3CF;";

		prosection.style = "display:none;";
		ullsection.style = "display:none;";
		loasection.style = "display:none;";

		var thesection = document.getElementById(theid + 'section');
		thesection.style = "display:block;";

		var theheader = document.getElementById(theid);
		theheader.style = "background-color:#C39BD3;";

	}

	function generateinvoice() {

		if (confirm('Are you sure the entries are correct?')) {

			var $goahead = 1;
			var rsubloc = '';


			var loccd = $('#loccd').val();
			var rcvloc = $('#rcvloc').val();
			var count_products = $('#count_products').val();

			var productstring = '';
			for (i = 0; i < count_products; i++) {
				var theitem = document.getElementById('theitem' + i).value;
				var thesubloc = document.getElementById('subloc' + i).value;
				var theqty_booked = document.getElementById('theqty_booked' + i).value;
				productstring = productstring + '&theitem' + i + '=' + theitem + '&subloc' + i + '=' + thesubloc + '&theqty_booked' + i + '=' + theqty_booked;
				if (loccd.trim() == '') {
					$goahead = 0;
					alert("Supply Location not provided");
				}

				if (thesubloc.trim() == '') {
					$goahead = 0;
					alert("One or more Sub Location not provided");
				}
				if (rcvloc.trim() != '') {
					var thersubloc = document.getElementById('rsubloc' + i).value;
					productstring = productstring + '&rsubloc' + i + '=' + thersubloc;
					if (thersubloc.trim() == '') {
						$goahead = 0;
						alert("One or more Sub Location not provided");
					}

				}

			}


			var deliveryaddress1 = $('#deliveryaddress1').val();
			if (deliveryaddress1.trim().length == 0) {
				$goahead = 0;
				alert("Please Specify the Destination Address");

			}

			var load_start = $('#load_start').val();
			var load_end = $('#load_end').val();
			var ull_time = $('#ull_time').val();

			var lstart = new Date(load_start);
			var lend = new Date(load_end);
			var ullagetime = new Date(ull_time);

			if (lstart.getTime() > lend.getTime()) {
				$goahead = 0;
				alert("Loading Completed Time can not be greater than Loading Commencement time");

			}

			if (lstart.getTime() > ullagetime.getTime() || lend.getTime() > ullagetime.getTime()) {
				$goahead = 0;
				alert("Ullaging Time can not be less than Loading Completion time");

			}


			var loadername = $('#loadername').val();
			if (loadername == '') {
				$goahead *= 0;
				alert('Please Specify Loader Name');
			}


			var mtr_b4 = $('#mtr_b4').val();
			if (mtr_b4 == 0) {
				$goahead *= 0;
				alert('Please Specify the Meter Reading Before Loading');
			}

			var mtr_after = $('#mtr_after').val();
			if (mtr_after == 0) {
				$goahead *= 0;
				alert('Please Specify the Meter Reading After Loading');
			}

			var ull_name = $('#ull_name').val();
			if (ull_name == '') {
				$goahead *= 0;
				alert("Please Specify the Ullager's Name");
			}


			var seal_no = $('#seal_no').val();
			if (seal_no == '') {
				$goahead *= 0;
				alert('Please Specify the Seal Number');
			}

			var vol1 = $('#vol1').val();
			var vol2 = $('#vol2').val();
			var vol3 = $('#vol3').val();
			var vol4 = $('#vol4').val();
			var vol5 = $('#vol5').val();
			var vol6 = $('#vol6').val();
			var store_qty = $('#store_qty').val();

			if ((Number(vol1) + Number(vol2) + Number(vol3) + Number(vol4) + Number(vol5) + Number(vol6)) < Number(store_qty)) {

				alert("Compartment Entry does not correspong with Quantity to load.");
				$goahead *= 0;
			}

			var $form_slipno = $('#slip_no').val();
			if ($form_slipno == '') {
				$goahead *= 0;
				alert('Please Specify Loading Slip Number');
			}

			var ullage1 = $('#ullage1').val();
			var ullage2 = $('#ullage2').val();
			var ullage3 = $('#ullage3').val();
			var ullage4 = $('#ullage4').val();
			var ullage5 = $('#ullage5').val();
			var ullage6 = $('#ullage6').val();

			var upseal_no1 = $('#upseal_no1').val();
			var upseal_no2 = $('#upseal_no2').val();
			var upseal_no3 = $('#upseal_no3').val();
			var upseal_no4 = $('#upseal_no4').val();
			var upseal_no5 = $('#upseal_no5').val();
			var upseal_no6 = $('#upseal_no6').val();
			var loseal_no1 = $('#loseal_no1').val();
			var loseal_no2 = $('#loseal_no2').val();
			var loseal_no3 = $('#loseal_no3').val();
			var loseal_no4 = $('#loseal_no4').val();
			var loseal_no5 = $('#loseal_no5').val();
			var loseal_no6 = $('#loseal_no6').val();

			if ((Number(vol1) > 0 && Number(ullage1) == 0) || (Number(vol2) > 0 && Number(ullage2) == 0) || (Number(vol3) > 0 && Number(ullage3) == 0) ||
				(Number(vol4) > 0 && Number(ullage4) == 0) || (Number(vol5) > 0 && Number(ullage5) == 0) || (Number(vol6) > 0 && Number(ullage6) == 0)) {
				$goahead *= 0;
				alert('Ullage for one or more of the Compartments is not specified.');

			}

			var $form_periodyear = $('#periodyear').val();
			var $form_periodmonth = $('#periodmonth').val();
			var today = new Date();
			var thismonth = (today.getMonth() + 1);
			var thisyear = today.getFullYear();
			if (Number($form_periodyear) != Number(thisyear) || Number($form_periodmonth) != Number(thismonth)) {
				alert('Date is not within the current period');
				$goahead *= 0;
			}
			if ($goahead == 1) {

				/*alert('brvloading.php?op=generateinvoice&slip_no='+$form_slipno+'&rcvloc='+rcvloc+'&loccd='+loccd
				+'&loadername='+loadername+'&load_start='+load_start+'&load_end='+load_end+productstring
				+'&mtr_b4='+mtr_b4+'&mtr_after='+mtr_after+'&ull_time='+ull_time+'&ull_name='+ull_name+'&seal_no='+seal_no+'&count_products='+count_products
				+'&store_qty='+store_qty+'&vol1='+vol1+'&vol2='+vol2+'&vol3='+vol3+'&vol4='+vol4+'&vol5='+vol5+'&vol6='+vol6
				+'&ullage1='+ullage1+'&ullage2='+ullage2+'&ullage3='+ullage3+'&ullage4='+ullage4+'&ullage5='+ullage5+'&ullage6='+ullage6);
			*/
				getpage('brvloading.php?op=generateinvoice&slip_no=' + $form_slipno + '&rcvloc=' + rcvloc + '&loccd=' + loccd + '&deliveryaddress1=' + deliveryaddress1 +
					'&loadername=' + loadername + '&load_start=' + load_start + '&load_end=' + load_end + productstring +
					'&mtr_b4=' + mtr_b4 + '&mtr_after=' + mtr_after + '&ull_time=' + ull_time + '&ull_name=' + ull_name + '&seal_no=' + seal_no + '&count_products=' + count_products +
					'&store_qty=' + store_qty + '&vol1=' + vol1 + '&vol2=' + vol2 + '&vol3=' + vol3 + '&vol4=' + vol4 + '&vol5=' + vol5 + '&vol6=' + vol6 +
					'&ullage1=' + ullage1 + '&ullage2=' + ullage2 + '&ullage3=' + ullage3 + '&ullage4=' + ullage4 + '&ullage5=' + ullage5 + '&ullage6=' + ullage6 +
					'&upseal_no1=' + upseal_no1 + '&upseal_no2=' + upseal_no2 + '&upseal_no3=' + upseal_no3 + '&upseal_no4=' + upseal_no4 + '&upseal_no5=' + upseal_no5 + '&upseal_no6=' + upseal_no6 +
					'&loseal_no1=' + loseal_no1 + '&loseal_no2=' + loseal_no2 + '&loseal_no3=' + loseal_no3 + '&loseal_no4=' + loseal_no4 + '&loseal_no5=' + loseal_no5 + '&loseal_no6=' + loseal_no6, 'page');
			}

		}

	}

	$(document).ready(function() {
		var now = new Date();
		var then = AddMinutesToDate(now, 30);
		var ullage = AddMinutesToDate(now, 90);

		arrangeDateTime(now, "load_start");
		arrangeDateTime(then, "load_end");
		arrangeDateTime(ullage, "ull_time");

		//alert(AddMinutesToDate(now, 30));
	});

	function arrangeDateTime(now, thecontrol) {
		var utcString = now.toISOString().substring(0, 19);
		var year = now.getFullYear();
		var month = now.getMonth() + 1;
		var day = now.getDate();
		var hour = now.getHours();
		var minute = now.getMinutes();
		var second = now.getSeconds();
		var localDatetime = year + "-" +
			(month < 10 ? "0" + month.toString() : month) + "-" +
			(day < 10 ? "0" + day.toString() : day) + "T" +
			(hour < 10 ? "0" + hour.toString() : hour) + ":" +
			(minute < 10 ? "0" + minute.toString() : minute) +
			utcString.substring(16, 19);
		var load_datetime = document.getElementById(thecontrol);
		load_datetime.value = localDatetime;
	}


	function AddMinutesToDate(date, minutes) {
		return new Date(new Date(date).getTime() + minutes * 60000);
	}
</script>