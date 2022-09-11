<?php
ob_start();
include_once "session_track.php";
?>


<style>
	td {
		padding: 5px;
	}
</style>
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
				Customer Master
			</strong></h3>
		<?php
		if ($_SESSION['somasters'] == 1 || $_SESSION['armasters'] == 1) {
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$user = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$custno = !isset($_REQUEST['custno']) ? '' : $dbobject->test_input($_REQUEST['custno']);
			$company = !isset($_REQUEST['company']) ? '' : $dbobject->test_input($_REQUEST['company']);
			$phone1 = !isset($_REQUEST['phone1']) ? '' : $dbobject->test_input($_REQUEST['phone1']);
			$address1 = !isset($_REQUEST['address1']) ? '' : $dbobject->test_input($_REQUEST['address1']);
			$address2 = !isset($_REQUEST['address2']) ? '' : $dbobject->test_input($_REQUEST['address2']);
			$city = !isset($_REQUEST['city']) ? '' : $dbobject->test_input($_REQUEST['city']);
			$contact = !isset($_REQUEST['contact']) ? '' : $dbobject->test_input($_REQUEST['contact']);
			$email = !isset($_REQUEST['email']) ? '' : $dbobject->test_input($_REQUEST['email']);
			$crlimit = !isset($_REQUEST['crlimit']) ? 0 : $dbobject->test_input($_REQUEST['crlimit']);
			$retarget = !isset($_REQUEST['retarget']) ? 0 : $dbobject->test_input($_REQUEST['retarget']);
			$editable = !isset($_REQUEST['editable']) ? 0 : $dbobject->test_input($_REQUEST['editable']);
			$alpha3code = !isset($_REQUEST['alpha3code']) ? "" : $dbobject->test_input($_REQUEST['alpha3code']);

			$selectclient = !isset($_REQUEST['selectclient']) ? '' : $dbobject->test_input($_REQUEST['selectclient']);
			$bu = !isset($_REQUEST['bu']) ? '' : $dbobject->test_input($_REQUEST['bu']);
			$category = !isset($_REQUEST['category']) ? '' : $dbobject->test_input($_REQUEST['category']);

			$roleid = !isset($_REQUEST['roleid']) ? 0 : $_REQUEST['roleid'];

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "" : $dbobject->test_input($_REQUEST['searchin']);

			$sql_client = "select distinct * FROM arcust WHERE 1=1 order by company";
			$result_client = mysqli_query($_SESSION['db_connect'], $sql_client);
			$count_client = mysqli_num_rows($result_client);


			$sql_catg = "select catcd,catdesc FROM catg where cattype='C' ORDER BY catcd";
			$result_catg = mysqli_query($_SESSION['db_connect'], $sql_catg);
			$count_catg = mysqli_num_rows($result_catg);

			$sql_countries = "select * FROM countries ORDER BY country ";
			$result_countries = mysqli_query($_SESSION['db_connect'], $sql_countries);
			$count_countries = mysqli_num_rows($result_countries);

			$sql_BizUnit = "select catcd,catdesc FROM catg where cattype='B' ORDER BY catcd";
			$result_BizUnit = mysqli_query($_SESSION['db_connect'], $sql_BizUnit);
			$count_BizUnit = mysqli_num_rows($result_BizUnit);

			if ($custno == '') {
				$next_refno = 1;
				$check_refno = 1;

				$transdate = date("d/m/Y H:i:s");
				$refnoday = substr($transdate, 0, 2);
				$refnomonth = substr($transdate, 3, 2);
				$refnoyear = substr($transdate, 6, 4);

				$refno =  "C" . $refnoday . $refnomonth . $refnoyear . $next_refno;
				$custno = $refno;

				while ($check_refno == 1) {
					//check if the reference has been used before
					$sql_checkcustno = "select * from arcust where trim(custno) = '$custno'";

					$result_checkcustno = mysqli_query($_SESSION['db_connect'], $sql_checkcustno);
					$count_checkcustno = mysqli_num_rows($result_checkcustno);
					if ($count_checkcustno > 0) {
						$next_refno++;
						$refno =  "C" . $refnoday . $refnomonth . $refnoyear . $next_refno;
						$custno = $refno;
					} else {
						$check_refno = 0;
					}
				}
			}

			if ($op == 'getselectclient') {
				$filter = "";

				$sql_Q = "SELECT * FROM arcust where  ";
				$custno = '';
				if (trim($selectclient) <> '') {
					//echo $selectitem;
					$itemdetails = explode("*", $selectclient);
					$custno = $itemdetails[0];
				}

				$filter = "  upper(trim(custno)) = upper('$custno')  ";



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
					$company   = $row['company'];
					$phone1 = $row['phone1'];
					$email = $row['email'];
					$address1  = $row['address1'];
					$address2  = $row['address2'];
					$city  = $row['city'];
					$contact  = $row['contact'];
					$alpha3code  = $row['alpha3code'];
					$bu  = $row['bu'];
					$editable  = $row['editable'];
					$category  = trim($row['category']);
					$selectclient = trim($row['custno']) . "*" . trim($row['company']);
					$retarget  = trim($row['retarget']);
					$crlimit  = trim($row['crlimit']);
				} else {
		?>
					<script>
						$('#item_error').html("<strong>Customer does not exist</strong>");
					</script>
				<?php
				}
			}




			if ($op == 'searchkeyword') {

				//echo "keyword ".$keyword . "<br/>";
				//echo "string length ".strlen($keyword) . "<br/>";
				$filter = "";
				$filter = " AND trim(custno) = '$keyword'   ";


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
					$company   = $row['company'];
					$phone1 = $row['phone1'];
					$email = $row['email'];
					$address1  = $row['address1'];
					$address2  = $row['address2'];
					$city  = $row['city'];
					$alpha3code  = $row['alpha3code'];
					$contact  = $row['contact'];
					$bu  = $row['bu'];
					$editable  = $row['editable'];
					$category  = trim($row['category']);
					$retarget  = trim($row['retarget']);
					$crlimit  = trim($row['crlimit']);

					$selectclient = trim($row['custno']) . "*" . trim($row['company']);
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Customer does not exist</strong>");
					</script>
				<?php
				}
			}

			if ($op == 'deleteCustomer') {
				$goahead = 1;

				if (trim($custno) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Customer ID</strong>");
					</script>
					<?php
				} else {

					$sql_checkpurchaseorder =  "select * from purchaseorder where trim(custno) = '$custno'";
					$result_checkpurchaseorder = mysqli_query($_SESSION['db_connect'], $sql_checkpurchaseorder);
					$count_checkpurchaseorder = mysqli_num_rows($result_checkpurchaseorder);

					if ($count_checkpurchaseorder >= 1) {
						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>This Customer cannot be deleted because it has been used in transactions.</strong>");
						</script>
					<?php }
				}

				if ($goahead == 1) {
					$sql_deleteCustomer =  "delete from arcust where trim(custno) = '$custno'";
					$result_deleteCustomer = mysqli_query($_SESSION['db_connect'], $sql_deleteCustomer);


					$dbobject->apptrail($user, 'Customer', $company, date('d/m/Y H:i:s A'), 'Deleted');
					?>
					<script>
						$('#item_error').html("<strong>Customer Record Deleted</strong>");
					</script>
				<?php

				}
			}



			if ($op == 'saving') {

				$goahead = 1;

				if (trim($custno) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Customer ID</strong>");
					</script>
				<?php }


				if (trim($_REQUEST['company']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Customer Name</strong>");
					</script>
				<?php }

				if (trim($_REQUEST['alpha3code']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify Customer Country</strong>");
					</script>
				<?php }


				if (trim($_REQUEST['contact']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Contact Person</strong>");
					</script>
				<?php }

				if (trim($_REQUEST['address1']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the Address</strong>");
					</script>
				<?php
				}
				if (trim($_REQUEST['city']) == '') {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Please specify the City</strong>");
					</script>
				<?php
				}


				if (empty($email)) {
					$goahead = $goahead * 0;
				?>
					<script>
						$('#item_error').html("<strong>Email is required</strong>");
					</script>
					<?php
				} else {

					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

						$goahead = $goahead * 0;
					?>
						<script>
							$('#item_error').html("<strong>Invalid email format.</strong>");
						</script>
					<?php
					}
				}





				//echo $goahead;
				if ($goahead == 1) {

					$sql_checkCustomer = "SELECT * FROM arcust where upper(trim(custno)) = upper('$custno') ";
					$result_checkCustomer = mysqli_query($_SESSION['db_connect'], $sql_checkCustomer);
					$count_checkCustomer = mysqli_num_rows($result_checkCustomer);

					if ($count_checkCustomer > 0) {
						$sql_saveCustomer = " update arcust set 
								 company = '$company', 
								 contact  = '$contact', 
								 phone1  = '$phone1', 
								 address1  = '$address1', 
								 email  = '$email',  
								 address2 = '$address2', 
								 city  = '$city', 
								  bu  = '$bu',  
								  alpha3code  = '$alpha3code', 
								 category = '$category', 
								 editable  = $editable, 
								 crlimit  = $crlimit, 
								 retarget  = $retarget
								where trim(custno) = '$custno'";

						$dbobject->apptrail($user, 'Customer', $company, date('d/m/Y H:i:s A'), 'Modified');
					} else {
						$sql_saveCustomer = " insert into arcust (  
								alpha3code,custno, company, contact, phone1, 
								email, address1, address2, city,  bu,category,editable, crlimit, retarget ) 
								 values ('$alpha3code','$custno', '$company' , '$contact', '$phone1',  '$email', 
								 '$address1' , '$address2', '$city', '$bu', '$category', $editable, $crlimit, $retarget) ";

						$dbobject->apptrail($user, 'Customer', $company, date('d/m/Y H:i:s A'), 'Created');
					}
					$result_saveCustomer = mysqli_query($_SESSION['db_connect'], $sql_saveCustomer);
					//echo $sql_saveCustomer;




					?>
					<script>
						$('#item_error').html("<strong>Customer Record Saved</strong>");
					</script>
			<?php

				}
			}
			//****			


			?>

			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="customer" />
			<input type="hidden" name="get_file" id="get_file" value="customers" />
			<table border="0" style="padding:0px;">
				<tr>
					<td colspan="2" style="color:red;" id="item_error" align="left"></td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="input-group">
							<b>Search by: <i>Name or Code or Phone Number</i> </b>&nbsp;
							<input type="text" size="35px" id="search" placeholder="Search for Customer" />
							<input name="keyword" type="hidden" class="table_text1" id="keyword" value="<?php echo $keyword; ?>" />

						</div>
						<!-- Suggestions will be displayed in below div. -->

						<div id="display"></div>
					</td>

				</tr>


			</table>
			<br />
			<div style="overflow-x:auto;">
				<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
					<tr>
						<td nowrap="nowrap">
							<b>Customer ID : </b>
						</td>
						<td>
							<input type="text" name="custno" id="custno" value="<?php echo $custno; ?>" <?php if ($custno != '') {
																											echo "style='color:lightgray'";
																											echo 'readonly';
																										} ?> placeholder="Enter Customer ID" />
						</td>

						<td>
							<div title="Tick if Customer Name is editable at Requisition, ideal to handle one off Customers!"><b>Editable&nbsp;&nbsp;&nbsp;<input type="checkbox" id="editable" name="editable" <?php if ($editable == 1) {
																																																					echo 'checked';
																																																				} ?> /></div>

						</td>
						<td>

							<input type="button" name="refreshbutton" title="Click to prepare form for a New Customer creation" id="submit-button" value="Refresh" onclick="javascript:  getpage('customers.php?','page');" />

						</td>
					</tr>
					<tr>

						<td>
							<b>Customer Name : </b>
						</td>
						<td colspan="3">
							<input type="text" size="50%" name="company" id="company" value="<?php echo $company; ?>" placeholder="Enter Customer Name" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Country : </b>
						</td>
						<td colspan="3">
							<?php
							$k = 0;
							?>

							<select name="alpha3code" id="alpha3code">
								<option value=""></option>
								<?php

								while ($k < $count_countries) {
									$row = mysqli_fetch_array($result_countries);
									//$theselectedcatg = trim($row['catcd'])."*  ". trim($row['catdesc']) ;
								?>
									<option value="<?php echo trim($row['alpha3code']); ?>" <?php echo ($alpha3code == trim($row['alpha3code']) ? "selected" : ""); ?>>
										<?php echo trim($row['country']); ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>
						</td>

					</tr>
					<tr>

						<td colspan="3">
							<b>Category : </b>
							<?php
							$k = 0;
							?>
							<br />
							<select name="category" id="category">
								<option value=""></option>
								<?php

								while ($k < $count_catg) {
									$row = mysqli_fetch_array($result_catg);
									//$theselectedcatg = trim($row['catcd'])."*  ". trim($row['catdesc']) ;
								?>
									<option value="<?php echo trim($row['catcd']); ?>" <?php echo ($category == trim($row['catcd']) ? "selected" : ""); ?>>
										<?php echo trim($row['catdesc']); ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>
						</td>
						<td>
							<b>Business Unit : </b>

							<?php
							$k = 0;
							?>
							<br />
							<select name="bu" id="bu">
								<option value=""></option>
								<?php

								while ($k < $count_BizUnit) {
									$row = mysqli_fetch_array($result_BizUnit);
									//$theselectedbizunit = trim($row['catcd'])."*  ". trim($row['catdesc']) ;
								?>
									<option value="<?php echo trim($row['catcd']); ?>" <?php echo ($bu == trim($row['catcd']) ? "selected" : ""); ?>>
										<?php echo trim($row['catdesc']); ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>
						</td>
					</tr>

					<tr>
						<td>
							<b>Contact Person : </b>
						</td>
						<td>
							<input type="text" name="contact" id="contact" value="<?php echo $contact; ?>" placeholder="Enter Contact Person" />
						</td>
						<td>
							<b>Email : </b>
						</td>
						<td>
							<input type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter Customer Email" />
						</td>
					</tr>
					<tr>
						<td>
							<b>Address1 : </b>
						</td>
						<td>
							<input type="text" name="address1" id="address1" value="<?php echo $address1; ?>" placeholder="Enter Address Line 1" />
						</td>
						<td>
							<b>Address2 : </b>
						</td>
						<td>
							<input type="text" name="address2" id="address2" value="<?php echo $address2; ?>" placeholder="Enter Address Line 2" />
						</td>
					</tr>
					<tr>
						<td>
							<b>City : </b>
						</td>
						<td>
							<input type="text" name="city" id="city" value="<?php echo $city; ?>" placeholder="Enter City" />
						</td>
						<td>
							<b>Phone : </b>
						</td>
						<td>
							<input type="tel" name="phone1" id="phone1" value="<?php echo $phone1; ?>" placeholder="Enter Phone Number" pattern="[0-9]{4,12}" title="Only Digits" />
						</td>
					</tr>
					<tr>
						<td>
							<div title="Enter Credit Limit if applicable!"><b>Credit Limit : </b></div>
						</td>
						<td>

							<input type="number" name="crlimit" id="crlimit" value="<?php echo $crlimit; ?>" />

						</td>
						<td nowrap="nowrap">

							<div title="Enter Sales Target if applicable!"><b>Sales Target : </b></div>
						</td>
						<td>
							<input type="number" name="retarget" id="retarget" value="<?php echo $retarget; ?>" />

						</td>
					</tr>
				</table>

				<table>

					<tr>
						<td>

						</td>
						<td nowrap="nowrap">

							<input title="Customer Specific Discount" type="button" name="spedisc" id="submit-button" value="Discount" onclick="javascript: specialdisc();">

						</td>


						<td>

							<input type="button" name="deletebutton" id="submit-button" value="Delete" onclick="deletecustomer();" />

						</td>

						<td>

							<input type="button" name="savebutton" id="submit-button" value="Save" onclick="savecustomer();" />

						</td>

						<td nowrap="nowrap">

							<?php $calledby = 'customers';
							$reportid = 31;
							include("specificreportlink.php");  ?>
						</td>


					</tr>

				</table>
			</div>

		<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('s_and_d.php?','page');" />
	<br />
</div>

<script>
	function specialdisc() {
		var $form_custno = $('#custno').val();
		var $form_company = $('#company').val();
		var $goahead = 1;

		if ($form_custno.trim() == '' || $form_company.trim() == '') {
			$goahead = $goahead * 0;
			alert("Please Enter Customer ID ");
		} else {
			getpage('customerdiscount.php?custno=' + $form_custno + '&company=' + $form_company, 'page');
		}
	}

	function savecustomer() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_custno = $('#custno').val();
			$form_address1 = $('#address1').val();
			var $form_company = $('#company').val();
			var $form_address2 = $('#address2').val();
			var $form_email = $('#email').val();
			var $form_city = $('#city').val();
			var $form_contact = $('#contact').val();
			var $form_phone1 = $('#phone1').val();
			var $form_alpha3code = $('#alpha3code').val();

			var $form_category = $('#category').val();
			var $form_bu = $('#bu').val();
			var $form_crlimit = $('#crlimit').val();
			var $form_retarget = $('#retarget').val();

			if (document.getElementById("editable").checked) {
				$form_editable = 1;
			} else {
				$form_editable = 0;
			}

			var $goahead = 1;

			if ($form_custno.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Customer ID ");
			}

			if ($form_alpha3code.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Select a Country ");
			}
			if ($form_company.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Customer Name ");
			}

			if ($form_address1.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please specify the Address");
			}

			if ($form_phone1.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter a Phone Number");
			} else {
				if (isNaN($form_phone1)) {
					$goahead = $goahead * 0;
					alert("Please Enter a Valid Phone Number");

				}

			}
			if ($form_contact.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter a Contact Person");
			}

			if ($form_city.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter City");
			}

			if ($form_email.trim() == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Email");
			} else {
				if (!IsValidEmail($form_email)) {
					$goahead = $goahead * 0;
					alert("Invalid email address!");
				}
			}

			if ($goahead == 1) {
				thegetpage = 'customers.php?op=saving&custno=' + $form_custno +
					'&company=' + $form_company +
					'&contact=' + $form_contact + '&phone1=' + $form_phone1 + '&address1=' + $form_address1 + '&address2=' + $form_address2 +
					'&crlimit=' + $form_crlimit + '&bu=' + $form_bu + '&retarget=' + $form_retarget + '&category=' + $form_category +
					'&city=' + $form_city + '&email=' + $form_email + '&editable=' + $form_editable + '&alpha3code=' + $form_alpha3code;
				//alert(thegetpage);	
				getpage(thegetpage, 'page');
			}

		}
	}


	function deletecustomer() {
		if (confirm('Are you sure the entries are correct?')) {

			var $form_custno = $('#custno').val();
			$form_address1 = $('#address1').val();
			var $form_company = $('#company').val();
			var $form_address2 = $('#address2').val();
			var $form_email = $('#email').val();
			var $form_city = $('#city').val();
			var $form_contact = $('#contact').val();
			var $form_phone1 = $('#phone1').val();



			var $goahead = 1;

			if ($form_custno == '') {
				$goahead = $goahead * 0;
				alert("Please Enter Customer ID ");
			}


			if ($goahead == 1) {

				getpage('customers.php?op=deleteCustomer&custno=' + $form_custno +
					'&company=' + $form_company +
					'&contact=' + $form_contact + '&phone1=' + $form_phone1 + '&address1=' + $form_address1 + '&address2=' + $form_address2 +
					'&city=' + $form_city + '&email=' + $form_email, 'page');
			}

		}
	}


	function IsValidEmail(email) {
		var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		return expr.test(email);
	}
</script>