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


	$datefield = "a.transdate";
	$custnofield = "";
	$salespsnfield = "";
	$itemfield = "";
	$loccdfield = "";
	$vendornofield = "";
	$po_field = "";

	$periodmonthfield = "";
	$periodyearfield = "";
	include "reportcondition.php";

	$query = " select a.* from journal a " .
		" where 1=1 " .
		$holdadditionalwhereclause . " ORDER BY STR_TO_DATE(a.transdate , '%d/%m/%Y') desc,a.transdate  ";

	$query_summary1 = " select sum(a.dr_amount) dr_amount, sum(a.cr_amount) cr_amount  from journal a " .
		" where 1=1 " .
		$holdadditionalwhereclause . " ORDER BY STR_TO_DATE(a.transdate , '%d/%m/%Y') desc,a.transdate  ";




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
		<h3 class="noprint"><strong>Journal Enteries</strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false">Close Window</a>


		<div id="print_table">
			<h3><strong>Journal Enteries</strong></h3>
			<h3><strong>Reporting from <?php echo $startdate; ?> &nbsp; to <?php echo $enddate; ?> </strong></h3>
			<table>

				<tr>
					<td align="center">


						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th class="Corner">&nbsp;</th>
									<th class="Odd">S/N</th>
									<th class="Odd">Transaction Date</th>
									<th class="Odd">Acct No</th>
									<th class="Odd">Acct Description</th>
									<th class="Odd">Sub Acct No</th>
									<th class="Odd">Sub Acct Description</th>
									<th class="Odd">Debit</th>
									<th class="Odd">Credit</th>
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
									<td><?php echo $row['transdate']; ?></td>
									<td><?php echo $row['acctno']; ?></td>
									<td><?php echo trim($row['acctdescription']); ?></td>
									<td><?php echo trim($row['subacctno']); ?></td>
									<td><?php echo trim($row['subacctdescription']); ?></td>
									<td align="right"><?php echo number_format($row['dr_amount'], 2); ?></td>
									<td align="right"><?php echo number_format($row['cr_amount'], 2); ?></td>
									<td></td>
								</tr>
							<?php
								//} //End For Loop
							} //End If Result Test	
							?>
							<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
								<td><strong>Summary </strong></td>
								<td></td>
								<td></td>
								<td align="right"><strong><?php echo number_format($summary_dr_amount, 2); ?></strong></td>
								<td align="right"><strong><?php echo number_format($summary_cr_amount, 2); ?></strong></td>
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