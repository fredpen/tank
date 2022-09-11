<?php
ob_start();
include_once "session_track.php";
?>


<div align="center" id="data-form_report">

	<?php
	require_once("lib/mfbconnect.php");
	?>

	<?php require 'lib/aesencrypt.php'; ?>

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<?php
		include("lib/dbfunctions.php");
		$dbobject = new dbfunction();
		$role_id = "";
		$branch_code = "";


		$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
		?>
		<h1><strong>
				<font color="red">
					<?php
					if ($op == 'payments') {
						echo 'Payments and Refunds';
					} elseif ($op == 'outstandingbills') {
						echo 'Outstanding Bills';
					} elseif ($op == 'reconciledbills') {
						echo 'Reconciled Bills';
					}

					?>
			</strong></h1>

		<?php
		$flatid = !isset($_REQUEST['flatid']) ? '' : $_REQUEST['flatid'];
		$startdate = !isset($_REQUEST['startdate']) ? date("d/m/Y", strtotime("-20 days")) : $_REQUEST['startdate'];
		$enddate = !isset($_REQUEST['enddate']) ? date("d/m/Y") : $_REQUEST['enddate'];
		$user_role_session = $_SESSION['role_id_sess'];
		$userflatid = $_SESSION['username_sess'];

		if ($op == 'payments') {

			if (trim($user_role_session) == "ADMINISTRATOR") {

				if (trim($_REQUEST['flatid']) <> "") {

					$sql_QueryStmt_Summary = "SELECT sum(IF(A.advrefund1=1,A.amount,0)) damount, " .
						"  sum(IF(A.advrefund1<>1,A.amount,0))  reamount, sum(A.amtused) amtused FROM levypmt A, flats B " .
						" WHERE trim(A.flatid) = trim(B.flatid) AND " .
						" trim(A.flatid) = '" . trim($_REQUEST['flatid']) . "'" .
						" AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";

					$sql_QueryStmt = "SELECT B.flatid,B.surname, B.firstname, B.middlename ,B.flatbal,B.flataddress, " .
						" A.refno,A.descriptn,A.advrefund1,A.amount, IF(A.advrefund1=1,A.amount,0) damount, " .
						"  IF(A.advrefund1<>1,A.amount,0)  reamount, A.pmtmode, A.bank_code, A.dd_no, " .
						" A.amtused,A.pmtdate FROM levypmt A, flats B " .
						" WHERE trim(A.flatid) = trim(B.flatid) AND " .
						" trim(A.flatid) = '" . trim($_REQUEST['flatid']) . "'" .
						" AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";
				} else {

					$sql_QueryStmt = "SELECT B.flatid,B.surname, B.firstname, B.middlename ,B.flatbal,B.flataddress, " .
						" A.refno,A.descriptn,A.advrefund1,A.amount, IF(A.advrefund1=1,A.amount,0) damount, " .
						"  IF(A.advrefund1<>1,A.amount,0)  reamount, A.pmtmode, A.bank_code, A.dd_no, " .
						" A.amtused,A.pmtdate FROM levypmt A, flats B " .
						" WHERE trim(A.flatid) = trim(B.flatid) " .
						" AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";

					$sql_QueryStmt_Summary = "SELECT sum(IF(A.advrefund1=1,A.amount,0)) damount, " .
						"  sum(IF(A.advrefund1<>1,A.amount,0))  reamount, sum(A.amtused) amtused FROM levypmt A, flats B " .
						" WHERE trim(A.flatid) = trim(B.flatid) " .
						" AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";
				}
			} else {
				$sql_QueryStmt = "SELECT B.flatid,B.surname, B.firstname, B.middlename ,B.flatbal,B.flataddress, " .
					" A.refno,A.descriptn,A.advrefund1,A.amount, IF(A.advrefund1=1,A.amount,0) damount, " .
					"  IF(A.advrefund1<>1,A.amount,0)  reamount, A.pmtmode, A.bank_code, A.dd_no, " .
					" A.amtused,A.pmtdate FROM levypmt A, flats B " .
					" WHERE trim(A.flatid) = trim(B.flatid) AND " .
					" trim(A.flatid) = '" . trim($userflatid) . "'" .
					" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";

				$sql_QueryStmt_Summary = "SELECT sum(IF(A.advrefund1=1,A.amount,0)) damount, " .
					"  sum(IF(A.advrefund1<>1,A.amount,0))  reamount, sum(A.amtused) amtused FROM levypmt A, flats B " .
					" WHERE trim(A.flatid) = trim(B.flatid) AND " .
					" trim(A.flatid) = '" . trim($userflatid) . "'" .
					" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";
			}
		}

		if ($op == 'outstandingbills') {

			if (trim($user_role_session) == "ADMINISTRATOR") {

				if (trim($_REQUEST['flatid']) <> "") {
					$sql_QueryStmt = "SELECT C.flataddress, C.surname   , C.firstname   , C.middlename ,C.flatbal,B.levydescr," .
						" A.flatid,A.levyid ,A.levyamt ,A.paidsofar,A.levydisc, " .
						" (A.levyamt - A.paidsofar)  BALANCE, " .
						" transdate  FROM flatbill A,schlevies B, flats C " .
						" WHERE trim(A.flatid) = trim(C.flatid) AND " .
						" trim(A.levyid) = trim(B.levyid) AND  (A.levyamt - A.paidsofar) > 0 " .
						" and trim(A.flatid) = '" . trim($_REQUEST['flatid']) .
						"'  ORDER BY A.transdate";

					$sql_QueryStmt_Summary = "SELECT sum(A.levyamt) levyamt ,sum(A.paidsofar) paidsofar , sum(A.levydisc) levydisc " .
						" FROM flatbill A,schlevies B, flats C " .
						" WHERE trim(A.flatid) = trim(C.flatid) AND " .
						" trim(A.levyid) = trim(B.levyid) AND  (A.levyamt - A.paidsofar) > 0 " .
						" and trim(A.flatid) = '" . trim($_REQUEST['flatid']) .
						"'  ORDER BY A.transdate";
				} else {

					$sql_QueryStmt = "SELECT  C.flataddress, C.surname   , C.firstname   , C.middlename ,C.flatbal,B.levydescr," .
						" A.flatid,A.levyid ,A.levyamt ,A.paidsofar,A.levydisc, " .
						" (A.levyamt - A.paidsofar)  BALANCE, " .
						" transdate  FROM flatbill A,schlevies B, flats C " .
						" WHERE trim(A.flatid) = trim(C.flatid) AND " .
						" trim(A.levyid) = trim(B.levyid) AND  (A.levyamt - A.paidsofar) > 0 " .
						"  ORDER BY A.transdate";


					$sql_QueryStmt_Summary = "SELECT sum(A.levyamt) levyamt ,sum(A.paidsofar) paidsofar , sum(A.levydisc) levydisc " .
						" FROM flatbill A,schlevies B, flats C " .
						" WHERE trim(A.flatid) = trim(C.flatid) AND " .
						" trim(A.levyid) = trim(B.levyid) AND  (A.levyamt - A.paidsofar) > 0 " .
						"  ORDER BY A.transdate";
				}
			} else {
				$sql_QueryStmt = "SELECT  C.flataddress, C.surname   , C.firstname   , C.middlename ,C.flatbal,B.levydescr," .
					" A.flatid,A.levyid ,A.levyamt ,A.paidsofar,A.levydisc, " .
					" (A.levyamt - A.paidsofar)  BALANCE, " .
					" transdate  FROM flatbill A,schlevies B, flats C " .
					" WHERE trim(A.flatid) = trim(C.flatid) AND " .
					" trim(A.levyid) = trim(B.levyid) AND  (A.levyamt - A.paidsofar) > 0 " .
					" and trim(A.flatid) = '" . trim($userflatid) . "'" .
					" AND STR_TO_DATE(A.transdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(A.transdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.transdate";

				$sql_QueryStmt_Summary = "SELECT sum(A.levyamt) levyamt ,sum(A.paidsofar) paidsofar , sum(A.levydisc) levydisc " .
					" FROM flatbill A,schlevies B, flats C " .
					" WHERE trim(A.flatid) = trim(C.flatid) AND " .
					" trim(A.levyid) = trim(B.levyid) AND  (A.levyamt - A.paidsofar) > 0 " .
					" and trim(A.flatid) = '" . trim($userflatid) . "'" .
					" AND STR_TO_DATE(A.transdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(A.transdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.transdate";
			}
		}

		if ($op == 'reconciledbills') {

			if (trim($user_role_session) == "ADMINISTRATOR") {

				if (trim($_REQUEST['flatid']) <> "") {

					$sql_QueryStmt = "SELECT A.*, B.flataddress,B.surname   , B.firstname   , B.middlename ,C.levydescr,C.levyamt   " .
						" FROM levypmtuse A, flats B, schlevies C " .
						" where trim(A.flatid) = trim(B.flatid) AND trim(A.levyid) = trim(C.levyid) " .
						" and trim(A.flatid) = '" . trim($_REQUEST['flatid']) .
						"' AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";

					$sql_QueryStmt_Summary = "SELECT sum(A.payments) payments, sum(C.levyamt) levyamt  " .
						" FROM levypmtuse A, schlevies C " .
						" where trim(A.levyid) = trim(C.levyid) " .
						" and trim(A.flatid) = '" . trim($_REQUEST['flatid']) .
						"' AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";
				} else {


					$sql_QueryStmt = "SELECT A.*, B.flataddress,B.surname   , B.firstname   , B.middlename ,C.levydescr,C.levyamt   " .
						" FROM levypmtuse A, flats B, schlevies C " .
						" where trim(A.flatid) = trim(B.flatid) AND trim(A.levyid) = trim(C.levyid) " .
						" AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";

					$sql_QueryStmt_Summary = "SELECT sum(A.payments) payments, sum(C.levyamt) levyamt  " .
						" FROM levypmtuse A, schlevies C " .
						" where trim(A.levyid) = trim(C.levyid) " .
						" AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";
				}
			} else {
				$sql_QueryStmt = "SELECT A.*, B.flataddress,B.surname   , B.firstname   , B.middlename ,C.levydescr,C.levyamt   " .
					" FROM levypmtuse A, flats B, schlevies C " .
					" where trim(A.flatid) = trim(B.flatid) AND trim(A.levyid) = trim(C.levyid) " .
					" and trim(A.flatid) = '" . trim($userflatid) . "'" .
					" AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";

				$sql_QueryStmt_Summary = "SELECT sum(A.payments) payments, sum(C.levyamt) levyamt " .
					" FROM levypmtuse A, flats B, schlevies C " .
					" where trim(A.flatid) = trim(B.flatid) AND trim(A.levyid) = trim(C.levyid) " .
					" and trim(A.flatid) = '" . trim($userflatid) . "'" .
					" AND STR_TO_DATE(A.pmtdate, '%d/%m/%Y') >= STR_TO_DATE('" . $_REQUEST['startdate'] . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(A.pmtdate, '%d/%m/%Y') <= STR_TO_DATE('" . $_REQUEST['enddate'] . "', '%d/%m/%Y')  ORDER BY A.pmtdate";
			}
		}


		$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
		$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

		$row_QueryStmt = mysqli_fetch_array($result_QueryStmt);


		$result_QueryStmt_Summary = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt_Summary);
		$count_QueryStmt_Summary = mysqli_num_rows($result_QueryStmt_Summary);

		$row_QueryStmt_Summary = mysqli_fetch_array($result_QueryStmt_Summary);


		?>

		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<table border="1">
			<?php if (trim($user_role_session) == "USER") { ?>
				<tr>
					<td>Name: </td>
					<td><?php echo $row_QueryStmt['surname'] . ' ' . $row_QueryStmt['middlename'] . ' ', $row_QueryStmt['firstname']; ?> </td>
				</tr>
				<tr>
					<td>House Address:</td>
					<td> <?php echo $row_QueryStmt['flataddress']; ?> </td>
				</tr>
			<?php } ?>
			<tr>
				<td>Start Date: <?php echo $startdate; ?></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp; End Date: <?php echo $enddate; ?> </td>
			</tr>

		</table>

		<?php if ($op == 'payments') { ?>
			<table>
				<thead>
					<tr class="right_backcolor">
						<th nowrap="nowrap" class="Corner">&nbsp;</th>
						<?php if (trim($user_role_session) == "ADMINISTRATOR") { ?>
							<th nowrap="nowrap" class="Odd">Flat</th>
							<th nowrap="nowrap" class="Odd">Name</th>
						<?php } ?>
						<th nowrap="nowrap" class="Odd">Pmt Reference</th>
						<th nowrap="nowrap" class="Odd">Description</th>
						<th nowrap="nowrap" class="Odd">Bank Reference</th>
						<th nowrap="nowrap" class="Odd">Deposit</th>
						<th nowrap="nowrap" class="Odd">Refund</th>
						<th nowrap="nowrap" class="Odd">Amount Used</th>
						<th nowrap="nowrap" class="Odd">Payment Date</th>
						<th nowrap="nowrap">&nbsp;</th>
					</tr>
				</thead>

				<tr>
					<td nowrap="nowrap">&nbsp;</td>
					<?php if (trim($user_role_session) == "ADMINISTRATOR") { ?>
						<td nowrap="nowrap"></td>
						<td nowrap="nowrap"> </td>
					<?php } ?>
					<td nowrap="nowrap"><strong>Summary:</strong></td>
					<td nowrap="nowrap"></td>
					<td nowrap="nowrap"> </td>
					<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt_Summary["damount"], 2); ?></td>
					<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt_Summary["reamount"], 2); ?></td>
					<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt_Summary["amtused"], 2); ?></td>
					<td nowrap="nowrap"></td>
					<td></td>
				</tr>

				<tr></tr>

				<?php
				$k = 0;

				while ($k < $count_QueryStmt) {
					$k++;

				?>

					<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
						<td nowrap="nowrap">&nbsp;</td>
						<?php if (trim($user_role_session) == "ADMINISTRATOR") { ?>
							<td nowrap="nowrap"><?php echo $row_QueryStmt['flataddress']; ?></td>
							<td nowrap="nowrap"><?php echo  $row_QueryStmt['surname'] . ' ' . $row_QueryStmt['middlename'] . ' ', $row_QueryStmt['firstname']; ?></td>
						<?php } ?>
						<td nowrap="nowrap"><?php echo $row_QueryStmt['refno']; ?></td>
						<td nowrap="nowrap"><?php echo $row_QueryStmt['descriptn']; ?></td>
						<td nowrap="nowrap"><?php echo $row_QueryStmt["bank_code"] . '-' . $row_QueryStmt["dd_no"]; ?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt["damount"], 2); ?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt["reamount"], 2); ?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt["amtused"], 2); ?></td>
						<td nowrap="nowrap"><?php echo $row_QueryStmt["pmtdate"]; ?></td>
						<td></td>
					</tr>
				<?php
					$row_QueryStmt = mysqli_fetch_array($result_QueryStmt);
				}
				?>
			</table>

		<?php }

		if ($op == 'outstandingbills') { ?>
			<table>
				<thead>
					<tr class="right_backcolor">
						<th nowrap="nowrap" class="Corner">&nbsp;</th>
						<?php if (trim($user_role_session) == "ADMINISTRATOR") { ?>
							<th nowrap="nowrap" class="Odd">Flat</th>
							<th nowrap="nowrap" class="Odd">Name</th>
						<?php } ?>

						<th nowrap="nowrap" class="Odd">Description</th>
						<th nowrap="nowrap" class="Odd">Bill Amount</th>
						<th nowrap="nowrap" class="Odd">Payment So Far</th>
						<th nowrap="nowrap" class="Odd">Balance</th>
						<th nowrap="nowrap">&nbsp;</th>
					</tr>
				</thead>

				<tr>
					<td nowrap="nowrap">&nbsp;</td>
					<?php if (trim($user_role_session) == "ADMINISTRATOR") { ?>
						<td nowrap="nowrap"></td>
						<td nowrap="nowrap"></td>
					<?php } ?>

					<td nowrap="nowrap"><strong>Summary:</strong></td>
					<td nowrap="nowrap" align="right"><?php echo number_format(($row_QueryStmt_Summary["levyamt"] - $row_QueryStmt_Summary["levydisc"]), 2); ?></td>
					<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt_Summary["paidsofar"], 2); ?></td>
					<td nowrap="nowrap" align="right"><?php echo number_format(($row_QueryStmt_Summary["levyamt"] - $row_QueryStmt_Summary["levydisc"] - $row_QueryStmt_Summary["paidsofar"]), 2); ?></td>
					<td></td>
				</tr>

				<tr></tr>
				<?php
				$k = 0;

				while ($k < $count_QueryStmt) {
					$k++;

				?>

					<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
						<td nowrap="nowrap">&nbsp;</td>
						<?php if (trim($user_role_session) == "ADMINISTRATOR") { ?>
							<td nowrap="nowrap"><?php echo $row_QueryStmt['flataddress']; ?></td>
							<td nowrap="nowrap"><?php echo  $row_QueryStmt['surname'] . ' ' . $row_QueryStmt['middlename'] . ' ', $row_QueryStmt['firstname']; ?></td>
						<?php } ?>

						<td nowrap="nowrap"><?php echo $row_QueryStmt['levydescr']; ?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format(($row_QueryStmt["levyamt"] - $row_QueryStmt["levydisc"]), 2); ?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt["paidsofar"], 2); ?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format(($row_QueryStmt["levyamt"] - $row_QueryStmt["levydisc"] - $row_QueryStmt["paidsofar"]), 2); ?></td>
						<td></td>
					</tr>
				<?php
					$row_QueryStmt = mysqli_fetch_array($result_QueryStmt);
				}
				?>
			</table>

		<?php }

		if ($op == 'reconciledbills') { ?>
			<table>
				<thead>
					<tr class="right_backcolor">
						<th nowrap="nowrap" class="Corner">&nbsp;</th>
						<?php if (trim($user_role_session) == "ADMINISTRATOR") { ?>
							<th nowrap="nowrap" class="Odd">Flat</th>
							<th nowrap="nowrap" class="Odd">Name</th>
						<?php } ?>

						<th nowrap="nowrap" class="Odd">Description</th>
						<th nowrap="nowrap" class="Odd">Bill Amount</th>
						<th nowrap="nowrap" class="Odd">Payments</th>
						<th nowrap="nowrap" class="Odd">Payment Date</th>
						<th nowrap="nowrap" class="Odd">Reference</th>
						<th nowrap="nowrap">&nbsp;</th>
					</tr>
				</thead>


				<tr>
					<td nowrap="nowrap">&nbsp;</td>
					<?php if (trim($user_role_session) == "ADMINISTRATOR") { ?>
						<td nowrap="nowrap"></td>
						<td nowrap="nowrap"> </td>
					<?php } ?>

					<td nowrap="nowrap"><strong>Summary:</strong></td>
					<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt_Summary["levyamt"], 2); ?></td>
					<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt_Summary["payments"], 2); ?></td>
					<td nowrap="nowrap"></td>
					<td nowrap="nowrap"> </td>
					<td></td>
				</tr>
				<tr></tr>


				<?php
				$k = 0;

				while ($k < $count_QueryStmt) {
					$k++;

				?>

					<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
						<td nowrap="nowrap">&nbsp;</td>
						<?php if (trim($user_role_session) == "ADMINISTRATOR") { ?>
							<td nowrap="nowrap"><?php echo $row_QueryStmt['flataddress']; ?></td>
							<td nowrap="nowrap"><?php echo  $row_QueryStmt['surname'] . ' ' . $row_QueryStmt['middlename'] . ' ', $row_QueryStmt['firstname']; ?></td>
						<?php } ?>

						<td nowrap="nowrap"><?php echo $row_QueryStmt['levydescr']; ?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt["levyamt"], 2); ?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($row_QueryStmt["payments"], 2); ?></td>
						<td nowrap="nowrap"><?php echo $row_QueryStmt["pmtdate"]; ?></td>
						<td nowrap="nowrap"><?php echo $row_QueryStmt["refno1"] . ' ' . $row_QueryStmt["refno2"] . ' ' . $row_QueryStmt["refno3"] . ' ' . $row_QueryStmt["refno4"] . ' ' . $row_QueryStmt["refno5"]; ?></td>
						<td></td>
					</tr>
				<?php
					$row_QueryStmt = mysqli_fetch_array($result_QueryStmt);
				}
				?>
			</table>

		<?php } ?>

		<table>
			<tr>

				<td align="right" nowrap="nowrap">
					<label>
						<input type="button" name="closebutton" id="submit-button" value="Close" onclick="javascript:  getpage('statement.php','page');">
					</label>
				</td>


			</tr>
		</table>


	</form>
</div>