<?php 
	ob_start();
	include_once "session_track.php";
?>


<style>
	td {padding:5px;}
</style>
<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align ="center" id="data-form" > 
	<input type="button" name="closebutton" id="submit-button" title="Close"  value="Close" onclick="javascript:  $('#data-form').hide();">	

	<?php 
		require_once("lib/mfbconnect.php"); 
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong><font size='10'>Bulk Road Vehicle Definition </font></strong></h3>
		<?php
			if ($_SESSION['somasters']==1)
			{
				include("lib/dbfunctions.php");
				$dbobject = new dbfunction();
				$role_id = "";
				
				$user = $_SESSION['username_sess'];
				$reqst_by = $_SESSION['username_sess'];
				$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
				$vehcno = !isset($_REQUEST['vehcno'])?'':$dbobject->test_input($_REQUEST['vehcno']);
				$trasno = !isset($_REQUEST['trasno'])?'':$dbobject->test_input($_REQUEST['trasno']);
				$company = !isset($_REQUEST['company'])?'':$dbobject->test_input($_REQUEST['company']);
				$capacity = !isset($_REQUEST['capacity'])?'':$dbobject->test_input($_REQUEST['capacity']);
				$address = !isset($_REQUEST['address'])?'':$dbobject->test_input($_REQUEST['address']);
				
					
				
				$roleid = !isset($_REQUEST['roleid'])?0:$_REQUEST['roleid'];
				
				$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
				$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
				
				$sql_brv = "select distinct * FROM tbvehc WHERE 1=1 order by vehcno";
					$result_brv = mysqli_query($_SESSION['db_connect'],$sql_brv);
					$count_brv = mysqli_num_rows($result_brv);
					
					
				$sql_transporter = "select distinct * FROM tbtras WHERE 1=1 order by company";
					$result_transporter = mysqli_query($_SESSION['db_connect'],$sql_transporter);
					$count_transporter = mysqli_num_rows($result_transporter);
					
				
				$sql_for_report = "select * from reptable where reportid = 29";
				$result_for_report = mysqli_query($_SESSION['db_connect'],$sql_for_report);
				$count_for_report = mysqli_num_rows($result_for_report);
				
				if ($count_for_report > 0){
					$rowreport = mysqli_fetch_array($result_for_report);
					
				}
				
				if($op=='getselectvehcno')
					{
						$filter = "";
						
						$sql_Q = "SELECT * FROM tbvehc where  ";
						
						
							$filter="  upper(trim(vehcno)) = upper('$vehcno')  ";
						
												
						
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
							$trasno    = $row['trasno'];
							$company   = $row['company'];
							$capacity = $row['capacity'];
							$vehcno  = $row['vehcno'];
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>BRV does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				
			
			
				if($op=='searchkeyword')
					{
						$filter=" AND trim(vehcno) like '%$keyword%'   ";
						
						$sql_Q = "SELECT * FROM tbvehc where ";
						if (strlen($keyword)!=0) {$sql_Q = $sql_Q . " 1 = 1 ";}else {$sql_Q = $sql_Q . " 1 = 2 ";}
						$orderby = "   ";
						$orderflag	= " ";
						$order = $orderby." ".$orderflag;
						$sql_QueryStmt = $sql_Q.$filter.$order. " limit 1";
							
						//echo "<br/> sql_Q ".$sql_Q;	
						//echo "<br/>".$sql_QueryStmt;
						$result_QueryStmt = mysqli_query($_SESSION['db_connect'],$sql_QueryStmt);
						$count_QueryStmt = mysqli_num_rows($result_QueryStmt);
						
						if ($count_QueryStmt >=1){
							$row       = mysqli_fetch_array($result_QueryStmt);
							$trasno    = $row['trasno'];
							$company   = $row['company'];
							$capacity = $row['capacity'];
							$vehcno = $row['vehcno'];
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>BRV does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				if($op=='deletevehcno')
				{
					$goahead = 1;
					
					if (trim($vehcno) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify BRV ID</strong>");
							</script>
						<?php 
						}else {
							
								$sql_checkusage =  "select * from invoice where trim(vehcno) = '$vehcno'";
								$result_checkusage = mysqli_query($_SESSION['db_connect'],$sql_checkusage);
								$count_checkusage = mysqli_num_rows($result_checkusage);
									
								if ($count_checkusage >=1)
								{
									$goahead = $goahead * 0;
								 ?>	
									<script>
										$('#item_error').html("<strong>This Vehicle cannot be deleted because it has been used in transactions.</strong>");
									</script>
						  <?php }
															
						}
					
					if ($goahead ==1 ){
						$sql_deletetrans =  "delete from tbvehc where trim(vehcno) = '$vehcno'";
						$result_deletetrans = mysqli_query($_SESSION['db_connect'],$sql_deletetrans);
								
						
						$dbobject->apptrail($reqst_by,'BRV',$vehcno ." ".$company,date('d/m/Y H:i:s A'),'Deleted');
						
						 ?>	
							<script>
								$('#item_error').html("<strong>BRV Record Deleted</strong>");
							</script>
				  <?php
						
					}
				
				}
		
		
		
				if($op=='saving')
				{
					
					$goahead = 1;
					
					if (trim($vehcno) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify BRV ID</strong>");
							</script>
				  <?php }
						
					if (trim($trasno) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Transporter ID</strong>");
							</script>
				  <?php }
						
					
						
								
					//echo $goahead;
					if ($goahead==1)
					{
						
						$sql_checktrans = "SELECT * FROM tbvehc where upper(trim(vehcno)) = upper('$vehcno') ";
						$result_checktrans = mysqli_query($_SESSION['db_connect'],$sql_checktrans);
						$count_checktrans = mysqli_num_rows($result_checktrans);
						
						if ($count_checktrans > 0){
							$sql_savetrans = " update tbvehc set 
								 company = '$company', 
								 capacity  = '$capacity', 
								 trasno  = '$trasno' 
								 where trim(vehcno) = '$vehcno'";
							
							$dbobject->apptrail($reqst_by,'BRV',$vehcno ." ".$company,date('d/m/Y H:i:s A'),'Modified');	 
								 
						}else{
							$sql_savetrans = " insert into tbvehc (  
								trasno, company,  capacity, vehcno ) 
								 values ('$trasno', '$company' ,  '$capacity', '$vehcno' ) ";
								 
							$dbobject->apptrail($reqst_by,'BRV',$vehcno ." ".$company,date('d/m/Y H:i:s A'),'Created');	 
							
						}
						$result_savetrans = mysqli_query($_SESSION['db_connect'],$sql_savetrans);
						
						
						//echo $sql_QueryStmt;
						
						
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Transporter Record Saved</strong>");
							</script>
				  <?php
						
					}
					
					
				}
//****			
			

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="brvdef" />
		<input type="hidden" name="get_file" id="get_file" value="brvdef" />
		<table border ="0"  style="padding:0px;">
			<tr>
				<td colspan="2" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input-group">
						<b>Search by: <i>Name or Code</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Truck" />
						<input name="keyword" type="hidden" class="table_text1"  id="keyword" value="<?php echo $keyword; ?>" />
					
					</div>
					<!-- Suggestions will be displayed in below div. -->
				
					   <div id="display"></div>
				</td>  
				
			</tr>
			
		</table>
		<br/>
		<div style="overflow-x:auto;" >
		<table border="0"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
			<tr >
				<td >
					<b>BRV ID : </b>
				</td>
				<td >
					<input type="text" name="vehcno" id="vehcno" value="<?php echo $vehcno; ?>" <?php if ($vehcno != ''){echo 'style="background-color:lightgray" readonly';} ?> placeholder="Enter BRV ID" />
				</td>
				<td >
				
				  <input type="button" name="refreshbutton" id="submit-button" value="Refresh" 
					onclick="javascript:  getpage('brvdef.php?','page');" />
						
				</td>
			</tr>
			<tr>
				<td>
					<b>Transporter Name : </b>
				</td>
				<td colspan="2">
					<?php 
						$k = 0;
						?>
						<select name="trasno"   id="trasno"  >
							<option  value="" ></option>
						<?php

						while($k< $count_transporter) 
						{
							$row = mysqli_fetch_array($result_transporter);
							
						?>
							<option  value="<?php echo trim($row['trasno']);?>" <?php  echo ($trasno== trim($row['trasno']) ?"selected":""); ?>>
								<?php echo trim($row['company']) ;?> 
							</option>
							
						<?php 
							$k++;
							} //End If Result Test	
						?>								
						</select>
				</td>
			</tr>
			<tr>
				<td>
					<b>Capacity : </b>
				</td>
				<td colspan="2">
					<input type="number" name="capacity" id="capacity" value="<?php echo $capacity; ?>" placeholder="Enter Phone Capacity" />
				</td>
			</tr>
			
			
		</table>
		<table>
			
			<tr>
				
				
				<td >
				
					  <input type="button" name="deletebutton" id="submit-button" value="Delete" 
						onclick="deletevehcno();" />
							
				</td>
				
				<td  >
				
					  <input type="button" name="savebutton" id="submit-button" value="Save" 
						onclick="savetrasno();" />
							
				</td>
				<?php if ($count_for_report > 0){ ?>
				<td nowrap="nowrap">
					
					<input type="hidden" id="the_reportname" value="<?php echo trim($rowreport['procname']);?>" />
					<input type="hidden" id="the_reportdesc" value="<?php echo trim($rowreport['reportdesc']);?>" />
					<input type="hidden" id="thestartdate" value="<?php echo trim($rowreport['startdate']);?>" />
					<input type="hidden" id="the_location" value="<?php echo trim($rowreport['location']);?>" />													
					<input type="hidden" id="the_product" value="<?php echo trim($rowreport['product']);?>" />		
					<input type="hidden" id="the_purchaseorder" value="<?php echo trim($rowreport['purchaseorder']);?>" />	
					<input type="hidden" id="the_vendor" value="<?php echo trim($rowreport['vendor']);?>" />	
					<input type="hidden" id="the_customer" value="<?php echo trim($rowreport['customer']);?>" />														
					<input type="hidden" id="the_salesperson" value="<?php echo trim($rowreport['salespsn']);?>" />													
																		
																		
					
					  <input type="button" name="closebutton" id="submit-button" value="Report" 
						onclick="javascript: 
							var reportname = $('#the_reportname').val();var reportdesc = $('#the_reportdesc').val();
							var startdate = $('#the_startdate').val();var location = $('#the_location').val();
							var product = $('#the_product').val();var purchaseorder = $('#the_purchaseorder').val();
							var vendor = $('#the_vendor').val();var customer = $('#the_customer').val();var salespsn = $('#the_salespsn').val();
							
						getpage('reportheader.php?calledby=brvdef&reportname='+reportname+'&reportdesc='+reportdesc+'&thestartdate='+startdate+'&location='+location+'&product='+product+'&purchaseorder='+purchaseorder+'&vendor='+vendor+'&customer='+customer+'&salesperson='+salespsn,'page');" />
				</td>
				<?php } ?>
			</tr>
		
	</table>
	</div>	

			<?php } ?>
	</form>
	<br/>
		<input type="button" name="closebutton" id="submit-button" value="Back" 
			onclick="javascript:  getpage('s_and_d.php?','page');"/>
	<br/>
</div>

<script>
	
	
	function savetrasno(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_transno = $('#trasno').val();$form_vehcno = $('#vehcno').val(); var $form_company = $('#company').val();
			var $form_capacity = $('#capacity').val();
				
			

			var $goahead = 1;
					
			if ($form_vehcno =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter BRV ID ");
			}	
		
			if ($form_transno =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Transporter Name ");
			}	

			
						
			if ($form_capacity.trim() =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Capacity");
			}else{
				if(isNaN($form_capacity)){
					$goahead = $goahead * 0;
					alert("Please Enter a Valid Capacity");
				
				}
				
			}	
			
			if ($goahead == 1) {
				getpage('brvdef.php?op=saving&trasno='+$form_transno
					+'&company='+$form_company
					+'&capacity='+$form_capacity+'&vehcno='+$form_vehcno,'page');						
			}
	
		}
	}


	function deletevehcno(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_transno = $('#trasno').val();$form_vehcno = $('#vehcno').val(); var $form_company = $('#company').val();
			var $form_capacity = $('#capacity').val();
				
			

			var $goahead = 1;
					
			if ($form_vehcno =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter BRV ID ");
			}	
		
			
			if ($goahead == 1) {
				getpage('brvdef.php?op=deletevehcno&trasno='+$form_transno
					+'&company='+$form_company
					+'&capacity='+$form_capacity+'&vehcno='+$form_vehcno,'page');						
			}
	
		}
	}	
</script>