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

	$query = "SELECT a.*,b.item,b.itemdesc,b.qty_asked,b.bprice," .
		"b.disc,b.duprice,b.vatduprice,b.price from headdata a, loadings b " .
		" WHERE TRIM(a.request) = TRIM(b.request) " .
		" AND TRIM(a.approval) = '' " .
		$holdadditionalwhereclause . " ORDER BY a.request";

	//echo $query;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$numrows = mysqli_num_rows($result);



	?>



	<form name="form1" id="form1" method="get" action="">
		<a href="#" class="noprint" onclick="window.close();return false">
			<h3>Close Window</h3>
		</a>

		<div id="print_table">
			<h3><strong>Pending Approvals </strong></h3>
			<h3><strong>Reporting from <?php echo $startdate; ?> &nbsp; to <?php echo $enddate; ?> </strong></h3>
			<table>

				<tr>
					<td align="center">


						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th class="Corner">&nbsp;</th>
									<th class="Odd">S/N</th>
									<th class="Odd">Requisition No:</th>
									<th class="Odd">Requisition Time</th>
									<th class="Odd">Customer Name</th>
									<th class="Odd">Product</th>
									<th class="Odd">Sup. Location</th>
									<th class="Odd">Destination</th>
									<th class="Odd">Quantity</th>
									<th class="Odd">Unit Price</th>
									<th class="Odd">Total Cost</th>
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
									<td><?php echo $row['request']; ?></td>
									<td><?php echo $row["loc_date"]; ?></td>
									<td><?php echo trim($row["ccompany"]); ?></td>
									<td><?php echo trim($row["itemdesc"]); ?></td>
									<td><?php echo substr($row["loc_name"], 0, 15); ?></td>
									<td><?php echo $row["station"]; ?></td>
									<td align="right"><?php echo number_format($row["qty_asked"], 2); ?></td>
									<td align="right"><?php echo number_format($row["price"], 2); ?></td>
									<td align="right"><?php echo number_format($row["total_cost"], 2); ?></td>
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