<?php
ob_start();
include_once "session_track.php";

include "printheader.php";
?>

<style>
	table {
		border-collapse: collapse;
	}

	@media screen {
		td {
			padding: 5px;
		}

		.tableb {
			border-radius: 15px 50px;
			border-collapse: separate;
			border: 5px solid olive;
		}

		#print_table {
			display: none;
		}
	}

	@media print {

		#print,
		#head-inner,
		#smoothmenu1,
		.tableb,
		.noprint,
		.PrintButton {
			display: none;
		}

		#print_table {
			display: block;
		}


	}
</style>

<div align="center" id="data-form">

	<?php

	include "basicparameters.php";

	$datefield = "a.invoice_dt";
	$custnofield = "trim(a.custno)";
	$salespsnfield = "trim(a.salespsn)";
	$itemfield = "trim(b.item)";
	$loccdfield = "trim(a.loccd)";
	$vendornofield = "";
	$po_field = "";


	$periodmonthfield = "";
	$periodyearfield = "";
	include "reportcondition.php";

	$query_summary = "SELECT sum(((select volfactor from icitem where TRIM(item) = TRIM(b.item))*b.store_qty)) as quantity ," .
		" sum(b.store_qty*b.price) AS invoice_am " .
		" FROM invoice a, inv_detl b, salesperson c " .
		" WHERE trim(a.slip_no) = trim(b.slip_no) and trim(a.salespsn) = trim(c.salespsn) " .
		" AND b.store_qty > 0 and a.reversed = 0 " .
		$holdadditionalwhereclause . " ORDER BY STR_TO_DATE(a.invoice_dt , '%d/%m/%Y') desc ";

	$result_summary = mysqli_query($_SESSION['db_connect'], $query_summary);



	//echo $query;
	$query = "SELECT b.request as linerequest,c.salespsn, c.salespsnname, c.salespsnemail, c.salespsnphone, " .
		" a.invoice_dt,a.slip_no,a.invoice_no,concat(TRIM(a.approval1),TRIM(a.approval)) approval_no, " .
		" ((select volfactor from icitem where TRIM(item) = TRIM(b.item))*b.store_qty) as quantity ," .
		" b.item,b.itemdesc,b.qty_booked,b.store_qty,b.bprice,a.reversed, a.request ," .
		" b.disc,b.duprice,b.vatduprice,b.price,a.vehcno,a.trasno,a.tcompany,a.custno,a.ccompany,a.station, " .
		" a.loccd,a.loc_name, (b.store_qty*b.price) AS invoice_am " .
		" FROM invoice a, inv_detl b, salesperson c " .
		" WHERE trim(a.slip_no) = trim(b.slip_no) and trim(a.salespsn) = trim(c.salespsn) " .
		" AND b.store_qty > 0 and a.reversed = 0" .
		$holdadditionalwhereclause . " ORDER BY c.salespsnname,a.ccompany, STR_TO_DATE(a.invoice_dt , '%d/%m/%Y') desc ";

	//echo $query;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$numrows = mysqli_num_rows($result);
	$summary_invoice_am = 0;
	$summary_quantity = 0;
	if ($numrows > 0) {
		$row_summary = mysqli_fetch_array($result_summary);
		$summary_invoice_am = $row_summary['invoice_am'];
		$summary_quantity = $row_summary['quantity'];
	}


	?>


	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">

		<a href="#" class="noprint" onclick="window.close();return false">
			<h3>Close Window</h3>
		</a>

		<div id="print_table">
			<h3><strong>Sales Person Performance</strong></h3>
			<h3><strong>Reporting from <?php echo $startdate; ?> &nbsp; to <?php echo $enddate; ?> </strong></h3>
			<table>

				<tr>
					<td align="center">


						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th class="Corner">&nbsp;</th>
									<th class="Odd">S/N</th>
									<th class="Odd">Invoice Number</th>
									<th class="Odd">Date</th>
									<th class="Odd">Ticket No</th>
									<th class="Odd">Customer</th>
									<th class="Odd">Product</th>
									<th class="Odd">Quantity</th>
									<th class="Odd">Invoice Amount</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<?php

							$k = 0;

							$prev_salespsn = "1";
							while ($k < $numrows) {
								$k++;
								//for($i=0; $i<$numrows; $i++){
								$row = mysqli_fetch_array($result);
								//while($i < $skip) continue;
								//echo 'count '.$i.'   '.$skip;	
								//}

								if (trim($prev_salespsn) != trim($row['salespsn'])) {
									$prev_salespsn = trim($row['salespsn']);
							?>


									<tr>
										<td>&nbsp;</td>
										<td></td>
										<td><strong>Sales Person</strong></td>
										<td></td>
										<td></td>
										<td><?php echo trim($row["salespsnname"]); ?></td>
										<td><?php echo trim($row["salespsnemail"]) . "-" . trim($row["salespsnphone"]); ?></td>
										<td align="right"> </td>
										<td align="right"> </td>
										<td></td>
									</tr>

								<?php
								}
								?>
								<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
									<td>&nbsp;</td>
									<td><?php echo $k; ?></td>
									<td><?php echo trim($row["invoice_no"]); ?></td>
									<td><?php echo trim($row["invoice_dt"]); ?></td>
									<td><?php echo SUBSTR(trim($row['slip_no']), 5, 2) . SUBSTR(trim($row['slip_no']), 7, 2) . SUBSTR(trim($row['slip_no']), 11); ?></td>
									<td><?php echo trim($row["ccompany"]); ?></td>
									<td><?php echo trim($row["itemdesc"]) . "-" . trim($row["item"]); ?></td>
									<td align="right"><?php echo number_format($row['quantity'], 2); ?></td>
									<td align="right"><?php echo number_format($row['invoice_am'], 2); ?></td>
									<td></td>
								</tr>
							<?php
								//} //End For Loop
							} //End If Result Test	
							?>

							<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
								<td>&nbsp;</td>
								<td></td>
								<td> </td>
								<td></td>
								<td></td>
								<td><strong>Report Summary</strong></td>
								<td></td>
								<td align="right"><strong><?php echo number_format($summary_quantity, 2); ?></strong></td>
								<td align="right"><strong><?php echo number_format($summary_invoice_am, 2); ?></strong></td>
								<td></td>
							</tr>
						</table>

					</td>
				</tr>

			</table>
		</div>

	</form>
</div>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.addEventListener("DOMContentLoaded", function() {
		PrintPage();
	});
</script>