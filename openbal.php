<?php 
	ob_start();
	include "session_track.php";
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<div align ="center" id="data-form_report111" > 

	<?php 

		include "basicparameters.php";	
		
		$datefield = "";
		$custnofield = "trim(a.custno)";
		$salespsnfield = "";
		$itemfield ="";
		$loccdfield = "";
		$vendornofield ="";
		$po_field ="";
		

		$additionalwhereclause = $dbobject->docase($startdate,$enddate,$custno,$salespsn,$item,$loccd,$vendorno,$purchaseorderno,
					$datefield,$custnofield,$salespsnfield,$itemfield,$loccdfield,$vendornofield,$po_field);
	
		$holdadditionalwhereclause = $additionalwhereclause <> ""?" and " . $additionalwhereclause :"";
		
			$query = "SELECT  a.* FROM arcust a WHERE 1 = 1 " .
						$holdadditionalwhereclause . " ORDER BY a.custno ";
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			
			

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
		
		<?php include "reportfilter.php";	?>
		<div id="print_div">
		<p ><h3><strong><font size='12'>Customer Master</font></strong></h3></p>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th nowrap="nowrap" class="Corner">&nbsp;</th>
									<th nowrap="nowrap" class="Odd">S/N</th>
									<th nowrap="nowrap" class="Odd">Customer</th>
									<th nowrap="nowrap" class="Odd">Address</th>
									<th nowrap="nowrap" class="Odd">Phone</th>
									<th nowrap="nowrap" class="Odd">3-Char Code</th>
									<th nowrap="nowrap" class="Odd">Unassigned Amount</th>
									<th nowrap="nowrap" class="Odd">Credit Limit</th>
									<th nowrap="nowrap" class="Odd">Unreconciled Credit</th>
									<th nowrap="nowrap">&nbsp;</th>
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
										<td nowrap="nowrap">&nbsp;</td>
										<td nowrap="nowrap"><?php echo $k+$skip;?></td>
										<td nowrap="nowrap"><?php echo trim($row["custno"]) ."-" . trim($row["company"]);?></td>
										<td nowrap="nowrap"><?php echo $row['address1'];?></td>
										<td nowrap="nowrap"><?php echo trim($row["phone1"]) ."-" . trim($row["phone2"]);?></td>
										<td nowrap="nowrap"><?php echo $row['cust3char'];?></td>
										<td nowrap="nowrap" align="right"><?php echo  number_format($row["custbal"],2);?></td>
										<td nowrap="nowrap" align="right"><?php echo  number_format($row["crlimit"],2);?></td>
										<td nowrap="nowrap" align="right"><?php echo  number_format($row["totcrtrans"],2);?></td>
										<td nowrap="nowrap"></td>
									</tr>
							<?php 
									//} //End For Loop
								} //End If Result Test	
							?>
						</table>
					
				</td>
			</tr>
			
			</table>
			</div>
			<table>
				<tr>
						
					<td align="center" nowrap="nowrap">
						<?php include "navigator.php";?></td>
					
				</tr>
			</table>
	</form>
</div>
<script type="text/javascript">
addTableRolloverEffect('RequisitionTable','tableRollOverEffect1','tableRowClickEffect1');
</script>