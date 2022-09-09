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
		
		$datefield = "a.invoice_dt";
		$custnofield = "trim(a.custno)";
		$salespsnfield = "trim(a.salespsn)";
		$itemfield ="trim(b.item)";
		$loccdfield = "trim(a.loccd)";
		$vendornofield ="";
		$po_field ="";
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		
			$query_summary = "SELECT sum(((select volfactor from icitem where TRIM(item) = TRIM(b.item))*b.store_qty)) as quantity ,".
					" sum(b.store_qty*b.price) AS invoice_am ".
					" FROM invoice a, inv_detl b ".
					" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.store_qty > 0 and a.reversed = 0 ".
							$holdadditionalwhereclause . " ORDER BY STR_TO_DATE(a.invoice_dt , '%d/%m/%Y') desc ";
			
			$result_summary = mysqli_query($_SESSION['db_connect'],$query_summary);
			
			//echo $query;
			$query = "SELECT sum(b.store_qty) as quantity ,".
				" a.loccd,a.loc_name,b.item,b.itemdesc, sum(b.store_qty*b.price) AS invoice_am ".
				" FROM invoice a, inv_detl b ".
				" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.store_qty > 0 and a.reversed = 0 ".
						$holdadditionalwhereclause . " group by a.loccd,a.loc_name,b.item,b.itemdesc ORDER BY a.loccd,b.item ";
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			$summary_invoice_am = 0;
			$summary_quantity = 0;
			if($numrows>0){
				$row_summary = mysqli_fetch_array($result_summary);
				$summary_invoice_am = $row_summary['invoice_am'];
				$summary_quantity = $row_summary['quantity'];
			}

			
		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css"  media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css"  media="screen">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong>Location Wise Sales/Loadings</strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Location</th>
									<th   class="Odd">Product</th>
									<th   class="Odd">Quantity</th>
									<th   class="Odd">Invoice Amount</th>
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
										<td  ><?php echo trim($row["loc_name"]);?></td>
										<td  ><?php echo trim($row["itemdesc"]) ."-" . trim($row["item"]);?></td>
										<td   align="right"><?php echo number_format($row['quantity'],2);?></td>
										<td   align="right"><?php echo number_format($row['invoice_am'],2);?></td>
										<td  ></td>
									</tr>
							<?php 
									//} //End For Loop
								} //End If Result Test	
							?>
							
							<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
								<td  >&nbsp;</td>
								<td  ></td>
								<td  ><strong>Report Summary</strong></td>
								<td  ></td>
								<td   align="right"><strong><?php echo number_format($row_summary['quantity'],2);?></strong></td>
								<td   align="right"><strong><?php echo number_format($row_summary['invoice_am'],2);?></strong></td>
								<td  ></td>
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