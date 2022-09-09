<?php 
	ob_start();
	include_once "session_track.php";
?>



<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div  align ="center" id="data-form" > 
	<input type="button" name="closebutton" id="submit-button" title="Close"  value="Close" onclick="javascript:  $('#data-form').hide();">	

	<?php 
		require_once("lib/mfbconnect.php"); 
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css"  media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css"  media="screen">
	<form action="" method="get" id="form1">
		<h3 class= "noprint"><strong><font size='12'>Print Loading Slip</font></strong></h3>
		
		<?php
			if ($_SESSION['prnloadingslip']==1)
			{
				include("lib/dbfunctions.php");
				$dbobject = new dbfunction();
				$role_id = "";
				
				$user = $_SESSION['username_sess'];
				$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
				
				$custno = !isset($_REQUEST['custno'])?'':$_REQUEST['custno'];
				$ccompany = !isset($_REQUEST['ccompany'])?'':$dbobject->test_input($_REQUEST['ccompany']);
				
				$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
				$keyword_receiptno = !isset($_REQUEST['keyword_receiptno'])?"":$dbobject->test_input(trim($_REQUEST['keyword_receiptno']));
				$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
				
				$slip_no = !isset($_REQUEST['slip_no'])?'':$dbobject->test_input($_REQUEST['slip_no']);
				$invoice_no = !isset($_REQUEST['invoice_no'])?'':$dbobject->test_input($_REQUEST['invoice_no']);
				
			
				
					
				if ($op=='searchkeyword') 
					{
						
						$sql_Q = "SELECT * FROM invoice where 1 =1  ";
						$filter=" AND trim(slip_no) like '%$keyword%'   ";
						
						$orderby = "   ";
						$orderflag	= " ";
						$order = $orderby." ".$orderflag;
						$sql_QueryStmt = $sql_Q.$filter.$order. " limit 1";
							
						//echo "<br/> sql_Q ".$sql_Q;	
						//echo "<br/>".$sql_QueryStmt."<br/>";
						$result_QueryStmt = mysqli_query($_SESSION['db_connect'],$sql_QueryStmt);
						$count_QueryStmt = mysqli_num_rows($result_QueryStmt);
						
						if ($count_QueryStmt >=1)
						{
							$row       = mysqli_fetch_array($result_QueryStmt);
							$custno    = $row['custno'];
							$ccompany   = $row['ccompany'];
							$invoice_no   = $row['invoice_no'];
							$slip_no   = $row['slip_no'];
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Loading Slip Number does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}

					
				
				
			
		

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
		<input type="hidden" name="ccompany" id="ccompany" value="<?php echo $ccompany; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="loadingslip" />
		<input type="hidden" name="get_file" id="get_file" value="printloadingslip" />
		
		<table class= "tableb"   style="padding:0px;">
			<tr>
				<td  colspan="2" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input-group">
						<b>Search by: <i>Name or Code</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Customer" />
						<input name="keyword" type="hidden" class="table_text1"  id="keyword" value="<?php echo $keyword; ?>" />
					
					</div>
					<!-- Suggestions will be displayed in below div. -->
					<br />
					   <div id="display"></div>
				</td>  
				
			</tr>
			
			
			<tr>
				
				<td nowrap="nowrap" colspan="2">
					<div class="input-group">
						<b>Loading Slip Number : </b>&nbsp;
						<input name="slip_no" type="text"  style="background:transparent;border:none;" tabindex="-1" class="table_text1"  id="slip_no" value="<?php echo $keyword; ?>" />
						
						&nbsp;&nbsp;
							<input type="submit" name="printslip" <?php  if (! empty($slip_no)) {echo ' style="display:block;"';} else {echo ' style="display:none;"'; }?> class="PrintButton" id="submit-button" formtarget="_blank" value ="Print Slip" formaction="<?php echo $_SESSION['applicationbase'].'apploadingslip.php' ;?>"/>
						
						
					</div>
				</td>
				
			</tr>
			<tr >
				<td  colspan="2" >
					<b>Client ID : </b>&nbsp;&nbsp;<?php echo $custno; ?> &nbsp;&nbsp;&nbsp;&nbsp; <b>Name : </b>&nbsp;<?php echo $ccompany ; ?>
					 &nbsp;&nbsp;
				</td>
			</tr>
			
			
		</table>
			
		<?php 	

			} ?>
	</form>
	<br />
	<input type="button" name="closebutton" id="submit-button" value="Back" 
						onclick="javascript:  getpage('s_and_d.php?','page');
							">
	<br />
</div>
