<?php
ob_start();
include_once "session_track.php";

require_once("lib/mfbconnect.php");
require 'lib/aesencrypt.php';
require 'file_insert.php';
?>

<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" type="text/css" href="css/style.css">

<!---->
<script type="text/javascript" src="js/tablehighlight.js"></script>


<?php
if (session_id() == "") {
	session_start();
}

include("lib/dbfunctions.php");
$dbobject = new dbfunction();

$count = 0;
$limit = !isset($_REQUEST['limit']) ? "20" : $_REQUEST['limit'];
$pageNo = !isset($_REQUEST['fpage']) ? "1" : $_REQUEST['pageNo'];
$searchby = !isset($_REQUEST['searchby']) ? "reportdesc" : $_REQUEST['searchby'];
$keyword = !isset($_REQUEST['keyword']) ? "" : $_REQUEST['keyword'];
$orderby = !isset($_REQUEST['orderby']) ? "reportdesc" : $_REQUEST['orderby'];
$orderflag = !isset($_REQUEST['orderflag']) ? "asc" : $_REQUEST['orderflag'];
$lower = !isset($_REQUEST['lower']) ? "" : $_REQUEST['lower'];
$upper = !isset($_REQUEST['upper']) ? "" : $_REQUEST['upper'];
$reportgrp = !isset($_REQUEST['reportgrp']) ? "" : $_REQUEST['reportgrp'];
$reportname = !isset($_REQUEST['reportname']) ? "" : $_REQUEST['reportname'];
$calledby = !isset($_REQUEST['calledby']) ? 0 : $dbobject->test_input($_REQUEST['calledby']);

$filter = "";

