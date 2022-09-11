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

	$periodmonthfield = "trim(a.periodmonth)";
	$periodyearfield = "trim(a.periodyear)";

	$datefield = "";
	$custnofield = "";
	$salespsnfield = "";
	$itemfield = "";
	$loccdfield = "";
	$vendornofield = "";
	$po_field = "";


	include "reportcondition.php";



	$query = "select a.* FROM ledger a WHERE  1=1 " .
		$holdadditionalwhereclause;

	$query_summary1 = "SELECT sum(a.dr_amount) dr_amount,sum(a.cr_amount) cr_amount " .
		"   FROM ledger a WHERE 1=1 " .
		$holdadditionalwhereclause;


	//echo $query;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$result_summary1 = mysqli_query($_SESSION['db_connect'], $query_summary1);
	$numrows = mysqli_num_rows($result);

	$summary_dr_amount = 0;
	$summary_cr_amount = 0;
	if ($numrows > 0) {

		$row_summary1 = mysqli_fetch_array($result_summary1);
		$numrows_summary1 = mysqli_num_rows($result_summary1);
		if ($numrows_summary1 > 0) {
			$summary_dr_amount = $summary_dr_amount + $row_summary1['dr_amount'];
			$summary_cr_amount = $summary_cr_amount + $row_summary1['cr_amount'];
		}
	}


	?>


	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		<h3 class="noprint"><strong>General Ledger </strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false">Close Window</a>

		<div id="print_table">
			<h3><strong>General Ledger </strong></h3>
			<h3><strong>Reporting Period <?php echo $periodyear; ?> &nbsp; <?php echo $periodmonth; ?> </strong></h3>

			<table>

				<tr>
					<td align="center">


						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th nowrap="nowrap" class="Corner">&nbsp;</th>
									<th nowrap="nowrap" class="Odd">S/N</th>
									<th nowrap="nowrap" class="Odd">Period</th>
									<th nowrap="nowrap" class="Odd">Account Category</th>
									<th nowrap="nowrap" class="Odd">Debit</th>
									<th nowrap="nowrap" class="Odd">Credit</th>
									<th nowrap="nowrap">&nbsp;</th>
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
									<td nowrap="nowrap">&nbsp;</td>
									<td nowrap="nowrap"><?php echo $k; ?></td>
									<td nowrap="nowrap"><?php echo trim($row['periodyear']) . "  " . trim($row['periodmonth']); ?></td>
									<td nowrap="nowrap"><?php echo trim($row['acctno']) . "  " . trim($row['acctdescription']); ?></td>
									<td nowrap="nowrap" align="right"><?php echo number_format($row["dr_amount"], 2); ?></td>
									<td nowrap="nowrap" align="right"><?php echo number_format($row["cr_amount"], 2); ?></td>
									<td nowrap="nowrap"></td>
								</tr>
							<?php
								//} //End For Loop
							} //End If Result Test	
							?>

							<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
								<td nowrap="nowrap">&nbsp;</td>
								<td nowrap="nowrap"></td>
								<td nowrap="nowrap"> <strong>Summary: </strong></td>
								<td nowrap="nowrap"></td>
								<td nowrap="nowrap" align="right"><strong><?php echo number_format($summary_dr_amount, 2); ?></strong></td>
								<td nowrap="nowrap" align="right"><strong><?php echo number_format($summary_cr_amount, 2); ?></strong></td>
								<td nowrap="nowrap"></td>
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