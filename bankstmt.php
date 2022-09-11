<?php

include "printheader.php";
?>

<div align="center" id="data-form">

	<?php


	include "basicparameters.php";

	$startdate = substr($startdate, 8, 2) . "/" . substr($startdate, 5, 2) . "/" . substr($startdate, 0, 4);
	$enddate = substr($enddate, 8, 2) . "/" . substr($enddate, 5, 2) . "/" . substr($enddate, 0, 4);


	$query = " SELECT SPACE(20) AS custno,exprefno, descriptio AS descriptn, expensdate,0 AS income," .
		" amount  AS expense,pmtmode,bank_code, " .
		"(select bank_name from bank where trim(bank.bank_code) = trim(expense.bank_code)) bank_name ,dd_no,dd_date FROM expense " .
		" WHERE pmtmode = 2 AND  STR_TO_DATE(expensdate , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
		" and STR_TO_DATE(expensdate , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') " .
		" UNION " .
		" SELECT SPACE(20) AS custno,refno, descriptn, pmtdate,amount AS income," .
		" 0 AS expense,pmtmode,bank_code, " .
		"(select bank_name from bank where trim(bank.bank_code) = trim(otherincome.bank_code)) bank_name,dd_no,dd_date FROM otherincome " .
		" WHERE pmtmode = 2 AND STR_TO_DATE(pmtdate , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
		" and STR_TO_DATE(pmtdate , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') " .
		" UNION " .
		" SELECT custno,refno, descriptn, pmtdate,IF(advrefund1 = 1,amount,0) AS income," .
		" IF(advrefund1 = 2,amount,0) AS expense,pmtmode,bank_code, " .
		" (select bank_name from bank where trim(bank.bank_code) = trim(payments.bank_code)) bank_name,dd_no,dd_date FROM payments " .
		" WHERE pmtmode = 2 AND STR_TO_DATE(pmtdate , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
		" and STR_TO_DATE(pmtdate , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') ";

	//echo $query;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$numrows = mysqli_num_rows($result);



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


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">

		<a href="#" class="noprint" onclick="window.close();return false">
			<h3>Close Window</h3>
		</a>

		<div id="print_table">
			<p>
			<h3><strong>Bank Transactions </strong></h3>
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
									<th class="Odd">Customer</th>
									<th class="Odd">DD/Teller No</th>
									<th class="Odd">Date</th>
									<th class="Odd">Bank</th>
									<th class="Odd">Particulars</th>
									<th class="Odd">Income</th>
									<th class="Odd">Expense</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
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
									<td>&nbsp;</td>
									<td><?php echo $k + $skip; ?></td>
									<td><?php echo $row['custno']; ?></td>
									<td><?php echo $row["dd_no"]; ?></td>
									<td><?php echo trim($row["dd_date"]); ?></td>
									<td><?php echo trim($row["bank_code"]) . "-" . trim($row["bank_name"]); ?></td>
									<td><?php echo trim($row["descriptn"]); ?></td>
									<td align="right"><?php echo number_format($row['income'], 2); ?></td>
									<td align="right"><?php echo number_format($row['expense'], 2); ?></td>
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