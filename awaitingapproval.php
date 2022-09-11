<?php
ob_start();
include "session_track.php";
?>
<link rel="stylesheet" type="text/css" href="css/style.css">

<div align="center" id="data-form_report">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		<h3><strong>Awaiting Approvals </strong></h3>
		<?php
		if ($_SESSION['request'] == 1 || $_SESSION['approval'] == 1) {
			include "basicparameters.php";


			$query = "select a.request,a.custno,a.ccompany,a.station,a.loc_date,a.reqst_by, b.item, b.itemdesc, b.qty_asked
				from headdata a, loadings b where trim(a.request)= trim(b.request) and approve_ok = 0 and refuse = 0 order by str_to_date(loc_date,'%d/%m/%Y H:s:i A') desc ";

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
		?>



			<input type="hidden" name="username" />
			<input type="hidden" name="op" />
			<input type="hidden" name="VAR1" />
			<input type="hidden" name="data" id="data" />
			<input type="hidden" name="datafilename" id="datafilename" />
			<input name="fpage" type="hidden" id="fpage" value="<?php echo $pageNo; ?>" size="3" />
			<input name="tpages" type="hidden" id="tpages" value="<?php echo $npages; ?>" size="3" />

			<input type='hidden' name='sql' id='sql' value="<?php echo $download_query; ?>" />
			<input type='hidden' name='filename' id='filename' value="AwaitingApprovals" />
			<input type='hidden' name='pageNo' id="pageNo" value="<?php echo $pageNo; ?>">
			<input type='hidden' name='rowCount' value="<?php echo $count; ?>">
			<input type='hidden' name='skipper' value="<?php echo $skip; ?>">
			<input type='hidden' name='pageEnd' value="<?php echo $npages; ?>">
			<input type='hidden' name='sel' />



			<table style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
				<tr>
					<td colspan="3">
						Limit :
						<select name="limit" class="table_text1" id="limit" onchange="javascript:doSearch('awaitingapproval.php');">
							<option value="1" <?php echo ($limit == "1" ? "selected" : ""); ?>>1</option>
							<option value="10" <?php echo ($limit == "10" ? "selected" : ""); ?>>10</option>
							<option value="20" <?php echo ($limit == "20" ? "selected" : ""); ?>>20</option>
							<option value="50" <?php echo ($limit == "50" ? "selected" : ""); ?>>50</option>
							<option value="100" <?php echo ($limit == "100" ? "selected" : ""); ?>>100</option>
							<option value="200" <?php echo ($limit == "200" ? "selected" : ""); ?>>200</option>
							<option value="500" <?php echo ($limit == "500" ? "selected" : ""); ?>>500</option>
							<option value="700" <?php echo ($limit == "700" ? "selected" : ""); ?>>700</option>
							<option value="1000" <?php echo ($limit == "1000" ? "selected" : ""); ?>>1000</option>
						</select>

					</td>
				</tr>

				<tr>

					<td>No of Records : <?php echo $count; ?></td>
					<td>&nbsp;&nbsp;Page <?php echo $pageNo; ?> of <?php echo $npages; ?> </td>

					<td>&nbsp; &nbsp; &nbsp;&nbsp;<a href="javascript: printDiv('print_div');">Print</a> </td>

				</tr>
			</table>
			<br>
			<table>
				<tr>
					<td align="center">
						<a href="#" onclick="javascript: goFirst('awaitingapproval.php');">
							<img src="images/first.gif" alt="First" width="16" height="16" border="0"></a>
						<a href="#" onclick="javascript: goPrevious('awaitingapproval.php');">
							<img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a>
						<a href="#" onclick="javascript: goNext('awaitingapproval.php');">
							<img src="images/next.gif" alt="Next" width="16" height="16" border="0" /></a>
						<a href="#" onclick="javascript: goLast('awaitingapproval.php');">
							<img src="images/last.gif" alt="Last" width="16" height="16" border="0" /></a>
					</td>
				</tr>
				<tr>
					<td>
						<input type="button" name="closebutton" id="submit-button" value="List Approvals" onclick="javascript:  getpage('approvedreqlist.php?','page');" />

						<input type="button" name="closebutton" id="submit-button" title="List Cancelled Requisitions" value="List Cancelled" onclick="javascript:  getpage('refusedreq.php?','page');" />

						<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('s_and_d.php?','page');" />
					</td>

				</tr>
				<tr>
					<td align="center">
						<div style="height: 150px; overflow-y: auto; overflow-x: auto;" id="print_div">

							<table width="95%" cellspacing="1" class="menu_backcolor" id="userlistTable" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
								<thead>
									<tr class="right_backcolor">
										<th nowrap="nowrap" class="Corner">&nbsp;</th>
										<th nowrap="nowrap" class="Odd">S/N</th>
										<th nowrap="nowrap" class="Odd">Requisition No:</th>
										<th nowrap="nowrap" class="Odd">Customer No</th>
										<th nowrap="nowrap" class="Odd">Customer Name</th>
										<th nowrap="nowrap" class="Odd">Product</th>
										<th nowrap="nowrap" class="Odd">Qty Asked</th>
										<th nowrap="nowrap" class="Odd">Requisition Time</th>
										<th nowrap="nowrap" class="Odd">Requisition By</th>
										<th nowrap="nowrap">&nbsp;</th>
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
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap"><?php echo $k + $skip; ?></td>
										<td nowrap="nowrap">&nbsp;<?php echo $row['request']; ?></td>
										<td nowrap="nowrap">&nbsp;<?php echo $row["custno"]; ?></td>
										<td nowrap="nowrap">&nbsp;<?php echo $row["ccompany"]; ?></td>
										<td nowrap="nowrap">&nbsp;<?php echo $row["itemdesc"]; ?></td>
										<td nowrap="nowrap" align="right">&nbsp;<?php echo $row["qty_asked"]; ?></td>
										<td nowrap="nowrap">&nbsp;<?php echo $row["loc_date"]; ?></td>
										<td nowrap="nowrap">&nbsp;<?php echo $row["reqst_by"]; ?></td>
										<td nowrap="nowrap">
											<a href="javascript:getpage('fastapproval.php?op=edit&request=<?php echo $row["request"]; ?>','page')">View Details</a>
										</td>
									</tr>
								<?php
									//} //End For Loop
								} //End If Result Test	
								?>
							</table>
						</div>
					</td>
				</tr>

				<tr>

					<td align="center" nowrap="nowrap">
						<a href="#" onclick="javascript: goFirst('awaitingapproval.php');">
							<img src="images/first.gif" alt="First" width="16" height="16" border="0" /></a>
						<a href="#" onclick="javascript: goPrevious('awaitingapproval.php');">
							<img src="images/prev.gif" alt="Previous" width="16" height="16" border="0" /></a>
						<a href="#" onclick="javascript: goNext('awaitingapproval.php');">
							<img src="images/next.gif" alt="Next" width="16" height="16" border="0" /></a>
						<a href="#" onclick="javascript: goLast('awaitingapproval.php');">
							<img src="images/last.gif" alt="Last" width="16" height="16" border="0" /></a>
					</td>


				</tr>
			</table>
		<?php } ?>
	</form>
</div>
<script type="text/javascript">
	addTableRolloverEffect('RequisitionTable', 'tableRollOverEffect1', 'tableRowClickEffect1');
</script>