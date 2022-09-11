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
	<form action="" method="get" id="form1">
		<h3><strong>
				Void Requisition Balance
			</strong></h3>
		<?php
		if ($_SESSION['approval'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$branch_code = "";
			$periodyear = $_SESSION['periodyear'];
			$periodmonth = $_SESSION['periodmonth'];
			$op = !isset($_REQUEST['op']) ? "" : $dbobject->test_input($_REQUEST['op']);
			$request = !isset($_REQUEST['request']) ? '' : $dbobject->test_input($_REQUEST['request']);
			$company = !isset($_REQUEST['company']) ? '' : $dbobject->test_input($_REQUEST['company']);
			$apprem = !isset($_REQUEST['apprem']) ? "" : $dbobject->test_input($_REQUEST['apprem']);
			$count_getpmtdetails = 0;
			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$thereason = !isset($_REQUEST['thereason']) ? "" : $dbobject->test_input($_REQUEST['thereason']);

			$the_amount_to_refund = 0;
			function updatepayments($pmtreference, $referenceid)
			{
				//check 3
				global $keyword, $the_amount_to_refund, $request, $custno, $ccompany, $periodmonth, $periodyear;
				if ($the_amount_to_refund > 0) {
					$thevoidedamt = 0;
					$sql_QueryStr1 = "SELECT * FROM payments  WHERE TRIM(refno) = '$pmtreference'";
					$result_QueryStr1 = mysqli_query($_SESSION['db_connect'], $sql_QueryStr1);
					$count_QueryStr1 = mysqli_num_rows($result_QueryStr1);
					if ($count_QueryStr1 > 0) {
						$row = mysqli_fetch_array($result_QueryStr1);
						if ($row['amount'] > $the_amount_to_refund) {
							if ($row['amtused'] >= $the_amount_to_refund) {

								$sql_updatepayment1 = "update payments set amtused = amtused - $the_amount_to_refund WHERE TRIM(refno) = '$pmtreference'";
								$result_updatepayment1 = mysqli_query($_SESSION['db_connect'], $sql_updatepayment1);

								$thevoidedamt = $the_amount_to_refund;
								$the_amount_to_refund = 0;
							}
						} else {
							$the_amount_to_refund = $the_amount_to_refund - $row['amtused'];
							$sql_updatepayment1 = "update payments set amtused = 0 WHERE TRIM(refno) = '$pmtreference'";

							$result_updatepayment1 = mysqli_query($_SESSION['db_connect'], $sql_updatepayment1);

							$thevoidedamt = $the_amount_to_refund;
						}

						if ($thevoidedamt > 0) {
							//***Update payment usage voidedamt field
							$sql_updatePaymentuse = "update paymentsuse set voidedamt$referenceid = $thevoidedamt,amtused$referenceid = amtused$referenceid - $thevoidedamt
								  WHERE trim(request) = '$keyword' and TRIM(refno$referenceid) = '$pmtreference'";

							$result_updatePaymentuse = mysqli_query($_SESSION['db_connect'], $sql_updatePaymentuse);



							$sql_CreateJournal1 = "call CreateJournalEntries('UNDOPAYMENTS_RECONCILIATION','$custno','$ccompany',$thevoidedamt,'" . date("d/m/Y h:i:s A") .
								"','$periodmonth','$periodyear')";

							$result_CreateJournal1 = mysqli_query($_SESSION['db_connect'], $sql_CreateJournal1);
						}
					}
				}
			}


			$productArray = array();
			if ($op == 'searchkeyword') {
				$sql_request = "select *  from headdata where approve_ok=1 and trim(request) = '$keyword'";
				$result_request = mysqli_query($_SESSION['db_connect'], $sql_request);
				$count_request = mysqli_num_rows($result_request);
				//echo $sql_request;
				if ($count_request >= 1) {
					$row = mysqli_fetch_array($result_request);
					$request = $row['request'];
				} else {
					$keyword = '';
		?>
					<script>
						$('#item_error').html("<strong>Selected Requisition is yet to be approved. <br/> Use the option of Refusal to Cancel a fresh Requisition</strong>");
					</script>
				<?php
				}
			}

			//retrieve requisition	

			$sql_getrequest = "select *  from headdata where trim(request) = '$keyword'";

			$result_getrequest = mysqli_query($_SESSION['db_connect'], $sql_getrequest);
			$count_getrequest = mysqli_num_rows($result_getrequest);
			if ($count_getrequest >= 1) {
				$row = mysqli_fetch_array($result_getrequest);
				$request = $row['request'];
				$custno = $row['custno'];
				$ccompany = $row['ccompany'];
				$approval = $row['approval'];
				$approval1 = $row['approval1'];
				$loccd = $row['loccd'];
				$loc_name = $row['loc_name'];
				$rcvloc = $row['rcv_locnm'];
				$py = $row['py'];
				$mv = $row['mv'];
				$bu = $row['bu'];
				$reqrem = $row['reqrem'];
				if ($apprem == '') {
					$apprem = $row['apprem'];
				}
				$approve_ok = $row['approve_ok'];
				$refuse = $row['refuse'];
				$loc_date = $row['loc_date'];
				$appr_date = $row['appr_date'];
				$salespsn = $row['salespsn'];
				$total_cost = $row['total_cost'];
				$reqst_by = $row['reqst_by'];
			} else {
				$custno = '';
				$ccompany = '';
				$approval = '';
				$approval1 = '';
				$loccd = '';
				$loc_name = '';
				$rcvloc = '';
				$py = '';
				$mv = '';
				$bu = '';
				$reqrem = '';
				$approve_ok = 0;
				$refuse = 0;
				$loc_date = '';
				$loc_date = '';
				$appr_date = '';
				$salespsn = '';
				$total_cost = 0;
				$reqst_by = '';
			}

			// retrieve product		

			$sql_products =  "SELECT item,itemdesc, qty_asked, price, cost, qty_booked,request,voided_qty FROM loadings " .
				" where trim(request) = '$keyword'";

			$show_void_button = 0;
			$result_products = mysqli_query($_SESSION['db_connect'], $sql_products);
			$count_products = mysqli_num_rows($result_products);
			for ($i = 0; $i < $count_products; $i++) {
				$row = mysqli_fetch_array($result_products);
				$productArray[$i]['item'] = $row['item'];
				$productArray[$i]['itemdesc'] = $row['itemdesc'];
				$productArray[$i]['qty_asked'] = $row['qty_asked'];
				$productArray[$i]['qty_booked'] = $row['qty_booked'];
				$productArray[$i]['price'] = $row['price'];
				$productArray[$i]['cost'] = $row['cost'];
				$productArray[$i]['request'] = $row['request'];
				$productArray[$i]['voided_qty'] = $row['voided_qty'];
				if ($row['qty_asked'] > $row['qty_booked']) {
					$show_void_button = 1;
				} else {
					$show_void_button = 0;
				}
			}


			//***get pmt usage based on this requisition

			$sql_getpmtusage = "select *  from paymentsuse where trim(request) = '$keyword'";

			$result_getpmtusage = mysqli_query($_SESSION['db_connect'], $sql_getpmtusage);
			$count_getpmtusage = mysqli_num_rows($result_getpmtusage);
			if ($count_getpmtusage >= 1) {
				$row = mysqli_fetch_array($result_getpmtusage);
				$getpaymentdetails = 1;
				$invoice_no = $row['invoice_no'];
				$payments = $row['payments'];
				$refno1 = $row['refno1'];
				$amtused1 = $row['amtused1'];
				$refno2 = $row['refno2'];
				$amtused2 = $row['amtused2'];
				$refno3 = $row['refno3'];
				$amtused3 = $row['amtused3'];
				$refno4 = $row['refno4'];
				$amtused4 = $row['amtused4'];
				$refno5 = $row['refno5'];
				$amtused5 = $row['amtused5'];

				//		**VARIABLE TO BE USED IN $ STATEMENT
				$refnovar = "'" . $refno1 . "','" . $refno2 . "','" . $refno3 . "','" .
					$refno4 . "','" . $refno5 . "'";


				//		&& RETRIEVING detail PAYMENTS REFERENCES USED IN THIS TRANSACTION
				$sql_getpmtdetails = "SELECT a.refno, a.amount, a.amtused, a.bank_code, a.dd_no," .
					" a.dd_date FROM payments a where a.advrefund1 = 1 and trim(a.refno) in (" . $refnovar . ")";

				//echo 	$sql_getpmtdetails;		
				$result_getpmtdetails = mysqli_query($_SESSION['db_connect'], $sql_getpmtdetails);
				$count_getpmtdetails = mysqli_num_rows($result_getpmtdetails);
			} else {
				$getpaymentdetails = 0;
				$invoice_no = '';
				$payments = 0.0;
				$refno1 = '';
				$amtused1 = 0.0;
				$refno2 = '';
				$amtused2 = 0;
				$refno3 = '';
				$amtused3 = 0;
				$refno4 = '';
				$amtused4 = 0;
				$refno5 = '';
				$amtused5 = 0;
			}




			$justvoided = 0;
			if ($op == 'voidreqbal') {
				$goahead = 1;
				// ***IF THERE ARE LOADING SLIPS NOT YET LOADED, DO NOT PERMIT REVERSAL

				$sql_checkifopenslipexist = "SELECT * FROM invoice  WHERE TRIM(request) = '$keyword' and TRIM(invoice_no) = '' and reversed = 0 ";

				$result_checkifopenslipexist = mysqli_query($_SESSION['db_connect'], $sql_checkifopenslipexist);
				$count_checkifopenslipexist = mysqli_num_rows($result_checkifopenslipexist);
				if ($count_checkifopenslipexist > 0) {
				?>
					<script>
						$('#item_error').html("<strong>There are Loading Slips for this Requisition neither Loaded nor Reversed. You cannot Void this Requisition at this time.</strong>");
					</script>
				<?php
					$goahead = 0;
				}


				if ($goahead == 1) {


					for ($i = 0; $i < $count_products; $i++) {
						$the_amount_to_refund = $the_amount_to_refund + (($productArray[$i]['qty_asked'] - $productArray[$i]['qty_booked']) * $productArray[$i]['price']);

						$sql_updatevoidedqty = "update loadings set voided_qty = qty_asked - qty_booked , voidreason = '$thereason'
								WHERE TRIM(request) = '$keyword' and TRIM(item) = '" . $productArray[$i]['item'] . "'";

						$result_updatevoidedqty = mysqli_query($_SESSION['db_connect'], $sql_updatevoidedqty);

						$sql_updatebookedqty = "update loadings set qty_booked = qty_asked  
								WHERE TRIM(request) = '$keyword' and TRIM(item) = '" . $productArray[$i]['item'] . "'";

						$result_updatebookedqty = mysqli_query($_SESSION['db_connect'], $sql_updatebookedqty);
					}

					$sql_CreateJournalR = "call CreateJournalEntries('UNDOREQUISITION','$custno','$ccompany'," . $the_amount_to_refund . ",'" . date("d/m/Y h:i:s A") .
						"','$periodmonth','$periodyear')";


					$result_CreateJournalR = mysqli_query($_SESSION['db_connect'], $sql_CreateJournalR);



					if ($the_amount_to_refund > 0) {
						updatepayments($refno1, 1);
					}

					if ($the_amount_to_refund > 0) {
						updatepayments($refno2, 2);
					}

					if ($the_amount_to_refund > 0) {
						updatepayments($refno3, 3);
					}

					if ($the_amount_to_refund > 0) {
						updatepayments($refno4, 4);
					}

					if ($the_amount_to_refund > 0) {
						updatepayments($refno5, 5);
					}


				?>
					<script>
						$('#item_error').html("<strong>Unutilised Requestion Quantity Voided</strong>");
					</script>
			<?php


					$savetrail = $dbobject->apptrail($_SESSION['username_sess'], 'Unused Requisition Quantity', $keyword, date("d/m/Y h:i:s A"), 'Voided');

					$justvoided = 1;
				}
			}
			//****


			?>
			<style>
				td {
					padding: 2px;
				}
			</style>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="approvals" />
			<input type="hidden" name="get_file" id="get_file" value="voidreqbalance" />
			<table border="0">
				<td colspan="4" style="color:red;" id="item_error" align="left"></td>
				<tr>
					<td colspan="4">
						<input type="text" size="71px" id="search" title="Search for Requisition by Name or Code" placeholder="Search for Requisition by Name or Code" />
						<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

						<!-- Suggestions will be displayed in below div. -->

						<div id="display"></div>
					</td>

				</tr>
				<tr>
					<td><strong>Request No :</strong></td>
					<td align="left">
						<input type="text" name="request" id="request" style="background:transparent;border:none;" tabindex="-1" value="<?php echo $keyword; ?>" readonly>
					</td>


					<td align="left">
						<strong>Req. Time:</strong>
					</td>
					<td nowrap="nowrap"> <?php echo "  " . $loc_date; ?> </td>
				</tr>

				<tr>
					<td><strong>Customer: </strong></td>
					<td align="left">
						<?php echo $custno . ": " . $ccompany; ?>
					</td>
					<td><strong>Remark :</strong>
						<?php echo $reqrem; ?>
					</td>
					<td><strong>Reqst_By :</strong>
						<?php echo $reqst_by; ?></td>
				</tr>
				<tr>
					<td><strong>Approval No: </strong></td>
					<td align="left">
						<?php echo $approval1 . $approval; ?>
					</td>
					<td><strong>Remark :</strong>
						<?php echo $apprem; ?>
					</td>
					<td nowrap="nowrap"><strong>Time:</strong> <?php echo "  " . $appr_date; ?> </td>

				</tr>

				<tr>
					<td><b>Reason</b></td>
					<td colspan="4"><input type="text" size="55%" id="thereason" name="thereason" placeholder="Please state the reason for Action" value="<?php echo $thereason; ?>" /></td>
				</tr>
			</table>

			<br>
			<strong>Products</strong>
			<div style="overflow-x:auto;">
				<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
					<thead>
						<tr class="right_backcolor">
							<th nowrap="nowrap" class="Corner">&nbsp;</th>
							<th nowrap="nowrap" class="Odd">S/N</th>
							<th nowrap="nowrap" class="Odd">Item</th>
							<th nowrap="nowrap" class="Odd">Description</th>
							<th nowrap="nowrap" class="Odd">Req. Quantity</th>
							<th nowrap="nowrap" class="Odd">Booked Quantity</th>
							<th nowrap="nowrap" class="Odd">Voided Quantity</th>
							<th nowrap="nowrap" class="Odd">Price</th>
							<th nowrap="nowrap" class="Odd">Cost</th>
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
							<td nowrap="nowrap"><?php echo $productArray[$i]['item']; ?></td>
							<td nowrap="nowrap"><?php echo $productArray[$i]["itemdesc"]; ?></td>
							<td nowrap="nowrap" align="right"><?php echo $productArray[$i]["qty_asked"]; ?></td>
							<td nowrap="nowrap" align="right"><?php echo $productArray[$i]["qty_booked"]; ?></td>
							<td nowrap="nowrap" align="right"><?php echo $productArray[$i]["voided_qty"]; ?></td>
							<td nowrap="nowrap" align="right"><?php echo $productArray[$i]["price"]; ?></td>
							<td nowrap="nowrap" align="right"><?php echo $productArray[$i]["cost"]; ?></td>
							<td nowrap="nowrap"></td>
						</tr>
					<?php
						//} //End For Loop

					} //End If Result Test	
					?>
				</table>
			</div>
			<br>
			<div style="overflow-x:auto;">
				<table border="1">
					<tr>
						<td>
							<strong>Payment References</strong>
							<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
								<thead>
									<tr class="right_backcolor">
										<th nowrap="nowrap" class="Corner">&nbsp;</th>
										<th nowrap="nowrap" class="Odd">Pmt References</th>
										<th nowrap="nowrap" class="Odd">Amount Referenced</th>
										<th nowrap="nowrap">&nbsp;</th>
									</tr>
								</thead>


								<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
									<td nowrap="nowrap">&nbsp;</td>
									<td nowrap="nowrap">
										<?php echo $refno1; ?><br>
										<?php echo $refno2; ?><br>
										<?php echo $refno3; ?><br>
										<?php echo $refno4; ?><br>
										<?php echo $refno5; ?> <br>
										<strong>Total</strong>
									</td>
									<td nowrap="nowrap" align="right">
										<?php echo $amtused1; ?> <br>
										<?php echo $amtused2; ?> <br>
										<?php echo $amtused3; ?> <br>
										<?php echo $amtused4; ?> <br>
										<?php echo $amtused5; ?> <br>
										<strong><?php echo $payments; ?> </strong>
									</td>
									<td nowrap="nowrap"></td>
								</tr>

							</table>
						</td>
						<td>
							<strong>Payment Instrument Details</strong>
							<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
								<thead>
									<tr class="right_backcolor">
										<th nowrap="nowrap" class="Corner">&nbsp;</th>
										<th nowrap="nowrap" class="Odd">S/N</th>
										<th nowrap="nowrap" class="Odd">Receipt No</th>
										<th nowrap="nowrap" class="Odd">Amount</th>
										<th nowrap="nowrap" class="Odd">Amount Used</th>
										<th nowrap="nowrap" class="Odd">Balance</th>
										<th nowrap="nowrap">&nbsp;</th>
									</tr>
								</thead>
								<?php
								$k = 0;

								while ($k < $count_getpmtdetails) {
									$k++;
									$row = mysqli_fetch_array($result_getpmtdetails);

								?>

									<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap">&nbsp;<?php echo $k; ?></td>
										<td nowrap="nowrap">&nbsp;<?php echo $row['refno']; ?></td>
										<td nowrap="nowrap">&nbsp;<?php echo number_format($row["amount"], 2); ?></td>
										<td nowrap="nowrap" align="right">&nbsp;<?php echo number_format($row["amtused"], 2); ?></td>
										<td nowrap="nowrap" align="right">&nbsp;<?php echo number_format($row["amount"] - $row["amtused"], 2); ?></td>
										<td nowrap="nowrap">&nbsp;</td>
									</tr>
								<?php
									//} //End For Loop
								} //End If Result Test	
								?>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<br>

			<table>
				<tr>

					<?php if ($show_void_button == 1 && $justvoided == 0) { ?>
						<td align="right" nowrap="nowrap">

							<input type="button" name="approvebutton" id="submit-button" title="Void Requisition Balance" value="Void Balance" onclick="javascript: voidreqbal(); ">

						</td>

					<?php } ?>

					<td>
						<?php $calledby = 'voidreqbalance';
						$reportid = 43;
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
	function voidreqbal() {

		if (confirm('Are you sure the entries are correct?')) {
			var $form_request = $('#request').val();
			var $form_thereason = $('#thereason').val();

			var $goahead = 1;
			if ($form_thereason == '') {
				$goahead *= 0;
				alert('Reason for Voiding Not Provided');

			}
			if ($goahead == 1) {
				getpage('voidreqbalance.php?op=voidreqbal&keyword=' + $form_request + '&thereason=' + $form_thereason, 'page');
			}

		}


	}
</script>