<?php 
	
	include "printheader.php";
?>
<div  align ="center" id="data-form" > 

	<?php 
		require_once("lib/mfbconnect.php"); 
	?>

	<?php require 'lib/aesencrypt.php'; 
		
		
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
		$selectinvoiceno = !isset($_REQUEST['selectinvoiceno'])?'':$dbobject->test_input($_REQUEST['selectinvoiceno']);
		$selectreceiptno = !isset($_REQUEST['selectreceiptno'])?'':$dbobject->test_input($_REQUEST['selectreceiptno']);
		$pmtref = !isset($_REQUEST['pmtref'])?'':$dbobject->test_input($_REQUEST['pmtref']);
		$pmtrefamtused = !isset($_REQUEST['pmtrefamtused'])?0:$dbobject->test_input($_REQUEST['pmtrefamtused']);
		
		$printwhat = !isset($_SESSION['printwhat'])?'invoice':$dbobject->test_input($_SESSION['printwhat']);
	

		$invoice_details = Array();
		$sql_invoiceno = "SELECT a.invoice_no,a.invoice_dt,a.approval1,a.approval,a.custno,a.ccompany, 
			  a.loc_name,a.loccd,a.rcv_locnm,a.rcvloc,a.station,a.deliveryaddress,a.bu,a.mv, 
			  a.vehcno,a.tcompany,b.request,a.prn,a.reversed,a.py, 
			  b.item,b.itemdesc,b.store_qty,b.price,b.disc,b.duprice,b.vatduprice, 
			  b.drivername,b.loadername,b.mtr_b4,b.mtr_after,b.load_start, 
			  b.load_end,b.ull_name,b.ull_time,b.vol1,b.vol2,b.vol3,b.vol4,b.vol5,b.vol6, 
			  b.ullage1,b.ullage2,b.ullage3,b.ullage4,b.ullage5,b.ullage6,b.seal_no, 
			  b.slip_no,b.slip_date, c.address1, c.address2 FROM invoice  a,  inv_detl  b,arcust c  
			  WHERE trim(a.slip_no) = trim(b.slip_no) and trim(a.custno) = trim(c.custno)  
			  and TRIM(a.invoice_no) = '$invoice_no'";
		
		//echo $sql_invoiceno	."<br/>".$sql_receiptno	;
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
			$invoice_details[$w]['seal_no'] = $rowinv['seal_no'];
			$invoice_details[$w]['slip_no'] = $rowinv['slip_no'];
			$invoice_details[$w]['slip_date'] = $rowinv['slip_date'];
			$invoice_details[$w]['address1'] = $rowinv['address1'];
			$invoice_details[$w]['address2'] = $rowinv['address2'];
			
			  
			
		}
		
		$sql_invoiceno_request = "SELECT distinct a.invoice_no, b.request FROM invoice  a,  inv_detl  b   
			  WHERE trim(a.slip_no) = trim(b.slip_no) and TRIM(a.invoice_no) = '$invoice_no'";
		
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
		<h3 class= "noprint"><strong><font size='12'>Print Invoice </font></strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false">Close Window</a>
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
		<input type="hidden" name="firstname" id="firstname" value="<?php echo $firstname; ?>" />
		<input type="hidden" name="ccompany" id="ccompany" value="<?php echo $ccompany; ?>" />
		<input type="hidden" name="othername" id="othername" value="<?php echo $othername; ?>" />
		<input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>" />
		<input type="hidden" name="refno" id="refno" value="<?php echo $refno; ?>" />
		


			<?php if ($count_invoiceno > 0) { ?>
			<div id="print_table" >
			<table  border="0" width="100%" id="recpt" >
				<tr>
					<td align="center" colspan="8">
						
						<font style="font-size:14"> <b>Customer Invoice/Waybill </b></font><br/>
						<?php echo $_SESSION['corpaddr'];?><br/>
						<?php echo $_SESSION['email'];?><br/>
						<?php echo $_SESSION['webaddress'];?><br/>
						 <?php echo $_SESSION['telex'];?><br/>
						
					</td>
				</tr>
				<tr>
					<td align="center" colspan="8">
						<table border="1" width="100%">
							<tr>
								<td nowrap="nowrap" width="20%">
									<b>Invoice No : </b>
								</td>
								<td width="30%">
									<?php echo $invoice_no; ?>
								</td>
								<td  width="20%">
									<b>Invoice Date :</b>
								</td>
								<td  width="30%">
									<?php echo $invoice_details[0]['invoice_dt']; ?>
								</td>
							</tr>		
						
							<tr>
								<td nowrap="nowrap" >
									<b>Customer : </b>
								</td>
								<td >
									<?php echo $invoice_details[0]['ccompany'];
											if ($invoice_details[0]['address1'] != '') { echo  '<br />'.$invoice_details[0]['address1'];}
											if ($invoice_details[0]['address2'] != '') { echo  '<br />'.$invoice_details[0]['address2'];}
									 ?>
								</td>
								<td nowrap="nowrap">
									<b>Approval No :</b><br /><b>Supply location :</b><br /><b>Receiving Location :</b>
								</td>
								<td>
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
								<td  width="16%">
									<b>U.P.</b>
								</td>
								<td  width="16%">
									<b>Vat</b>
								</td>
								<td  width="18%">
									<b>Cost</b>
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
								<td >
									<?php echo $invoice_details[$w]['price']; ?>
								</td>
								<td >
									<?php echo $invoice_details[$w]['vatduprice']; ?>
								</td>
								<td >
									<?php echo $invoice_details[$w]['store_qty'] * $invoice_details[$w]['price']; ?>
								</td>
							</tr>
							<?php  $thetotalqty = $thetotalqty + $invoice_details[$w]['store_qty']; $thetotalcost = $thetotalcost + $invoice_details[$w]['store_qty'] * $invoice_details[$w]['price'];        } ?>
							<tr>
								
								<td align="right" colspan="3">
									<b>Total Quantity</b> &nbsp;&nbsp;<?php echo $thetotalqty; ?>
								</td>
								<td align="right" colspan="3">
									<b>Total Cost</b> &nbsp;&nbsp;<?php echo $thetotalcost; echo " (".$dbobject->convert_number_to_words($thetotalcost).")"; ?>
								</td>
							</tr>
								
						
						</table>
					</td>
				</tr>
				
				
				<tr>
					<td > <b>Payment Ref : </b></td> <td colspan="7" > <?php echo $pmtref  ; ?> </td>
				</tr>
				<tr>
					<td > <b>Amount Utilized : </b></td> <td colspan="7" align="left"> <?php echo number_format($pmtrefamtused,2); echo "  (".$dbobject->convert_number_to_words($pmtrefamtused).")";  ?> </td>
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
								<td width="20%" >
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
									<?php echo $invoice_details[0]['mtr_b4']; ?>
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
									<?php echo $invoice_details[0]['mtr_after']; ?>
								</td>
							</tr>			
						
							<tr>
								<td >
									<b>Ticket Number :</b> 
								</td>
								<td  >
									<?php echo substr($invoice_details[0]['slip_no'],5,2).substr($invoice_details[0]['slip_no'],7,2).substr($invoice_details[0]['slip_no'],11); ?>
								</td>
								<td >
									<b>Time Loading Started:</b> 
								</td>
								<td >
									<?php echo $invoice_details[0]['load_start']; ?>
								</td>
							</tr>
							<tr>
								<td colspan="2" >
									
								</td>
								
								<td >
									<b>Time Loading Ended:</b> 
								</td>
								<td >
									<?php echo $invoice_details[0]['load_end']; ?>
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
									<?php echo $invoice_details[0]['ull_name']; ?>
								</td>
								<td >
									<b>Ullage Time:</b> 
								</td>
								<td  colspan="3">
									<?php echo $invoice_details[0]['ull_time']; ?>
								</td>
							</tr>		
							
							<tr>
								<td width="22%" >
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
								<td  >
									<b>Volume in Litres :</b> 
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['vol1']; ?> 
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['vol2']; ?>  
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['vol3']; ?>  
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['vol4']; ?>  
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['vol5']; ?>  
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['vol6']; ?>  
								</td>
							</tr>
							<tr>
								<td  >
									<b>Ullage :</b> 
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['ullage1']; ?> 
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['ullage2']; ?>  
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['ullage3']; ?>  
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['ullage4']; ?>  
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['ullage5']; ?>  
								</td>
								<td  align="center" >
									<?php echo $invoice_details[0]['ullage6']; ?>  
								</td>
							</tr>
							<tr>
								<td >
									<b>Seal Number :</b> 
								</td>
								<td  colspan="6">
									<?php echo $invoice_details[0]['seal_no']; ?>
								</td>
								
							</tr>
							
						</table>
					</td>
				</tr>
				
				
				
				<tr>
					<td align="center" colspan="8">
						<table border="1" width="100%">
							<tr>
								<td align="center" colspan="2">
									<b><font size='2'>Attestation</font></b>
								</td>
							</tr>
							<tr>
								<td width="50%">
									Product Issued by:
									<br />Officer's Name .................................
									<br />Signature ......................................
									<br />Date ...........................................
								</td>
								<td  width="50%" >
									I Received the above product in good order and condition
									<br />Customer/Representative's Name ..................
									<br />Signature .......................................
									<br />Date ............................................
								</td>
							</tr>
						</table>
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