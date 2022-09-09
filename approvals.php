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
		$loccdfield = "trim(a.loccd)";
		$vendornofield ="";
		$po_field ="";
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		

			$query = "SELECT a.*,b.item,b.itemdesc,b.qty_asked,b.bprice,".
						"b.disc,b.duprice,b.vatduprice,b.price from headdata a, loadings b ".
						" WHERE TRIM(a.request) = TRIM(b.request) " .
						"  and approve_ok = 1  " .
						$holdadditionalwhereclause . " ORDER BY  STR_TO_DATE(a.loc_date, '%d/%m/%Y') desc ";
			
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
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css"  media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css"  media="screen">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		<h3  class= "noprint"><strong><font size='12'>Approvals  </font></strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong><font size='12'>Approvals  </font></strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table width="95%">
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Approval Time</th>
									<th   class="Odd">Approval No</th>
									<th   class="Odd">Customer Name</th>
									<th   class="Odd">Product</th>
									<th   class="Odd">Destination</th>
									<th   class="Odd">Quantity</th>
									<th   class="Odd">Unit Price</th>
									<th   class="Odd">Total Cost</th>
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
										<td  ><?php echo $row["appr_date"];?></td>
										<td  ><?php echo trim($row["approval1"]) . " " .trim($row["approval"]);?></td>
										<td  ><?php echo trim($row["ccompany"]);?></td>
										<td  ><?php echo trim($row["itemdesc"]) ;?></td>
										<td  ><?php echo $row["station"];?></td>
										<td   align="right"><?php echo number_format($row["qty_asked"],2);?></td>
										<td   align="right"><?php echo number_format($row["price"],2);?></td>
										<td   align="right"><?php echo number_format($row["total_cost"],2);?></td>
										<td  ></td>
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
			
	</form>
</div>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.addEventListener("DOMContentLoaded",function(){PrintPage();});
		
</script>