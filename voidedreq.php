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

<div align ="center" id="data-form" > 

	<?php 
		
		include "basicparameters.php";	
		
		$datefield = "a.loc_date";
		$custnofield = "trim(a.custno)";
		$salespsnfield = "trim(a.salespsn)";
		$itemfield ="trim(b.item)";
		$loccdfield = "trim(b.loccd)";
		$vendornofield ="";
		$po_field ="";
		
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		
			$query = "SELECT b.item,b.itemdesc ,b.bprice , a.request ,".
					" b.disc,b.duprice,b.vatduprice,b.price ,a.custno,a.ccompany,a.station,a.loc_date,b.voidreason, ".
					" a.loccd,a.loc_name, b.qty_asked,b.voided_qty, (b.qty_asked - b.voided_qty) as qty_booked  ".
					" FROM headdata a, loadings b ".
					" WHERE trim(a.request) = trim(b.request)  AND b.voided_qty > 0   ".
							$holdadditionalwhereclause . " ORDER BY STR_TO_DATE(a.loc_date, '%d/%m/%Y') desc , a.request  ";

			$query_summary = "SELECT sum(b.voided_qty) as voided_qty ,".
					" sum(b.qty_asked) qty_asked FROM headdata a, loadings b ".
					" WHERE trim(a.request) = trim(b.request)  AND b.voided_qty > 0 ".
							$holdadditionalwhereclause ;

		
		
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$result_summary = mysqli_query($_SESSION['db_connect'],$query_summary);
			$numrows = mysqli_num_rows($result);
			
			$summary_qty_asked = 0;
			$summary_voided_qty = 0;
			if($numrows>0){
				$row_summary = mysqli_fetch_array($result_summary);
				$summary_qty_asked = $row_summary['qty_asked'];
				$summary_voided_qty = $row_summary['voided_qty'];
			}


			
		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong><font size="10"> List of Voided Requisition Qty Balance</font></strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Request No</th>
									<th   class="Odd">Request Time</th>
									<th   class="Odd">Customer</th>
									<th   class="Odd">Product</th>
									<th   class="Odd">Req Qty</th>
									<th   class="Odd">Qty Booked</th>
									<th   class="Odd">Qty Voided</th>
									<th   class="Odd">Unit Price</th>
									<th   class="Odd">Refundable Amount</th>
									<th   class="Odd">Reason</th>
									<th  >&nbsp;</th>
								</tr>
							</thead>
							<?php 
								
								$k = 0;
			  
								while($k<$numrows) 
								{
									$k++;
									//for($i=0; $i<$numrows; $i++){
									$row = mysqli_fetch_array($result);
									//while($i < $skip) continue;
									//echo 'count '.$i.'   '.$skip;	
								//}
							?>
							
									<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td  >&nbsp;</td>
										<td  ><?php echo $k;?></td>
										<td   ><?php echo $row['request'];?></td>
										<td   ><?php echo $row['loc_date'];?></td>
										<td  ><?php echo trim($row['ccompany']);?></td>
										<td  ><?php echo trim($row['itemdesc']);?></td>
										<td   align="right"><?php echo number_format($row['qty_asked'],2);?></td>
										<td   align="right"><?php echo number_format($row['qty_booked'],2);?></td>
										<td   align="right"><?php echo number_format($row['voided_qty'],2);?></td>
										<td   align="right"><?php echo number_format($row['price'],2);?></td>
										<td   align="right"><?php echo number_format($row['price']*$row['voided_qty'],2);?></td>
										<td  ><?php echo trim($row['voidreason']);?></td>
										<td  ></td>
									</tr>
							<?php 
									//} //End For Loop
								} //End If Result Test	
							?>
									<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td  >&nbsp;</td>
										<td  ></td>
										<td   ></td>
										<td   ></td>
										<td  ><strong>Summary : </strong></td>
										<td  ></td>
										<td   align="right"><strong><?php echo number_format($summary_qty_asked,2);?></strong></td>
										<td   align="right"></td>
										<td   align="right"><strong><?php echo number_format($summary_voided_qty,2);?></strong></td>
										<td   colspan="3"></td>
										
									</tr>							
							
						</table>
					
				</td>
			</tr>
			
			</table>
			</div>
			
	</form>
</div>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.addEventListener("DOMContentLoaded",function(){PrintPage();});
		
</script>