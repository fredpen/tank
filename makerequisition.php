<?php
ob_start();
include_once "session_track.php";
?>

<script type="text/javascript" src="js/dynamic_search.js"></script>
<div align="center" id="data-form">
	<input type="button" name="closebutton" id="submit-button" title="Close" value="Close" onclick="javascript:  $('#data-form').hide();">
	<?php
	require_once("lib/mfbconnect.php");
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/dynamic_search_script.js"></script>
	<form action="" method="get" id="form1">
		<h3><strong>
				Requisition for Release of Product
				<?php switch ($_SESSION['trantype']) {
					case 1:
						echo ' - Cash Transaction';
						break;
					case  2:
						echo ' - Credit Transaction';
						break;
					case  3:
						echo ' - Own Use Transaction';
						break;
					case  4:
						echo ' - Product Transfer Transaction';
				}
				?>
			</strong></h3>
		<?php
		if ($_SESSION['request'] == 1) {
			$theitems = array();
			$theitemsDescription = array();
			$theitemsQty = array();
			$thebaseprice = array();
			$thevolumefactor = array();
			$thediscount = array();
			$thediscount_type = array();
			$the_flat = array();
			$the_slab = array();
			$the_percent = array();
			$thediscountedunitprice = array();
			$thevat = array();
			$thevatduprice = array();
			$theprice = array();
			$thedisctax = array();
			$thecost = array();
			$thevolume = array();

			$client_var = array();
			$lmf_var = 	array();
			$slabdef_var = array();
			$slabdisc_var = array();
			$products_var = array();
			$custpric_var = array();

			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";

			$periodyear = $_SESSION['periodyear'];
			$periodmonth = $_SESSION['periodmonth'];
			$reqst_by = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op']) ? '' : $_REQUEST['op'];
			$selectclient = !isset($_REQUEST['selectclient']) ? '' : $dbobject->test_input($_REQUEST['selectclient']);
			$selectloccd = !isset($_REQUEST['selectloccd']) ? '' : $dbobject->test_input($_REQUEST['selectloccd']);
			$selectrcvloc = !isset($_REQUEST['selectrcvloc']) ? '' : $dbobject->test_input($_REQUEST['selectrcvloc']);
			$selectproduct = !isset($_REQUEST['selectproduct']) ? '' : $dbobject->test_input($_REQUEST['selectproduct']);
			$theselectedpromo = !isset($_REQUEST['theselectedpromo']) ? '' : $dbobject->test_input($_REQUEST['theselectedpromo']);
			$selectpromo = !isset($_REQUEST['selectpromo']) ? '' : $dbobject->test_input($_REQUEST['selectpromo']);
			$promo = !isset($_REQUEST['promo']) ? '' : $dbobject->test_input($_REQUEST['promo']);
			$disctype = !isset($_REQUEST['disctype']) ? '' : $dbobject->test_input($_REQUEST['disctype']);
			$trantype = !isset($_SESSION['trantype']) ? 0 : $_SESSION['trantype'];
			$querytable = !isset($_REQUEST['querytable']) ? 1 : $dbobject->test_input($_REQUEST['querytable']);

			$keyword = !isset($_REQUEST['keyword']) ? "" : $dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin']) ? "custno" : $dbobject->test_input($_REQUEST['searchin']);

			$custno = !isset($_REQUEST['custno']) ? '' : $_REQUEST['custno'];
			$company = !isset($_REQUEST['company']) ? '' : $_REQUEST['company'];
			$crlimit = !isset($_REQUEST['crlimit']) ? 0 : $_REQUEST['crlimit'];
			$totcrtrans = !isset($_REQUEST['totcrtrans']) ? 0 : $_REQUEST['totcrtrans'];
			$count_custpric = !isset($_REQUEST['count_custpric']) ? 0 : $_REQUEST['count_custpric'];

			$apprem = !isset($_REQUEST['apprem']) ? "" : $_REQUEST['apprem'];
			$loccd = !isset($_REQUEST['loccd']) ? "" : $_REQUEST['loccd'];
			$loc_name = !isset($_REQUEST['loc_name']) ? "" : $_REQUEST['loc_name'];
			$xchar2 = !isset($_REQUEST['xchar2']) ? "" : $_REQUEST['xchar2'];

			$rcvloc = !isset($_REQUEST['rcvloc']) ? "" : $_REQUEST['rcvloc'];
			$rcv_locnm = !isset($_REQUEST['rcv_locnm']) ? "" : $_REQUEST['rcv_locnm'];
			//$py= !isset($_REQUEST['py'])?"":$_REQUEST['py'];
			//$mv= !isset($_REQUEST['mv'])?"":$_REQUEST['mv'];
			$bu = !isset($_REQUEST['bu']) ? "" : $_REQUEST['bu'];
			$reqrem = !isset($_REQUEST['reqrem']) ? "" : $_REQUEST['reqrem'];

			$custbal = !isset($_REQUEST['custbal']) ? 0 : $_REQUEST['custbal'];
			$approve_ok = !isset($_REQUEST['approve_ok']) ? 0 : $_REQUEST['approve_ok'];
			$refuse = !isset($_REQUEST['refuse']) ? 0 : $_REQUEST['refuse'];
			$loc_date = !isset($_REQUEST['loc_date']) ? "" : $_REQUEST['loc_date'];
			$appr_date = !isset($_REQUEST['appr_date']) ? "" : $_REQUEST['appr_date'];
			$salespsn = !isset($_REQUEST['salespsn']) ? "" : $_REQUEST['salespsn'];
			$item_count = !isset($_REQUEST['item_count']) ? 0 : $_REQUEST['item_count'];
			$count_getpmtdetails = 0;

			$sql_for_report = "select * from reptable where reportid = 8";
			$result_for_report = mysqli_query($_SESSION['db_connect'], $sql_for_report);
			$count_for_report = mysqli_num_rows($result_for_report);

			if ($count_for_report > 0) {
				$rowreport = mysqli_fetch_array($result_for_report);
			}

			$sql_client = "select distinct * FROM arcust WHERE 1=1 order by trim(company)";
			switch ($_SESSION['trantype']) {

				case  3:
					$sql_client = "select distinct * FROM arcust WHERE trim(custno) = '99000999' order by trim(company)";
					break;
				case  4:
					$sql_client = "select distinct * FROM arcust WHERE trim(custno) = '99900999' order by trim(company)";
			}



			$result_client = mysqli_query($_SESSION['db_connect'], $sql_client);
			$count_client = mysqli_num_rows($result_client);

			$k = 0;
			while ($k < $count_client) {
				$row = mysqli_fetch_array($result_client);
				$client_var[$k]['custno'] = $row['custno'];
				$client_var[$k]['company'] = $row['company'];

				$k++;
			}


			$sql_loccd = "select distinct * FROM lmf WHERE 1=1 order by trim(loc_name)";
			$result_loccd = mysqli_query($_SESSION['db_connect'], $sql_loccd);
			$count_loccd = mysqli_num_rows($result_loccd);

			$k = 0;
			while ($k < $count_loccd) {
				$row = mysqli_fetch_array($result_loccd);
				$lmf_var[$k]['loccd'] = $row['loccd'];
				$lmf_var[$k]['loc_name'] = $row['loc_name'];

				$k++;
			}


			$sql_slabdef = "select distinct * FROM slabdef WHERE 1=1 order by trim(slabdesc)";
			$result_slabdef = mysqli_query($_SESSION['db_connect'], $sql_slabdef);
			$count_slabdef = mysqli_num_rows($result_slabdef);

			$k = 0;
			while ($k < $count_slabdef) {
				$row = mysqli_fetch_array($result_slabdef);
				$slabdef_var[$k]['slabid'] = $row['slabid'];
				$slabdef_var[$k]['slabdesc'] = $row['slabdesc'];

				$k++;
			}


			//obtain slab discount if any
			$sql_slabdisc = "select distinct * FROM slabdisc WHERE 1=1 ";
			$result_slabdisc = mysqli_query($_SESSION['db_connect'], $sql_slabdisc);
			$count_slabdisc = mysqli_num_rows($result_slabdisc);


			$k = 0;
			while ($k < $count_slabdisc) {
				$row = mysqli_fetch_array($result_slabdisc);
				$slabdisc_var[$k]['slabid'] = $row['slabid'];
				$slabdisc_var[$k]['lbound'] = $row['lbound'];
				$slabdisc_var[$k]['ubound'] = $row['ubound'];
				$slabdisc_var[$k]['disc'] = $row['disc'];
				$slabdisc_var[$k]['targetdisc'] = $row['targetdisc'];

				$k++;
			}

			//create hidden inputs to hold vital discount details
			for ($k = 0; $k < $count_slabdisc; $k++) {

		?>
				<input type="hidden" name="<?php echo 'slabdisc' . $k . $slabdisc_var[$k]['slabid']; ?>" id="<?php echo 'slabdisc' . $k . $slabdisc_var[$k]['slabid']; ?>" value="<?php echo $slabdisc_var[$k]['slabid']; ?>" />

				<input type="hidden" name="<?php echo 'slabdisclbound' . $k . $slabdisc_var[$k]['slabid']; ?>" id="<?php echo 'slabdisclbound' . $k . $slabdisc_var[$k]['slabid']; ?>" value="<?php echo $slabdisc_var[$k]['lbound']; ?>" />

				<input type="hidden" name="<?php echo 'slabdiscubound' . $k . $slabdisc_var[$k]['slabid']; ?>" id="<?php echo 'slabdiscubound' . $k . $slabdisc_var[$k]['slabid']; ?>" value="<?php echo $slabdisc_var[$k]['ubound']; ?>" />

				<input type="hidden" name="<?php echo 'slabdiscdisc' . $k . $slabdisc_var[$k]['slabid']; ?>" id="<?php echo 'slabdiscdisc' . $k . $slabdisc_var[$k]['slabid']; ?>" value="<?php echo $slabdisc_var[$k]['disc']; ?>" />

				<input type="hidden" name="<?php echo 'slabdisctargetdisc' . $k . $slabdisc_var[$k]['slabid']; ?>" id="<?php echo 'slabdisctargetdisc' . $k . $slabdisc_var[$k]['slabid']; ?>" value="<?php echo $slabdisc_var[$k]['targetdisc']; ?>" />
			<?php
			}

			$sql_products = "select distinct * FROM icitem WHERE 1=1 order by trim(itemdesc)";
			$result_products = mysqli_query($_SESSION['db_connect'], $sql_products);
			$count_products = mysqli_num_rows($result_products);


			$k = 0;
			while ($k < $count_products) {
				$row = mysqli_fetch_array($result_products);
				$products_var[$k]['item'] = $row['item'];
				$products_var[$k]['itemdesc'] = $row['itemdesc'];
				$products_var[$k]['vat'] = $row['vat'];
				$products_var[$k]['volfactor'] = $row['volfactor'];

				$products_var[$k]['prvalidity'] = $row['prvalidity'];
				$products_var[$k]['otprice'] = $row['otprice'];
				$products_var[$k]['scprice'] = $row['scprice'];
				$products_var[$k]['retflat'] = $row['retflat'];
				$products_var[$k]['retslab'] = $row['retslab'];
				$products_var[$k]['recent'] = $row['recent'];
				$products_var[$k]['retail'] = $row['retail'];

				$products_var[$k]['owprvalid'] = $row['owprvalid'];
				$products_var[$k]['owotprice'] = $row['owotprice'];
				$products_var[$k]['owscprice'] = $row['owscprice'];
				$products_var[$k]['owflat'] = $row['owflat'];
				$products_var[$k]['owslab'] = $row['owslab'];
				$products_var[$k]['owcent'] = $row['owcent'];
				$products_var[$k]['ow'] = $row['ow'];

				$products_var[$k]['prprvalid'] = $row['prprvalid'];
				$products_var[$k]['protprice'] = $row['protprice'];
				$products_var[$k]['prscprice'] = $row['prscprice'];
				$products_var[$k]['prflat'] = $row['prflat'];
				$products_var[$k]['prslab'] = $row['prslab'];
				$products_var[$k]['prcent'] = $row['prcent'];
				$products_var[$k]['pr'] = $row['pr'];

				$k++;
			}
			//create hidden inputs to hold vital product details

			for ($k = 0; $k < $count_products; $k++) {

			?>
				<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_vat'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_vat'; ?>" value="<?php echo $products_var[$k]['vat']; ?> " />

				<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_volfactor'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_volfactor'; ?>" value="<?php echo $products_var[$k]['volfactor']; ?> " />




				<?php
				switch ($_SESSION['trantype']) {
					case 1:
						//cash transaction


						$priceisvalid = 'No';
						if (date('d/m/Y', strtotime($products_var[$k]['prvalidity'])) < date('d/m/Y')) {
							$priceisvalid = 'Yes';
						}
				?>
						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_pricevalidornot'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_pricevalidornot'; ?>" value="<?php echo $priceisvalid; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_otprice'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_otprice'; ?>" value="<?php echo $products_var[$k]['otprice']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_scprice'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_scprice'; ?>" value="<?php echo $products_var[$k]['scprice']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_flat'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_flat'; ?>" value="<?php echo $products_var[$k]['retflat']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_slab'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_slab'; ?>" value="<?php echo $products_var[$k]['retslab']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_cent'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_cent'; ?>" value="<?php echo $products_var[$k]['recent']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_disc_type'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_disc_type'; ?>" value="<?php echo $products_var[$k]['retail']; ?>" />


					<?php


						break;


					case 3:
						//Own Use


						$priceisvalid = 'No';
						if (date('d/m/Y', strtotime($products_var[$k]['owprvalid'])) < date('d/m/Y')) {
							$priceisvalid = 'Yes';
						}
					?>
						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_pricevalidornot'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_pricevalidornot'; ?>" value="<?php echo $priceisvalid; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_otprice'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_otprice'; ?>" value="<?php echo $products_var[$k]['owotprice']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_scprice'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_scprice'; ?>" value="<?php echo $products_var[$k]['owscprice']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_flat'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_flat'; ?>" value="<?php echo $products_var[$k]['owflat']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_slab'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_slab'; ?>" value="<?php echo $products_var[$k]['owslab']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_cent'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_cent'; ?>" value="<?php echo $products_var[$k]['owcent']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_disc_type'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_disc_type'; ?>" value="<?php echo $products_var[$k]['ow']; ?>" />

					<?php


						break;


					default:
						//Do not permit transaction

						$priceisvalid = 'No';
						if (date('d/m/Y', strtotime($products_var[$k]['prprvalid'])) < date('d/m/Y')) {
							$priceisvalid = 'Yes';
						}
					?>
						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_pricevalidornot'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_pricevalidornot'; ?>" value="<?php echo $priceisvalid; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_otprice'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_otprice'; ?>" value="<?php echo $products_var[$k]['protprice']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_scprice'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_scprice'; ?>" value="<?php echo $products_var[$k]['prscprice']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_flat'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_flat'; ?>" value="<?php echo $products_var[$k]['prflat']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_slab'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_slab'; ?>" value="<?php echo $products_var[$k]['prslab']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_cent'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_cent'; ?>" value="<?php echo $products_var[$k]['prcent']; ?>" />

						<input type="hidden" name="<?php echo trim($products_var[$k]['item']) . '_the_disc_type'; ?>" id="<?php echo trim($products_var[$k]['item']) . '_the_disc_type'; ?>" value="<?php echo $products_var[$k]['pr']; ?> " />

					<?php



				}
			}


			switch ($_SESSION['trantype']) {
				case 1:
					//cash transaction
					$mv = 'SC';
					$mvdescription = 'Self Collection';
					$py = 'CA';
					$pydescription = 'Cash Transaction';
					$bridging = 'No - Bridging Not Applicable';
					$mbridging = 'L';
					break;
				case 2:
					//credit
					$mv = 'SC';
					$mvdescription = 'Self Collection';
					$py = 'CR';
					$pydescription = 'Credit Transaction';
					$bridging = 'No - Bridging Not Applicable';
					$mbridging = 'L';
					break;

				case 3:
					//Own Use
					$mv = 'SC';
					$mvdescription = 'Self Collection';
					$py = 'OU';
					$pydescription = 'Own Use Transaction';
					$bridging = 'No - Bridging Not Applicable';
					$mbridging = 'L';
					break;

				case 4:
					//Bridging
					$mv = 'ST';
					$mvdescription = 'Stock Transfer';
					$py = 'BR';
					$pydescription = 'Bridging Transaction';
					$bridging = 'Yes - Bridging Applicable';
					$mbridging = 'B';
					break;

				default:
					//Do not permit transaction
					$mv = '';
					$mvdescription = '';
					$py = '';
					$pydescription = '';
					$bridging = '';
					$mbridging = '';
			}

			$obtain_customer_open_payments = 0;
			if ($op == 'searchkeyword') {
				if (trim($keyword) != '') {

					$sql_request = "select *  from arcust where custno like '$keyword'";
					$result_request = mysqli_query($_SESSION['db_connect'], $sql_request);
					$count_request = mysqli_num_rows($result_request);
					//echo "<br/>".$sql_request."<br/>";
					if ($count_request >= 1) {
						$row = mysqli_fetch_array($result_request);
						$custno    = $row['custno'];
						$company   = $row['company'];
						$custbal = $row['custbal'];
						$crlimit = $row['crlimit'];
						$totcrtrans = $row['totcrtrans'];

						$bu = $row['bu'];
						$selectclient = trim($row['custno']) . "*  " . trim($row['company']);
						$obtain_customer_open_payments = 1;
					} else {
					?>
						<script>
							$('#item_error').html("<strong>Customer does not exist</strong>");
						</script>
					<?php
					}
				} else {
					?>
					<script>
						$('#item_error').html("<strong>Keyword is empty</strong>");
					</script>
				<?php
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
					$custbal = $row['custbal'];
					$crlimit = $row['crlimit'];
					$totcrtrans = $row['totcrtrans'];

					$bu = $row['bu'];
					//echo "<br/>".$company;
					$obtain_customer_open_payments = 1;
				} else {
				?>
					<script>
						$('#item_error').html("<strong>Customer does not exist</strong>");
					</script>
				<?php
				}
			}

			$count_open_pmts = 0;
			if ($obtain_customer_open_payments == 1 || $op == 'saverequisition') {
				?> <input type="hidden" id="trackbalance" value="<?php echo $custbal ?>" /> <?php

																							$sql_open_pmts = " select refno, amount, amtused from payments where amount - amtused > 0 
				 and advrefund1 = 1 and TRIM(custno) = '$custno'";

																							$result_open_pmts = mysqli_query($_SESSION['db_connect'], $sql_open_pmts);
																							$count_open_pmts = mysqli_num_rows($result_open_pmts);


																							//obtain customer specific discount if any
																							$sql_custpric = "select distinct * FROM custpric WHERE trim(custno) = '$custno' ";
																							$result_custpric = mysqli_query($_SESSION['db_connect'], $sql_custpric);
																							$count_custpric = mysqli_num_rows($result_custpric);

																							$k = 0;
																							while ($k < $count_custpric) {
																								$row = mysqli_fetch_array($result_custpric);
																								$custpric_var[$k]['item'] = $row['item'];
																								$custpric_var[$k]['srvchg'] = $row['srvchg'];
																								$custpric_var[$k]['dmargin'] = $row['dmargin'];
																								$custpric_var[$k]['nfr'] = $row['nfr'];
																								$custpric_var[$k]['misc'] = $row['misc'];
																								$custpric_var[$k]['slabid'] = $row['slabid'];
																								$custpric_var[$k]['disctype'] = $row['disctype'];

																								$k++;
																							}
																							//create hidden inputs to hold vital customer specific discount details
																							for ($k = 0; $k < $count_custpric; $k++) {
																								//create variables to hold vital information
																								$hold_srvchg = $custpric_var[$k]['item'] . 'custpric_srvchg';
																								$$hold_srvchg = $custpric_var[$k]['srvchg'];

																								$hold_dmargin = $custpric_var[$k]['item'] . 'custpric_dmargin';
																								$$hold_dmargin = $custpric_var[$k]['dmargin'];

																								$hold_nfr = $custpric_var[$k]['item'] . 'custpric_nfr';
																								$$hold_nfr = $custpric_var[$k]['nfr'];

																								$hold_misc = $custpric_var[$k]['item'] . 'custpric_misc';
																								$$hold_misc = $custpric_var[$k]['misc'];

																								$hold_slabid = $custpric_var[$k]['item'] . 'custpric_slabid';
																								$$hold_slabid = $custpric_var[$k]['slabid'];

																								$hold_disctype = $custpric_var[$k]['item'] . 'custpric_disctype';
																								$$hold_disctype = $custpric_var[$k]['disctype'];

																							?>
					<input type="hidden" name="<?php echo $custpric_var[$k]['item'] . 'custpric_srvchg'; ?>" id="<?php echo $custpric_var[$k]['item'] . 'custpric_srvchg'; ?>" value="<?php echo $custpric_var[$k]['srvchg']; ?>" />

					<input type="hidden" name="<?php echo $custpric_var[$k]['item'] . 'custpric_dmargin'; ?>" id="<?php echo $custpric_var[$k]['item'] . 'custpric_dmargin'; ?>" value="<?php echo $custpric_var[$k]['dmargin']; ?>" />

					<input type="hidden" name="<?php echo $custpric_var[$k]['item'] . 'custpric_nfr'; ?>" id="<?php echo $custpric_var[$k]['item'] . 'custpric_nfr'; ?>" value="<?php echo $custpric_var[$k]['nfr']; ?>" />

					<input type="hidden" name="<?php echo $custpric_var[$k]['item'] . 'custpric_misc'; ?>" id="<?php echo $custpric_var[$k]['item'] . 'custpric_misc'; ?>" value="<?php echo $custpric_var[$k]['misc']; ?> " />

					<input type="hidden" name="<?php echo $custpric_var[$k]['item'] . 'custpric_vat'; ?>" id="<?php echo $custpric_var[$k]['item'] . 'custpric_vat'; ?>" value="<?php echo $custpric_var[$k]['vat']; ?>" />

					<input type="hidden" name="<?php echo $custpric_var[$k]['item'] . 'custpric_slabid'; ?>" id="<?php echo $custpric_var[$k]['item'] . 'custpric_slabid'; ?>" value="<?php echo $custpric_var[$k]['slabid']; ?> " />

					<input type="hidden" name="<?php echo $custpric_var[$k]['item'] . 'custpric_disctype'; ?>" id="<?php echo $custpric_var[$k]['item'] . 'custpric_disctype'; ?>" value="<?php echo $custpric_var[$k]['disctype']; ?> " />
				<?php
																							}
																						}


																						if ($op == 'getselectloccd') {
																							$filter = "";

																							$sql_Q = "SELECT * FROM lmf where  ";
																							$loccd = '';
																							if (trim($selectloccd) <> '') {
																								//echo $selectitem;
																								$itemdetails = explode("*", $selectloccd);
																								$loccd = $itemdetails[0];
																							}

																							$filter = "  upper(trim(loccd)) = upper('$loccd')  ";



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
																								$loccd    = $row['loccd'];
																								$loc_name   = $row['loc_name'];
																								$xchar2 = $row['xchar2'];

																								//echo "<br/>".$company;


																							} else {
				?>
					<script>
						$('#item_error').html("<strong>Location does not exist</strong>");
					</script>
					<?php
																							}
																						}



																						function mygetdiscount($i, $disctype)
																						{
																							//determine the type of discount and obtain discount
																							$thediscount = 0;
																							global $the_slab, $thediscount_type, $the_flat, $thebaseprice, $the_percent, $thevolumefactor, $theitemsQty, $theitems, $count_custpric, $promo;

																							if ($disctype == 'disctype1') {
																								//obtain product default discount

																								$product_disc_type = $thediscount_type[$i];
																								//1 is flat, 3 is %, 2 is slab

																								if ($product_disc_type == 1) {
																									$thediscount = $the_flat[$i];
																								} else if ($product_disc_type == 3) {

																									$thediscount = $thebaseprice[$i] * ($the_percent[$i] / 100);
																								} else {

																									//obtain the volume of the product
																									$thevolume = $thevolumefactor[$i] * $theitemsQty[$i];

																									//obtain the lower and upper bounds of the slab
																									$thediscount = obtainslabdiscount($the_slab[$i], $thevolume, $thebaseprice[$i]);
																								}
																							}


																							if ($disctype == 'disctype2') {
																								//check if special discount exists for this customer
																								$hold_srvchg = $theitems[$i] . 'custpric_srvchg';

																								$hold_dmargin = $theitems[$i] . 'custpric_dmargin';

																								$hold_nfr = $theitems[$i] . 'custpric_nfr';

																								$hold_misc = $theitems[$i] . 'custpric_misc';

																								$hold_slabid = $theitems[$i] . 'custpric_slabid';

																								$hold_disctype = $theitems[$i] . 'custpric_disctype';

																								if ($count_custpric != 0) {
																									//obtain product default discount
																									$customer_disc_type = $$hold_disctype;
																									//1 is flat, 2 is slab

																									if ($customer_disc_type == 1) {
																										//get service charge
																										$custpric_srvchg = $$hold_srvchg;
																										//get dealer margin
																										$custpric_dmargin = $$hold_dmargin;
																										//get dealer nfr
																										$custpric_nfr = $$hold_nfr;
																										//get dealer Misc
																										$custpric_misc = $$hold_misc;

																										$thediscount = -1 * ($custpric_srvchg - $custpric_dmargin + $custpric_nfr + $custpric_misc);
																									} else {
																										$slabdisc = $$hold_slabid;
																										//obtain the volume of the product
																										$thevolume = $thevolumefactor[$i] * $theitemsQty[$i];

																										//obtain the lower and upper bounds of the slab
																										$thediscount = obtainslabdiscount($slabdisc, $thevolume, $thebaseprice[$i]);
																									}
																								}
																							}


																							if ($disctype == 'disctype3') {


																								if ($promo != '') {

																									$thevolume = $thevolumefactor[$i] * $theitemsQty[$i];;

																									//obtain the lower and upper bounds of the slab
																									$thediscount = obtainslabdiscount($promo, $thevolume, $thebaseprice[$i]);
																								}
																							}

																							return $thediscount;
																						}



																						function obtainslabdiscount($slabdisc, $thevolume, $baseprice)
																						{
																							global $count_slabdisc, $slabdisc_var;
																							$slabobtained = 0;
																							$i = 0;
																							$found_disc = 0;

																							while ($i < $count_slabdisc && $slabobtained == 0) {
																								//get a slab and compare volume

																								if ($slabdisc_var[$i]['slabid'] == $slabdisc) {


																									if ($thevolume >= $slabdisc_var[$i]['lbound']  && $thevolume <= $slabdisc_var[$i]['ubound']) {
																										$slabobtained = 1;
																										$founddisc = $slabdisc_var[$i]['disc'];
																										$found_disc = $baseprice * $founddisc / 100;
																									}
																								}
																								$i++;
																							}

																							return $found_disc;
																						}


																						if ($op == 'saverequisition') {
																							$saverecord = 1;


																							//check if submitted customer exists
																							$sql_Customer = "select * from arcust where trim(custno) = '$custno'";
																							//echo $sql_Customer;
																							$result_Customer = mysqli_query($_SESSION['db_connect'], $sql_Customer);
																							$count_Customer = mysqli_num_rows($result_Customer);

																							if ($count_Customer >= 1) {
																								$row       = mysqli_fetch_array($result_Customer);
																								$custno    = $row['custno'];
																								$company   = $row['company'];
																								$custbal = $row['custbal'];
																								$crlimit = $row['crlimit'];
																								$totcrtrans = $row['totcrtrans'];

																								$bu = $row['bu'];

																								//obtain the passed parameters
																								if (trim($selectloccd) <> '') {
																									//echo $selectitem;
																									$loccddetails = explode("*", $selectloccd);
																									$loccd = $loccddetails[0];
																									$loc_name = $loccddetails[1];
																								}

																								$rcvloc = '';
																								$rcv_locnm = '';
																								if (trim($selectrcvloc) <> '') {
																									//echo $selectitem;
																									$rcvlocdetails = explode("*", $selectrcvloc);
																									$rcvloc = $rcvlocdetails[0];
																									$rcv_locnm = $rcvlocdetails[1];
																								}


																								$thetotalcost = 0;
																								$thetotalvolume = 0;
																								for ($i = 0; $i < $item_count; $i++) {
																									$theitems[$i] = $dbobject->test_input($_REQUEST['item' . $i]);
																									$theitemsQty[$i] = $dbobject->test_input($_REQUEST['itemqty' . $i]);
																									//echo $theitems[$i].' '.$theitemsQty[$i].'<br />';
																									//retrieve product details
																									$sql_passed_item = "select * from icitem where trim(item) = '" . $theitems[$i] . "'";
																									//echo $sql_passed_item;
																									$result_passed_item = mysqli_query($_SESSION['db_connect'], $sql_passed_item);
																									$count_passed_item = mysqli_num_rows($result_passed_item);
																									if ($count_passed_item >= 1) {
																										$row  = mysqli_fetch_array($result_passed_item);
																										//
																										$theitemsDescription[$i] = $row['itemdesc'];


																										//obtain volume factor
																										$thevolumefactor[$i] = $row['volfactor'];

																										// **Checking if customer has a special discount or approval definition else use business category pricing policy
																										// get the discount type
																										switch ($_SESSION['trantype']) {
																											case 1:
																												$thediscount_type[$i] = $row['retail'];
																												//obtain base price
																												if ($mv == 'SC') {
																													$thebaseprice[$i] = $row['scprice'];
																												} else {
																													$thebaseprice[$i] = $row['otprice'];
																												}

																												$the_flat[$i] = $row['retflat'];
																												$the_slab[$i] = $row['retslab'];
																												$the_percent[$i] = $row['recent'];

																												break;
																											case 3:
																												$thediscount_type[$i] = $row['ow'];
																												if ($mv == 'SC') {
																													$thebaseprice[$i] = $row['owscprice'];
																												} else {
																													$thebaseprice[$i] = $row['owotprice'];
																												}

																												$the_flat[$i] = $row['owflat'];
																												$the_slab[$i] = $row['owslab'];
																												$the_percent[$i] = $row['owcent'];

																												break;

																											default:
																												if ($mv == 'SC') {
																													$thebaseprice[$i] = $row['prscprice'];
																												} else {
																													$thebaseprice[$i] = $row['protprice'];
																												}

																												$the_flat[$i] = $row['prflat'];
																												$the_slab[$i] = $row['prslab'];
																												$the_percent[$i] = $row['prcent'];
																												$thediscount_type[$i] = $row['pr'];
																										}


																										$targetbase = 0;
																										$met_target = 0;
																										$the_target = 0;
																										$slabused = '';
																										$d_regime = 0;
																										$caution = 0;
																										//do later

																										$thediscount[$i] = mygetdiscount($i, $disctype);


																										$thediscountedunitprice[$i] = $thebaseprice[$i] - $thediscount[$i];

																										//obtain vat
																										$thevat[$i] = $row['vat'];

																										$thevatduprice[$i] = $thediscountedunitprice[$i] * $thevat[$i] / 100;
																										$theprice[$i] = $thediscountedunitprice[$i] + $thevatduprice[$i];
																										$thedisctax[$i] = $thevat[$i] - $thediscount[$i];
																										$thecost[$i] = $theitemsQty[$i] * $theprice[$i];
																										$thevolume[$i] = $theitemsQty[$i] * $thevolumefactor[$i];
																										$thetotalcost += $thecost[$i];
																										$thetotalvolume += $thevolume[$i];
																										//
																									} else {
																										$saverecord *= 0;
																									}
																								}	//end of product pricing
																								//obtain requisition number
																								$sql_requisition = "select * from const where 1=1";
																								$result_requisition = mysqli_query($_SESSION['db_connect'], $sql_requisition);
																								$count_requisition = mysqli_num_rows($result_requisition);
																								if ($count_requisition >= 1) {
																									$row  = mysqli_fetch_array($result_requisition);
																									switch ($_SESSION['trantype']) {
																										case 1:
																											//cash transaction
																											$nextReqno = $row['csh_reqno'];
																											$pref = "CSH";
																											$UpdateConst = " update const set csh_reqno = ";
																											break;
																										case 2:
																											//credit
																											$nextReqno = $row['cr_reqno'];
																											$pref = "CRT";
																											$UpdateConst = " update const set cr_reqno = ";
																											break;

																										case 3:
																											//Own Use
																											$nextReqno = $row['own_reqno'];
																											$pref = "OWN";
																											$UpdateConst = " update const set own_reqno = ";
																											break;

																										case 4:
																											//Bridging
																											$nextReqno = $row['ptn_reqno'];
																											$pref = "PTN";
																											$UpdateConst = " update const set ptn_reqno = ";
																											break;

																										default:
																											//Do not permit transaction
																											$nextReqno = 1;
																											$pref = "";
																											$UpdateConst = "";
																									}

																									$requestno = $pref . date("d") . date("m") . date("Y") . $nextReqno;

																									//check usage
																									$sql_check_usage = "select * from headdata where trim(request) = '$requestno'";
																									$result_check_usage = mysqli_query($_SESSION['db_connect'], $sql_check_usage);
																									$count_check_usage = mysqli_num_rows($result_check_usage);
																									if ($count_check_usage >= 1) {
																										$Reqno_in_use = 1;
																										while ($Reqno_in_use == 1) {
																											$nextReqno++;
																											$requestno = $pref . date("d") . date("m") . date("Y") . $nextReqno;
																											$sql_check_usage_again = "select * from headdata where trim(request) = '$requestno'";
																											$result_check_usage_again = mysqli_query($_SESSION['db_connect'], $sql_check_usage_again);
																											$count_check_usage_again = mysqli_num_rows($result_check_usage_again);
																											if ($count_check_usage_again == 0) {
																												$Reqno_in_use = 0;
																											}
																										}
																									}
																								} //end of obtaining requisition number

																								$theRefno = array();
																								$theRefAmt = array();
																								$theRefAmtBalance = array();
																								//$theRefAmtUsedInThisTransaction = Array();
																								$pmtRefUsed = array();
																								$pmtAmtUsed = array();
																								for ($i = 0; $i < 5; $i++) {
																									$pmtRefUsed[$i] = '';
																									$pmtAmtUsed[$i] = 0;
																								}
																								$hold_total_pmt = 0;
																								$trackCostAndPayment = $thetotalcost;
																								//$trackCostAndPayment should be zero at the end of payment check
																								//determine payments
																								if ($count_open_pmts > 0) {
																									for ($i = 0; $i < $count_open_pmts; $i++) {
																										$row = mysqli_fetch_array($result_open_pmts);
																										$theRefno[$i] = $row['refno'];
																										$theRefAmt[$i] = $row['amount'];
																										$theRefAmtBalance[$i] = $row['amount'] - $row['amtused'];
																										if ($trackCostAndPayment > 0 && $i < 5) {
																											if ($theRefAmtBalance[$i] > $trackCostAndPayment) {
																												//balance can settle  all the cost
																												$pmtAmtUsed[$i] = $trackCostAndPayment;
																												$trackCostAndPayment = 0;
																												//echo 'balance > <br/>';
																											} else {
																												//balance can settle only part of the cost
																												$pmtAmtUsed[$i] = $theRefAmtBalance[$i];
																												$trackCostAndPayment = $trackCostAndPayment - $theRefAmtBalance[$i];
																												//echo 'balance < <br/>';
																											}
																											//save the usage

																											$pmtRefUsed[$i] = $theRefno[$i];

																											$hold_total_pmt += $pmtAmtUsed[$i];

																											//echo $i.' ' .$pmtRefUsed[$i].' '. $pmtAmtUsed[$i].'<br/>';
																										}
																									}
																								}

																								//echo 'Total Payment '.$hold_total_pmt.'<br/>';
																								//echo 'trackCostAndPayment '.$trackCostAndPayment.'<br/>';
																								//echo 'thetotalcost '.$thetotalcost.'<br/>';

																								//if ($trackCostAndPayment == 0 || $_SESSION['trantype'] == 2 || $_SESSION['trantype'] == 4){

																								if ($trackCostAndPayment != 0 && $_SESSION['trantype'] != 2) {
																									$saverecord = 0;
																								} else {
																									if ($thetotalcost > 0 and $trantype == 2) {
																										if ($thetotalcost + $totcrtrans  > $crlimit) {
					?>
								<script>
									$('#item_error').html("<strong>This Transaction will exceed the Credit Limit</strong>");
								</script>
						<?php
																											$saverecord = 0;
																										}
																									}
																								}
																								if ($saverecord == 1) {
																									//records can be saved
																									//update const table
																									$sql_update_Const = $UpdateConst . ($nextReqno + 1) .  'where 1=1 ';
																									$result_update_Const = mysqli_query($_SESSION['db_connect'], $sql_update_Const);

																									//save to headdata
																									$sql_SaveReq = " insert into headdata 
										(salespsn, request, custno,ccompany,loccd,loc_name,reqst_by,bridging,loc_date, py,
										mv, bu, total_cost, total_vol , reqrem,  rcvloc, rcv_locnm,  reqamount, trantype, targetbase,
										met_target , the_target, slabused, d_regime, modified, caution, logsysreg,periodmonth,periodyear ) 
								values  
									( '$salespsn','$requestno','$custno','$company','$loccd','$loc_name','$reqst_by','$mbridging',
									'" . date('d/m/Y H:i:s A') . "', '$py', '$mv', '$bu',$thetotalcost , $thetotalvolume ,
									'$reqrem',  '$rcvloc', '$rcv_locnm', $thetotalcost, " . $_SESSION['trantype'] . ", $targetbase , $met_target ,
									$the_target , '$slabused', $d_regime, 1, $caution, '" . $_SERVER['REMOTE_ADDR'] . "','$periodmonth','$periodyear' )";

																									$result_SaveReq = mysqli_query($_SESSION['db_connect'], $sql_SaveReq);

																									//echo $sql_SaveReq.'<br />';
																									//save product details to loadings
																									for ($i = 0; $i < $item_count; $i++) {
																										$sql_SaveItemDetails = " insert into loadings 
									(request, item, itemdesc, qty_asked,bprice,disc,duprice,vatduprice,price,cost,trantype,lineno ,
									 totlineno ,periodmonth,periodyear)  values ('$requestno','" .  $theitems[$i] . "','" . $theitemsDescription[$i] .
																											"'," . $theitemsQty[$i] . "," . $thebaseprice[$i] . "," . $thediscount[$i] . "," . $thediscountedunitprice[$i] . "," .
																											$thevatduprice[$i] . "," . $theprice[$i] . "," . $thecost[$i] . " ," . $_SESSION['trantype']  . " ," . ($i + 1) . " ,$item_count ,'$periodmonth','$periodyear') ";

																										$result_SaveItemDetails = mysqli_query($_SESSION['db_connect'], $sql_SaveItemDetails);

																										//echo $sql_SaveItemDetails.'<br />';

																									}


																									// **UPDATING CUSTOMER BALANCE I.E LOCAL OR OWN USE AND NOT STOCK TRANSFER GENERIC CUSTOMER
																									if ($_SESSION['trantype'] != 4) {
																										//not bridging
																										if ($_SESSION['trantype'] != 2) {
																											//not credit
																											//update payment
																											for ($i = 0; $i < $count_open_pmts; $i++) {

																												if (isset($pmtAmtUsed[$i])) {
																													$sql_Update_Payment = "update payments set 
													amtused = amtused + " . $pmtAmtUsed[$i] . " where TRIM(refno) = '" . $theRefno[$i] . "'";

																													$result_Update_Payment = mysqli_query($_SESSION['db_connect'], $sql_Update_Payment);
																												}
																											}


																											//update payment usage
																											$sql_PaymentUsage = "insert into paymentsuse 
											( custno,request,invoice_no,payments,pmtdate,transdate,transby,refno1,refno2, 
											refno3,refno4,refno5,amtused1,amtused2,amtused3,amtused4,amtused5,periodmonth,periodyear ) 
										values ( '$custno','$requestno','$requestno',$hold_total_pmt,
											'" . date('d/m/Y') . "','" . date('d/m/Y') . "','$reqst_by','" . $pmtRefUsed[0] . "','" . $pmtRefUsed[1] . "',
											'" . $pmtRefUsed[2] . "','" . $pmtRefUsed[3] . "','" . $pmtRefUsed[4] . "'," .
																												$pmtAmtUsed[0] . "," . $pmtAmtUsed[1] . "," . $pmtAmtUsed[2] . "," . $pmtAmtUsed[3] . "," . $pmtAmtUsed[4] . ",
											'$periodmonth','$periodyear')";

																											$result_PaymentUsage = mysqli_query($_SESSION['db_connect'], $sql_PaymentUsage);

																											// ***updating corporate receivable balance
																											$sql_Update_Const_stmt = " update const set pmtsusacct = pmtsusacct - $hold_total_pmt
										,corpbal = corpbal + $hold_total_pmt , receivable = receivable - $hold_total_pmt where 1 = 1 ";

																											$result_Update_Const_stmt = mysqli_query($_SESSION['db_connect'], $sql_Update_Const_stmt);

																											//create journal entries for payment usage
																											//IN passedTHEMODULE VARCHAR(40), IN mTHE_SUB_ACCOUNTNO VARCHAR(40), IN mTHE_SUB_ACCOUNT_DESCRIPTION VARCHAR(40), IN  mTHE_AMOUNT  DECIMAL(25,2), IN  mTHE_TRANSDATE  VARCHAR(22), IN mperiodmonth VARCHAR(2), IN mperiodyear VARCHAR(4)


																											$sql_CreateJournal2 = "call CreateJournalEntries('PAYMENTS_RECONCILIATION','$custno','$company',$thetotalcost,'" . date('d/m/Y H:i:s A') . "','$periodmonth','$periodyear')";

																											$result_CreateJournal2 = mysqli_query($_SESSION['db_connect'], $sql_CreateJournal2);
																											//echo $sql_CreateJournal2.'<br/>';
																										} else {
																											//credit
																											/* $sql_Update_Const_stmt = " update arcust set 
											 totcrtrans = totcrtrans + " . ($pmtAmtUsed[0]+$pmtAmtUsed[1]+$pmtAmtUsed[2]+$pmtAmtUsed[3]+$pmtAmtUsed[4]).
											" where TRIM(custno) = '$custno'";*/

																											$sql_Update_Credit_stmt = " update arcust set 
											 totcrtrans = totcrtrans + " . $thetotalcost .
																												" where TRIM(custno) = '$custno'";

																											//echo $sql_Update_Credit_stmt;			
																											$result_Update_Const_stmt = mysqli_query($_SESSION['db_connect'], $sql_Update_Credit_stmt);
																										}
																									}

																									$sql_Update_Credit_stmt = " update arcust set 
											 custbal = custbal + " . $thetotalcost .
																										" where TRIM(custno) = '$custno'";

																									//echo $sql_Update_Credit_stmt;			
																									$result_Update_Const_stmt = mysqli_query($_SESSION['db_connect'], $sql_Update_Credit_stmt);



																									$sql_CreateJournalR = "call CreateJournalEntries('REQUISITION','$custno','$company',$thetotalcost,'" . date('d/m/Y H:i:s A') . "','$periodmonth','$periodyear')";

																									$result_CreateJournalR = mysqli_query($_SESSION['db_connect'], $sql_CreateJournalR);

																									$dbobject->apptrail($reqst_by, 'Requisition', $requestno, date('d/m/Y H:i:s A'), 'Requisition Booked');

																									$dbobject->workflow($reqst_by, 'Requisition Created, Approval Required', $requestno, date('d/m/Y H:i:s A'), 4, 2, 'fastapproval');

																									echo "<h3>The Requisition Number is <b>$requestno</b></h3>";
						?>
						<script>
							$('#item_error').html("<strong>The Requisition was saved </strong>");
						</script>
					<?php

																								} else {

					?>
						<script>
							$('#item_error').html("<strong>Requisition not Saved</strong>");
						</script>
					<?php

																								}
																							} else {

					?>
					<script>
						$('#item_error').html("<strong>Customer Does Not Exist</strong>");
					</script>
			<?php

																							}

																							$count_open_pmts = 0;
																						}





																						// ****		
			?>
			<style>
				td {
					padding: 5px;
				}
			</style>
			<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
			<input type="hidden" name="trantype" id="trantype" value="<?php echo $trantype; ?>" />
			<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
			<input type="hidden" name="company" id="company" value="<?php echo $company; ?>" />
			<input type="hidden" name="loccd" id="loccd" value="<?php echo $loccd; ?>" />
			<input type="hidden" name="loc_name" id="loc_name" value="<?php echo $loc_name; ?>" />
			<input type="hidden" name="rcvloc" id="rcvloc" value="<?php echo $rcvloc; ?>" />
			<input type="hidden" name="loc_name" id="loc_name" value="<?php echo $loc_name; ?>" />
			<input type="hidden" name="xchar2" id="xchar2" value="<?php echo $xchar2; ?>" />
			<input type="hidden" name="bu" id="bu" value="<?php echo $bu; ?>" />
			<input type="hidden" name="py" id="py" value="<?php echo $py; ?>" />

			<input type="hidden" name="periodmonth" id="periodmonth" value="<?php echo $periodmonth; ?>" />
			<input type="hidden" name="periodyear" id="periodyear" value="<?php echo $periodyear; ?>" />
			<input type="hidden" name="crlimit" id="crlimit" value="<?php echo $crlimit; ?>" />
			<input type="hidden" name="totcrtrans" id="totcrtrans" value="<?php echo $totcrtrans; ?>" />
			<input type="hidden" name="slabcount" id="slabcount" value="<?php echo $count_slabdisc; ?>" />
			<input type="hidden" name="count_custpric" id="count_custpric" value="<?php echo $count_custpric; ?>" />
			<input type="hidden" name="thetablename" id="thetablename" value="customer" />
			<input type="hidden" name="get_file" id="get_file" value="makerequisition" />

			<input type="hidden" id="no_itemsincart" value=0 />
			<input type="hidden" id="itemsincart" value="" />

			<div id="items_in_cart"></div>
			<table style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
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

				<tr>
					<td colspan="2" valign="top">
						<b>Customer</b>&nbsp;&nbsp;
						<input type="text" name="selectclient" size="45px" style="background:transparent;border:none;" tabindex="-1" id="selectclient" value="<?php echo $selectclient; ?>" />

						<br /><br />
						<b><?php echo $bu; ?>
							&nbsp;&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;&nbsp;
							<?php echo $py . ' ' . $pydescription; ?>
							&nbsp;&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;&nbsp;

							<select name="mv" id="mv">
								<option value="SC" <?php echo ($mv == 'SC' ? "selected" : ""); ?>>Self Collection</option>
								<option value="LD" <?php echo ($mv == 'LD' ? "selected" : ""); ?>>Local Delivery</option>
							</select>


							&nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $bridging; ?>
						</b>
					</td>
				</tr>

			</table>
			<div style="overflow-x:auto;">
				<table>
					<tr>
						<td valign="center" nowrap="nowrap">
							<b>Supply Location:</b>
						</td>
						<td valign="center">
							<?php
							$k = 0;
							?>
							<br />
							<select name="selectloccd" id="selectloccd">
								<option value=""></option>
								<?php

								while ($k < $count_loccd) {
									//$row = mysqli_fetch_array($result_loccd);
									$theselectedloccd = trim($lmf_var[$k]['loccd']) . "*  " . trim($lmf_var[$k]['loc_name']);
								?>
									<option value="<?php echo $theselectedloccd; ?>" <?php echo ($selectloccd == $theselectedloccd ? "selected" : ""); ?>>
										<?php echo $theselectedloccd; ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>
						</td>

						<?php if ($_SESSION['trantype'] == 4) { ?>

							<td valign="center" nowrap="nowrap">

								<b>Receiving Location:</b>
							</td>
							<td valign="center">

								<?php
								$k = 0;
								?>
								<br />
								<select name="selectrcvloc" id="selectrcvloc" onChange="javascript: 
									var $form_selectrcvloc = $('#selectrcvloc').val();var $form_selectrcvloc = $('#selectrcvloc').val();
									var $form_selectloccd = $('#selectloccd').val(); var $form_selectclient = $('#selectclient').val();  
									var $form_custno = $('#custno').val();var $form_company = $('#company').val(); var $form_bu = $('#bu').val();
										//getpage('makerequisition.php?op=getselectrcvloc&selectloccd='+$form_selectloccd+
										'&rcvloc='+$form_rcvloc+'&custno='+$form_custno+'&company='+$form_company+'&selectclient='+$form_selectclient
										+'&bu='+$form_bu
										,'page')
							
								">
									<option value=""></option>
									<?php

									while ($k < $count_loccd) {
										//$row = mysqli_fetch_array($result_loccd);
										$theselectedrcvloc = trim($lmf_var[$k]['loccd']) . "*  " . trim($lmf_var[$k]['loc_name']);
									?>
										<option value="<?php echo $theselectedrcvloc; ?>" <?php echo ($selectrcvloc == $theselectedrcvloc ? "selected" : ""); ?>>
											<?php echo $theselectedrcvloc; ?>
										</option>

									<?php
										$k++;
									} //End If Result Test	
									?>
								</select>

							</td>
						<?php } ?>
					</tr>

				</table>
			</div>


			<div style="overflow-x:auto;">
				<table border="0">
					<tr>

						<td nowrap="nowrap" valign="top">
							<b>Select A Discount Type</b> &nbsp;
							&nbsp; &nbsp; <input type="radio" name="disc_category" id="disctype1" checked onclick="mydiscount(this.id)" />Product Default
							&nbsp; &nbsp; <input type="radio" name="disc_category" id="disctype2" onclick="mydiscount(this.id)" />Custonmer Specific
							&nbsp; &nbsp; <input type="radio" name="disc_category" id="disctype3" onclick="mydiscount(this.id)" />Promotion

						</td>

						<td nowrap="nowrap">
							<?php
							$k = 0;
							?>

							<select name="selectpromo" id="selectpromo" style="display:none">
								<option value=""></option>
								<?php

								while ($k < $count_slabdef) {
									//$row = mysqli_fetch_array($result_client);
									$theselectedpromo = trim($slabdef_var[$k]['slabid']) . "*  " . trim($slabdef_var[$k]['slabdesc']);

								?>
									<option value="<?php echo $theselectedpromo; ?>" <?php echo ($selectpromo == $theselectedpromo ? "selected" : ""); ?>>
										<?php echo $theselectedpromo; ?>
									</option>

								<?php
									$k++;
								} //End If Result Test	
								?>
							</select>


						</td>
					</tr>
				</table>
			</div>

			<table>
				<tr>
					<td valign="top">
						<b>Select Product</b>&nbsp;&nbsp;


						<?php
						$k = 0;
						?>
						<select name="selectproduct" id="selectproduct">
							<option value=""></option>
							<?php

							while ($k < $count_products) {
								//$row = mysqli_fetch_array($result_client);
								$theselectedproduct = trim($products_var[$k]['item']) . "*  " . trim($products_var[$k]['itemdesc']);
							?>
								<option value="<?php echo $theselectedproduct; ?>" <?php echo ($selectproduct == $theselectedproduct ? "selected" : ""); ?>>
									<?php echo $theselectedproduct; ?>
								</option>

							<?php
								$k++;
							} //End If Result Test	
							?>
						</select>


						&nbsp;&nbsp;
						Quantity <input type="text" size="5px" id="productqty" name="productqty" />

					</td>
					<td valign="top">
						<input type="button" name="addproduct" id="submit-button" value="Add Product" onclick="myAddItem();">

					</td>
				</tr>
			</table>

			<div style="overflow-x:auto;">
				<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
					<thead>
						<tr class="right_backcolor">
							<th nowrap="nowrap" class="Corner">&nbsp;</th>
							<td nowrap="nowrap" class="Odd" colspan="6" align="right"><b>Total Cost</b></td>
							<td id="totalcost" nowrap="nowrap" class="Odd" colspan="2"><input align="right" type="text" id="hold_totalcost" value=0 readonly /></td>
							<th nowrap="nowrap">&nbsp;</th>
						</tr>
					</thead>

					<tr class="right_backcolor">
						<th nowrap="nowrap" class="Corner">&nbsp;</th>
						<th nowrap="nowrap" class="Odd">Item</th>
						<th nowrap="nowrap" class="Odd">Description</th>
						<th nowrap="nowrap" class="Odd">Qty Req</th>
						<th nowrap="nowrap" class="Odd">Base Price</th>
						<th nowrap="nowrap" class="Odd">Unit Price</th>
						<th nowrap="nowrap" class="Odd">Volume</th>
						<th nowrap="nowrap" class="Odd">Disc/Tax</th>
						<th nowrap="nowrap" class="Odd">Cost</th>
						<th nowrap="nowrap">&nbsp;</th>
					</tr>



				</table>
			</div>

			<table>
				<tr>
					<td><strong>Sales Person :</strong>&nbsp;&nbsp;
						<input type="text" name="salespsn" id="salespsn" onKeyup="javascript: suggestentry(this.id,'salespsn');" value="<?php echo $salespsn; ?>" class="required-text">
						<div id="salespsndisplay"></div>
					</td>
					<td><strong>Remark :</strong>&nbsp;&nbsp;
						<input type="text" name="reqrem" id="reqrem" value="<?php echo $reqrem; ?>" class="required-text">
					</td>
				</tr>
				<tr>

					<td align="right" nowrap="nowrap">

						<input type="button" name="approvebutton" id="submit-button" value="Save" onclick="mysavefunction();">

					</td>


					<td nowrap="nowrap">


						<?php if ($count_for_report > 0) { ?>

							<input type="hidden" id="the_reportname" value="<?php echo trim($rowreport['procname']); ?>" />
							<input type="hidden" id="the_reportdesc" value="<?php echo trim($rowreport['reportdesc']); ?>" />
							<input type="hidden" id="thestartdate" value="<?php echo trim($rowreport['startdate']); ?>" />
							<input type="hidden" id="the_location" value="<?php echo trim($rowreport['location']); ?>" />
							<input type="hidden" id="the_product" value="<?php echo trim($rowreport['product']); ?>" />
							<input type="hidden" id="the_purchaseorder" value="<?php echo trim($rowreport['purchaseorder']); ?>" />
							<input type="hidden" id="the_vendor" value="<?php echo trim($rowreport['vendor']); ?>" />
							<input type="hidden" id="the_customer" value="<?php echo trim($rowreport['customer']); ?>" />
							<input type="hidden" id="the_salesperson" value="<?php echo trim($rowreport['salespsn']); ?>" />



							<input type="button" name="closebutton" id="submit-button" value="Report" onclick="javascript: 
								var reportname = $('#the_reportname').val();var reportdesc = $('#the_reportdesc').val();
								var startdate = $('#the_startdate').val();var location = $('#the_location').val();
								var product = $('#the_product').val();var purchaseorder = $('#the_purchaseorder').val();
								var vendor = $('#the_vendor').val();var customer = $('#the_customer').val();var salespsn = $('#the_salespsn').val();
								
							getpage('reportheader.php?calledby=makerequisition&reportname='+reportname+'&reportdesc='+reportdesc+'&thestartdate='+startdate+'&location='+location+'&product='+product+'&purchaseorder='+purchaseorder+'&vendor='+vendor+'&customer='+customer+'&salesperson='+salespsn,'page');" />

						<?php } ?>

					</td>

				</tr>

			</table>
			<br>
			<hr>

			<strong>Open Payment Instrument Details</strong>
			<table border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
				<thead>
					<tr class="right_backcolor">
						<th nowrap="nowrap" class="Corner">&nbsp;</th>
						<th nowrap="nowrap" class="Odd">S/N</th>
						<th nowrap="nowrap" class="Odd">Receipt No</th>
						<th nowrap="nowrap" class="Odd">Amount</th>
						<th nowrap="nowrap" class="Odd">Amount Used</th>
						<th nowrap="nowrap" class="Odd">Balance</th>
						<th nowrap="nowrap">&nbsp;</th>
					</tr>
				</thead>
				<?php
				$k = 0;
				$total_available_pmts = 0;
				while ($k < $count_open_pmts) {
					$k++;
					$row = mysqli_fetch_array($result_open_pmts);

				?>

					<tr <?php echo ($k % 2 == 0) ? "class='treven'" : "class='trodd'"; ?>>
						<td nowrap="nowrap">&nbsp;</td>
						<td nowrap="nowrap">&nbsp;&nbsp;<?php echo $k; ?></td>
						<td nowrap="nowrap">&nbsp;&nbsp;<?php echo $row['refno']; ?></td>
						<td nowrap="nowrap">&nbsp;&nbsp;<?php echo number_format($row["amount"], 2); ?></td>
						<td nowrap="nowrap" align="right">&nbsp;&nbsp;<?php echo number_format($row["amtused"], 2); ?></td>
						<td nowrap="nowrap" align="right">&nbsp;&nbsp;<?php $total_available_pmts += $row["amount"] - $row["amtused"];
																		echo number_format($row["amount"] - $row["amtused"], 2); ?></td>
						<td nowrap="nowrap"></td>
					</tr>
				<?php
					//} //End For Loop
				} //End If Result Test	
				?>
				<tr>
					<td nowrap="nowrap">&nbsp;</td>
					<td nowrap="nowrap" colspan="4" align="right"><b>Total Available Fund</b></td>
					<td nowrap="nowrap" align="right"><b><input style="background-color:green" id="total_available_pmts" type="text" readonly value="<?php echo number_format($total_available_pmts, 2); ?>" /></b></td>
					<td nowrap="nowrap"></td>
				</tr>
			</table>


		<?php } ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" onclick="javascript:  getpage('s_and_d.php?','page');
							">
	<br />
