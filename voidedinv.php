<?php 
	
	include "printheader.php";
?>

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
	
		$startdate = substr($startdate,8,2)."/".substr($startdate,5,2)."/".substr($startdate,0,4);
		$enddate = substr($enddate,8,2)."/".substr($enddate,5,2)."/".substr($enddate,0,4);
		

		$additionalwhereclause = $dbobject->docase($startdate,$enddate,$custno,$salespsn,$item,$loccd,$vendorno,$purchaseorderno,
					$datefield,$custnofield,$salespsnfield,$itemfield,$loccdfield,$vendornofield,$po_field);
	
		$holdadditionalwhereclause = $additionalwhereclause <> ""?" and " . $additionalwhereclause :"";
		
			$query_summary = "SELECT sum(((select volfactor from icitem where TRIM(item) = TRIM(b.item))*b.store_qty)) as quantity ,".
					" sum(b.store_qty*b.price) AS invoice_am ".
					" FROM invoice a, inv_detl b ".
					" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.store_qty > 0 and a.reversed = 1 ".
							$holdadditionalwhereclause . " ORDER BY STR_TO_DATE(a.invoice_dt , '%d/%m/%Y') desc ";
			
			$result_summary = mysqli_query($_SESSION['db_connect'],$query_summary);
			
			//echo $query;
			$query = "SELECT b.request as linerequest,a.invoice_dt,a.slip_no,".
				"a.invoice_no,concat(TRIM(a.approval1),TRIM(a.approval)) approval_no, ".
				" ((select volfactor from icitem where TRIM(item) = TRIM(b.item))*b.store_qty) as quantity ,".
				" b.item,b.itemdesc,b.qty_booked,b.store_qty,b.bprice,a.reversed, a.request ,".
				" b.disc,b.duprice,b.vatduprice,b.price,a.vehcno,a.trasno,a.tcompany,a.custno,a.ccompany,a.station, ".
				" a.loccd,a.loc_name, (b.store_qty*b.price) AS invoice_am ".
				" FROM invoice a, inv_detl b ".
				" WHERE trim(a.slip_no) = trim(b.slip_no)  AND b.store_qty > 0 and a.reversed = 1 ".
						$holdadditionalwhereclause . " ORDER BY STR_TO_DATE(a.invoice_dt , '%d/%m/%Y') desc ";
			
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

			$count = $numrows;
						
			$skip = 0;
			$maxPage = $limit;
			//echo $count;
			$npages = (int)($count/$maxPage);
			//echo $npages;
			if ($npages!=0){
				if(($npages * $maxPage) != $count){	
					$npages = $npages+1;
					//echo $npages;
				}
			}else{
				$npages = 1;
				//echo "Here";
			}
			
			$sel = !isset($_REQUEST['op'])?"":$_REQUEST['op'];

			$download_query = $query;
			
			//echo 'D page:  '.$pageNo;
		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong>Sales Returns and Allowances</strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Invoice Number</th>
									<th   class="Odd">Date</th>
									<th   class="Odd">Ticket No</th>
									<th   class="Odd">Customer</th>
									<th   class="Odd">Product</th>
									<th   class="Odd">Quantity</th>
									<th   class="Odd">Invoice Amount</th>
									<th  >&nbsp;</th>
								</tr>
							</thead>
							<?php 
								$skip = $maxPage * ($pageNo-1);
								$k = 0;
			  
								for($i=0; $i<$skip; $i++)
								{
									$row = mysqli_fetch_array($result);
									//echo 'count '.$i.'   '.$skip;
								} 
						  
								while($k<$maxPage && $numrows>($k+$skip)) 
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
										<td  ><?php echo $k+$skip;?></td>
										<td  ><?php echo trim($row["invoice_no"]);?></td>
										<td  ><?php echo trim($row["invoice_dt"]);?></td>
										<td  ><?php echo SUBSTR(trim($row['slip_no']),5,2).SUBSTR(trim($row['slip_no']),7,2).SUBSTR(trim($row['slip_no']),11);?></td>
										<td  ><?php echo trim($row["ccompany"]);?></td>
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
								<td  > </td>
								<td  ></td>
								<td  ></td>
								<td  ><strong>Report Summary</strong></td>
								<td  ></td>
								<td   align="right"><strong><?php echo number_format($summary_quantity,2);?></strong></td>
								<td   align="right"><strong><?php echo number_format($summary_invoice_am,2);?></strong></td>
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