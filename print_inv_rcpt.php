<?php
ob_start();
include_once "session_track.php";
?>


<div align="center" id="data-form">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">

	<?php
	require_once("lib/mfbconnect.php");
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<form action="" method="get" id="form1">
		<h3 class="noprint"><strong>Print Invoice or Receipt</strong></h3>

		<?php
		if ($_SESSION['prnrcpt'] == 1 || $_SESSION['prninv'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$user = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];

			$custno = !isset($_REQUEST['custno']) ? '' : $_REQUEST['custno'];
			$ccompany = !isset($_REQUEST['ccompany']) ? '' : $dbobject->test_input($_REQUEST['ccompany']);

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$keyword_invoiceno = !isset($_REQUEST['keyword_invoiceno']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword_invoiceno']));
			$keyword_receiptno = !isset($_REQUEST['keyword_receiptno']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword_receiptno']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$refno = !isset($_REQUEST['refno']) ? '' : $dbobject->test_input($_REQUEST['refno']);
			$invoice_no = !isset($_REQUEST['invoice_no']) ? '' : $dbobject->test_input($_REQUEST['invoice_no']);


			if ($op == 'searchclient') {

				//echo "keyword ".$keyword . "<br/>";
				//echo "string length ".strlen($keyword) . "<br/>";
				$filter = "";
				if ($searchin == "custno") {
					if ($keyword != '') {
						$filter = " AND trim(custno) like '%$keyword%'   ";
					}
				} else {
					if ($keyword != '') {
						$filter = " AND trim(company) like '%$keyword%'   ";
					}
				}



				$sql_Q = "SELECT * FROM arcust where ";
				if (strlen($keyword) != 0) {
					$sql_Q = $sql_Q . " 1 = 1 ";
				} else {
					$sql_Q = $sql_Q . " 1 = 2 ";
				}
				$orderby = "   ";
				$orderflag	= " ";
				$order = $orderby . " " . $orderflag;
				$sql_QueryStmt = $sql_Q . $filter . $order . " limit 1";

				//echo "<br/> sql_Q ".$sql_Q;	
				//echo "<br/>".$sql_QueryStmt;
				$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
				$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

				if ($count_QueryStmt >= 1) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$custno    = $row['custno'];
					$ccompany   = $row['company'];
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Customer does not exist</strong>");
					</script>
				<?php
				}
			}



			if ($op == 'searchinvoiceno') {
				$filter = "";

				$sql_Q = "SELECT * FROM invoice where 1 =1  ";


				if ($keyword_invoiceno != '') {
					$filter = " AND trim(invoice_no) like '%$keyword_invoiceno%'   ";
				}
				if (strlen($keyword_invoiceno) == 0) {
					$sql_Q = $sql_Q . " and 1 = 2 ";
				}




				$orderby = "   ";
				$orderflag	= " ";
				$order = $orderby . " " . $orderflag;
				$sql_QueryStmt = $sql_Q . $filter . $order . " limit 1";

				//echo "<br/> sql_Q ".$sql_Q;	
				//echo "<br/>".$sql_QueryStmt."<br/>";
				$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
				$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

				if ($count_QueryStmt >= 1) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$custno    = $row['custno'];
					$ccompany   = $row['ccompany'];
					$invoice_no   = $row['invoice_no'];
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Invoice Number does not exist</strong>");
					</script>
				<?php
				}
			}


			if ($op == 'searchreceiptno') {
				$filter = "";

				$sql_Q = "SELECT a.custno,a.refno,a.amount,a.descriptn,a.pmtdate,a.transby, b.company  
							FROM payments a, arcust b where trim(a.custno) = trim(b.custno) ";


				if ($keyword_receiptno != '') {
					$filter = " AND trim(a.refno) like '%$keyword_receiptno%'   ";
				}
				if (strlen($keyword_receiptno) == 0) {
					$sql_Q = $sql_Q . " and 1 = 2 ";
				}


				$orderby = "   ";
				$orderflag	= " ";
				$order = $orderby . " " . $orderflag;
				$sql_QueryStmt = $sql_Q . $filter . $order . " limit 1";

				//echo "<br/> sql_Q ".$sql_Q;	
				//echo "<br/>".$sql_QueryStmt."<br/>";
				$result_QueryStmt = mysqli_query($_SESSION['db_connect'], $sql_QueryStmt);
				$count_QueryStmt = mysqli_num_rows($result_QueryStmt);

				if ($count_QueryStmt >= 1) {
					$row       = mysqli_fetch_array($result_QueryStmt);
					$custno    = $row['custno'];
					$ccompany   = $row['company'];
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Receipt Number does not exist</strong>");
					</script>
			<?php
				}
			}

			if ($custno  == '') {
				$sql_invoiceno = "select * FROM invoice order by STR_TO_DATE(invoice_dt, '%d/%m/%Y') desc limit 1000";

				$sql_receiptno = "select * FROM payments order by STR_TO_DATE(pmtdate, '%d/%m/%Y') desc limit 30";
			} else {
				$sql_invoiceno = "select * FROM invoice where trim(custno) = '$custno' order by STR_TO_DATE(invoice_dt, '%d/%m/%Y') desc limit 1000";

				$sql_receiptno = "select * FROM payments where trim(custno) = '$custno' order by STR_TO_DATE(pmtdate, '%d/%m/%Y') desc limit 30";
			}

			//echo $sql_invoiceno	."<br/>".$sql_receiptno	;
			$result_invoiceno = mysqli_query($_SESSION['db_connect'], $sql_invoiceno);
			$count_invoiceno = mysqli_num_rows($result_invoiceno);

			$result_receiptno = mysqli_query($_SESSION['db_connect'], $sql_receiptno);
			$count_receiptno = mysqli_num_rows($result_receiptno);





			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
			<input type="hidden" name="ccompany" id="ccompany" value="<?php echo $ccompany; ?>" />


			<table class="tableb" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>

					<td colspan="2">
						<div class="input-group">
							<b>Search Client : </b>&nbsp;<input name="keyword" type="text" placeholder="Enter a keyword" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

							&nbsp;
							<b>Search in: </b>

							<select name="searchin" id="searchin">
								<option value="company" <?php echo ($searchin == 'company' ? "selected" : ""); ?>>Name</option>
								<option value="custno" <?php echo ($searchin == 'custno' ? "selected" : ""); ?>>Customer ID</option>
							</select>



							&nbsp;
							<input type="button" name="searchclient" id="submit-button" value="Search" onclick="javascript:var $form_keyword = $('#keyword').val();var $form_searchin = $('#searchin').val();
										 getpage('print_inv_rcpt.php?op=searchclient&keyword='+$form_keyword+'&searchin='+$form_searchin,'page');">
						</div>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<b>Client ID : </b>&nbsp;&nbsp;<?php echo $custno; ?> &nbsp;&nbsp;&nbsp;&nbsp; <b>Name : </b>&nbsp;<?php echo $ccompany; ?>
						&nbsp;&nbsp;
					</td>
				</tr>

				<tr>

					<td nowrap="nowrap" colspan="2">
						<div class="input-group">
							<b>Search Invoice : </b>&nbsp;<input name="keyword_invoiceno" type="text" placeholder="Enter Invoice Number" class="table_text1" id="keyword_invoiceno" value="<?php echo $keyword_invoiceno; ?>" />

							&nbsp;&nbsp;
							<input type="button" name="searchinvoiceno" id="submit-button" value="Search" onclick="javascript:var $form_keyword_invoiceno = $('#keyword_invoiceno').val();
										 getpage('print_inv_rcpt.php?op=searchinvoiceno&keyword_invoiceno='+$form_keyword_invoiceno,'page');"> &nbsp;




						</div>
					</td>

				</tr>
				<tr>

					<td colspan="2">
						<div class="input-group">
							<b>Search Receipt : </b>&nbsp;<input name="keyword_receiptno" type="text" placeholder="Enter Receipt Number" class="table_text1" id="keyword_receiptno" value="<?php echo $keyword_receiptno; ?>" />

							&nbsp;&nbsp;
							<input type="button" name="searchreceiptno" id="submit-button" value="Search" onclick="javascript:var $form_keyword_receiptno = $('#keyword_receiptno').val();
										 getpage('print_inv_rcpt.php?op=searchreceiptno&keyword_receiptno='+$form_keyword_receiptno,'page');"> &nbsp;




						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<b>Select Invoice : </b>&nbsp;


						<?php
						$k = 0;
						?>
						<select name="invoice_no" id="invoice_no" onChange="javascript: whattoprint(this.id,this.value); ">
							<option value=""></option>
							<?php

							while ($k < $count_invoiceno) {
								$row = mysqli_fetch_array($result_invoiceno);
								$theselectedinvoiceno = trim($row['invoice_no']) . "  " . str_replace("&", "and", trim($row['ccompany'])) . "   " . $row['invoice_am'];
							?>
								<option value="<?php echo trim($row['invoice_no']); ?>" <?php echo ($invoice_no == trim($row['invoice_no']) ? "selected" : ""); ?>>
									<?php echo $theselectedinvoiceno; ?>
								</option>

							<?php
								$k++;
							} //End If Result Test	
							?>
						</select>

						<input type="submit" name="PrintInvoice" <?php if (!empty($invoice_no)) {
																		echo ' style="display:block;"';
																	} else {
																		echo ' style="display:none;"';
																	} ?> class="PrintButton" id="submit-button" formtarget="_blank" value="Print Invoice" formaction="<?php echo $_SESSION['applicationbase'] . 'printinvoice.php'; ?>" />
					</td>
				</tr>
				<tr>
					<td colspan="2">

						<b>Select Receipt : </b>&nbsp;


						<?php
						$k = 0;
						?>
						<select name="refno" id="refno" onChange="javascript: whattoprint(this.id,this.value);
										
							">
							<option value=""></option>
							<?php

							while ($k < $count_receiptno) {
								$row = mysqli_fetch_array($result_receiptno);
								$theselectedreceiptno = trim($row['refno']) . " " . trim($row['custno']) . " " . $row['amount'];

							?>
								<option value="<?php echo trim($row['refno']); ?>" <?php echo ($refno == trim($row['refno']) ? "selected" : ""); ?>>
									<?php echo $theselectedreceiptno; ?>
								</option>

							<?php
								$k++;
							} //End If Result Test	
							?>
						</select>

						<input type="submit" <?php if (!empty($refno)) {
													echo ' style="display:block;"';
												} else {
													echo ' style="display:none;"';
												} ?> name="PrintReceipt" class="PrintButton" id="submit-button" formtarget="_blank" value="Print Receipt" formaction="<?php echo $_SESSION['applicationbase'] . 'printreceipt.php' ?>" />
					</td>
				</tr>
			</table>

		<?php

		} ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('s_and_d.php?','page');
							">
	<br />
</div>

<script>
	function whattoprint(theid, thevalue) {

		var showprninv = document.getElementsByName("PrintInvoice");
		var showprnrcpt = document.getElementsByName("PrintReceipt");
		showprnrcpt[0].style = "display:none;";
		showprninv[0].style = "display:none;"
		if (thevalue != '') {
			if (theid == 'invoice_no') {
				showprninv[0].style = "display:block;";

			} else {
				showprnrcpt[0].style = "display:block;";

			}

		}


	}
</script>