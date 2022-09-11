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

	$datefield = "a.pmtdate";
	$custnofield = "trim(a.custno)";
	$salespsnfield = "";
	$itemfield = "";
	$loccdfield = "";
	$vendornofield = "";
	$po_field = "";


	$periodmonthfield = "";
	$periodyearfield = "";
	include "reportcondition.php";


	$query = "SELECT  a.refno, a.custno, a.descriptn, a.bank_code, a.dd_no, a.dd_date, a.amount, a.amtused, a.pmtdate, " .
		" (select company from arcust where trim(arcust.custno) = trim(a.custno)) company " .
		" ,(select bank_name from bank where trim(bank.bank_code) = trim(a.bank_code)) bank_name FROM payments a  " .
		" WHERE a.amount > a.amtused  " .
		$holdadditionalwhereclause . " ORDER BY a.pmtdate desc";

	//echo $query;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$numrows = mysqli_num_rows($result);


	?>


	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		<h3 class="noprint"><strong>
				Unused Payment Balances
			</strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false">Close Window</a>


		<div id="print_table">
			<h3><strong>
					Unused Payment Balances
				</strong></h3>
			<h3><strong>Reporting from <?php echo $startdate; ?> &nbsp; to <?php echo $enddate; ?> </strong></h3>
			<table>

				<tr>
					<td align="center">


						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th nowrap="nowrap" class="Corner">&nbsp;</th>
									<th nowrap="nowrap" class="Odd">S/N</th>
									<th nowrap="nowrap" class="Odd">Customer Name</th>
									<th nowrap="nowrap" class="Odd">Receipt No:</th>
									<th nowrap="nowrap" class="Odd">Description</th>
									<th nowrap="nowrap" class="Odd">Bank</th>
									<th nowrap="nowrap" class="Odd">Bank Ref</th>
									<th nowrap="nowrap" class="Odd">DD/TT Date</th>
									<th nowrap="nowrap" class="Odd">Amount</th>
									<th nowrap="nowrap" class="Odd">Amount Used</th>
									<th nowrap="nowrap" class="Odd">Balance</th>
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
									<td nowrap="nowrap"><?php echo substr(trim($row["company"]), 0, 20); ?></td>
									<td nowrap="nowrap"><?php echo $row['refno']; ?></td>
									<td nowrap="nowrap"><?php echo $row["descriptn"]; ?></td>
									<td nowrap="nowrap"><?php echo substr($row["bank_name"], 0, 12); ?></td>
									<td nowrap="nowrap"><?php echo $row["dd_no"]; ?></td>
									<td nowrap="nowrap"><?php echo $row["dd_date"]; ?></td>
									<td nowrap="nowrap" align="right"><?php echo number_format($row["amount"], 2); ?></td>
									<td nowrap="nowrap" align="right"><?php echo number_format($row["amtused"], 2); ?></td>
									<td nowrap="nowrap" align="right"><?php echo number_format($row["amount"] - $row["amtused"], 2); ?></td>
									<td nowrap="nowrap"></td>
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