<?php 
	ob_start();
	include_once "session_track.php";
?>

<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align ="center" id="data-form" > 
	<input type="button" name="closebutton" id="submit-button" title="Close"  value="Close" onclick="javascript:  $('#data-form').hide();">	
	<?php 
		require_once("lib/mfbconnect.php"); 
		
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong><font size='5'>Approval for Release of Product 
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
		</font></strong></h3>
		<?php
			if ($_SESSION['approval']==1){
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$branch_code = "";
			$periodyear = $_SESSION['periodyear'];
			$periodmonth = $_SESSION['periodmonth'];
			$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
			$request = !isset($_REQUEST['request'])?'':$_REQUEST['request'];
			$company = !isset($_REQUEST['company'])?'':$_REQUEST['company'];
			$apprem = !isset($_REQUEST['apprem'])?"":$_REQUEST['apprem'];
			$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
			$trantype = !isset($_SESSION['trantype'])?0:$_SESSION['trantype'];
			
			$count_getpmtdetails = 0;
			
			//echo $op;
			if($op=='searchkeyword'){
				$sql_request = "select *  from headdata where request  like '%".trim($keyword)."%' and trantype = $trantype " ;
				//echo $sql_request;
				$result_request = mysqli_query($_SESSION['db_connect'],$sql_request);
				$count_request = mysqli_num_rows($result_request);
				if ($count_request >=1){
					$row = mysqli_fetch_array($result_request);
					$request= $row['request'];
					
				}else 	
				{
				?>
					<script>
					
					$('#item_error').html("<strong>Requisition does not exist</strong>");
					</script>
				<?php	
				}	
			}	
	
			//retrieve requisition	
			
			$sql_getrequest = "select *  from headdata where trim(request) = '".trim($request)."'  and trantype = $trantype " ;
						
			$result_getrequest = mysqli_query($_SESSION['db_connect'],$sql_getrequest);
			$count_getrequest = mysqli_num_rows($result_getrequest);
			if ($count_getrequest >=1){
				$row = mysqli_fetch_array($result_getrequest);
				$request= $row['request'];
				$custno= $row['custno'];
				$ccompany= $row['ccompany'];
				$approval= $row['approval'];
				$approval1= $row['approval1'];
				$loccd= $row['loccd'];
				$loc_name= $row['loc_name'];
				$rcvloc= $row['rcv_locnm'];
				$py= $row['py'];
				$mv= $row['mv'];
				$bu= $row['bu'];
				$reqrem= $row['reqrem'];
				if ($apprem==''){$apprem= $row['apprem'];}
				$approve_ok= $row['approve_ok'];
				$refuse= $row['refuse'];
				$loc_date = $row['loc_date'];
				$appr_date= $row['appr_date'];
				$salespsn = $row['salespsn'];
				$total_cost = $row['total_cost'];
				$reqst_by = $row['reqst_by'];
			
			}else 	
			{
				$custno= '';
				$ccompany= '';
				$approval= '';
				$approval1= '';
				$loccd= '';
				$loc_name= '';
				$rcvloc= '';
				$py= '';
				$mv= '';
				$bu= '';
				$reqrem= '';
				$approve_ok= 0;
				$refuse= 0;
				$loc_date = '';
				$loc_date = '';
				$appr_date= '';
				$salespsn = '';
				$total_cost = 0;
				$reqst_by = '';
			
			}	
			
	// retrieve product		
			
			$sql_products =  "SELECT item,itemdesc, qty_asked, price, cost, qty_booked,request FROM loadings " .
			" where trim(request) = '" . trim($request)."'";
							
			$result_products = mysqli_query($_SESSION['db_connect'],$sql_products);
			$count_products = mysqli_num_rows($result_products);
				
			//***get pmt usage based on this requisition
			
			$sql_getpmtusage = "select *  from paymentsuse where trim(request) = '".trim($request)."'";
							
			$result_getpmtusage = mysqli_query($_SESSION['db_connect'],$sql_getpmtusage);
			$count_getpmtusage = mysqli_num_rows($result_getpmtusage);
			if ($count_getpmtusage >=1){
				$row = mysqli_fetch_array($result_getpmtusage);
				$getpaymentdetails = 1;
				$invoice_no= $row['invoice_no'];
				$payments= $row['payments'];
				$refno1= $row['refno1'];
				$amtused1= $row['amtused1'];
				$refno2= $row['refno2'];
				$amtused2= $row['amtused2'];
				$refno3= $row['refno3'];
				$amtused3= $row['amtused3'];
				$refno4= $row['refno4'];
				$amtused4= $row['amtused4'];
				$refno5= $row['refno5'];
				$amtused5= $row['amtused5'];
				
				//		**VARIABLE TO BE USED IN $ STATEMENT
				$refnovar = "'".$refno1 . "','" . $refno2 . "','" .$refno3 . "','" .
								$refno4 . "','" . $refno5 ."'";

		
				//		&& RETRIEVING detail PAYMENTS REFERENCES USED IN THIS TRANSACTION
				$sql_getpmtdetails = "SELECT a.refno, a.amount, a.amtused, a.bank_code, a.dd_no," .
									" a.dd_date FROM payments a where a.advrefund1 = 1 and trim(a.refno) in (" . $refnovar . ")";				
				
				//echo 	$sql_getpmtdetails;		
				$result_getpmtdetails = mysqli_query($_SESSION['db_connect'],$sql_getpmtdetails);
				$count_getpmtdetails = mysqli_num_rows($result_getpmtdetails);				
				
			}
			else {
				$getpaymentdetails = 0;
				$invoice_no= '';
				$payments= 0.0;
				$refno1= '';
				$amtused1= 0.0;
				$refno2= '';
				$amtused2= 0;
				$refno3= '';
				$amtused3= 0;
				$refno4= '';
				$amtused4= 0;
				$refno5= '';
				$amtused5= 0;
			}


	
			if($op=='approving'){
				
				if ($apprem==''){
					?>	
							<script>
								$('#item_error').html("<strong>Please enter remark.</strong>");
							</script>
						<?php 
						
				}
				else 
				{
					if ($approve_ok==1){
					?>	
							<script>
								$('#item_error').html("<strong>Already approved.</strong>");
							</script>
						<?php 
						
					}
					else 
					{
						
						//obtain the two character code based on requisition location
						$mapproval = $request;
						$mloccd = '';
						$sql_xchar2 = "SELECT xchar2 FROM lmf  WHERE trim(loccd) = '" . $loccd . "'";
						$result_xchar2 = mysqli_query($_SESSION['db_connect'],$sql_xchar2);
						$count_xchar2 = mysqli_num_rows($result_xchar2);
						
						if ($count_xchar2 >=1){
							$row = mysqli_fetch_array($result_xchar2);
							$mloccd = $row['xchar2'];
						}
						
						$mapproval= $mloccd . $mv . $mapproval;
						
						$querystr = "update headdata set " .
									" approval = '" . $mapproval . "', approve_ok = 1, prn = 0 ";
									
									


						//&& RE- APPROVING
						if ($refuse == 1) {
							$querystr =	$querystr . ", reapp_date = '" . date("d/m/Y h:i:s A") . "', reapprby = '" . $_SESSION['username_sess'] . "'";
						}
						else
						{
							$querystr =	$querystr . ", appr_date = '" . date("d/m/Y h:i:s A") . "', appvd_by = '" . $_SESSION['username_sess'] . "'";

						}
						$querystr =	$querystr . ", apprem = '" . $apprem . "', refuse = 0, modified = 1" .
											" WHERE trim(request) = '" . $request . "'" ;
						
						$result_querystr = mysqli_query($_SESSION['db_connect'],$querystr);
						//echo $querystr;
							?>	
								<script>
									$('#item_error').html("<strong>Done</strong>");
								</script>
							<?php 
							

						$savetrail = $dbobject->apptrail($_SESSION['username_sess'],'Web Approval Portal',$request,date("d/m/Y h:i:s A"),'Approved');
						$dbobject->workflow($_SESSION['username_sess'],'Requisition Created, Requisition Approved',$request,date('d/m/Y H:i:s A'),0,2,'');
					}
				}
			}
//****			
			
			if($op=='refusing')
			{
				
				if ($apprem==''){
					?>	
							<script>
								$('#item_error').html("<strong>Please enter remark.</strong>");
							</script>
						<?php 
						
				}
				else 
				{
					if ($refuse==1)
					{
						?>	
							<script>
								$('#item_error').html("<strong>Already Cancelled.</strong>");
							</script>
						<?php 
						
					}
					else 
					{
						// check if loading slip has been generated on this requisition or not
						
						$sql_qty_booked = "select * from loadings where trim(request) = '$request' and qty_booked > 0 " ;

						$result_qty_booked = mysqli_query($_SESSION['db_connect'],$sql_qty_booked);
						
						$count_qty_booked = mysqli_num_rows($result_qty_booked);
						
						if ($count_qty_booked == 0)
						{
							
						
						
							$querystr = "update headdata set " .
									" approve_ok = 0, refuse = 1, logsysappr = '" . $_SERVER['REMOTE_ADDR'] . "'" .
									" , apprem = '" . $apprem . '(Refused)' . "'" .
									", refused_by = '" . $_SESSION['username_sess'] . "'".
									" , refused_dt = '" . date("d/m/Y h:i:s A") . "'".
									", approval = '" . 'Not Approved' . "', modified = 1" .
									" where trim(request) = '" . $request . "'";

							$result_querystr = mysqli_query($_SESSION['db_connect'],$querystr);
		

							//&& not stock transfer
							if ($custno <>'99900999') 
							{ 
								if ( $py == 'CA')			
								{
								//&&& reverting previous payment references if editing record				
								/*	$querypmtuse = "update paymentsuse set ".
												" payments = 0, refno1 = '', refno2 = '',refno3 = '',refno4 = '',refno5 = ''" .
												" ,amtused1 = 0 ,amtused2 = 0 , amtused3 = 0 ,amtused4 = 0 ,amtused5 = 0 ".
												" where trim(request) = '" . $request . "'"; */
												
								//	$querypmtuse = "delete from paymentsuse where trim(request) = '" . $request . "'";			

								//	$result_querystr = mysqli_query($_SESSION['db_connect'],$querypmtuse);

		

									//&&&CURRENT
									if (trim($refno1)!=''){
										$querypayments1 = "update payments set ".
												" amtused =  amtused - " . $amtused1 .
												" where trim(refno) = '" . trim($refno1) . "'";
										
										$result_querystr = mysqli_query($_SESSION['db_connect'],$querypayments1);
										
										
										//				***Update payment usage voidedamt field
										$sql_updatePaymentuse = "update paymentsuse set voidedamt1 = $amtused1,amtused1 = amtused1 - $amtused1
											  WHERE trim(request) = '$request' and TRIM(refno1) = '" . trim($refno1) . "'";

										$result_updatePaymentuse = mysqli_query($_SESSION['db_connect'],$sql_updatePaymentuse);
										
										
										$sql_CreateJournal1 = "call CreateJournalEntries('UNDOPAYMENTS_RECONCILIATION','$custno','$ccompany',$amtused1,'" .date("d/m/Y h:i:s A") . "','$periodmonth','$periodyear')";
										$result_CreateJournal1 = mysqli_query($_SESSION['db_connect'],$sql_CreateJournal1);	
										$queryconst1 = "update const set ".
												" pmtsusacct =  pmtsusacct + " . $amtused1 .
												" where 1 = 1";
												
										$result_querystr = mysqli_query($_SESSION['db_connect'],$queryconst1);
									}
									
									if (trim($refno2)!=''){			
										$querypayments2 = "update payments set ".
													" amtused =  amtused - " . $amtused2 .
													" where trim(refno) = '" . trim($refno2) . "'";	
										$result_querystr = mysqli_query($_SESSION['db_connect'],$querypayments2);	


										//				***Update payment usage voidedamt field
										$sql_updatePaymentuse = "update paymentsuse set voidedamt2 = $amtused2,amtused2 = amtused2 - $amtused2
											  WHERE trim(request) = '$request' and TRIM(refno2) = '" . trim($refno2) . "'";

										$result_updatePaymentuse = mysqli_query($_SESSION['db_connect'],$sql_updatePaymentuse);
											
										$sql_CreateJournal2 = "call CreateJournalEntries('UNDOPAYMENTS_RECONCILIATION','$custno','$ccompany',$amtused2,'" .date("d/m/Y h:i:s A") . "','$periodmonth','$periodyear')";
										$result_CreateJournal2 = mysqli_query($_SESSION['db_connect'],$sql_CreateJournal2);			
										
										$queryconst2 = "update const set ".
												" pmtsusacct =  pmtsusacct + " . $amtused2 .
												" where 1 = 1";		
										$result_querystr = mysqli_query($_SESSION['db_connect'],$queryconst2);	
									}			

									if (trim($refno3)!=''){
										$querypayments3 = "update payments set ".
													" amtused =  amtused - " . $amtused3 .
													" where trim(refno) = '" . trim($refno3) . "'";	
										$result_querystr = mysqli_query($_SESSION['db_connect'],$querypayments3);
										
										
										//				***Update payment usage voidedamt field
										$sql_updatePaymentuse = "update paymentsuse set voidedamt3 = $amtused3,amtused3 = amtused3 - $amtused3
											  WHERE trim(request) = '$request' and TRIM(refno1) = '" . trim($refno3) . "'";

										$result_updatePaymentuse = mysqli_query($_SESSION['db_connect'],$sql_updatePaymentuse);
										
										$sql_CreateJournal3 = "call CreateJournalEntries('UNDOPAYMENTS_RECONCILIATION','$custno','$ccompany',$amtused3,'" .date("d/m/Y h:i:s A") . "','$periodmonth','$periodyear')";
										$result_CreateJournal3 = mysqli_query($_SESSION['db_connect'],$sql_CreateJournal3);	

										$queryconst3 = "update const set ".
												" pmtsusacct =  pmtsusacct + " . $amtused3 .
												" where 1 = 1";
										
										$result_querystr = mysqli_query($_SESSION['db_connect'],$queryconst3);		
									}
									
									
									if (trim($refno4)!=''){
										$querypayments4 = "update payments set ".
													" amtused =  amtused - " . $amtused4 .
													" where trim(refno) = '" . trim($refno4) . "'";	
										$result_querystr = mysqli_query($_SESSION['db_connect'],$querypayments4);
										
										//				***Update payment usage voidedamt field
										$sql_updatePaymentuse = "update paymentsuse set voidedamt4 = $amtused4,amtused4 = amtused4 - $amtused4
											  WHERE trim(request) = '$request' and TRIM(refno4) = '" . trim($refno4) . "'";

										$result_updatePaymentuse = mysqli_query($_SESSION['db_connect'],$sql_updatePaymentuse);
										
										$sql_CreateJournal4 = "call CreateJournalEntries('UNDOPAYMENTS_RECONCILIATION','$custno','$ccompany',$amtused4,'" .date("d/m/Y h:i:s A") . "','$periodmonth','$periodyear')";
										$result_CreateJournal4 = mysqli_query($_SESSION['db_connect'],$sql_CreateJournal4);		
										
										$queryconst4 = "update const set ".
												" pmtsusacct =  pmtsusacct + " . $amtused4 .
												" where 1 = 1";

										$result_querystr = mysqli_query($_SESSION['db_connect'],$queryconst4);
									}
									
									
									if (trim($refno5)!=''){
										$querypayments5 = "update payments set ".
													" amtused =  amtused - " . $amtused5 .
													" where trim(refno) = '" . trim($refno5) . "'";	
										$result_querystr = mysqli_query($_SESSION['db_connect'],$querypayments5);
										
										//				***Update payment usage voidedamt field
										$sql_updatePaymentuse = "update paymentsuse set voidedamt5 = $amtused5,amtused5 = amtused5 - $amtused5
											  WHERE trim(request) = '$request' and TRIM(refno5) = '" . trim($refno5) . "'";

										$result_updatePaymentuse = mysqli_query($_SESSION['db_connect'],$sql_updatePaymentuse);
										
										$sql_CreateJournal5 = "call CreateJournalEntries('UNDOPAYMENTS_RECONCILIATION','$custno','$ccompany',$amtused5,'" .date("d/m/Y h:i:s A") . "','$periodmonth','$periodyear')";
										$result_CreateJournal5 = mysqli_query($_SESSION['db_connect'],$sql_CreateJournal5);
										
										$queryconst5 = "update const set ".
												" pmtsusacct =  pmtsusacct + " . $amtused5 .										
												" where 1 = 1";
										$result_querystr = mysqli_query($_SESSION['db_connect'],$queryconst5);
									}
								}
								else
								{

									if ($py == 'CR')
									{
										$queryStr = "update arcust set ".
													" totcrtrans =  totcrtrans - " . $total_cost .
													" where trim(custno) = '" . $custno . "'";

										// &&& reverting
										$result_querystr = mysqli_query($_SESSION['db_connect'],$queryStr);	
										
									}
								}
								
								$queryStr = "update arcust set ".
													" custbal =  custbal - " . $total_cost .
													" where trim(custno) = '" . $custno . "'";

								// &&& reverting
								$result_querystr = mysqli_query($_SESSION['db_connect'],$queryStr);	

							}
							
							$sql_CreateJournalR = "call CreateJournalEntries('UNDOREQUISITION','$custno','$ccompany'," . $total_cost . ",'". date("d/m/Y h:i:s A") .
									 "','$periodmonth','$periodyear')";
							
							$result_CreateJournalR = mysqli_query($_SESSION['db_connect'],$sql_CreateJournalR);		 

								?>	
									<script>
										$('#item_error').html("<strong>Request Cancelled</strong>");
									</script>
								<?php 
								

							$savetrail = $dbobject->apptrail($_SESSION['username_sess'],'Web Approval Portal',$request,date("d/m/Y h:i:s A"),'Refused');
							$dbobject->workflow($_SESSION['username_sess'],'Requisition Created, Requisition Cancelled',$request,date('d/m/Y H:i:s A'),0,2,'');
						}else {
							?>	
								<script>
									$('#item_error').html("<strong>This Requisition cannot be Cancelled.</strong>");
								</script>
							<?php 
							
						}
					
					}
					
				}
			}
//****		
		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="approvals" />
		<input type="hidden" name="get_file" id="get_file" value="fastapproval" />
		<style>
			td {padding:1px;}
		</style>
		<table border ="0" >
			
			<tr>
				<td colspan="4">
					<input type="text" size="50px" id="search" title="Type to search Requisition" placeholder="Search Requisition by Name or Code" />
					<input name="keyword" type="hidden" class="table_text1"  id="keyword" value="<?php echo $keyword; ?>" />
				</td> 
			</tr>
			<tr>
				<td><strong>Request No :</strong></td>
				<td >
					<input type="text" style="background:transparent;border:none;" tabindex="-1" name="request" id="request" value="<?php echo $request; ?>" class="required-text" readonly >
				</td>
				<td >
					<strong>Req. Time:</strong>
				</td>
				<td nowrap="nowrap"> <?php echo "  " . $loc_date; ?> </td>
			</tr>
			<tr>
				<td colspan="4">
					
					<!-- Suggestions will be displayed in below div. -->
					   <div id="display"></div>
				</td> 
			</tr>
			<tr>
				<td><strong>Customer: </strong></td>
				<td align="left">
					<?php echo $custno . ": ". $ccompany; ?> 
				</td>
				<td><strong>Remark :</strong>
					<?php echo $reqrem; ?> 
				</td>
				<td><strong>Reqst_By :</strong>
					<?php echo $reqst_by; ?></td>
			</tr>
			<tr>
				<td><strong>Approval No: </strong></td>
				<td align="left">
					<?php echo $approval1 . $approval; ?> 
				</td>
				<td><strong>Remark :</strong>
					<?php echo $apprem; ?> 
				</td>
				<td nowrap="nowrap"><strong>Time:</strong> <?php echo "  " . $appr_date; ?> </td>
				
			</tr>			
		</table>
		<hr>
		<br>
		<strong>Products</strong>
		<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
			<thead>
				<tr class="right_backcolor">
					<th nowrap="nowrap" class="Corner">&nbsp;</th>
					<th nowrap="nowrap" class="Odd">S/N</th>
					<th nowrap="nowrap" class="Odd">Item</th>
					<th nowrap="nowrap" class="Odd">Description</th>
					<th nowrap="nowrap" class="Odd">Quantity</th>
					<th nowrap="nowrap" class="Odd">Price</th>
					<th nowrap="nowrap" class="Odd">Cost</th>
					<th nowrap="nowrap">&nbsp;</th>
				</tr>
			</thead>
			<?php 
				$k = 0;

				while($k<$count_products) 
				{
					$k++;
					$row = mysqli_fetch_array($result_products);

			?>
			
					<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
						<td nowrap="nowrap">&nbsp;</td>
						<td nowrap="nowrap"><?php echo $k;?></td>
						<td nowrap="nowrap"><?php echo $row['item'];?></td>
						<td nowrap="nowrap"><?php echo $row["itemdesc"];?></td>
						<td nowrap="nowrap" align="right"><?php echo $row["qty_asked"];?></td>
						<td nowrap="nowrap" align="right"><?php echo $row["price"];?></td>
						<td nowrap="nowrap" align="right"><?php echo $row["cost"];?></td>
						<td nowrap="nowrap"></td>
					</tr>
			<?php 
					//} //End For Loop
				} //End If Result Test	
			?>
		</table>
		<br>
		<table border="1">
			<tr>
				<td>
					<strong>Payment References</strong>
					<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
						<thead>
							<tr class="right_backcolor">
								<th nowrap="nowrap" class="Corner">&nbsp;</th>
								<th nowrap="nowrap" class="Odd">Pmt References</th>
								<th nowrap="nowrap" class="Odd">Amount Referenced</th>
								<th nowrap="nowrap">&nbsp;</th>
							</tr>
						</thead>

						
								<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
									<td nowrap="nowrap">&nbsp;</td>
									<td nowrap="nowrap">
										<?php echo $refno1;?><br>
										<?php echo $refno2;?><br>
										<?php echo $refno3;?><br>
										<?php echo $refno4;?><br>
										<?php echo $refno5;?> <br>
										<strong>Total</strong>
									</td>
									<td nowrap="nowrap" align="right">
										<?php echo $amtused1;?> <br>
										<?php echo $amtused2;?> <br>
										<?php echo $amtused3;?> <br>
										<?php echo $amtused4;?> <br>
										<?php echo $amtused5;?> <br>
										<strong><?php echo $payments;?> </strong>
									</td>
									<td nowrap="nowrap"></td>
								</tr>

					</table>		
				</td>
				<td>
					<strong>Payment Instrument Details</strong>
					<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
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

							while($k<$count_getpmtdetails) 
							{
								$k++;
								$row = mysqli_fetch_array($result_getpmtdetails);

						?>
						
								<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
									<td nowrap="nowrap">&nbsp;</td>
									<td nowrap="nowrap">&nbsp;<?php echo $k;?></td>
									<td nowrap="nowrap">&nbsp;<?php echo $row['refno'];?></td>
									<td nowrap="nowrap">&nbsp;<?php echo number_format($row["amount"],2);?></td>
									<td nowrap="nowrap" align="right">&nbsp;<?php echo number_format($row["amtused"],2);?></td>
									<td nowrap="nowrap" align="right">&nbsp;<?php echo number_format($row["amount"]-$row["amtused"],2);?></td>
									<td nowrap="nowrap">&nbsp;</td>
								</tr>
						<?php 
								//} //End For Loop
							} //End If Result Test	
						?>
					</table>
				</td>
			</tr>
		</table>
		<br>
		<hr>
		<br>
		<table>
		  <tr>
				<td><strong>Remark :</strong></td>
				<td colspan="2" align="left">
					<input type="text" size="40px" name="apprem" id="apprem" value="<?php echo $apprem; ?>" class="required-text" >
				</td>

			</tr>
			<tr>
				<td  align="right" nowrap="nowrap">
					
					  <input type="button" name="approvebutton" id="submit-button" value="Approve" <?php if ($approve_ok==1 || $refuse==1){echo 'style="display:none"';} ?>
						onclick="javascript:
							if (confirm('Are you sure the entries are correct?')) {
									var $form_request = $('#request').val();  var $form_apprem = $('#apprem').val();
								getpage('fastapproval.php?op=approving&request='+$form_request+'&apprem='+$form_apprem,'page');
							}	
						">
					
				</td>
				
				<td nowrap="nowrap">
					
					  <input type="button" name="refusebutton" id="submit-button" value="Refuse" <?php if ( $refuse==1){echo 'style="display:none"';} ?>
						onclick="javascript:
							if (confirm('Do you really want to refuse this requisition?')) {
									var $form_request = $('#request').val();  var $form_apprem = $('#apprem').val();
								getpage('fastapproval.php?op=refusing&request='+$form_request+'&apprem='+$form_apprem,'page');
							}	
							">
					
				</td>
						
				<td nowrap="nowrap">
					
					<?php $calledby = 'fastapproval'; $reportid = 44; include("specificreportlink.php");  ?>
				
					
				</td>
			  
		  </tr>
		  <tr>
			<td colspan="3" style="color:red;" id = "item_error" align = "left"  ></td>
		  </tr>
		</table>

			<?php } ?>
	</form>
	<br/>
	  <input type="button" name="closebutton" id="submit-button" value="Back" 
						onclick="javascript:  getpage('s_and_d.php','page');
							">
	<br/>
</div>

