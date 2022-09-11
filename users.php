<?php

include "printheader.php";
?>

<div align="center" id="data-form">

	<?php


	include "basicparameters.php";
	$periodmonthfield = "";
	$periodyearfield = "";
	$datefield = "";
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


	$query = "SELECT a.administra, a.approval, a.apptype, a.authentica, a.cca, a.credits, a.crrecon, a.delivery," .
		" a.expense, a.inventory, a.loadings, a.masters,a.names, a.othincome, a.ownuse, a.payments, a.prninv," .
		"a.prnrcpt, a.ptn, a.reports, a.reprint, a.request, a.retail, a.spereq, a.userid FROM datum a  where 1 = 1 " .
		$holdadditionalwhereclause . " ORDER BY a.names  ";

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
			<h3><strong>BIZMAAP Users </strong></h3>
			</p>
			<table>

				<tr>
					<td align="center">


						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th class="Corner">&nbsp;</th>
									<th class="Odd">S/N</th>
									<th class="Odd">User ID</th>
									<th class="Odd">User Name</th>
									<th class="Odd">Role</th>
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
									<td><?php echo $row['userid']; ?></td>
									<td><?php echo $row['names']; ?></td>
									<td><?php echo $row['administra'] == 1 ? "Administrator" : "User"; ?></td>
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