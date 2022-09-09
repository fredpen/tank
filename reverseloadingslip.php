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
		<h3><strong><font size='10'>Reverse Loading Slip 
		
		</font></strong></h3>
		<?php
			if ($_SESSION['approval']==1){
			include("lib/dbfunctions.php");
			$dbobject = new dbfunction();
			$role_id = "";
			$branch_code = "";
			$periodyear = $_SESSION['periodyear'];
			$periodmonth = $_SESSION['periodmonth'];
			$reqst_by = $_SESSION['username_sess'];
			$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
			$request = !isset($_REQUEST['request'])?'':$_REQUEST['request'];
			$company = !isset($_REQUEST['company'])?'':$_REQUEST['company'];
			$custno = !isset($_REQUEST['custno'])?'':$dbobject->test_input($_REQUEST['custno']);
			$ccompany = !isset($_REQUEST['ccompany'])?'':$dbobject->test_input($_REQUEST['ccompany']);
			$vehcno = !isset($_REQUEST['vehcno'])?'':$dbobject->test_input($_REQUEST['vehcno']);
			$slip_no = !isset($_REQUEST['slip_no'])?'':$dbobject->test_input($_REQUEST['slip_no']);
			$drivername = !isset($_REQUEST['drivername'])?'':$dbobject->test_input($_REQUEST['drivername']);	
			$fieldtosearch = !isset($_REQUEST['fieldtosearch'])?'':$dbobject->test_input($_REQUEST['fieldtosearch']);
			$lookfor = !isset($_REQUEST['lookfor'])?'':$dbobject->test_input($_REQUEST['lookfor']);
			$reversed = !isset($_REQUEST['reversed'])?1:$dbobject->test_input($_REQUEST['reversed']);
			$invoice_no ='';
			
			$thereason = !isset($_REQUEST['thereason'])?"":$dbobject->test_input($_REQUEST['thereason']);
			$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
			
			if($op=='reverseslip')
			{
				
				$goahead = 1;
				$sql_get_products =  "SELECT a.drivername,a.item,a.itemdesc, a.qty_asked, a.price, a.cost, a.qty_booked, a.request  FROM invoice b, inv_detl a" .
					" where trim(b.slip_no) = trim(a.slip_no) and trim(b.slip_no) = '" . trim($slip_no)."'  ";
			
			
			
				//echo $sql_get_products."<br/>";
				
				$result_get_products = mysqli_query($_SESSION['db_connect'],$sql_get_products);
				$count_get_products = mysqli_num_rows($result_get_products);
				for ($i=0;$i<$count_get_products;$i++)
				{
					$row = mysqli_fetch_array($result_get_products);
					$sql_update_loadings = "update loadings set qty_booked = qty_booked - " . $row['qty_booked'] .
						" WHERE trim(request) = '" . trim($row['request']) . "' and " .
						" trim(item) = '" . trim($row['item']) . "'";
					
					
					$result_update_loadings = mysqli_query($_SESSION['db_connect'],$sql_update_loadings);
				}
				
				
				if ($count_get_products> 0)
				{
					$sql_update_invoice = "update invoice set reversed = 1, reversalreason = '$thereason' WHERE trim(slip_no) = '$slip_no'";
					$result_update_invoice = mysqli_query($_SESSION['db_connect'],$sql_update_invoice);
					
					
					$savetrail = $dbobject->apptrail($_SESSION['username_sess'],'Loading Slip',$slip_no,date("d/m/Y h:i:s A"),'Reversed');
					$dbobject->workflow($_SESSION['username_sess'],'Loading Slip Created, Loading Slip Reversed',$slip_no,date('d/m/Y H:i:s A'),0,3);
					?>
						<script>
						
						$('#item_error').html("<strong>Loading Slip Reversed</strong>");
						</script>
					<?php	
						
					
				}

			}
	
			
			$products_icitem_var = Array();
			$productArray = Array();
			
			$sql_slipno = "select distinct * FROM invoice WHERE reversed = 0 and trim(invoice_no) = '' order by substr(slip_no,4) desc limit 1000";
			
		
			$result_slipno = mysqli_query($_SESSION['db_connect'],$sql_slipno);
			$count_slipno = mysqli_num_rows($result_slipno);
			
			$k=0;
			while ($k<$count_slipno){
				$row = mysqli_fetch_array($result_slipno);
				$slipno_var[$k]['slip_no']=$row['slip_no'];
				$slipno_var[$k]['ccompany']=$row['ccompany'];
				
				$k++;
			}
			
			
			
	
	
	
			if($op=='getselectslipno')
				{
					$filter = "";
					
					$sql_Q = "SELECT * FROM invoice where  ";
					
					$filter="  upper(trim(slip_no)) = upper('$slip_no')  ";
					
											
					
					$orderby = "   ";
					$orderflag	= " ";
					$order = $orderby." ".$orderflag;
					$sql_QueryStmt = $sql_Q.$filter.$order. " limit 1";
						
					//echo "<br/> sql_Q ".$sql_Q;	
					//echo "<br/>".$sql_QueryStmt."<br/>";
					$result_QueryStmt = mysqli_query($_SESSION['db_connect'],$sql_QueryStmt);
					$count_QueryStmt = mysqli_num_rows($result_QueryStmt);
					
					if ($count_QueryStmt >=1){
						$row       = mysqli_fetch_array($result_QueryStmt);
						$slip_no    = $row['slip_no'];
						$ccompany   = $row['ccompany'];
						$invoice_no    = $row['invoice_no'];
						$reversed   = $row['reversed'];
						$vehcno   = $row['vehcno'];
					}else 	
					{
					?>
						<script>
						
						$('#item_error').html("<strong>LoadingSlip does not exist</strong>");
						</script>
					<?php	
					}	
					
					
				}	
			
			if($op=='searchkeyword'){
				if (trim($keyword) !=''){
					
					$sql_request = "select *  from invoice where trim(slip_no) = '$keyword'";
					//echo $sql_request."<br />";
					$result_request = mysqli_query($_SESSION['db_connect'],$sql_request);
					$count_request = mysqli_num_rows($result_request);
					//echo "<br/>".$sql_request."<br/>";
					if ($count_request >=1){
						$row = mysqli_fetch_array($result_request);
						$slip_no    = $row['slip_no'];
						$ccompany   = $row['ccompany'];
						$invoice_no    = $row['invoice_no'];
						$reversed   = $row['reversed'];
						$vehcno   = $row['vehcno'];
						if ($reversed = 1 || trim(invoice_no) != '')
						{
							?>
								<script>
								
								$('#item_error').html("<strong>Loading Slip Cannot be reversed</strong>");
								</script>
							<?php	
						}
						
					}else 	
					{
					?>
						<script>
						
						$('#item_error').html("<strong>Loading Slip does not exist</strong>");
						</script>
					<?php	
					}
				}
				else
				{
					?>
						<script>
						
						$('#item_error').html("<strong>Keyword is empty</strong>");
						</script>
					<?php
				}
			}
			

			
			
			
			

			
			
					
	// retrieve product		
						
			$sql_products =  "SELECT a.drivername,a.item,a.itemdesc, a.qty_asked, a.price, a.cost, a.qty_booked, a.request  FROM invoice b, inv_detl a" .
					" where trim(b.slip_no) = trim(a.slip_no) and trim(b.slip_no) = '" . trim($slip_no)."'  ";
			
			
			
			//echo $sql_products."<br/>";
			$show_void_button = 1;
			$result_products = mysqli_query($_SESSION['db_connect'],$sql_products);
			$count_products = mysqli_num_rows($result_products);
			for ($i=0;$i<$count_products;$i++){
				$row = mysqli_fetch_array($result_products);
				$productArray[$i]['item'] = $row['item'];
				$productArray[$i]['itemdesc'] = $row['itemdesc'];
				$productArray[$i]['drivername'] = $row['drivername'];
				$productArray[$i]['qty_booked'] = $row['qty_booked'];
				$productArray[$i]['price'] = $row['price'];
				$productArray[$i]['cost'] = $row['cost'];
				$productArray[$i]['request'] = $row['request'];
				$productArray[$i]['request'] = $row['request'];
				
				 
			}
			if (trim($invoice_no) != ''){$show_void_button = $show_void_button * 0;}
			if ($reversed == 1){$show_void_button = $show_void_button * 0;}
			
			
	
		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		
		<div  style="color:red;" id = "item_error" align = "center"  ></div>
		<input type="hidden" name="thetablename" id="thetablename" value="loadingslip" />
		<input type="hidden" name="get_file" id="get_file" value="reverseloadingslip" />
		
		<div  id="multipleapproval_table"   >
		<table  border="0" style="border:1px solid black;padding:5px;border-collapse:separate;border-radius:15px"  >
			<tr>
				<td><b>Search by: <i>Name or Code or Phone Number</i> </b>&nbsp;
				</td>
				<td colspan="4">
					<div class="input-group">
						
						<input type="text" size="35px" id="search" placeholder="Search for Vendor" />
						<input name="keyword" type="hidden" class="table_text1"  id="keyword" value="<?php echo $keyword; ?>" />
					
					</div>
					
				</td>  
				
			</tr>
			<tr >
				<td colspan="5" align="center">
				<!-- Suggestions will be displayed in below div. -->
					
					<div id="display"></div>
				</td>  
			</tr >
			<tr >
				<td valign="top">
					<b>Select Slip Number</b>
				</td>
				<td  colspan="4" >
					
						<?php 
						$k = 0;
						?>
						<select name="selectslipno"   id="selectslipno" 
							onChange="javascript: 
									var $form_selectslipno = $('#selectslipno').val();  
										
										getpage('reverseloadingslip.php?op=getselectslipno&slip_no='+$form_selectslipno
										,'page')
							
								"
						
						>
							<option  value="" ></option>
						<?php

						while($k< $count_slipno) 
						{
							
						?>
							<option  value="<?php echo trim($slipno_var[$k]['slip_no']) ;?>" <?php  echo ($slip_no== trim($slipno_var[$k]['slip_no']) ?"selected":""); ?>>
								<?php echo trim($slipno_var[$k]['slip_no'].' '.$slipno_var[$k]['ccompany']) ;?> 
							</option>
							
						<?php 
							$k++;
							} //End If Result Test	
						?>								
						</select>
						<b><?php echo $slip_no; ?> </b><input type="hidden" name="slip_no" id="slip_no" value="<?php echo $slip_no; ?>" />
				</td>
			</tr>
			
			
			<tr>
				<td><b>Reason</b></td>
				<td colspan="4" ><input type="text" size="35%" id="thereason" name="thereason" placeholder="Please state the reason for Reversal" value="<?php echo $thereason; ?>" /></td>
			</tr>
		</table>
		</div>
		
		<br>
		
		<h3><strong>Products </strong></h3>
		
		<div style="overflow-x:auto;" id="single_approval_product_row" >
		
		<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
			<thead>
				<tr class="right_backcolor">
					<th nowrap="nowrap" class="Corner">&nbsp;</th>
					<th nowrap="nowrap" class="Odd">S/N</th>
					<th nowrap="nowrap" class="Odd">Requisition Nummber</th>
					<th nowrap="nowrap" class="Odd">Item</th>
					<th nowrap="nowrap" class="Odd">Description</th>
					<th nowrap="nowrap" class="Odd">Qty Booked</th>
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
					$i = $k -1;

			?>
			
					<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?>  >
						<td nowrap="nowrap">&nbsp;</td>
						<td nowrap="nowrap"><?php echo $k;?></td>
						<td nowrap="nowrap"><?php echo $productArray[$i]['request'];?></td>
						<td nowrap="nowrap"><?php echo $productArray[$i]['item'];?></td>
						<td nowrap="nowrap"><?php echo $productArray[$i]["itemdesc"];?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["qty_booked"],2);?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["price"],2);?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["cost"],2);?></td>
						
						<td nowrap="nowrap"></td>
					</tr>
					
					
			<?php 
					
					//End For Loop
				} //End If Result Test	
			?>
		</table>
			
		</div>
		
		<br />
		<div>
				
				<b>Bulk Road Vehicle</b>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php  echo trim($vehcno) ; ?> 
						
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<b>Driver Name</b>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if (isset($productArray[0]["drivername"])){echo trim($productArray[0]["drivername"]) ;}?> 
				
		</div>
			
		<table>
		  <tr>
			
			<?php if ($show_void_button==1) {?>
			<td  align="right" nowrap="nowrap">
				
				  <input type="button" name="approvebutton" id="submit-button" title="Reverse Loading Slip" value="Reverse Slip" 
					onclick="javascript: reverseslip();">
				
			</td>
			<?php } ?>
			
			
		  
			<td>
				<?php $calledby = 'reverseloadingslip'; $reportid = 42; include("specificreportlink.php");  ?>
			</td>
		  </tr>
		  
		</table>

			<?php } ?>
	</form>
	
	<br />
				
		  <input type="button" name="closebutton" id="submit-button" value="Back" 
			onclick="javascript:  getpage('s_and_d.php?op=refresh','page');
				">

	<br />
</div>


<script>
	function reverseslip()
	{
		
		if (confirm('Are you sure the entries are correct?')) {
			var $goahead = 1;
			var $form_slipno = $('#slip_no').val(); 
			
			
			
			if($form_slipno==''){
				$goahead *=0;
				alert('Please Specify Loading Slip Number');
			}
				
			
		var $form_thereason = $('#thereason').val();
		
		
		if ($form_thereason == '' ){
				$goahead *= 0;
				alert('Reason for Return Not Provided');
			
		}	
			
			if ($goahead == 1)
			{
				
				//alert('reverseloadingslip.php?op=reverseslip&slip_no='+$form_slipno);
				getpage('reverseloadingslip.php?op=reverseslip&slip_no='+$form_slipno+'&thereason='+$form_thereason,'page');
			}
			
		}	
					
	}
	
	
</script>