</div>

<script>
	function mycalculatediscount(clicked) {
		//calculate discount for all items in the product table

	}



	function obtainslabdiscount(slabdisc, thevolume, baseprice) {
		//obtain slabdisc count

		var slabcount = $('#slabcount').val();
		var slabobtained = 0;
		var $i = 0;
		var found_disc = 0;

		while ($i < slabcount && slabobtained == 0) {
			//get a slab and compare volume
			var checkthisslab = $('#slabdisc' + $i + slabdisc).val();

			if (checkthisslab == slabdisc) {
				//get lower and upper bound
				var lowerbound = $('#slabdisclbound' + $i + slabdisc).val();
				var upperbound = $('#slabdiscubound' + $i + slabdisc).val();


				if (Number(thevolume) >= Number(lowerbound) && Number(thevolume) <= Number(upperbound)) {
					slabobtained = 1;
					var founddisc = $('#slabdiscdisc' + $i + slabdisc).val();
					found_disc = baseprice * founddisc / 100;
				}
			}
			$i++;
		}

		return found_disc;
	}





	function mydiscount(clicked) {
		//alert(clicked);
		var x = document.getElementById('selectpromo');
		if (clicked == 'disctype3') {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
		//mycalculatediscount(clicked);
	}


	function mysavefunction() {
		if (confirm('Are you sure the entries are correct?')) {
			var $goahead = 1;
			//check active period
			var $form_periodyear = $('#periodyear').val();
			var $form_periodmonth = $('#periodmonth').val();
			var today = new Date();
			var thismonth = (today.getMonth() + 1);
			var thisyear = today.getFullYear();
			if (Number($form_periodyear) != Number(thisyear) || Number($form_periodmonth) != Number(thismonth)) {
				alert('Date is not within the current period');
				$goahead *= 0;
			}
			//alert($form_periodyear);
			//obtain total requested cost
			var $form_totalcost = $('#hold_totalcost').val();
			//obtain total open payments
			var $form_total_available_pmts = $('#total_available_pmts').val();


			//check if credit transaction and if customer is within the credit limit
			//obtain trantype
			var $form_trantype = $('#trantype').val();
			if ($form_trantype == 2) {
				//obtain crlimit
				var $form_crlimit = $('#crlimit').val();
				//obtain total cr transactions
				var $form_totcrtrans = $('#totcrtrans').val();

				if (Number($form_totalcost) + Number($form_totcrtrans) > Number($form_crlimit)) {
					$goahead *= 0;
					alert('Transaction will exceed the Customer(s) Credit Limt');
				}
			}


			if (Number($form_trantype) == 1 || Number($form_trantype) == 3) {
				//Cash Transaction or Own Use

				if (Number($form_totalcost) > Number($form_total_available_pmts)) {
					$goahead *= 0;
					alert('Available Payments can not be less than the Product Cost');
				}

			}



			if ($form_totalcost <= 0) {
				$goahead *= 0;
				alert('Product cost should not be zero');
			}

			//obtain salespsn and remark
			var $form_salespsn = $('#salespsn').val();
			var $form_reqrem = $('#reqrem').val();

			if ($form_salespsn == '') {
				$goahead *= 0;
				alert('Please enter a Sales Person ID Ref');
			}
			if ($form_reqrem == '') {
				$goahead *= 0;
				alert('Please enter a Remark');
			}


			//obtain supply location
			var $form_selectloccd = $('#selectloccd').val();
			if ($form_selectloccd == '') {
				$goahead *= 0;
				alert('Please Provide a Supply Location');
			}


			//check if it is stock transfer and receiving location is empty
			if ($form_trantype == 4) {
				//obtain receiving location
				var $form_selectrcvloc = $('#selectrcvloc').val();
				if ($form_selectrcvloc == '') {
					$goahead *= 0;
					alert('Please Provide a Receiving Location');

				}
				if ($form_selectrcvloc == $form_selectloccd) {
					$goahead *= 0;
					alert('Please Provide a Receiving Location different from Supply Location');

				}

			}

			var $form_promo = '';

			if (document.getElementById('disctype1').checked) {
				var $form_disctype = 'disctype1';
			}

			if (document.getElementById('disctype2').checked) {
				var $form_disctype = 'disctype2';
			}

			if (document.getElementById('disctype3').checked) {
				var $form_disctype = 'disctype3';
				var x = $('#selectpromo').val();

				if (x != '') {
					//obtain the slabid
					//split to individual products
					const myArrayOfSlabs = x.split("*");
					var $form_promo = myArrayOfSlabs[0];

				} else {
					$goahead *= 0;
					Alert('Please Select a Promo');
				}
			}


			if ($goahead == 1) {
				//prepare to save 
				//determine how many products are in the cart
				var item_count = document.getElementById("no_itemsincart").value;

				//obtain the items in the cart
				var theitemsincart = document.getElementById("itemsincart").value;
				//split to individual products
				const myArrayOfItems = theitemsincart.split("*");

				//obtain itemcode and qtyreq pair
				var productstring = '';
				for (i = 0; i < item_count; i++) {
					//alert(myArrayOfItems[i]);
					var theqty = document.getElementById('qty' + myArrayOfItems[i]).value;
					//alert('The quantity'+theqty);
					productstring = productstring + '&item' + i + '=' + myArrayOfItems[i] + '&itemqty' + i + '=' + theqty;
				}
				//alert('Product String '+productstring);

				getpagestring = 'makerequisition.php?op=saverequisition';
				var $form_selectloccd = $('#selectloccd').val();
				getpagestring = getpagestring + '&selectloccd=' + $form_selectloccd;

				if ($form_trantype == 4) {
					var $form_selectrcvloc = $('#selectrcvloc').val();
					getpagestring = getpagestring + '&selectrcvloc=' + $form_selectrcvloc;
				}

				var $form_custno = $('#custno').val();
				var $form_company = $('#company').val();
				var $form_bu = $('#bu').val();
				var $form_salespsn = $('#salespsn').val();
				var $form_reqrem = $('#reqrem').val();

				getpagestring = getpagestring + '&custno=' + $form_custno + '&company=' + $form_company + '&bu=' + $form_bu;
				getpagestring = getpagestring + '&salespsn=' + $form_salespsn + '&reqrem=' + $form_reqrem + '&item_count=' + item_count;
				getpagestring = getpagestring + '&promo=' + $form_promo + '&disctype=' + $form_disctype;
				getpagestring = getpagestring + productstring;

				//alert('the getpage string '+getpagestring);

				getpage(getpagestring, 'page');


			} else {
				alert('Cannot Save This Requisition');
			}

		}
	}


	function myremoveitem(clicked) {

		if (confirm('Are you sure of this action?')) {

			var therowid = clicked.substring(3);
			var row = document.getElementById(therowid);
			row.parentNode.removeChild(row);


			var thehiddenproducttextbox = document.getElementById('product' + therowid);
			var thehiddencosttextbox = document.getElementById('cost' + therowid);
			var thehiddenqtytextbox = document.getElementById('qty' + therowid);

			//obtain cost
			var productcost = thehiddencosttextbox.value;

			thehiddenproducttextbox.parentNode.removeChild(thehiddenproducttextbox);
			thehiddencosttextbox.parentNode.removeChild(thehiddencosttextbox);
			thehiddenqtytextbox.parentNode.removeChild(thehiddenqtytextbox);

			alert(therowid + ' Product Line Item Removed');

			var addeditems = document.getElementById("itemsincart");
			var thevalue = addeditems.value;


			var newvalue = thevalue.replace(therowid + '*', '');
			//alert(newvalue);
			addeditems.value = newvalue;


			//var obtaincost = document.getElementById('cost'+therowid);


			//substract from total cost
			var add_to_total_cost = document.getElementById("hold_totalcost");
			add_to_total_cost.value = Number(add_to_total_cost.value) - Number(productcost);

			//deduct from number of items in cart
			var item_count = document.getElementById("no_itemsincart");

			item_count.value = Number($('#no_itemsincart').val()) - 1;
		}
	}




	function Mygetdiscount(item) {
		//determine the type of discount and obtain discount
		var thediscount = 0;
		//obtain movement code
		var $movementcode = $('#mv').val();
		//obtain base price
		if ($movementcode == 'SC') {
			var $baseprice = $('#' + item + '_the_scprice').val();
		} else {
			var $baseprice = $('#' + item + '_the_otprice').val();
		}

		//obtain volume factor
		var $volumefactor = $('#' + item + '_volfactor').val();

		//obtain the quantity
		var $theqty = $('#productqty').val();


		if (document.getElementById('disctype3').checked) {

			//if promo was selected, check if the promo slab is empty or not
			var x = document.getElementById('selectpromo');

			if (x.value == '') {
				alert('Warning!, Please select a Promo');
			}
		}


		if (document.getElementById('disctype1').checked) {
			//obtain product default discount
			var $product_disc_type = $('#' + item + '_the_disc_type').val();
			//1 is flat, 3 is %, 2 is slab

			if ($product_disc_type == 1) {
				thediscount = $('#' + item + '_the_flat').val();
			} else if ($product_disc_type == 3) {
				var $percentdisc = $('#' + item + '_the_cent').val();
				thediscount = Number($baseprice) * (Number($percentdisc) / 100);
				alert($percentdisc);
			} else {
				var $slabdisc = $('#' + item + '_the_slab').val();
				//obtain the volume of the product
				var thevolume = Number($volumefactor) * Number($theqty);

				//obtain the lower and upper bounds of the slab
				thediscount = obtainslabdiscount($slabdisc, thevolume, $baseprice);
			}
		}


		if (document.getElementById('disctype2').checked) {
			//check if special discount exists for this customer
			var count_custpric = $('#count_custpric').val();
			if (Number(count_custpric) != 0) {
				//obtain product default discount
				var $customer_disc_type = $('#' + item + 'custpric_disctype').val();
				//1 is flat, 2 is slab

				if (Number($customer_disc_type) == 1) {
					//get service charge
					custpric_srvchg = $('#' + item + 'custpric_srvchg').val();
					//get dealer margin
					custpric_dmargin = $('#' + item + 'custpric_dmargin').val();
					//get dealer nfr
					custpric_nfr = $('#' + item + 'custpric_nfr').val();
					//get dealer Misc
					custpric_misc = $('#' + item + 'custpric_misc').val();

					thediscount = -1 * (Number(custpric_srvchg) - Number(custpric_dmargin) + Number(custpric_nfr) + Number(custpric_misc));
				} else {
					var $slabdisc = $('#' + item + 'custpric_slabid').val();
					//obtain the volume of the product
					var thevolume = Number($volumefactor) * Number($theqty);

					//obtain the lower and upper bounds of the slab
					thediscount = obtainslabdiscount($slabdisc, thevolume, $baseprice);
				}
			} else {
				alert('Customer Specific Discount Not Found');
			}
		}


		if (document.getElementById('disctype3').checked) {
			var x = $('#selectpromo').val();

			if (x != '') {
				//obtain the slabid
				//split to individual products
				const myArrayOfSlabs = x.split("*");
				var $slabdisc = myArrayOfSlabs[0];
				//obtain the volume of the product
				var thevolume = Number($volumefactor) * Number($theqty);

				//obtain the lower and upper bounds of the slab
				thediscount = obtainslabdiscount($slabdisc, thevolume, $baseprice);

			}


		}

		return thediscount;
	}

	function myAddItem() {
		var $form_productqty = $('#productqty').val();
		// var $form_productprice = $('#productprice').val();
		var $form_selectproduct = $('#selectproduct').val();
		let $addrow = 1;
		//alert($form_productqty);
		$('#mv').css('pointer-events', 'none');

		// alert(trim$form_productqty));
		if ($form_productqty == '') {
			$addrow = $addrow * 0;
		}
		//if ($form_productprice==''){$addrow = $addrow * 0;}
		if ($form_selectproduct == '') {
			$addrow = $addrow * 0;
		}

		if ($addrow == 1) {
			var $pos = $form_selectproduct.indexOf("*");
			var $itemcode = $form_selectproduct.substring(0, $pos);
			var $itemdescription = $form_selectproduct.substring($pos + 1);

			//Attempt to get the product element using document.getElementById
			var element = document.getElementById("product" + $itemcode);

			//If it isn't "undefined" and it isn't "null", then it exists.
			if (typeof(element) != 'undefined' && element != null) {
				alert('Product already added!');
			} else {


				var $is_price_valid = $('#' + $itemcode + '_pricevalidornot').val();

				//alert($is_price_valid+' Should be Yes or No');

				//obtain movement code
				var $movementcode = $('#mv').val();
				//obtain base price
				if ($movementcode == 'SC') {
					var $baseprice = $('#' + $itemcode + '_the_scprice').val();
				} else {
					var $baseprice = $('#' + $itemcode + '_the_otprice').val();
				}

				//obtain volume factor
				var $volumefactor = $('#' + $itemcode + '_volfactor').val();

				// Checking if customer has a special discount or approval definition else use business category pricing policy
				//do later
				//alert($itemcode);
				var $discount = Mygetdiscount($itemcode);
				//var $discount = 0;
				var $discountedunitprice = $baseprice - $discount;

				//obtain vat
				var $vat = $('#' + $itemcode + '_vat').val();

				var $vatduprice = $discountedunitprice * $vat / 100;
				var $price = $discountedunitprice + $vatduprice;
				var $disctax = $vat - $discount;
				var $cost = $form_productqty * $price;
				var $thevolume = $form_productqty * $volumefactor;

				if ($is_price_valid == 'Yes') {
					//add the control
					var container = document.getElementById("items_in_cart");
					//purpose is to track  items while adding
					var $control_to_add = '<input type="hidden" id="product' + $itemcode + '" name ="product' + $itemcode + '" value="' + $itemcode + '" />';
					var $control_cost = '<input type="hidden" id="cost' + $itemcode + '" name ="cost' + $itemcode + '" value="' + $cost + '" />';
					var $control_req_qty = '<input type="hidden" id="qty' + $itemcode + '" name ="qty' + $itemcode + '" value="' + $form_productqty + '" />';

					container.innerHTML += $control_to_add;
					container.innerHTML += $control_cost;
					container.innerHTML += $control_req_qty;

					//to identify items_in_cart for processing
					var addeditems = document.getElementById("itemsincart");
					addeditems.value += $itemcode + '*';

					//add to total cost
					var add_to_total_cost = document.getElementById("hold_totalcost");
					add_to_total_cost.value = Number(add_to_total_cost.value) + $cost;

					var no_of_addeditems = document.getElementById("no_itemsincart");

					no_of_addeditems.value = Number($('#no_itemsincart').val()) + 1;

					//var $therowid = Number($('#no_itemsincart').val());

					var table = document.getElementById("productlistTable");
					var row = table.insertRow();
					row.id = $itemcode;
					var cell1 = row.insertCell(0);
					var cell2 = row.insertCell(1);
					var cell3 = row.insertCell(2);
					var cell4 = row.insertCell(3);
					var cell5 = row.insertCell(4);
					var cell6 = row.insertCell(5);
					var cell7 = row.insertCell(6)
					var cell8 = row.insertCell(7);
					var cell9 = row.insertCell(8);
					var cell10 = row.insertCell(9)

					//cell1.innerHTML = $therowid;
					cell2.innerHTML = '&nbsp;&nbsp;' + $itemcode + '&nbsp;&nbsp;';
					cell3.innerHTML = $itemdescription + '&nbsp;&nbsp;';
					cell4.innerHTML = $form_productqty;
					cell5.innerHTML = $baseprice;
					cell6.innerHTML = $price;
					cell7.innerHTML = $thevolume;
					cell8.innerHTML = $disctax;
					cell9.innerHTML = $cost;
					var $forbutton = '<input type="button" id="but' + $itemcode + '" onclick="myremoveitem(this.id);" value="X"/>';
					cell10.innerHTML = $forbutton;


				} else {
					alert('Price is no longer Valid');
				}

			}


		}



	}
</script>