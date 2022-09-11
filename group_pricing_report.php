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

	$datefield = "";
	$custnofield = "";
	$salespsnfield = "";
	$itemfield = "a.item";
	$loccdfield = "";
	$vendornofield = "";
	$po_field = "";

	$periodmonthfield = "";
	$periodyearfield = "";
	include "reportcondition.php";

	//$additionalwhereclause = $dbobject->docase($startdate,$enddate,$custno,$salespsn,$item,$loccd,$vendorno,$purchaseorderno,
	//			$datefield,$custnofield,$salespsnfield,$itemfield,$loccdfield,$vendornofield,$po_field);

	//$holdadditionalwhereclause = $additionalwhereclause <> ""?" and " . $additionalwhereclause :"";


	$queryflat = "SELECT  b.catdesc, a.*,c.itemdesc FROM grprice a, catg b, icitem c where trim(a.custno)=trim(b.catcd) and trim(a.item)=trim(c.item) and a.disctype = 1 " .
		$holdadditionalwhereclause . " ORDER BY b.catdesc,c.itemdesc";

	//echo $queryflat."<br />";
	$result_flat = mysqli_query($_SESSION['db_connect'], $queryflat);
	$numrowsflat = mysqli_num_rows($result_flat);

	$queryslab = "SELECT  a.*,b.catdesc, c.slabdesc, d.lbound,d.ubound,d.disc,d.targetdisc ,e.itemdesc
					FROM grprice a, catg b, slabdef c, slabdisc d , icitem e
					where trim(a.custno)=trim(b.catcd) and a.disctype = 2 and trim(a.slabid)=trim(d.slabid) and trim(a.item)=trim(e.item) " .
		$holdadditionalwhereclause . " ORDER BY a.custno,c.slabdesc,d.lbound";


	$result_slab = mysqli_query($_SESSION['db_connect'], $queryslab);
	$numrowsslab = mysqli_num_rows($result_slab);

	//echo $queryslab."<br />";
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">

		<a href="#" class="noprint" onclick="window.close();return false">
			<h3>Close Window</h3>
		</a>

		<div id="print_table">
			<h3><strong>Customer Category Pricing Policy</strong></h3>
			<table>

				<tr>
					<td align="center">
						<b>Category A - Flat Discount</b><br />
						<?php if ($numrowsflat > 0) { ?>
							<table width="95%" border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
								<thead>
									<tr class="right_backcolor">
										<th nowrap="nowrap" class="Corner">&nbsp;</th>
										<th nowrap="nowrap" class="Odd">S/N</th>
										<th nowrap="nowrap" class="Odd">Group ID</th>
										<th nowrap="nowrap" class="Odd">Description</th>
										<th nowrap="nowrap" class="Odd">Product</th>
										<th nowrap="nowrap" class="Odd">Service Charge</th>
										<th nowrap="nowrap" class="Odd">Dealer Margin</th>
										<th nowrap="nowrap" class="Odd">Non Fuel Retail</th>
										<th nowrap="nowrap" class="Odd">miscellaneous</th>
										<th nowrap="nowrap">&nbsp;</th>
									</tr>
								</thead>
								<?php

								$k = 0;

								while ($k <  $numrowsflat) {
									$k++;
									//for($i=0; $i<$numrows; $i++){
									$row = mysqli_fetch_array($result_flat);
									//while($i < $skip) continue;
									//echo 'count '.$i.'   '.$skip;	
									//}
								?>

									<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap"><?php echo $k; ?></td>
										<td nowrap="nowrap"><?php echo $row['custno']; ?></td>
										<td nowrap="nowrap"><?php echo $row["catdesc"]; ?></td>
										<td nowrap="nowrap"><?php echo $row["itemdesc"]; ?></td>
										<td nowrap="nowrap" align="right"><?php echo number_format($row["srvchg"], 2); ?></td>
										<td nowrap="nowrap" align="right"><?php echo number_format($row["dmargin"], 2); ?></td>
										<td nowrap="nowrap" align="right"><?php echo number_format($row["nfr"], 2); ?></td>
										<td nowrap="nowrap" align="right"><?php echo number_format($row["misc"], 2); ?></td>
										<td nowrap="nowrap"></td>
									</tr>
								<?php
									//} //End For Loop
								} //End If Result Test	
								?>
							</table>
						<?php }


						if ($numrowsslab > 0) { ?>
							<br /><br /><b>Category A - Slab Discount</b><br />
							<table width="95%" border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
								<thead>
									<tr class="right_backcolor">
										<th nowrap="nowrap" class="Corner">&nbsp;</th>
										<th nowrap="nowrap" class="Odd">S/N</th>
										<th nowrap="nowrap" class="Odd">Group ID</th>
										<th nowrap="nowrap" class="Odd">Description</th>
										<th nowrap="nowrap" class="Odd">Product</th>
										<th nowrap="nowrap" class="Odd">Lower</th>
										<th nowrap="nowrap" class="Odd">Upper</th>
										<th nowrap="nowrap" class="Odd">Discount</th>
										<th nowrap="nowrap" class="Odd">Target Based Discount</th>
										<th nowrap="nowrap">&nbsp;</th>
									</tr>
								</thead>
								<?php

								$k = 0;

								while ($k <  $numrowsslab) {
									$k++;
									//for($i=0; $i<$numrows; $i++){
									$row = mysqli_fetch_array($result_slab);
									//while($i < $skip) continue;
									//echo 'count '.$i.'   '.$skip;	
									//}
								?>

									<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap"><?php echo $k; ?></td>
										<td nowrap="nowrap"><?php echo $row['slabid']; ?></td>
										<td nowrap="nowrap"><?php echo $row["catdesc"]; ?></td>
										<td nowrap="nowrap"><?php echo $row["itemdesc"]; ?></td>
										<td nowrap="nowrap" align="right"><?php echo number_format($row["lbound"], 2); ?></td>
										<td nowrap="nowrap" align="right"><?php echo number_format($row["ubound"], 2); ?></td>
										<td nowrap="nowrap" align="right"><?php echo number_format($row["disc"], 2); ?></td>
										<td nowrap="nowrap" align="right"><?php echo number_format($row["targetdisc"], 2); ?></td>
										<td nowrap="nowrap"></td>
									</tr>
								<?php
									//} //End For Loop
								} //End If Result Test	
								?>
							</table>
						<?php } ?>

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