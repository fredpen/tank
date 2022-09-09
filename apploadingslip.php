<?php 
	ob_start();
	include_once "session_track.php";
	
	include "printheader.php";
?>

<style>
	table {
		  border-collapse: collapse;
		}
	@media screen {
			td {padding:5px;}
			.tableb {border-radius: 15px 50px; border-collapse: separate;border : 5px solid olive;}
			
			#print_table {
				display:none;
			}
	}
	
	@media print{
			#print, #head-inner,#smoothmenu1, .tableb, .noprint, .PrintButton{
				display:none;
			}
			#print_table {
				display:block;
			}
		
			
		}
</style>
<div  align ="center" id="data-form" > 

	<?php 
		require_once("lib/mfbconnect.php"); 


		
		
		$refno = !isset($_REQUEST['refno'])?'':$_REQUEST['refno'];
		
		$user = $_SESSION['username_sess'];
		//$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
		$op = !isset($_POST['operation'])?'not posted':$_POST['operation'];	
		
		$custno = !isset($_REQUEST['custno'])?'':$_REQUEST['custno'];
		$ccompany = !isset($_REQUEST['ccompany'])?'':$dbobject->test_input($_REQUEST['ccompany']);
		$firstname = !isset($_REQUEST['firstname'])?'':$dbobject->test_input($_REQUEST['firstname']);
		$othername = !isset($_REQUEST['othername'])?'':$dbobject->test_input($_REQUEST['othername']);
		$amount = !isset($_REQUEST['amount'])?0.0:$_REQUEST['amount'];
		$pmtdate = !isset($_REQUEST['pmtdate'])?date("Y-m-d"):$_REQUEST['pmtdate'];
		$descriptn = !isset($_REQUEST['descriptn'])?"":$_REQUEST['descriptn'];			
		
		$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
		$keyword_invoiceno = !isset($_REQUEST['keyword_invoiceno'])?"":$dbobject->test_input(trim($_REQUEST['keyword_invoiceno']));
		$keyword_receiptno = !isset($_REQUEST['keyword_receiptno'])?"":$dbobject->test_input(trim($_REQUEST['keyword_receiptno']));
		
		$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);	
		
		$express = !isset($_REQUEST['express'])?0:$dbobject->test_input($_REQUEST['express']);
		$iron_only = !isset($_REQUEST['iron_only'])?0:$dbobject->test_input($_REQUEST['iron_only']);
		$qtybooked = !isset($_REQUEST['qtybooked'])?0:$dbobject->test_input($_REQUEST['qtybooked']);
		$itemsbooked = !isset($_REQUEST['itemsbooked'])?0:$dbobject->test_input($_REQUEST['itemsbooked']);
		$starchlevel = !isset($_REQUEST['starchlevel'])?0:$dbobject->test_input($_REQUEST['starchlevel']);
		$d_regime = !isset($_REQUEST['d_regime'])?0:$dbobject->test_input($_REQUEST['d_regime']);
		$discount = !isset($_REQUEST['discount'])?0:$dbobject->test_input($_REQUEST['discount']);
		$disc_tcost = !isset($_REQUEST['disc_tcost'])?0:$dbobject->test_input($_REQUEST['disc_tcost']);
		$vat = !isset($_REQUEST['vat'])?0:$dbobject->test_input($_REQUEST['vat']);
		$vat_tcost = !isset($_REQUEST['vat_tcost'])?0:$dbobject->test_input($_REQUEST['vat_tcost']);
		$net_cost = !isset($_REQUEST['net_cost'])?0:$dbobject->test_input($_REQUEST['net_cost']);
		$total_tag_count = !isset($_REQUEST['total_tag_count'])?0:$dbobject->test_input($_REQUEST['total_tag_count']);
		
		
		$total_cost = !isset($_REQUEST['total_cost'])?0:$dbobject->test_input($_REQUEST['total_cost']);
		$invoice_no = !isset($_REQUEST['invoice_no'])?'':$dbobject->test_input($_REQUEST['invoice_no']);
		$slip_no = !isset($_REQUEST['slip_no'])?'':$dbobject->test_input($_REQUEST['slip_no']);
		$selectinvoiceno = !isset($_REQUEST['selectinvoiceno'])?'':$dbobject->test_input($_REQUEST['selectinvoiceno']);
		$selectreceiptno = !isset($_REQUEST['selectreceiptno'])?'':$dbobject->test_input($_REQUEST['selectreceiptno']);
		$pmtref = !isset($_REQUEST['pmtref'])?'':$dbobject->test_input($_REQUEST['pmtref']);
		$pmtrefamtused = !isset($_REQUEST['pmtrefamtused'])?0:$dbobject->test_input($_REQUEST['pmtrefamtused']);
		


		$invoice_details = Array();
		$sql_invoiceno = "SELECT a.invoice_no,a.invoice_dt,a.approval1,a.approval,a.custno,a.ccompany, 
			  a.loc_name,a.loccd,a.rcv_locnm,a.rcvloc,a.station,a.deliveryaddress,a.bu,a.mv, 
			  a.vehcno,a.tcompany,b.request,a.prn,a.reversed,a.py, 
			  b.item,b.itemdesc,b.store_qty,b.price,b.disc,b.duprice,b.vatduprice, 
			  b.drivername,b.loadername,b.mtr_b4,b.mtr_after,b.load_start, 
			  b.load_end,b.ull_name,b.ull_time,b.vol1,b.vol2,b.vol3,b.vol4,b.vol5,b.vol6, 
			  b.ullage1,b.ullage2,b.ullage3,b.ullage4,b.ullage5,b.ullage6,b.upseal_no1, b.upseal_no2, b.upseal_no3, b.upseal_no4, b.upseal_no5, b.upseal_no6, 
			  b.loseal_no1, b.loseal_no2, b.loseal_no3, b.loseal_no4, b.loseal_no5, b.loseal_no6, 
			  b.slip_no,b.slip_date,c.contact,c.phone1,c.phone2, c.address1, c.address2 FROM invoice  a,  inv_detl  b,arcust c  
			  WHERE trim(a.slip_no) = trim(b.slip_no) and trim(a.custno) = trim(c.custno)  
			  and TRIM(a.slip_no) = '$slip_no'";
		
		//echo "<br/>".$sql_invoiceno	."<br/>"	;
		$result_invoiceno = mysqli_query($_SESSION['db_connect'],$sql_invoiceno);
		$count_invoiceno = mysqli_num_rows($result_invoiceno);
		
		for ($w=0;$w<$count_invoiceno ;$w++)
		{
			$rowinv = mysqli_fetch_array($result_invoiceno);
			$invoice_details[$w]['invoice_no'] = $rowinv['invoice_no'];
			$invoice_details[$w]['invoice_dt'] = $rowinv['invoice_dt'];
			$invoice_details[$w]['approval1'] = $rowinv['approval1'];
			$invoice_details[$w]['approval'] = $rowinv['approval'];
			$invoice_details[$w]['custno'] = $rowinv['custno'];
			$invoice_details[$w]['ccompany'] = $rowinv['ccompany'];
			$invoice_details[$w]['phone1'] = $rowinv['phone1'];
			$invoice_details[$w]['phone2'] = $rowinv['phone2'];
			$invoice_details[$w]['contact'] = $rowinv['contact'];
			$invoice_details[$w]['loc_name'] = $rowinv['loc_name'];
			$invoice_details[$w]['loccd'] = $rowinv['loccd'];
			$invoice_details[$w]['rcv_locnm'] = $rowinv['rcv_locnm'];
			$invoice_details[$w]['rcvloc'] = $rowinv['rcvloc'];
			$invoice_details[$w]['station'] = $rowinv['station'];
			$invoice_details[$w]['deliveryaddress'] = $rowinv['deliveryaddress'];
			$invoice_details[$w]['bu'] = $rowinv['bu'];
			$invoice_details[$w]['mv'] = $rowinv['mv'];
			$invoice_details[$w]['vehcno'] = $rowinv['vehcno'];
			$invoice_details[$w]['tcompany'] = $rowinv['tcompany'];
			
			$invoice_details[$w]['request'] = $rowinv['request'];
			$invoice_details[$w]['prn'] = $rowinv['prn'];
			$invoice_details[$w]['reversed'] = $rowinv['reversed'];
			$invoice_details[$w]['py'] = $rowinv['py'];
			$invoice_details[$w]['item'] = $rowinv['item'];
			$invoice_details[$w]['itemdesc'] = $rowinv['itemdesc'];
			$invoice_details[$w]['store_qty'] = $rowinv['store_qty'];
			$invoice_details[$w]['price'] = $rowinv['price'];
			$invoice_details[$w]['disc'] = $rowinv['disc'];
			$invoice_details[$w]['duprice'] = $rowinv['duprice'];
			$invoice_details[$w]['vatduprice'] = $rowinv['vatduprice'];
			$invoice_details[$w]['drivername'] = $rowinv['drivername'];
			$invoice_details[$w]['loadername'] = $rowinv['loadername'];
			$invoice_details[$w]['mtr_b4'] = $rowinv['mtr_b4'];
			$invoice_details[$w]['mtr_after'] = $rowinv['mtr_after'];
			$invoice_details[$w]['load_start'] = $rowinv['load_start'];
			
			$invoice_details[$w]['load_end'] = $rowinv['load_end'];
			$invoice_details[$w]['ull_name'] = $rowinv['ull_name'];
			$invoice_details[$w]['ull_time'] = $rowinv['ull_time'];
			$invoice_details[$w]['vol1'] = $rowinv['vol1'];
			$invoice_details[$w]['vol2'] = $rowinv['vol2'];
			$invoice_details[$w]['vol3'] = $rowinv['vol3'];
			$invoice_details[$w]['vol4'] = $rowinv['vol4'];
			$invoice_details[$w]['vol5'] = $rowinv['vol5'];
			$invoice_details[$w]['vol6'] = $rowinv['vol6'];
			$invoice_details[$w]['ullage1'] = $rowinv['ullage1'];
			
			$invoice_details[$w]['ullage2'] = $rowinv['ullage2'];
			$invoice_details[$w]['ullage3'] = $rowinv['ullage3'];
			$invoice_details[$w]['ullage4'] = $rowinv['ullage4'];
			$invoice_details[$w]['ullage5'] = $rowinv['ullage5'];
			$invoice_details[$w]['ullage6'] = $rowinv['ullage6'];
			$invoice_details[$w]['slip_no'] = $rowinv['slip_no'];
			$invoice_details[$w]['slip_date'] = $rowinv['slip_date'];
			$invoice_details[$w]['address1'] = $rowinv['address1'];
			$invoice_details[$w]['address2'] = $rowinv['address2'];
			
			$invoice_details[$w]['upseal_no1'] = $rowinv['upseal_no1'];
			$invoice_details[$w]['upseal_no2'] = $rowinv['upseal_no2'];
			$invoice_details[$w]['upseal_no3'] = $rowinv['upseal_no3'];
			$invoice_details[$w]['upseal_no4'] = $rowinv['upseal_no4'];
			$invoice_details[$w]['upseal_no5'] = $rowinv['upseal_no5'];
			$invoice_details[$w]['upseal_no6'] = $rowinv['upseal_no6'];
			
			$invoice_details[$w]['loseal_no1'] = $rowinv['loseal_no1'];
			$invoice_details[$w]['loseal_no2'] = $rowinv['loseal_no2'];
			$invoice_details[$w]['loseal_no3'] = $rowinv['loseal_no3'];
			$invoice_details[$w]['loseal_no4'] = $rowinv['loseal_no4'];
			$invoice_details[$w]['loseal_no5'] = $rowinv['loseal_no5'];
			$invoice_details[$w]['loseal_no6'] = $rowinv['loseal_no6'];  
			
		}
		
		$sql_invoiceno_request = "SELECT distinct a.invoice_no, b.request FROM invoice  a,  inv_detl  b   
			  WHERE trim(a.slip_no) = trim(b.slip_no) and TRIM(a.slip_no) = '$slip_no'";
		
		//echo $sql_invoiceno	."<br/>".$sql_receiptno	;
		$result_invoiceno_request = mysqli_query($_SESSION['db_connect'],$sql_invoiceno_request);
		$count_invoiceno_request = mysqli_num_rows($result_invoiceno_request);
		
		$pmtref =''; $pmtrefamtused =0;
		for ($i=0;$i<$count_invoiceno_request;$i++)
		{
			$row_request = mysqli_fetch_array($result_invoiceno_request);
			$thepmtrequest = $row_request['request'];
				//get payment references
			$sql_pmtreference = "SELECT * FROM paymentsuse WHERE TRIM(request) = '$thepmtrequest' ";
			//echo 	"<br/>".$sql_pmtreference."<br/>"	;
			$result_pmtreference = mysqli_query($_SESSION['db_connect'],$sql_pmtreference);
			$numrows_pmtreference = mysqli_num_rows($result_pmtreference);
			//echo $sql_pmtreference;
			if ($numrows_pmtreference > 0)
			{
				
				$k=0;
				
				while ($k<$numrows_pmtreference)
				{
					$row_pmtreference= mysqli_fetch_array($result_pmtreference);
					$pmtref = trim($row_pmtreference['refno1'] ." " .$row_pmtreference['refno2']
							." " .$row_pmtreference['refno3']." " .$row_pmtreference['refno4']." " .$row_pmtreference['refno5']);
					
					
					$pmtrefamtused = $pmtrefamtused + $row_pmtreference['amtused1'];
					
					$pmtrefamtused = $pmtrefamtused + $row_pmtreference['amtused2'];
					
					$pmtrefamtused = $pmtrefamtused + $row_pmtreference['amtused3'];
					
					$pmtrefamtused = $pmtrefamtused + $row_pmtreference['amtused4'];
					
					$pmtrefamtused = $pmtrefamtused + $row_pmtreference['amtused5'];
					

					$k++;
				}
			}
		}
		
	
	?>

	<link rel="stylesheet" type="text/css" href="css/main.css"  media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css"  media="screen">
	<form action="" method="get" id="form1">
		<h3 class= "noprint"><strong><font size='12'>Print Loading Slip </font></strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false">Close Window</a>
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
		


			<?php if ($count_invoiceno > 0) { ?>
			<div id="print_table" >
			<table  border="0" width="100%" id="recpt" >
				<tr>
					<td align="center" colspan="8">
						<img width="10%" src="images/applogo1.jpeg"/>
					</td>
				</tr>	
				<tr>
					<td align="center" colspan="8">
						
						<font style="font-size:14"> <b>Loading Slip </b></font><br/>
						
						
					</td>
				</tr>
				<tr>
					<td align="center" colspan="8">
						<table border="1" width="100%">
							<tr>
								<td nowrap="nowrap" width="20%">
									<b>Loading Slip No : </b>
								</td>
								<td width="30%">
									<?php echo $slip_no; ?>
								</td>
								<td  width="20%">
									<b>Date :</b>
								</td>
								<td  width="30%">
									<?php echo $invoice_details[0]['slip_date']; ?>
								</td>
							</tr>		
						
							<tr>
								<td nowrap="nowrap" valign="top"> 
									<b>Customer : </b><br />
									<b>Address : </b><br />
									<b>Contact : </b><br />
									<b>Tel : </b>
									
								</td>
								<td  valign="top">
									<?php echo $invoice_details[0]['ccompany'];
											 echo  '<br />'.$invoice_details[0]['address1'];
											 echo  '<br />'.$invoice_details[0]['contact'];
											 echo  '<br />'.$invoice_details[0]['phone1']. " ".  $invoice_details[0]['phone2'];
									 ?>
								</td>
								<td nowrap="nowrap" valign="top">
									<b>Approval No :</b><br /><b>Supply location :</b><br /><b>Receiving Location :</b>
								</td>
								<td  valign="top">
									<?php echo $invoice_details[0]['approval1'] .$invoice_details[0]['approval'] .'<br />'.$invoice_details[0]['loc_name'] . '<br />'.$invoice_details[0]['rcv_locnm'] ; ?>
								</td>
							</tr>		
						
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="8">
						<table border="1" width="100%">
							<tr>
								<td width="15%" >
									<b>Req Reference</b>
								</td>
								<td  width="20%">
									<b>Product</b>
								</td>
								<td  width="15%">
									<b>Qty</b>
								</td>
								
							</tr>
						
							
							<?php $thetotalqty = 0; $thetotalcost = 0; for ($w=0;$w<$count_invoiceno ;$w++) { ?>
							<tr>
								<td >
									<?php echo $invoice_details[$w]['request']; ?>
								</td>
								<td>
									<?php echo $invoice_details[$w]['itemdesc']; ?>
								</td>
								<td >
									<?php echo $invoice_details[$w]['store_qty']; ?>
								</td>
								
							</tr>
							<?php  $thetotalqty = $thetotalqty + $invoice_details[$w]['store_qty']; $thetotalcost = $thetotalcost + $invoice_details[$w]['store_qty'] * $invoice_details[$w]['price'];        } ?>
							<tr>
								
								<td align="center" colspan="3">
									<b>Total Quantity</b> &nbsp;&nbsp;<?php echo $thetotalqty; ?>
									&nbsp;&nbsp;<?php echo " (".$dbobject->convert_number_to_words($thetotalqty).")"; ?>
								</td>
							</tr>
								
						
						</table>
					</td>
				</tr>
				
				
				<tr>
					<td align="center" colspan="8">
						<table border="1" width="100%">
							<tr>
								<td width="20%" >
									<b>Truck No :</b> 
								</td>
								<td width="30%" >
									<?php echo $invoice_details[0]['vehcno']; ?>
								</td>
								<td  nowrap="nowrap" >
									<b>Loader's Name :</b> 
								</td>
								<td  width="30%">
									<?php echo $invoice_details[0]['loadername']; ?>
								</td>
							</tr>	
							<tr>
								<td >
									<b>Driver's Name :</b> 
								</td>
								<td >
									<?php echo $invoice_details[0]['drivername']; ?>
								</td>
								<td >
									<b>Meter Before:</b> 
								</td>
								<td >
									<?php //echo $invoice_details[0]['mtr_b4']; ?>
								</td>
							</tr>	


							<tr>
								<td >
									<b>Transporter :</b> 
								</td>
								<td >
									<?php echo $invoice_details[0]['tcompany']; ?>
								</td>
								<td >
									<b>Meter After:</b> 
								</td>
								<td >
									<?php //echo $invoice_details[0]['mtr_after']; ?>
								</td>
							</tr>			
						
							<tr>
								<td  nowrap="nowrap">
									<b>Ticket Number :</b> 
								</td>
								<td  >
									<?php echo substr($invoice_details[0]['slip_no'],5,2).substr($invoice_details[0]['slip_no'],7,2).substr($invoice_details[0]['slip_no'],11); ?>
								</td>
								<td >
									<b>Time Loading Started:</b> 
								</td>
								<td >
									<?php //echo $invoice_details[0]['load_start']; ?>
								</td>
							</tr>
							<tr>
								<td colspan="2" >
									
								</td>
								
								<td >
									<b>Time Loading Ended:</b> 
								</td>
								<td >
									<?php //echo $invoice_details[0]['load_end']; ?>
								</td>
							</tr>
							
						
						</table>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="8">
						<table border="1" width="100%" >
							<tr>
								<td >
									<b>Ullager's Name :</b> 
								</td>
								<td colspan="2">
									<?php //echo $invoice_details[0]['ull_name']; ?>
								</td>
								<td >
									<b>Ullage Time:</b> 
								</td>
								<td  colspan="3">
									<?php //echo $invoice_details[0]['ull_time']; ?>
								</td>
							</tr>		
							
							<tr>
								<td  nowrap="nowrap"  >
									<b>Compactment No :</b> 
								</td>
								<td align="center" width="13%">
									<b>1</b> 
								</td>
								<td align="center"  width="13%">
									<b>2</b> 
								</td>
								<td  align="center" width="13%">
									<b>3</b> 
								</td>
								<td  align="center" width="13%">
									<b>4</b> 
								</td>
								<td  align="center" width="13%">
									<b>5</b> 
								</td>
								<td  align="center" width="13%" >
									<b>6</b> 
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap" >
									<b>Volume in Litres :</b> 
								</td>
								<td  align="center" >
									 
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
							</tr>
							<tr>
								<td  >
									<b>Ullage :</b> 
								</td>
								<td  align="center" >
									
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									
								</td>
							</tr>
							<tr>
								<td  >
									<b>Upper Seal No :</b> 
								</td>
								<td  align="center" >
									 
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									 
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
							</tr>
							
							<tr>
								<td  >
									<b>Lower Seal No :</b> 
								</td>
								<td  align="center" >
									
								</td>
								<td  align="center" >
									 
								</td>
								<td  align="center" >
									 
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									  
								</td>
								<td  align="center" >
									 
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr>
					<td align="center" colspan="8">
						<img width="70%" src="images/appsafety.png"/>
					</td>
				</tr>
				
				<tr>	
					
					<td align="center" colspan="8">
					<br />
					<b>Head Office :</b><?php echo $_SESSION['corpaddr'];?><br/>
					<b>Email :</b>	<?php echo $_SESSION['email'];?><br/>
					<b>Website :</b>	<?php echo $_SESSION['webaddress'];?><br/>
					<b>Tel :</b>	 <?php echo $_SESSION['telex'];?><br/>
					APP Group Sales Terms and Conditions Apply to this Document
					</td>
				</tr>
				
			</table>
			
			
			</div>
			<?php } ?>

	</form>
</div>
				

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.addEventListener("DOMContentLoaded",function(){PrintPage();});
		
</script>