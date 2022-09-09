<?php 
	ob_start();
	include_once "session_track.php";
	
	include "printheader.php";
?>
	<link rel="stylesheet" type="text/css" href="css/main.css"  media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css"  media="screen">
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

		<?php
			
			
			
			include "basicparameters.php";	
		
			$datefield = "a.transdate";
			$custnofield = "";
			$salespsnfield = "";
			$itemfield ="trim(b.productid)";
			$loccdfield = "trim(a.loccd)";
			$vendornofield ="";
			$po_field ="";
			
			$periodmonthfield = "";
			$periodyearfield = "";
			include "reportcondition.php";
			
			
			
				
			$Tankquery = " SELECT a.dayoftheyear,a.transdate readingdate, b.*  FROM readingmaster a, tankreading b ".
				" WHERE  TRIM(a.transno) = TRIM(b.transno) AND TRIM(a.loccd) = TRIM(b.loccd) and b.readingdiff > 0 ". $holdadditionalwhereclause . 
				" order by a.loccd,STR_TO_DATE(a.transdate, '%d/%m/%Y') desc, b.tankid,b.productid ";

			//	echo $Tankquery;
			$Tankresult = mysqli_query($_SESSION['db_connect'],$Tankquery);
			$numrows_tankreadings = mysqli_num_rows($Tankresult);	
				
		
			
			$TankSummaryQuery = " SELECT SUM(b.tankqty) tankqty  FROM readingmaster a, tankreading b ".
				" WHERE  TRIM(a.transno) = TRIM(b.transno) AND TRIM(a.loccd) = TRIM(b.loccd) and b.readingdiff > 0 ". $holdadditionalwhereclause  ;

			$TankSummaryresult = mysqli_query($_SESSION['db_connect'],$TankSummaryQuery);
			$TankSummarynumrows = mysqli_num_rows($TankSummaryresult);
			
			
			if ($TankSummarynumrows > 0){ 
			
				$TankSummaryresultrow = mysqli_fetch_array($TankSummaryresult);
				$SummaryTankQty = $TankSummaryresultrow['tankqty'];
			}
			
			include "gainlosslogic.php";
			include "consecutivegainlosslogic.php"; 
			
			 
		?>

<div align ="center" id="data-form" > 
	

	<form name="form1" id="form1" method="post" action="">
		<h3  class= "noprint"><strong><font size='5'>Tank Reading Consecutive Gains</font></strong></h3>
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		

		
		<div id="print_table" >
			<h3><strong><font size='5'>Tank Reading Consecutive Gains</font></strong></h3>
			<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong><?php if ($loccd ==''){ echo 'For No Location ';}else { echo ' for Location '. $loccd;} ?></h3>

		
			<?php if ($numrows_tanks > 0) { ?>				
			<table width="95%" border="1">
				
				
				<thead>
					
					<tr class="right_backcolor">
						<th nowrap="nowrap" class="Odd">S/N</th>
						<th nowrap="nowrap" class="Odd">Date</th>
						<?php 
							
							for ($i=0; $i <$numrows_tanks; $i++) { 
								
						?> 
						<th nowrap="nowrap" class="Odd"><?php echo $tankidarray[$i]; ?></th>
						
						<?php } ?> 
						<th nowrap="nowrap" class="Odd"></th>
					</tr>
				</thead>

				
				<?php 
					
					$u = 0;

					while($u<$consecutivecount) 
					{
						$u++;
						
						
				?>
				
						<tr <?php echo ($u%2==0)?"class='treven'":"class='trodd'"; ?> >
							<td nowrap="nowrap"><?php echo $u;?></td>
							<td nowrap="nowrap"><?php echo $dailytankarray[$consecutive_array[$u]]['readingdate'];?></td>
								<?php 
									
									
									for ($v=0; $v <$numrows_tanks; $v++) { 
								?> 
								<td nowrap="nowrap" class="Odd"><?php if (array_key_exists($u.trim($tankidarray[$v]), $dailytankarray)) {echo $dailytankarray[$consecutive_array[$u].$tankidarray[$v]];} ?></td>
								
								<?php } ?> 
							<td nowrap="nowrap" align="right"></td>
						</tr>
						
				<?php 
						
					} 
				?>
					
			</table>
			<?php } ?>									
										
		</div>
	</form>
</div>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.addEventListener("DOMContentLoaded",function(){PrintPage();});
		
</script>