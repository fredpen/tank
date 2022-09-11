<?php
ob_start();
include_once "session_track.php";

include "printheader.php";
?>
<link rel="stylesheet" type="text/css" href="css/main.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
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

	$datefield = "";
	$custnofield = "";
	$salespsnfield = "";
	$itemfield = "";
	$loccdfield = "";
	$vendornofield = "";
	$po_field = "";

	$periodmonthfield = "";
	$periodyearfield = "";
	include "reportcondition.php";





	$query = "SELECT '' forgroup,a.acctno, a.acctdescription,   ABS(sum(a.dr_amount-a.cr_amount)) amount,b.accounttype  " .
		" FROM ledger a, chart_of_account b where trim(a.acctno) = trim(b.chartcode) and trim(b.accounttype) = 'Revenue' " .
		" and periodyear = '" . $periodyear .  "' " .
		" 	GROUP BY a.acctno, a.acctdescription, a.periodyear " .
		" UNION " .
		"SELECT '' forgroup,'' acctno, 'Total Revenue' acctdescription,  ABS(sum(a.dr_amount-a.cr_amount)) amount,'' accounttype  " .
		" FROM ledger a, chart_of_account b where trim(a.acctno) = trim(b.chartcode) and trim(b.accounttype) = 'Revenue' " .
		" and periodyear = '" . $periodyear . "' " .
		" 	GROUP BY b.accounttype " .
		" UNION " .
		"SELECT '' forgroup,'' acctno, '________________________________________' acctdescription,  0 amount,'' accounttype  " .
		" FROM dual " .
		" UNION " .
		" SELECT '' forgroup,a.acctno, a.acctdescription,  ABS(sum(a.dr_amount-a.cr_amount)) amount,b.accounttype  " .
		"  FROM ledger a, chart_of_account b where trim(a.acctno) = trim(b.chartcode) and trim(b.accounttype) = 'Expense' " .
		" and periodyear = '" . $periodyear . "' " .
		"	GROUP BY a.acctno, a.acctdescription, a.periodyear " .
		" UNION " .
		"SELECT '' forgroup,'' acctno, 'Total Expenses' acctdescription,  ABS(sum(a.dr_amount-a.cr_amount)) amount,'' accounttype  " .
		" FROM ledger a, chart_of_account b where trim(a.acctno) = trim(b.chartcode) and trim(b.accounttype) = 'Expense' " .
		" and periodyear = '" . $periodyear . "' " .
		" 	GROUP BY b.accounttype ";

	$query_summary1 = "SELECT ABS(sum(a.dr_amount-a.cr_amount)) amount   " .
		" FROM ledger a, chart_of_account b where trim(a.acctno) = trim(b.chartcode) and trim(b.accounttype) = 'Revenue' " .
		" and periodyear = '" . $periodyear . "' " .
		" 	GROUP BY b.accounttype ";

	$query_summary2 = "SELECT ABS(sum(a.dr_amount-a.cr_amount)) amount   " .
		" FROM ledger a, chart_of_account b where trim(a.acctno) = trim(b.chartcode) and trim(b.accounttype) = 'Expense' " .
		" and periodyear = '" . $periodyear . "' " .
		" 	GROUP BY b.accounttype ";;

	//echo $query;
	//echo $query_summary;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$result_summary1 = mysqli_query($_SESSION['db_connect'], $query_summary1);
	$result_summary2 = mysqli_query($_SESSION['db_connect'], $query_summary2);
	$numrows = mysqli_num_rows($result);
	$summary_amount1 = 0;
	$summary_amount2 = 0;
	if ($numrows > 0) {

		$row_summary1 = mysqli_fetch_array($result_summary1);
		$row_summary2 = mysqli_fetch_array($result_summary2);
		$numrows_summary1 = mysqli_num_rows($result_summary1);
		$numrows_summary2 = mysqli_num_rows($result_summary2);
		if ($numrows_summary1 > 0) {
			$summary_amount1 = $summary_amount1 + $row_summary1['amount'];
		}
		if ($numrows_summary2 > 0) {
			$summary_amount2 = $summary_amount2 + $row_summary2['amount'];
		}
	}

	$count = $numrows;

	$skip = 0;
	$maxPage = $limit;
	//echo $count;
	$npages = (int)($count / $maxPage);
	//echo $npages;
	if ($npages != 0) {
		if (($npages * $maxPage) != $count) {
			$npages = $npages + 1;
			//echo $npages;
		}
	} else {
		$npages = 1;
		//echo "Here";
	}

	$sel = !isset($_REQUEST['op']) ? "" : $_REQUEST['op'];

	$download_query = $query;

	//echo 'D page:  '.$pageNo;
	?>



	<form name="form1" id="form1" method="post" action="">

		<h3 class="noprint"><strong>
				Income Statement (P & L)
			</strong></h3>
		<h3 class="noprint"><strong>
				As at 31st December <?php echo $periodyear; ?>
			</strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false">
			<h3>Close Window</h3>
		</a>

		<div id="print_table">
			<h3><strong>
					Income Statement (P & L)
				</strong></h3>
			<h3><strong>As at 31st December <?php echo $periodyear; ?> </strong></h3>
			<table width="95%">

				<tr>
					<td align="center">


						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">

							<?php
							$skip = $maxPage * ($pageNo - 1);
							$k = 0;

							for ($i = 0; $i < $skip; $i++) {
								$row = mysqli_fetch_array($result);
								//echo 'count '.$i.'   '.$skip;
							}

							while ($k < $maxPage && $numrows > ($k + $skip)) {
								$k++;
								//for($i=0; $i<$numrows; $i++){
								$row = mysqli_fetch_array($result);
								//while($i < $skip) continue;
								//echo 'count '.$i.'   '.$skip;	
								//}
							?>

								<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
									<td nowrap="nowrap">&nbsp;</td>
									<td nowrap="nowrap" width="370"><b><?php echo $row['acctdescription']; ?></b></td>
									<td nowrap="nowrap" align="right"><?php if ($row["amount"] > 0) {
																			echo number_format($row["amount"], 2);
																		} ?></td>
									<td nowrap="nowrap"></td>
								</tr>
							<?php
								//} //End For Loop
							} //End If Result Test	
							?>

							<tr>
								<td nowrap="nowrap">&nbsp;</td>
								<td nowrap="nowrap"> </td>
								<td nowrap="nowrap"></td>
							</tr>
							<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
								<td nowrap="nowrap">&nbsp;</td>
								<td nowrap="nowrap"> <strong>Net: </strong></td>
								<td nowrap="nowrap" align="right"><strong><?php echo number_format($summary_amount1 - $summary_amount2, 2); ?></strong></td>
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