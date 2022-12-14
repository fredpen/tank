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

	$datefield = "b.delv_date";
	$custnofield = "trim(a.custno)";
	$salespsnfield = "trim(a.salespsn)";
	$itemfield = "trim(b.item)";
	$loccdfield = "trim(a.loccd)";
	$vendornofield = "";
	$po_field = "";

	$periodmonthfield = "";
	$periodyearfield = "";
	include "reportcondition.php";

	$query = "SELECT DISTINCT a.*,b.item,b.itemdesc,b.qty_booked,b.store_qty,b.bprice," .
		"b.disc,b.duprice,b.vatduprice,b.price,b.delv_date,b.delv_qty," .
		" (select company from arcust where trim(arcust.custno) = trim(a.custno)) company " .
		"FROM invoice a, inv_detl b  " .
		"WHERE b.delv_qty >0 AND trim(a.slip_no) = trim(b.slip_no) " .
		$holdadditionalwhereclause . " ORDER BY a.slip_no desc";

	//echo $query;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$numrows = mysqli_num_rows($result);


	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">

		<a href="#" class="noprint" onclick="window.close();return false">
			<h3>Close Window</h3>
		</a>

		<div id="print_table">
			<p>
			<h3><strong>Confirmed Deliveries </strong></h3>
			</p>
			<h3><strong>Reporting from <?php echo $startdate; ?> &nbsp; to <?php echo $enddate; ?> </strong></h3>
			<table>

				<tr>
					<td align="center">


						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th class="Corner">&nbsp;</th>
									<th class="Odd">S/N</th>
									<th class="Odd">Supply Location:</th>
									<th class="Odd">Invoice No:</th>
									<th class="Odd">Customer</th>
									<th class="Odd">Transporter</th>
									<th class="Odd">BRV No</th>
									<th class="Odd">Item</th>
									<th class="Odd">Slip No</th>
									<th class="Odd">Invoice Date</th>
									<th class="Odd">Qty Loaded</th>
									<th class="Odd">Qty Delivered</th>
									<th class="Odd">Delivered Date</th>
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
									<td><?php echo $row['loc_name']; ?></td>
									<td><?php echo $row['invoice_no']; ?></td>
									<td><?php echo trim($row["custno"]) . "-" . trim($row["company"]); ?></td>
									<td><?php echo $row['tcompany']; ?></td>
									<td><?php echo trim($row["vehcno"]); ?></td>
									<td><?php echo trim($row["itemdesc"]); ?></td>
									<td><?php echo trim($row["slip_no"]); ?></td>
									<td><?php echo $row["invoice_dt"]; ?></td>
									<td><?php echo  number_format($row["store_qty"], 2); ?></td>
									<td><?php echo  number_format($row["delv_qty"], 2); ?></td>
									<td><?php echo $row["delv_date"]; ?></td>
									<td></td>
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