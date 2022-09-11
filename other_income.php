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
	$custnofield = "";
	$salespsnfield = "";
	$itemfield = "";
	$loccdfield = "";
	$vendornofield = "";
	$po_field = "";

	$periodmonthfield = "";
	$periodyearfield = "";
	include "reportcondition.php";


	$query = "SELECT SPACE(20) AS custno,a.refno, a.descriptn, a.pmtdate,a.amount,a.pmtmode,a.bank_code,a.dd_no," .
		"(select bank_name from bank where trim(bank.bank_code) = trim(a.bank_code)) bank_name," .
		" 'Other Income' company FROM otherincome a  " .
		" WHERE 1=1 " .
		$holdadditionalwhereclause . " ORDER BY pmtdate desc";




	//echo $query;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$numrows = mysqli_num_rows($result);




	?>


	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">

		<a href="#" class="noprint" onclick="window.close();return false">
			<h3>Close Window</h3>
		</a>

		<div id="print_table">
			<p>
			<h3><strong>
					Other Income
				</strong></h3>
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
									<th class="Odd">Income Ref</th>
									<th class="Odd">Customer</th>
									<th class="Odd">Description</th>
									<th class="Odd">Pmt Date</th>
									<th class="Odd">Bank</th>
									<th class="Odd">Bank Ref</th>
									<th class="Odd">Amount</th>
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
									<td><?php echo $row['refno']; ?></td>
									<td><?php echo ($row["company"] == null ? $row["custno"] : trim($row["company"])); ?></td>
									<td><?php echo $row["descriptn"]; ?></td>
									<td><?php echo trim($row["pmtdate"]); ?></td>
									<td><?php echo $row["bank_name"]; ?></td>
									<td><?php echo $row["dd_no"]; ?></td>
									<td align="right"><?php echo number_format($row["amount"], 2); ?></td>
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