<?php
ob_start();
include_once "session_track.php";

require_once("lib/mfbconnect.php");

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
$limit = !isset($_REQUEST['limit']) ? "100" : $_REQUEST['limit'];
$pageNo = !isset($_REQUEST['fpage']) ? "1" : $_REQUEST['pageNo'];
$searchby = !isset($_REQUEST['searchby']) ? "reportdesc" : $_REQUEST['searchby'];
$keyword = !isset($_REQUEST['keyword']) ? "" : $_REQUEST['keyword'];
$orderby = !isset($_REQUEST['orderby']) ? "reportdesc" : $_REQUEST['orderby'];
$orderflag = !isset($_REQUEST['orderflag']) ? "asc" : $_REQUEST['orderflag'];
$lower = !isset($_REQUEST['lower']) ? "" : $_REQUEST['lower'];
$upper = !isset($_REQUEST['upper']) ? "" : $_REQUEST['upper'];
$reportgrp = !isset($_REQUEST['reportgrp']) ? "" : $_REQUEST['reportgrp'];


switch (true) {
	case $reportgrp == '0':

		$thereportgrp = '';
		$_SESSION['reportgrp'] = $reportgrp;
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

$filter = "";
if (trim($keyword) != '') {
	$filter = " AND $searchby like '%$keyword%' ";
}
$order = " order by " . $orderby . " " . $orderflag;
$sql = "select count(reportdesc) counter from reptable where 1=1  $thereportgrp " . $filter . $order;
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
$branch_code = "";
$user_role_session = $_SESSION['role_id_sess'];
$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];






$query = "select * from reptable where 1=1 $thereportgrp " . $filter . $order;
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

<div align="center" id="data-form">
<!--    <span class="close-x">X</span>-->
    	<input type="button" name="closebutton" id="submit-button" title="Close" value="X" onclick="javascript:  $('#data-form').hide();">
<!--    	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">-->
	<form>
		<h3><strong>
				Reports List
			</strong></h3>
		<?php
		if ($_SESSION['reports'] == 1) { ?>
			<table border="0" cellspacing="1" style="border:1px solid black;padding:10px;border-collapse:separate;border-radius:15px">


				<tr class="back_image">
					<td>No of Records : <?php echo $count; ?>&nbsp;&nbsp;
						Page <?php echo $pageNo; ?> of <?php echo $npages; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


						<a href="#" onclick="javascript: goFirst('reportlist.php');">
							<img src="images/first.gif" alt="First" width="16" height="16" border="0"></a>
						<a href="#" onclick="javascript: goPrevious('reportlist.php');">
							<img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a>
						<a href="#" onclick="javascript: goNext('reportlist.php');">
							<img src="images/next.gif" alt="Next" width="16" height="16" border="0" /></a>
						<a href="#" onclick="javascript: goLast('reportlist.php');">
							<img src="images/last.gif" alt="Last" width="16" height="16" border="0" /></a>

						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

						Limit :
						<select name="limit" class="table_text1" id="limit" onchange="javascript:doSearch('reportlist.php');">
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

						<input name="search22" type="button" class="table_text1" id="submit-button" onclick="javascript:doSearch('reportlist.php');" value="Search" />
					</td>

				</tr>

			</table>

			<div style="height: 300px; overflow-y: auto">
				<table id="reporttable" class="table table-striped table-bordered" style="width:90%">
					<thead>
						<tr class="right_backcolor">
							<th nowrap="nowrap" class="Corner">&nbsp;</th>
							<th nowrap="nowrap" class="Odd">S/N</th>
							<th nowrap="nowrap" class="Odd">Report Description</th>
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
								<td nowrap="nowrap"><?php echo $row['reportdesc']; ?></td>
								<td nowrap="nowrap"><a href="javascript: getpage('reportheader.php?reportname=<?php echo trim($row['procname']); ?>
																					&reportdesc=<?php echo trim($row['reportdesc']); ?>
																					&thestartdate=<?php echo trim($row['startdate']); ?>
																					&location=<?php echo trim($row['location']); ?>
																					&product=<?php echo trim($row['product']); ?>
																					&purchaseorder=<?php echo trim($row['purchaseorder']); ?>
																					&vendor=<?php echo trim($row['vendor']); ?>
																					&customer=<?php echo trim($row['customer']); ?>
																					&salesperson=<?php echo trim($row['salespsn']); ?>
																					','page')">Select</a></td>
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
							<th nowrap="nowrap" class="Odd">Report Description</th>
							<th nowrap="nowrap">&nbsp;</th>
						</tr>
					</tfoot>

				</table>
			</div>

		<?php } ?>

	</form>
</div>
<script type="text/javascript">
	addTableRolloverEffect('reporttable', 'tableRollOverEffect1', 'tableRowClickEffect1');
</script>