switch (true) {
	case $reportname == 'rec_invent':
		$orderby = !isset($_REQUEST['orderby']) ? "STR_TO_DATE(receivd_dt, '%d/%m/%Y') " : $_REQUEST['orderby'];
		$orderflag = !isset($_REQUEST['orderflag']) ? "desc" : $_REQUEST['orderflag'];
		if (trim($keyword) != '') {
			$filter = " AND (inv_recpt_no like '%$keyword%' || company like '%$keyword%' || vesselname like '%$keyword%' || captain like '%$keyword%' )";
		}
		$order = " order by " . $orderby . " " . $orderflag;
		$sql = "select count(inv_recpt_no) counter from rec_invent where 1=1 " . $filter . $order;
		$query = "select * from rec_invent where 1=1  " . $filter . $order;

		//echo $sql;

		break;

	case $reportname == 'inv_issues':
		$orderby = !isset($_REQUEST['orderby']) ? "STR_TO_DATE(issued_dt, '%d/%m/%Y') " : $_REQUEST['orderby'];
		$orderflag = !isset($_REQUEST['orderflag']) ? "desc" : $_REQUEST['orderflag'];
		if (trim($keyword) != '') {
			$filter = " AND (issue_no like '%$keyword%' || company like '%$keyword%'  )";
		}
		$order = " order by " . $orderby . " " . $orderflag;
		$sql = "select count(issue_no) counter from inv_issues where 1=1 " . $filter . $order;
		$query = "select * from inv_issues where 1=1  " . $filter . $order;

		//echo $sql;

		break;



	case $reportname == 'loadingslip':
		$orderby = !isset($_REQUEST['orderby']) ? "STR_TO_DATE(slip_date, '%d/%m/%Y') " : $_REQUEST['orderby'];
		$orderflag = !isset($_REQUEST['orderflag']) ? "desc" : $_REQUEST['orderflag'];
		if (trim($keyword) != '') {
			$filter = " AND (a.vehcno like '%$keyword%' || b.slip_date like '%$keyword%' || a.ccompany like '%$keyword%' || a.slip_no like '%$keyword%' || b.itemdesc like '%$keyword%' )";
		}
		$order = " order by " . $orderby . " " . $orderflag;
		$sql = "select count(a.slip_no) counter FROM invoice a, inv_detl b " .
			" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.qty_booked > 0 " . $filter . $order;

		$query = "SELECT b.slip_date,a.slip_no, b.item,b.itemdesc,b.qty_booked,b.store_qty,a.vehcno,a.trasno,a.tcompany,a.custno,a.ccompany,a.station, " .
			" a.loccd,a.loc_name, a.request " .
			" FROM invoice a, inv_detl b " .
			" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.qty_booked > 0 " . $filter . $order;
		break;

	case $reportname == 'waybill':
		$orderby = !isset($_REQUEST['orderby']) ? "STR_TO_DATE(a.invoice_dt, '%d/%m/%Y') " : $_REQUEST['orderby'];
		$orderflag = !isset($_REQUEST['orderflag']) ? "desc" : $_REQUEST['orderflag'];
		if (trim($keyword) != '') {
			$filter = " AND (a.vehcno like '%$keyword%' || b.slip_date like '%$keyword%' || a.ccompany like '%$keyword%' || a.slip_no like '%$keyword%' || b.itemdesc like '%$keyword%' )";
		}
		$order = " order by " . $orderby . " " . $orderflag;
		$sql = "select count(a.slip_no) counter FROM invoice a, inv_detl b " .
			" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.qty_booked > 0 " . $filter . $order;

		$query = "SELECT a.invoice_no, a.invoice_dt, b.slip_date,a.slip_no, b.item,b.itemdesc,b.qty_booked,b.store_qty,a.vehcno,a.trasno,a.tcompany,a.custno,a.ccompany,a.station, " .
			" a.loccd,a.loc_name, a.request " .
			" FROM invoice a, inv_detl b " .
			" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.qty_booked > 0 " . $filter . $order;
		break;

	case $reportname == 'journaladjustment':
		$orderby = !isset($_REQUEST['orderby']) ? "STR_TO_DATE(a.journaldate, '%d/%m/%Y') " : $_REQUEST['orderby'];
		$orderflag = !isset($_REQUEST['orderflag']) ? "desc" : $_REQUEST['orderflag'];
		if (trim($keyword) != '') {
			$filter = " AND (a.journalentryid like '%$keyword%'  )";
		}
		$order = " order by " . $orderby . " " . $orderflag;
		$sql = "select count(a.journalentryid) counter FROM directjournalmaster a, directjournaldetl b " .
			" where trim(a.journalentryid) = trim(b.journalentryid) " . $filter . $order;
		//echo $sql;
		$query = " select a.*,b.chartcode, b.description, b.credit,b.debit from directjournalmaster a, directjournaldetl b " .
			" where trim(a.journalentryid) = trim(b.journalentryid) " . $filter . $order;


		break;

	case $reportgrp == '':
		if (isset($_REQUEST['reportgrp'])) {
			$thereportgrp = $_REQUEST['reportgrp'];
		} else {
			$thereportgrp = '';
		}
		break;
	default:
		$thereportgrp = " and reportgrp = '$reportgrp' ";
		$_SESSION['reportgrp'] = $reportgrp;
		break;
}


//echo $sql;
$result = mysqli_query($_SESSION['db_connect'], $sql);
if ($result) {
	$row = mysqli_fetch_array($result);
	$count = $row['counter'];
}

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

$role_id = "";

$user_role_session = $_SESSION['role_id_sess'];
$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];



//echo $query;
$result = mysqli_query($_SESSION['db_connect'], $query);
$numrows = mysqli_num_rows($result);
//echo $query;


?>
<input name="fpage" type="hidden" id="fpage" value="<?php echo $pageNo; ?>" size="3" />
<input name="tpages" type="hidden" id="tpages" value="<?php echo $npages; ?>" size="3" />

