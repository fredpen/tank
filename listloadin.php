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

	$datefield = "a.loc_date";
	$custnofield = "trim(a.custno)";
	$salespsnfield = "trim(a.salespsn)";
	$itemfield = "trim(b.item)";
	$loccdfield = "";
	$vendornofield = "";
	$po_field = "";

	$periodmonthfield = "";
	$periodyearfield = "";
	include "reportcondition.php";

	$query = "SELECT a.invoice_dt,a.slip_no,a.invoice_no," .
		" ((select volfactor from icitem where TRIM(item) = TRIM(b.item))*b.store_qty) as quantity ," .
		" b.item,b.itemdesc,b.qty_booked,b.store_qty,b.bprice," .
		" b.disc,b.duprice,b.vatduprice,b.price,a.vehcno,a.trasno,a.tcompany,a.custno,a.ccompany,a.station, " .
		" a.loccd,a.loc_name, (b.store_qty*b.price) AS INVOICE_AM, a.reversed, a.request " .
		" FROM invoice a, inv_detl b " .
		" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.qty_booked > 0 " .
		$holdadditionalwhereclause . " ORDER BY  a.loccd,b.item,a.invoice_dt,a.request  ";

	$query_summary = "SELECT sum((select volfactor from icitem where TRIM(item) = TRIM(b.item))*b.store_qty) as quantity ," .
		" sum(b.qty_booked) qty_booked FROM invoice a, inv_detl b " .
		" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.qty_booked > 0 " .
		$holdadditionalwhereclause;



	//echo $query;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$result_summary = mysqli_query($_SESSION['db_connect'], $query_summary);
	$numrows = mysqli_num_rows($result);

	$summary_qty_booked = 0;
	$summary_quantity = 0;
	if ($numrows > 0) {
		$row_summary = mysqli_fetch_array($result_summary);
		$summary_qty_booked = $row_summary['qty_booked'];
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
			<h3><strong>List of Loading Slips</strong></h3>
			<h3><strong>Reporting from <?php echo $startdate; ?> &nbsp; to <?php echo $enddate; ?> </strong></h3>
			<table>

				<tr>
					<td align="center">


						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th class="Corner">&nbsp;</th>
									<th class="Odd">S/N</th>
									<th class="Odd">Supply Location</th>
									<th class="Odd">Product</th>
									<th class="Odd">Req. No</th>
									<th class="Odd">Loading Slip</th>
									<th class="Odd">Qty Booked</th>
									<th class="Odd">Qty Loaded</th>
									<th class="Odd">Price</th>
									<th class="Odd">BRV</th>
									<th class="Odd">Customer</th>
									<th class="Odd">Retail Outlet</th>
									<th class="Odd">Status</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<?php

							$k = 0;


							while ($k < $numrows) {
								$k++;
								//for($i=0; $i<$numrows; $i++){
								$row = mysqli_fetch_array($result);
								//while($i < $skip) continue;
								//echo 'count '.$i.'   '.$skip;	
								//}
							?>

								<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
									<td>&nbsp;</td>
									<td><?php echo $k; ?></td>
									<td><?php echo substr(trim($row['loc_name']), 0, 15); ?></td>
									<td><?php echo trim($row['itemdesc']); ?></td>
									<td><?php echo substr(trim($row['request']), 0, 11); ?></td>
									<td><?php echo trim($row['slip_no']); ?></td>
									<td align="right"><?php echo number_format($row['qty_booked'], 2); ?></td>
									<td align="right"><?php echo number_format($row['quantity'], 2); ?></td>
									<td align="right"><?php echo number_format($row['price'], 2); ?></td>
									<td><?php echo $row['vehcno']; ?></td>
									<td><?php echo substr(trim($row['ccompany']), 0, 25); ?></td>
									<td><?php echo trim($row['station']); ?></td>
									<td><?php echo ($row['reversed'] == 1 ? "Reversed" : "Okay"); ?></td>
									<td></td>
								</tr>
							<?php
								//} //End For Loop
							} //End If Result Test	
							?>

							<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
								<td>&nbsp;</td>
								<td> </td>
								<td></td>
								<td><strong>Summary : </strong></td>
								<td></td>
								<td></td>
								<td align="right"><strong><?php echo number_format($summary_qty_booked, 2); ?></strong></td>
								<td align="right"><strong><?php echo number_format($summary_quantity, 2); ?></strong></td>
								<td align="right"></td>
								<td></td>
								<td> </td>
								<td></td>
								<td> </td>
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