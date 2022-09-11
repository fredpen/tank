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
	$periodmonthfield = "";
	$periodyearfield = "";
	$datefield = "a.changedt";
	$custnofield = "";
	$salespsnfield = "";
	$itemfield = "";
	$loccdfield = "";
	$vendornofield = "";
	$po_field = "";


	$startdate = substr($startdate, 8, 2) . "/" . substr($startdate, 5, 2) . "/" . substr($startdate, 0, 4);
	$enddate = substr($enddate, 8, 2) . "/" . substr($enddate, 5, 2) . "/" . substr($enddate, 0, 4);

	$additionalwhereclause = $dbobject->docase(
		$startdate,
		$enddate,
		$custno,
		$salespsn,
		$item,
		$loccd,
		$vendorno,
		$purchaseorderno,
		$periodyear,
		$periodmonth,
		$datefield,
		$custnofield,
		$salespsnfield,
		$itemfield,
		$loccdfield,
		$vendornofield,
		$po_field,
		$periodyearfield,
		$periodmonthfield
	);

	$holdadditionalwhereclause = $additionalwhereclause <> "" ? " and " . $additionalwhereclause : "";



	$query = "SELECT a.* FROM apptrail a " .
		" WHERE 1=1  " .
		$holdadditionalwhereclause . " ORDER BY  STR_TO_DATE(a.changedt, '%d/%m/%Y') desc ";

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
			<h3><strong>Audit Trail </strong></h3>
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
									<th class="Odd">User</th>
									<th class="Odd">Module</th>
									<th class="Odd">Code</th>
									<th class="Odd">Operation</th>
									<th class="Odd">Client's Machine</th>
									<th class="Odd">Accessed Date</th>
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
									<td><?php echo $row['musername']; ?></td>
									<td><?php echo $row["mprocess"]; ?></td>
									<td><?php echo trim($row["itemcode"]); ?></td>
									<td><?php echo trim($row["edittype"]); ?></td>
									<td><?php echo trim($row["netinfo"]); ?></td>
									<td><?php echo $row["changedt"]; ?></td>
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