<input type='hidden' name='pageNo' id="pageNo" value="<?php echo $pageNo; ?>">
<input type='hidden' name='rowCount' value="<?php echo $count; ?>">
<input type='hidden' name='skipper' value="<?php echo $skip; ?>">
<input type='hidden' name='pageEnd' value="<?php echo $npages; ?>">
<input type='hidden' name='reportgrp' id='reportgrp' value="<?php echo $reportgrp; ?>">
<input type='hidden' name='reportname' id='reportname' value="<?php echo $reportname; ?>">
<input type="hidden" name="calledby" id="calledby" value="<?php echo $calledby; ?>" />
<div align="center" id="data-form_report">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form_report').hide();">
	<form>


		<table border="0" cellspacing="1" style="border:1px solid black;padding:10px;border-collapse:separate;border-radius:15px">


			<tr class="back_image">
				<td>No of Records : <?php echo $count; ?>&nbsp;&nbsp;
					Page <?php echo $pageNo; ?> of <?php echo $npages; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


					<a href="#" onclick="javascript: goFirst('lookupreport.php');">
						<img src="images/first.gif" alt="First" width="16" height="16" border="0"></a>
					<a href="#" onclick="javascript: goPrevious('lookupreport.php');">
						<img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a>
					<a href="#" onclick="javascript: goNext('lookupreport.php');">
						<img src="images/next.gif" alt="Next" width="16" height="16" border="0" /></a>
					<a href="#" onclick="javascript: goLast('lookupreport.php');">
						<img src="images/last.gif" alt="Last" width="16" height="16" border="0" /></a>

					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

					Limit :
					<select name="limit" class="table_text1" id="limit" onchange="javascript:doSearch('lookupreport.php');">
						<option value="1" <?php echo ($limit == "1" ? "selected" : ""); ?>>1</option>
						<option value="5" <?php echo ($limit == "5" ? "selected" : ""); ?>>5</option>
						<option value="10" <?php echo ($limit == "10" ? "selected" : ""); ?>>10</option>
						<option value="20" <?php echo ($limit == "20" ? "selected" : ""); ?>>20</option>
						<option value="30" <?php echo ($limit == "30" ? "selected" : ""); ?>>30</option>
						<option value="50" <?php echo ($limit == "50" ? "selected" : ""); ?>>50</option>
						<option value="100" <?php echo ($limit == "100" ? "selected" : ""); ?>>100</option>
					</select>


				</td>
			</tr>

			<tr>
				<td>Keyword:
					<input name="keyword" type="text" title="Enter Keyword to Search or Clear to retrieve all" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

					<input name="search22" type="button" class="table_text1" id="submit-button" onclick="javascript:doSearch('lookupreport.php');" value="Search" />
				</td>

			</tr>
			<tr>

				<td>
					<input type='hidden' name='reportgrp' id='reportgrp' value="<?php echo $reportgrp; ?>">
					<?php if ($calledby != '') { ?>

						<input type="button" name="getreport" id="submit-button" value="Back" onclick="javascript: 
								var calledby = $('#calledby').val();
							getpage(calledby+'.php','page');">
					<?php } ?>
				</td>
			</tr>
		</table>



		<?php switch (true) {
			case ($reportname == 'rec_invent' || $reportname == 'inv_issues'): ?>

				<?php if ($reportname == 'rec_invent') { ?>
					<h3><strong>
							Received Products
						</strong></h3>
				<?php } else { ?>
					<h3><strong>
							Issued Products
						</strong></h3>
				<?php } ?>

				<div style="max-height: 300px; overflow-y: auto;overflow-x: auto;">
					<table id="reporttable" class="table table-striped table-bordered" style="width:90%">
						<thead>
							<tr class="right_backcolor">
								<th nowrap="nowrap" class="Corner">&nbsp;</th>
								<th nowrap="nowrap" class="Odd">S/N</th>
								<th nowrap="nowrap" class="Odd">Ref Doc No</th>
								<?php if ($reportname == 'rec_invent') { ?>
									<th nowrap="nowrap" class="Odd">Vendor</th>
									<th nowrap="nowrap" class="Odd">Vessel</th>
								<?php } ?>
								<th nowrap="nowrap" class="Odd">Captain</th>
								<th nowrap="nowrap" class="Odd">Product</th>
								<th nowrap="nowrap" class="Odd">Qty</th>
								<th nowrap="nowrap" class="Odd">Date</th>
								<th nowrap="nowrap">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
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
									<td nowrap="nowrap"><?php echo $k + $skip; ?></td>
									<?php if ($reportname == 'rec_invent') { ?>
										<td nowrap="nowrap"><?php echo $row['inv_recpt_no']; ?></td>
									<?php } else { ?>
										<td nowrap="nowrap"><?php echo $row['issue_no']; ?></td>
									<?php } ?>
									<td nowrap="nowrap"><?php echo $row['company']; ?></td>
									<?php if ($reportname == 'rec_invent') { ?>
										<td nowrap="nowrap"><?php echo $row['vesselname']; ?></td>
										<td nowrap="nowrap"><?php echo $row['captain']; ?></td>
									<?php } ?>
									<td nowrap="nowrap"><?php echo $row['itemdesc']; ?></td>
									<?php if ($reportname == 'rec_invent') { ?>
										<td nowrap="nowrap"><?php echo $row['qtyreceived']; ?></td>
										<td nowrap="nowrap"><?php echo $row['receivd_dt']; ?></td>
									<?php } else { ?>
										<td nowrap="nowrap"><?php echo $row['qtyissued']; ?></td>
										<td nowrap="nowrap"><?php echo $row['issued_dt']; ?></td>
									<?php } ?>
									<td nowrap="nowrap">&nbsp;
										<?php
										//$target_dir = $_SERVER['DOCUMENT_ROOT']."/documents/";
										//$target_dir = $_SESSION['target_dir'];
										$target_dir = 'documents/';
										$filepath = $target_dir . trim($row["supportdoc"]);
										if (trim($row["supportdoc"]) != '') {
											if (file_exists($filepath)) { ?>
												<a href="<?php echo $filepath; ?> " rel="noopener noreferrer" target="_blank">View Doc</a>

										<?php
											}
										} ?>
									</td>
								</tr>
							<?php
								//} //End For Loop
							} //End If Result Test	
							?>
						</tbody>
						<tfoot>
							<tr class="right_backcolor">
								<th nowrap="nowrap" class="Corner">&nbsp;</th>
								<th nowrap="nowrap" class="Odd">S/N</th>
								<th nowrap="nowrap" class="Odd">Ref Doc No</th>
								<th nowrap="nowrap" class="Odd">Vendor</th>
								<?php if ($reportname == 'rec_invent') { ?>
									<th nowrap="nowrap" class="Odd">Vendor</th>
									<th nowrap="nowrap" class="Odd">Vessel</th>
								<?php } ?><th nowrap="nowrap" class="Odd">Product</th>
								<th nowrap="nowrap" class="Odd">Qty</th>
								<th nowrap="nowrap" class="Odd">Date</th>
								<th nowrap="nowrap">&nbsp;</th>
							</tr>
						</tfoot>

					</table>
				</div>
			<?php
				break;

			case $reportname == 'loadingslip':
			?>

				<h3><strong>
						Loading Slips
					</strong></h3>
				<div style="max-height: 300px; overflow-y: auto;overflow-x: auto;">
					<table id="reporttable" class="table table-striped table-bordered" style="width:90%">
						<thead>
							<tr class="right_backcolor">
								<th class="Corner">&nbsp;</th>
								<th class="Odd">S/N</th>
								<th class="Odd">Loading Slip</th>
								<th class="Odd">Date</th>
								<th class="Odd">Supply Location</th>
								<th class="Odd">Product</th>
								<th class="Odd">Req. No</th>
								<th class="Odd">Qty Booked</th>
								<th class="Odd">Qty Loaded</th>
								<th class="Odd">BRV</th>
								<th class="Odd">Customer</th>
								<th class="Odd">Retail Outlet</th>
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
								<td><?php echo trim($row['slip_no']); ?></td>
								<td><?php echo trim($row['slip_date']); ?></td>
								<td><?php echo substr(trim($row['loc_name']), 0, 15); ?></td>
								<td><?php echo trim($row['itemdesc']); ?></td>
								<td><?php echo substr(trim($row['request']), 0, 11); ?></td>
								<td align="right"><?php echo number_format($row['qty_booked'], 2); ?></td>
								<td align="right"><?php echo number_format($row['store_qty'], 2); ?></td>
								<td><?php echo $row['vehcno']; ?></td>
								<td><?php echo substr(trim($row['ccompany']), 0, 25); ?></td>
								<td><?php echo trim($row['station']); ?></td>
								<td></td>
							</tr>
						<?php
							//} //End For Loop
						} //End If Result Test	
						?>

					</table>
				</div>
			<?php
				break;
			case $reportname == 'waybill':
			?>

				<h3><strong>
						Way Bills
					</strong></h3>
				<div style="max-height: 300px; overflow-y: auto;overflow-x: auto;">
					<table id="reporttable" class="table table-striped table-bordered" style="width:90%">
						<thead>
							<tr class="right_backcolor">
								<th class="Corner">&nbsp;</th>
								<th class="Odd">S/N</th>
								<th class="Odd">Supply Loc.</th>
								<th class="Odd">Product</th>
								<th class="Odd">Invoice Date</th>
								<th class="Odd">Ticket NO</th>
								<th class="Odd">Way Bill</th>
								<th class="Odd">Quantity</th>
								<th class="Odd">Truck No</th>
								<th class="Odd">Transporter</th>
								<th class="Odd">Customer</th>
								<th class="Odd">Retail Outlet</th>
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
								<td>&nbsp;<?php echo substr(trim($row['loc_name']), 0, 16); ?></td>
								<td>&nbsp;<?php echo trim($row["itemdesc"]); ?></td>
								<td>&nbsp;<?php echo trim($row['invoice_dt']); ?></td>
								<td>&nbsp;<?php echo SUBSTR(trim($row['slip_no']), 5, 2) . SUBSTR(trim($row['slip_no']), 7, 2) . SUBSTR(trim($row['slip_no']), 11); ?></td>
								<td>&nbsp;<?php echo trim($row['invoice_no']); ?></td>
								<td align="right">&nbsp;<?php echo number_format($row['store_qty'], 2); ?></td>
								<td>&nbsp;<?php echo trim($row['vehcno']); ?></td>
								<td>&nbsp;<?php echo SUBSTR(trim($row['tcompany']), 0, 14); ?></td>
								<td>&nbsp;<?php echo SUBSTR(trim($row["ccompany"]), 0, 16); ?></td>
								<td>&nbsp;<?php echo trim($row['station']); ?></td>
								<td></td>
							</tr>
						<?php
							//} //End For Loop
						} //End If Result Test	
						?>


					</table>
				</div>

			<?php
				break;

			case $reportname == 'journaladjustment':
			?>

				<h3><strong>
						Direct Journal Entries
					</strong></h3>
				<div style="max-height: 300px; overflow-y: auto;overflow-x: auto;">
					<table id="reporttable" class="table table-striped table-bordered" style="width:90%">
						<thead>
							<tr class="right_backcolor">
								<th class="Corner">&nbsp;</th>
								<th class="Odd">S/N</th>
								<th class="Odd">Transaction Date</th>
								<th class="Odd">Reference </th>
								<th class="Odd">Remark </th>
								<th class="Odd">Acct No</th>
								<th class="Odd">Acct Description</th>
								<th class="Odd">Debit</th>
								<th class="Odd">Credit</th>
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
								<td><?php echo $k; ?></td>
								<td><?php echo $row['journaldate']; ?></td>
								<td><?php echo $row['journalentryid']; ?></td>
								<td><?php echo $row['explanation']; ?></td>
								<td><?php echo $row['chartcode']; ?></td>
								<td><?php echo trim($row['description']); ?></td>
								<td align="right"><?php echo number_format($row['debit'], 2); ?></td>
								<td align="right"><?php echo number_format($row['credit'], 2); ?></td>
								<td>
									<?php
									//$target_dir = $_SERVER['DOCUMENT_ROOT']."/documents/";
									//$target_dir = $_SESSION['target_dir'];
									$target_dir = 'documents/';
									$filepath = $target_dir . trim($row["supportdoc"]);
									if (trim($row["supportdoc"]) != '') {
										if (file_exists($filepath)) { ?>
											<a href="<?php echo $filepath; ?> " rel="noopener noreferrer" target="_blank">View Doc</a>

									<?php
										}
									} ?>
								</td>
							</tr>
						<?php
							//} //End For Loop
						} //End If Result Test	
						?>


					</table>
				</div>
		<?php
				break;
		}
		?>




	</form>
</div>
<script type="text/javascript">
	addTableRolloverEffect('reporttable', 'tableRollOverEffect1', 'tableRowClickEffect1');
</script>