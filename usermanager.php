<?php
ob_start();
include_once "session_track.php";
?>

<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align="center" id="data-form">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">
	<?php
	require_once("lib/mfbconnect.php");
	?>



	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong>
				<font size='12'>Users </font>
			</strong></h3>
		<?php
		include("lib/dbfunctions.php");
		$dbobject = new dbfunction();
		$role_id = "";
		$branch_code = "";

		$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
		$sysuserid = !isset($_REQUEST['sysuserid']) ? '' : test_input($_REQUEST['sysuserid']);
		$names = !isset($_REQUEST['names']) ? '' : test_input($_REQUEST['names']);
		$roleid = !isset($_REQUEST['roleid']) ? '' : test_input($_REQUEST['roleid']);
		$email = !isset($_REQUEST['email']) ? '' : test_input($_REQUEST['email']);
		$productionreq = !isset($_REQUEST['productionreq']) ? 0 : test_input($_REQUEST['productionreq']);
		$productionappr = !isset($_REQUEST['productionappr']) ? 0 : test_input($_REQUEST['productionappr']);
		$createpo = !isset($_REQUEST['createpo']) ? 0 : test_input($_REQUEST['createpo']);
		$password = !isset($_REQUEST['password']) ? '' : test_input($_REQUEST['password']);
		$reports = !isset($_REQUEST['reports']) ? 0 : test_input($_REQUEST['reports']);
		$request = !isset($_REQUEST['request']) ? 0 : test_input($_REQUEST['request']);
		$fieldtosearch = !isset($_REQUEST['fieldtosearch']) ? '' : test_input($_REQUEST['fieldtosearch']);
		$lookfor = !isset($_REQUEST['lookfor']) ? '' : test_input($_REQUEST['lookfor']);
		$administra = !isset($_REQUEST['administra']) ? 0 : test_input($_REQUEST['administra']);
		$delivery = !isset($_REQUEST['delivery']) ? 0 : test_input($_REQUEST['delivery']);
		$othincome = !isset($_REQUEST['othincome']) ? 0 : test_input($_REQUEST['othincome']);
		$expense = !isset($_REQUEST['expense']) ? 0 : test_input($_REQUEST['expense']);
		$authentica = !isset($_REQUEST['authentica']) ? 0 : test_input($_REQUEST['authentica']);
		$approvepo = !isset($_REQUEST['approvepo']) ? 0 : test_input($_REQUEST['approvepo']);
		$glposting = !isset($_REQUEST['glposting']) ? 0 : test_input($_REQUEST['glposting']);
		$retail = !isset($_REQUEST['retail']) ? 0 : test_input($_REQUEST['retail']);
		$credits = !isset($_REQUEST['credits']) ? 0 : test_input($_REQUEST['credits']);
		$ownuse = !isset($_REQUEST['ownuse']) ? 0 : test_input($_REQUEST['ownuse']);
		$ptn = !isset($_REQUEST['ptn']) ? 0 : test_input($_REQUEST['ptn']);
		$receivepo = !isset($_REQUEST['receivepo']) ? 0 : test_input($_REQUEST['receivepo']);
		$payments = !isset($_REQUEST['payments']) ? 0 : test_input($_REQUEST['payments']);
		$cca = !isset($_REQUEST['cca']) ? 0 : test_input($_REQUEST['cca']);
		$crrecon = !isset($_REQUEST['crrecon']) ? 0 : test_input($_REQUEST['crrecon']);
		$reprint = !isset($_REQUEST['reprint']) ? 0 : test_input($_REQUEST['reprint']);
		$prninv = !isset($_REQUEST['prninv']) ? 0 : test_input($_REQUEST['prninv']);
		$prnrcpt = !isset($_REQUEST['prnrcpt']) ? 0 : test_input($_REQUEST['prnrcpt']);
		$approval = !isset($_REQUEST['approval']) ? 0 : test_input($_REQUEST['approval']);
		$directjournal = !isset($_REQUEST['directjournal']) ? 0 : test_input($_REQUEST['directjournal']);

		$genloadingslip = !isset($_REQUEST['genloadingslip']) ? 0 : test_input($_REQUEST['genloadingslip']);
		$prnloadingslip = !isset($_REQUEST['prnloadingslip']) ? 0 : test_input($_REQUEST['prnloadingslip']);
		$genwaybill = !isset($_REQUEST['genwaybill']) ? 0 : test_input($_REQUEST['genwaybill']);
		$prnwaybill = !isset($_REQUEST['prnwaybill']) ? 0 : test_input($_REQUEST['prnwaybill']);
		$receiveprod = !isset($_REQUEST['receiveprod']) ? 0 : test_input($_REQUEST['receiveprod']);
		$issueprod = !isset($_REQUEST['issueprod']) ? 0 : test_input($_REQUEST['issueprod']);
		$returnpo = !isset($_REQUEST['returnpo']) ? 0 : test_input($_REQUEST['returnpo']);
		$ivmasters = !isset($_REQUEST['ivmasters']) ? 0 : test_input($_REQUEST['ivmasters']);
		$apmasters = !isset($_REQUEST['apmasters']) ? 0 : test_input($_REQUEST['apmasters']);
		$somasters = !isset($_REQUEST['somasters']) ? 0 : test_input($_REQUEST['somasters']);
		$armasters = !isset($_REQUEST['armasters']) ? 0 : test_input($_REQUEST['armasters']);
		$pomasters = !isset($_REQUEST['pomasters']) ? 0 : test_input($_REQUEST['pomasters']);
		$glmasters = !isset($_REQUEST['glmasters']) ? 0 : test_input($_REQUEST['glmasters']);
		$storagereadings = !isset($_REQUEST['storagereadings']) ? 0 : test_input($_REQUEST['storagereadings']);
		$approvereadings = !isset($_REQUEST['approvereadings']) ? 0 : test_input($_REQUEST['approvereadings']);

		$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));




		if ($op == 'searchkeyword') {

			$sql_userid = "select * from datum where trim(userid) = '" . trim($keyword) . "'";
			$result_userid = mysqli_query($_SESSION['db_connect'], $sql_userid);
			$count_userid = mysqli_num_rows($result_userid);
			if ($count_userid >= 1) {
				$row = mysqli_fetch_array($result_userid);
				$sysuserid = $row['userid'];
				$names = $row['names'];
				$roleid = $row['roleid'];
				$administra = $row['administra'];
				$request = $row['request'];
				$reports = $row['reports'];
				$productionreq = $row['productionreq'];
				$productionappr = $row['productionappr'];
				$delivery = $row['delivery'];
				$othincome = $row['othincome'];
				$expense = $row['expense'];
				$authentica = $row['authentica'];
				$pomasters = $row['pomasters'];
				$somasters = $row['somasters'];
				$armasters = $row['armasters'];
				$glmasters = $row['glmasters'];
				$ivmasters = $row['ivmasters'];
				$apmasters = $row['apmasters'];
				$createpo = $row['createpo'];
				$receivepo = $row['receivepo'];
				$approvepo = $row['approvepo'];
				$returnpo = $row['returnpo'];
				$glposting = $row['glposting'];
				$receiveprod = $row['receiveprod'];
				$issueprod = $row['issueprod'];
				$retail = $row['retail'];
				$credits = $row['credits'];
				$ownuse = $row['ownuse'];
				$ptn = $row['ptn'];
				$email = $row['useremail'];
				$approval = $row['approval'];
				$prninv = $row['prninv'];
				$directjournal = $row['directjournal'];
				$payments = $row['payments'];
				$cca = $row['cca'];
				$crrecon = $row['crrecon'];
				$prnrcpt = $row['prnrcpt'];
				$genloadingslip = $row['genloadingslip'];
				$prnloadingslip = $row['prnloadingslip'];
				$genwaybill = $row['genwaybill'];
				$prnwaybill = $row['prnwaybill'];
				$reprint = $row['reprint'];
				$storagereadings = $row['storagereadings'];
				$approvereadings = $row['approvereadings'];
			} else {

				$reprint = 0;
				$prnrcpt = 0;
				$crrecon = 0;
				$cca = 0;
				$payments = 0;
				$receivepo = 0;
				$prninv = 0;
				$directjournal = 0;
				$approval = 0;
				$names = '';
				$roleid = '';
				$administra = 0;
				$request = 0;
				$reports = 0;
				$createpo = 0;
				$productionreq = 0;
				$productionappr = 0;
				$storagereadings = 0;
				$approvereadings = 0;

				$delivery = 0;
				$othincome = 0;
				$expense = 0;
				$authentica = 0;
				$approvepo = 0;
				$glposting = 0;
				$email = '';
				$retail = 0;
				$credits = 0;
				$ownuse = 0;
				$ptn = 0;

				$genloadingslip = 0;
				$prnloadingslip = 0;
				$genwaybill = 0;
				$prnwaybill = 0;
				$receiveprod = 0;
				$issueprod = 0;
				$returnpo = 0;
				$ivmasters = 0;
				$apmasters = 0;

				$somasters = 0;
				$armasters = 0;
				$pomasters = 0;
				$glmasters = 0;

		?>
				<script>
					$('#item_error').html("<strong>This is a new Record</strong>");
				</script>
			<?php
			}
		}


		if ($op == 'deleteuser') {

			$sql_userid = "delete from datum where trim(userid) = '" . trim($sysuserid) . "'";
			$result_userid = mysqli_query($_SESSION['db_connect'], $sql_userid);
			?>
			<script>
				$('#item_error').html("<strong> <?php echo trim($sysuserid) ?> Deleted </strong>");
			</script>
			<?php

		}





		if ($op == 'saving') {
			$goahead = 1;
			if (trim($sysuserid) == '') {
				$goahead = 0;
			?>
				<script>
					$('#item_error').html("<strong>Please specify User ID</strong>");
				</script>
			<?php }
			if (trim($names) == '') {
				$goahead = 0;
			?>
				<script>
					$('#item_error').html("<strong>Please specify Name</strong>");
				</script>
			<?php }

			if (trim($administra) == '') {
				$goahead = 0;
			?>
				<script>
					$('#item_error').html("<strong>Please specify A Role</strong>");
				</script>
			<?php }


			if (trim($email) == '') {
				$goahead = 0;
			?>
				<script>
					$('#item_error').html("<strong>Please Email is required</strong>");
				</script>
			<?php

			} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$goahead = 0;
			?>
				<script>
					$('#item_error').html("<strong>You have entered an invalid Email.</strong>");
				</script>
				<?php
			} else {

				//check for uniqueness of the email
				$sql_email = "select userid, useremail from datum where trim(useremail) = '" . trim($email) . "'";
				//echo $sql_email ;
				$result_email = mysqli_query($_SESSION['db_connect'], $sql_email);
				$count_email = mysqli_num_rows($result_email);


				if ($count_email > 0) {

					$row = mysqli_fetch_array($result_email);
					if (strtoupper(trim($sysuserid)) <> strtoupper(trim($row['userid']))) {
						$goahead = 0;

				?>
						<script>
							$('#item_error').html("<strong>Email in use by another. </strong>");
						</script>
					<?php

					}
				}
			}






			//save if all is ok
			if ($goahead == 1) {


				$sql_userid = "select * from datum where trim(userid) = '" . trim($sysuserid) . "'";

				$result_userid = mysqli_query($_SESSION['db_connect'], $sql_userid);
				$count_userid = mysqli_num_rows($result_userid);


				$therole = ($administra == 1) ? "ADMINISTRATOR" : "USER";
				if ($count_userid >= 1) {
					$theset = (trim($password) != '') ? ", webpassword = '" . md5(md5($sysuserid) . md5($password)) . "'" : '';


					$sql_update = " update datum set  
								 names = '$names', administra = $administra 
								 , useremail = '$email' " .
						$theset .
						", request = $request ,approval = $approval ,cca = $cca 
								,reports = $reports  ,retail = $retail 
								  , credits = $credits ,ownuse = $ownuse ,delivery = $delivery 
								  ,reprint = $reprint ,expense = $expense 
								 ,othincome = $othincome ,crrecon = $crrecon , payments = $payments 
								 ,prninv = $prninv ,prnrcpt = $prnrcpt ,storagereadings = $storagereadings 
								   , ptn = $ptn   ,createpo = $createpo,approvereadings = $approvereadings 
								  ,approvepo = $approvepo , receivepo = $receivepo ,productionreq = $productionreq 
								  ,productionappr = $productionappr ,glposting = $glposting 
								   ,authentica = $authentica , roleid = '$therole'
								  , genloadingslip = $genloadingslip , prnloadingslip = $prnloadingslip 
								  , genwaybill = $genwaybill , prnwaybill = $prnwaybill , receiveprod = $receiveprod
								  , issueprod = $issueprod , returnpo =$returnpo , ivmasters =$ivmasters , apmasters =$apmasters 
								 , somasters =$somasters , armasters =$armasters ,pomasters = $pomasters 
								, glmasters =$glmasters, directjournal =$directjournal   where trim(userid) = '$sysuserid'";


					//echo $sql_update;
					$result_update = mysqli_query($_SESSION['db_connect'], $sql_update);

					?> <script>
						$('#item_error').html("<strong>Record Updated</strong>");
					</script> <?php
							} else {
								$thefield = (trim($password) != '') ? " webpassword, " : "";
								$thevalue = (trim($password) != '') ? "'" . md5(md5($sysuserid) . md5($password)) . "'," : '';

								$sql_insert = " insert into datum  
						    ($thefield roleid, useremail,userid, names, administra,  request,approval, cca,reports, 
							  retail, credits, ownuse, delivery,  
							    reprint, expense, othincome, crrecon, payments, 
							  prninv, prnrcpt,   ptn,  
							  createpo, approvepo, receivepo, productionreq, productionappr, glposting, authentica, 
							  genloadingslip, prnloadingslip, genwaybill , prnwaybill , receiveprod,
							  issueprod,  returnpo, ivmasters ,apmasters , somasters, armasters , pomasters , glmasters,storagereadings,approvereadings,directjournal ) 
							  values   
							  ($thevalue '$therole', '$email', '$sysuserid', '$names', $administra , 
							 $request , $approval , $cca , $reports  , 
							 $retail ,$credits ,$ownuse , $delivery ,  
							 $reprint , $expense ,$othincome , $crrecon , $payments , 
							$prninv , $prnrcpt ,   
							$ptn  ,$createpo , $approvepo , $receivepo , 
							$productionreq ,$productionappr ,$glposting , $authentica, 
							$genloadingslip, $prnloadingslip,$genwaybill ,$prnwaybill ,$receiveprod,
							$issueprod, $returnpo,$ivmasters ,$apmasters ,$somasters,$armasters ,$pomasters,$glmasters ,$storagereadings ,$approvereadings ,$directjournal  )";


								//echo $sql_insert;
								$result_insert = mysqli_query($_SESSION['db_connect'], $sql_insert);

								?> <script>
						$('#item_error').html("<strong>New Record Created</strong>");
					</script> <?php
							}
						}
					}
					//****			

					function test_input($data)
					{
						$data = trim($data);
						$data = stripslashes($data);
						$data = htmlspecialchars($data);
						return $data;
					}

								?>

		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="users" />
		<input type="hidden" name="get_file" id="get_file" value="usermanager" />

		<table border="0" style="border-spacing: 10px">
			<tr>
				<td colspan="4" style="color:red;" id="item_error" align="left"></td>
			</tr>
			<tr>
				<td colspan="4">
					<div class="input-group">
						<b>Search by: <i>Name or Code or Role</i> </b>&nbsp;
						<input type="text" id="search" placeholder="Search for User" />
						<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

					</div>
					<!-- Suggestions will be displayed in below div. -->

					<div id="display"></div>
				</td>

			</tr>
			<tr>
				<td align="left"><b>User ID :</b></td>
				<td align="left">
					<input type="text" name="sysuserid" id="sysuserid" value="<?php echo $sysuserid; ?>" class="required-text" title="User ID">
				</td>
				<td align="left"><b>User Name :</b></td>
				<td align="left">
					<input type="text" name="names" id="names" value="<?php echo $names; ?>" class="required-text">
				</td>
			</tr>
			<tr>
				<td><b>Email :</b></td>
				<td align="left"><input type="text" name="email" id="email" value="<?php echo $email; ?>" class="required-email" title="Email" /></td>
				<td valign="top"><b>Role :</b></td>
				<td align="left">

					<select name="administra" id="administra">
						<option value=""></option>

						<option value="1" <?php echo ($administra == 1 ? "selected" : ""); ?>>Administrator</option>
						<option value="2" <?php echo ($administra == 2 ? "selected" : ""); ?>>User</option>
					</select>
				</td>

			</tr>
			<tr>
				<td colspan="4" align="left"><br /><b>Business Category :</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="retail" <?php if ($retail == 1) {
																								echo 'checked';
																							} ?> />&nbsp;&nbsp;<b>Cash</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="credits" <?php if ($credits == 1) {
																								echo 'checked';
																							} ?> />&nbsp;&nbsp;<b>Credit</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="ownuse" <?php if ($ownuse == 1) {
																								echo 'checked';
																							} ?> />&nbsp;&nbsp;<b>Own Use</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="ptn" <?php if ($ptn == 1) {
																							echo 'checked';
																						} ?> />&nbsp;&nbsp;<b>Product Transfer</b>


			</tr>

			<tr>
				<td align="center" colspan="4">
					<table border="0" cellspacing="5" style="outline-style: double;">
						<tr>
							<td><input type="checkbox" id="createpo" <?php if ($createpo == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Create PO</b>
							</td>
							<td><input type="checkbox" id="approvepo" <?php if ($approvepo == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Approve PO</b>
							</td>
							<td><input type="checkbox" id="receivepo" <?php if ($receivepo == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Receive PO</b>
							</td>
							<td><input type="checkbox" id="returnpo" <?php if ($returnpo == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Return PO</b>
							</td>
						</tr>
						<tr>
							<td><input type="checkbox" id="receiveprod" <?php if ($receiveprod == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Receive Product</b>
							</td>
							<td><input type="checkbox" id="issueprod" <?php if ($issueprod == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Issue Product</b>
							</td>
							<td><input type="checkbox" id="productionreq" <?php if ($productionreq == 1) {
																				echo 'checked';
																			} ?> />&nbsp;&nbsp;<b>Production Req</b>
							</td>
							<td><input type="checkbox" id="productionappr" <?php if ($productionappr == 1) {
																				echo 'checked';
																			} ?> />&nbsp;&nbsp;<b>Production Approval</b>
							</td>
						</tr>

						<tr>

							<td>
								<input type="checkbox" id="request" <?php if ($request == 1) {
																		echo 'checked';
																	} ?> />&nbsp;&nbsp;<b>Requisition</b>
							</td>
							<td><input type="checkbox" id="approval" <?php if ($approval == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Approve Requisition</b>
							</td>
							<td>
								<input type="checkbox" id="genloadingslip" <?php if ($genloadingslip == 1) {
																				echo 'checked';
																			} ?> />&nbsp;&nbsp;<b>Generate Loading Slip</b>
							</td>
							<td>
								<input type="checkbox" id="prnloadingslip" <?php if ($prnloadingslip == 1) {
																				echo 'checked';
																			} ?> />&nbsp;&nbsp;<b>Print Loading Slip</b>
							</td>

						</tr>

						<tr>
							<td>
								<input type="checkbox" id="genwaybill" <?php if ($genwaybill == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Generate Waybill</b>
							</td>
							<td>
								<input type="checkbox" id="prnwaybill" <?php if ($prnwaybill == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Print Waybill</b>
							</td>
							<td><input type="checkbox" id="prninv" <?php if ($prninv == 1) {
																		echo 'checked';
																	} ?> />&nbsp;&nbsp;<b>Print Invoice</b></td>
							<td>
								<input type="checkbox" id="delivery" <?php if ($delivery == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Confirm Delivery</b>
							</td>

						</tr>
						<tr>

							<td><input type="checkbox" id="payments" <?php if ($payments == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Payments</b>
							</td>
							<td><input type="checkbox" id="prnrcpt" <?php if ($prnrcpt == 1) {
																		echo 'checked';
																	} ?> />&nbsp;&nbsp;<b>Print Receipt</b></td>
							<td><input type="checkbox" id="reprint" <?php if ($reprint == 1) {
																		echo 'checked';
																	} ?> />&nbsp;&nbsp;<b>Re-Print</b>
							</td>
							<td><input type="checkbox" id="othincome" <?php if ($othincome == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>Other Income</b>
							</td>

						</tr>
						<tr>
							<td><input type="checkbox" id="expense" <?php if ($expense == 1) {
																		echo 'checked';
																	} ?> />&nbsp;&nbsp;<b>Expenditures</b>
							</td>
							<td><input type="checkbox" id="cca" <?php if ($cca == 1) {
																	echo 'checked';
																} ?> />&nbsp;&nbsp;<b>Bank Reconciliation</b>
							</td>
							<td><input type="checkbox" id="crrecon" <?php if ($crrecon == 1) {
																		echo 'checked';
																	} ?> />&nbsp;&nbsp;<b>Credit Reconciliation</b>
							</td>
							<td><input type="checkbox" id="directjournal" <?php if ($directjournal == 1) {
																				echo 'checked';
																			} ?> />&nbsp;&nbsp;<b>Journal Entry</b>
							</td>
						</tr>

						<tr>
							<td><input type="checkbox" id="glposting" <?php if ($glposting == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>GL Posting</b>
							</td>
							<td><input type="checkbox" id="somasters" <?php if ($somasters == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>SO Masters</b>
							</td>

							<td><input type="checkbox" id="armasters" <?php if ($armasters == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>AR Masters</b>
							</td>
							<td><input type="checkbox" id="pomasters" <?php if ($pomasters == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>PO Masters</b>
							</td>

						</tr>
						<tr>
							<td><input type="checkbox" id="glmasters" <?php if ($glmasters == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>GL Masters</b>
							</td>
							<td><input type="checkbox" id="apmasters" <?php if ($apmasters == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>AP Masters</b>
							</td>
							<td><input type="checkbox" id="ivmasters" <?php if ($ivmasters == 1) {
																			echo 'checked';
																		} ?> />&nbsp;&nbsp;<b>IV Masters</b>
							</td>
							<td><input type="checkbox" id="storagereadings" <?php if ($storagereadings == 1) {
																				echo 'checked';
																			} ?> />&nbsp;&nbsp;<b>Storage Readings</b>
							</td>

						</tr>
						<tr>
							<td><input type="checkbox" id="approvereadings" <?php if ($approvereadings == 1) {
																				echo 'checked';
																			} ?> />&nbsp;&nbsp;<b>Approve Readings</b>
							</td>
							<td colspan="3"><input type="checkbox" id="reports" <?php if ($reports == 1) {
																					echo 'checked';
																				} ?> />&nbsp;&nbsp;<b>Reports</b>
							</td>
						</tr>
					</table>
				</td>
			</tr>


			<tr>


				<td nowrap="nowrap" align="right" valign="top" colspan="3">
					<input type="checkbox" id="initializepassword" onClick="javasscript: var thepassword = document.getElementById('password');
							if(this.checked){thepassword.style='display:block;';}else {thepassword.style='display:none;';}" />&nbsp;&nbsp;&nbsp;<b>Inititialize Password :</b>
				</td>
				<td valign="top">
					<input name="password" id="password" value="" style="display:none;" />
				</td>

			</tr>
		</table>
		<br />
		<table>
			<tr>

				<td align="center" colspan="2">
					<label>
						<input type="button" name="deleteuser" id="submit-button" value="Delete" onclick="javascript: 
					if (confirm('Are you sure of this action to delete?')) 
					{
						if (confirm('Are you sure that you want to delete?')) 
						{

							var $form_userid = $('#sysuserid').val(); 
							
							getpage('usermanager.php?op=deleteuser&sysuserid='+$form_userid,'page');
						}
					}
						">
					</label>
				</td>

				<td align="center" colspan="2">
					<label>
						<input type="button" name="testsave" id="submit-button" value="Save" onclick="javascript: 
					if (confirm('Are you sure the entries are correct?')) 
					{
						
						var othincomecheckbox = document.getElementById('othincome');
						if (othincomecheckbox.checked){var $othincome = 1; }else {var $othincome = 0;}
						var storagereadingscheckbox = document.getElementById('storagereadings');
						if (storagereadingscheckbox.checked){var $storagereadings = 1; }else {var $storagereadings = 0;}
						var approvereadingscheckbox = document.getElementById('approvereadings');
						if (approvereadingscheckbox.checked){var $approvereadings = 1; }else {var $approvereadings = 0;}
						
						var expensecheckbox = document.getElementById('expense');
						if (expensecheckbox.checked){var $expense = 1; }else {var $expense = 0;}
						var glpostingcheckbox = document.getElementById('glposting');
						if (glpostingcheckbox.checked){var $glposting = 1; }else {var $glposting = 0;}
						var reportscheckbox = document.getElementById('reports');
						if (reportscheckbox.checked){var $reports = 1; }else {var $reports = 0;}
						var requestcheckbox = document.getElementById('request');
						if (requestcheckbox.checked){var $request = 1; }else {var $request = 0;}
						var productionreqcheckbox = document.getElementById('productionreq');
						if (productionreqcheckbox.checked){var $productionreq = 1; }else {var $productionreq = 0;}
						
						var createpocheckbox = document.getElementById('createpo');
						if (createpocheckbox.checked){var $createpo = 1; }else {var $createpo = 0;}
						var deliverycheckbox = document.getElementById('delivery');
						if (deliverycheckbox.checked){var $delivery = 1; }else {var $delivery = 0;}
						var approvepocheckbox = document.getElementById('approvepo');
						if (approvepocheckbox.checked){var $approvepo = 1; }else {var $approvepo = 0;}
						
						var reprintcheckbox = document.getElementById('reprint');
						if (reprintcheckbox.checked){var $reprint = 1; }else {var $reprint = 0;}
						
						
						var prnrcptcheckbox = document.getElementById('prnrcpt');
						if (prnrcptcheckbox.checked){var $prnrcpt = 1; }else {var $prnrcpt = 0;}
						var crreconcheckbox = document.getElementById('crrecon');
						if (crreconcheckbox.checked){var $crrecon = 1; }else {var $crrecon = 0;}
						var ccacheckbox = document.getElementById('cca');
						if (ccacheckbox.checked){var $cca = 1; }else {var $cca = 0;}
						var paymentscheckbox = document.getElementById('payments');
						if (paymentscheckbox.checked){var $payments = 1; }else {var $payments = 0;}
						var receivepocheckbox = document.getElementById('receivepo');
						if (receivepocheckbox.checked){var $receivepo = 1; }else {var $receivepo = 0;}
						var prninvcheckbox = document.getElementById('prninv');
						if (prninvcheckbox.checked){var $prninv = 1; }else {var $prninv = 0;}
						var approvalcheckbox = document.getElementById('approval');
						if (approvalcheckbox.checked){var $approval = 1; }else {var $approval = 0;}
						
						var productionapprcheckbox = document.getElementById('productionappr');
						if (productionapprcheckbox.checked){var $productionappr = 1; }else {var $productionappr = 0;}
						var retailcheckbox = document.getElementById('retail');
						if (retailcheckbox.checked){var $retail = 1; }else {var $retail = 0;}
						var creditscheckbox = document.getElementById('credits');
						if (creditscheckbox.checked){var $credits = 1; }else {var $credits = 0;}
						var ownusecheckbox = document.getElementById('ownuse');
						if (ownusecheckbox.checked){var $ownuse = 1; }else {var $ownuse = 0;}
						var ptncheckbox = document.getElementById('ptn');
						if (ptncheckbox.checked){var $ptn = 1; }else {var $ptn = 0;}
						
						var genloadingslipcheckbox = document.getElementById('genloadingslip');
						if (genloadingslipcheckbox.checked){var $genloadingslip = 1; }else {var $genloadingslip = 0;}
						
						var prnloadingslipcheckbox = document.getElementById('prnloadingslip');
						if (prnloadingslipcheckbox.checked){var $prnloadingslip = 1; }else {var $prnloadingslip = 0;}
						
						var genwaybillcheckbox = document.getElementById('genwaybill');
						if (genwaybillcheckbox.checked){var $genwaybill = 1; }else {var $genwaybill = 0;}
						
						var prnwaybillcheckbox = document.getElementById('prnwaybill');
						if (prnwaybillcheckbox.checked){var $prnwaybill = 1; }else {var $prnwaybill = 0;}
						
						var receiveprodcheckbox = document.getElementById('receiveprod');
						if (receiveprodcheckbox.checked){var $receiveprod = 1; }else {var $receiveprod = 0;}
						
						var issueprodcheckbox = document.getElementById('issueprod');
						if (issueprodcheckbox.checked){var $issueprod = 1; }else {var $issueprod = 0;}
						
						var returnpocheckbox = document.getElementById('returnpo');
						if (returnpocheckbox.checked){var $returnpo = 1; }else {var $returnpo = 0;}
						var ivmasterscheckbox = document.getElementById('ivmasters');
						if (ivmasterscheckbox.checked){var $ivmasters = 1; }else {var $ivmasters = 0;}
						var apmasterscheckbox = document.getElementById('apmasters');
						if (apmasterscheckbox.checked){var $apmasters = 1; }else {var $apmasters = 0;}
						
						var somasterscheckbox = document.getElementById('somasters');
						if (somasterscheckbox.checked){var $somasters = 1; }else {var $somasters = 0;}
						var armasterscheckbox = document.getElementById('armasters');
						if (armasterscheckbox.checked){var $armasters = 1; }else {var $armasters = 0;}
						
						var pomasterscheckbox = document.getElementById('pomasters');
						if (pomasterscheckbox.checked){var $pomasters = 1; }else {var $pomasters = 0;}
						var glmasterscheckbox = document.getElementById('glmasters');
						if (glmasterscheckbox.checked){var $glmasters = 1; }else {var $glmasters = 0;}
						
						var directjournalcheckbox = document.getElementById('directjournal');
						if (directjournalcheckbox.checked){var $directjournal = 1; }else {var $directjournal = 0;}
						
						
					
						$moreoptions ='&reprint='+$reprint  
							+'&prnrcpt='+$prnrcpt+'&crrecon='+$crrecon+'&cca='+$cca+'&payments='+$payments
							+'&receivepo='+$receivepo+'&prninv='+$prninv+'&approval='+$approval +'&approvereadings='+$approvereadings
							+'&genloadingslip='+$genloadingslip+'&prnloadingslip='+$prnloadingslip+'&genwaybill='+$genwaybill+'&prnwaybill='+$prnwaybill
							+'&receiveprod='+$receiveprod+'&issueprod='+$issueprod+'&returnpo='+$returnpo+'&ivmasters='+$ivmasters+'&apmasters='+$apmasters
							+'&somasters='+$somasters+'&armasters='+$armasters+'&pomasters='+$pomasters+'&glmasters='+$glmasters+'&directjournal='+$directjournal+'&storagereadings='+$storagereadings
							+'&productionappr='+$productionappr+'&retail='+$retail+'&credits='+$credits+'&ownuse='+$ownuse+'&ptn='+$ptn;
							
						var initializepassword = document.getElementById('initializepassword');
						if (initializepassword.checked){var $password = $('#password').val(); }else {$password = '';}
						
						var $form_userid = $('#sysuserid').val();  var $names = $('#names').val(); 
						var $form_roleid= $('#roleid').val(); 
						var $form_email = $('#email').val(); var $administra = $('#administra').val(); 

						getpage('usermanager.php?op=saving&sysuserid='+$form_userid+'&names='+$names+'&roleid='+$form_roleid
							+'&password='+$password+'&email='+$form_email +'&request='+$request+'&createpo='+$createpo
							+'&productionreq='+$productionreq+'&approvepo='+$approvepo+'&delivery='+$delivery
							+'&othincome='+$othincome+'&expense='+$expense+'&glposting='+$glposting+'&reports='+$reports+'&administra='+$administra+$moreoptions
							,'page');
					}
						">
					</label>
				</td>
			</tr>
		</table>



	</form>
</div>