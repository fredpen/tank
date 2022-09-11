<?php
ob_start();
include "session_track.php";
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<div align="center" id="data-form">

	<?php

	require("lib/mfbconnect.php");


	$count = 0;
	$limit = !isset($_REQUEST['limit']) ? "20" : $_REQUEST['limit'];
	$pageNo = !isset($_REQUEST['fpage']) ? "1" : $_REQUEST['pageNo'];
	$searchby = !isset($_REQUEST['searchby']) ? "names" : $_REQUEST['searchby'];
	$keyword = !isset($_REQUEST['keyword']) ? "" : $_REQUEST['keyword'];
	$orderby = !isset($_REQUEST['orderby']) ? "names" : $_REQUEST['orderby'];
	$orderflag = !isset($_REQUEST['orderflag']) ? "asc" : $_REQUEST['orderflag'];
	$lower = !isset($_REQUEST['lower']) ? "" : $_REQUEST['lower'];
	$upper = !isset($_REQUEST['upper']) ? "" : $_REQUEST['upper'];


	$filter = "";
	if ($keyword != '') {
		$filter = " AND $searchby like '%$keyword%' ";
	}
	$order = " order by " . $orderby . " " . $orderflag;
	$sql = "select count(userid) counter from datum where 1=1" . $filter . $order;
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

	$sel = !isset($_REQUEST['op']) ? "" : $_REQUEST['op'];
	if ($sel == "del") {
		$delvalues = !isset($_REQUEST['sysuserid']) ? "" : $_REQUEST['sysuserid'];
		$delsql = "delete from datum where userid = '$delvalues'";
		$dresult = mysqli_query($_SESSION['db_connect'], $delsql);
		echo "<font class='header2white'>No of Deleted Records: " . mysqli_affected_rows() . " ";
	}

	//mysql_select_db($database_courier);
	$query = "select * from datum where 1=1" . $filter . $order;
	//echo $query;
	$result = mysqli_query($_SESSION['db_connect'], $query);
	$numrows = mysqli_num_rows($result);

	$download_query = "select userid,names,roleid,useremail  from datum where 1=1" . $filter . $order;

	//echo 'D page:  '.$pageNo;
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">

		<input type="hidden" name="username" />
		<input type="hidden" name="op" />
		<input type="hidden" name="VAR1" />
		<input type="hidden" name="data" id="data" />
		<input type="hidden" name="datafilename" id="datafilename" />
		<input name="fpage" type="hidden" id="fpage" value="<?php echo $pageNo; ?>" size="3" />
		<input name="tpages" type="hidden" id="tpages" value="<?php echo $npages; ?>" size="3" />

		<input type='hidden' name='sql' id='sql' value="<?php echo $download_query; ?>" />
		<input type='hidden' name='filename' id='filename' value="userdata" />
		<input type='hidden' name='pageNo' id="pageNo" value="<?php echo $pageNo; ?>">
		<input type='hidden' name='rowCount' value="<?php echo $count; ?>">
		<input type='hidden' name='skipper' value="<?php echo $skip; ?>">
		<input type='hidden' name='pageEnd' value="<?php echo $npages; ?>">
		<input type='hidden' name='sel' />

		<p>
		<h3><strong>List of Users </strong></h3>
		</p>

		<table border="0" align="center" cellpadding="0" cellspacing="0" id="list_table">

			<tr class="table_background">

				<td>
					<table border="0" cellspacing="1">


						<tr class="tr_whitebackground">
							<td>Search By: </td>

							<td>Order By :</td>

						</tr>
						<tr>
							<td>
								<select name="searchby" class="table_text1" id="searchby">
									<option value="names" <?php echo ($searchby == 'names') ? "selected" : ""; ?>>Username</option>
									<option value="useremail" <?php echo ($searchby == 'useremail') ? "selected" : ""; ?>>Email</option>
								</select>
							</td>




							<td>
								<select name="orderby" class="table_text1" id="orderby">
									<option value="names" <?php echo ($orderby == 'names') ? "selected" : ""; ?>>Username</option>
									<option value="useremail" <?php echo ($orderby == 'useremail') ? "selected" : ""; ?>>email</option>
								</select>
							</td>
							<td>
								<select name="orderflag" class="table_text1" id="orderflag">
									<option value="asc" <?php echo ($orderflag == 'asc') ? "selected" : ""; ?>>Ascending</option>
									<option value="desc" <?php echo ($orderflag == 'desc') ? "selected" : ""; ?>>Descending</option>
								</select>
							</td>
							<td>&nbsp;&nbsp;Limit :
								<select name="limit" class="table_text1" id="limit" onchange="javascript:doSearch('user_list.php');">
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


						<tr class="back_image">

							<td>Keyword: </td>
							<td>
								<input name="keyword" type="text" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />
							</td>
							<td>
								<input name="search22" type="button" class="table_text1" id="submit-button" onclick="javascript:doSearch('user_list.php');" value="Search" />
							</td>

						</tr>
						<tr></tr>
					</table>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td>No of Records : <?php echo $count; ?></td>
				<td>&nbsp;&nbsp;Page <?php echo $pageNo; ?> of <?php echo $npages; ?> </td>

				<td>&nbsp; &nbsp; &nbsp;&nbsp;<a href="javascript: printDiv('print_div');">Print</a>
			</tr>
		</table>
		<br>
		<table>
			<tr>
				<td align="center">
					<a href="#" onclick="javascript: goFirst('user_list.php');"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a> <a href="#" onclick="javascript: goPrevious('user_list.php');"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a> <a href="#" onclick="javascript: goNext('user_list.php');"><img src="images/next.gif" alt="Next" width="16" height="16" border="0" /></a> <a href="#" onclick="javascript: goLast('user_list.php');"><img src="images/last.gif" alt="Last" width="16" height="16" border="0" /></a>

				</td>

			</tr>
			<tr>
				<td align="center">

					<div id="print_div">
						<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th nowrap="nowrap" class="Corner">&nbsp;</th>
									<th nowrap="nowrap" class="Odd">S/N</th>
									<th nowrap="nowrap" class="Odd">User ID</th>
									<th nowrap="nowrap" class="Odd">User Name</th>
									<th nowrap="nowrap" class="Odd">Email</th>
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
									<td nowrap="nowrap"><?php echo $row['userid']; ?></td>
									<td nowrap="nowrap"><?php echo $row["names"]; ?></td>
									<td nowrap="nowrap"><?php echo $row["useremail"]; ?></td>
									<td nowrap="nowrap"><a href="javascript:getpage('user.php?op=edit&sysuserid=<?php echo $row["userid"]; ?>','page')">Edit</a></td>
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

				<td align="center" nowrap="nowrap"><a href="#" onclick="javascript: goFirst('user_list.php');"><img src="images/first.gif" alt="First" width="16" height="16" border="0" /></a> <a href="#" onclick="javascript: goPrevious('user_list.php');"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0" /></a> <a href="#" onclick="javascript: goNext('user_list.php');"><img src="images/next.gif" alt="Next" width="16" height="16" border="0" /></a> <a href="#" onclick="javascript: goLast('user_list.php');"><img src="images/last.gif" alt="Last" width="16" height="16" border="0" /></a></td>

			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
	addTableRolloverEffect('userlistTable', 'tableRollOverEffect1', 'tableRowClickEffect1');
</script>