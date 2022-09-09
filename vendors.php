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
	<br />
	<?php 
		require_once("lib/mfbconnect.php"); 
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<div align="center"><h3><strong><font size='12'>Vendor Master</font></strong></h3></div>
		<?php
			if ($_SESSION['pomasters']==1 || $_SESSION['apmasters']==1)
			{
				include("lib/dbfunctions.php");
				$dbobject = new dbfunction();
				$role_id = "";
				
				$user = $_SESSION['username_sess'];
				$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
				$vendorno = !isset($_REQUEST['vendorno'])?'':$_REQUEST['vendorno'];
				$company = !isset($_REQUEST['company'])?'':$dbobject->test_input($_REQUEST['company']);
				$phone = !isset($_REQUEST['phone'])?'':$dbobject->test_input($_REQUEST['phone']);
				$address1 = !isset($_REQUEST['address1'])?'':$dbobject->test_input($_REQUEST['address1']);
				$address2 = !isset($_REQUEST['address2'])?'':$dbobject->test_input($_REQUEST['address2']);
				$city = !isset($_REQUEST['city'])?'':$dbobject->test_input($_REQUEST['city']);
				$state = !isset($_REQUEST['state'])?'':$dbobject->test_input($_REQUEST['state']);
				$contactperson = !isset($_REQUEST['contactperson'])?'':$dbobject->test_input($_REQUEST['contactperson']);
				$email = !isset($_REQUEST['email'])?'':$dbobject->test_input($_REQUEST['email']);
				$alpha3code = !isset($_REQUEST['alpha3code'])?"":$dbobject->test_input($_REQUEST['alpha3code']);
					
				$selectclient = !isset($_REQUEST['selectclient'])?'':$dbobject->test_input($_REQUEST['selectclient']);
				
				$roleid = !isset($_REQUEST['roleid'])?0:$_REQUEST['roleid'];
				
				$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
				$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
				
				$sql_client = "select distinct * FROM vendors WHERE 1=1 order by company";
					$result_client = mysqli_query($_SESSION['db_connect'],$sql_client);
					$count_client = mysqli_num_rows($result_client);
				//echo "dd_no ".$dd_no;
				
				
				if ($vendorno=='')
				{
					$next_refno = 1;
					$check_refno=1;
					
					$transdate = date("d/m/Y H:i:s");
					$refnoday = substr($transdate,0,2);$refnomonth = substr($transdate,3,2);$refnoyear = substr($transdate,6,4); 
					
					$refno =  "V". $refnoday.$refnomonth.$refnoyear.$next_refno;
					$vendorno = $refno;
					
					while ($check_refno==1)
					{
						//check if the reference has been used before
						$sql_checkvendor = "select * from vendors where trim(vendorno) = '$vendorno'";
						
						$result_checkvendor = mysqli_query($_SESSION['db_connect'],$sql_checkvendor);
						$count_checkvendor = mysqli_num_rows($result_checkvendor);
						if ($count_checkvendor > 0)
						{
							$next_refno++;
							$refno =  "V". $refnoday.$refnomonth.$refnoyear.$next_refno;
							$vendorno = $refno ;
						}else {$check_refno=0;}
						
					}
					
					
				}
				// obtain next refno
			
				
				
				$sql_countries = "select * FROM countries ORDER BY country ";
				$result_countries = mysqli_query($_SESSION['db_connect'],$sql_countries);
				$count_countries = mysqli_num_rows($result_countries);
				
				if($op=='getselectclient')
					{
						$filter = "";
						
						$sql_Q = "SELECT * FROM vendors where  ";
						$vendorno = '';		
						if(trim($selectclient)<>'')
							{
								//echo $selectitem;
								$itemdetails = explode("*",$selectclient);
								$vendorno = $itemdetails[0];
								
							}
						
							$filter="  upper(trim(vendorno)) = upper('$vendorno')  ";
						
												
						
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
							$vendorno    = $row['vendorno'];
							$company   = $row['company'];
							$phone = $row['phone'];
							$email = $row['email'];
							$address1  = $row['address1'];
							$address2  = $row['address2'];
							$city  = $row['city'];
							$state  = $row['state'];
							$contactperson  = $row['contactperson'];
							$alpha3code  = $row['alpha3code'];
							$selectclient = trim($row['vendorno'])."*". trim($row['company']) ;
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Vendor does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				
			
			
				if($op=='searchkeyword')
					{
						
						//echo "keyword ".$keyword . "<br/>";
						//echo "string length ".strlen($keyword) . "<br/>";
						$filter=" AND trim(vendorno) like '%$keyword%'   ";
						
						
						$sql_Q = "SELECT * FROM vendors where ";
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
							$vendorno    = $row['vendorno'];
							$company   = $row['company'];
							$phone = $row['phone'];
							$email = $row['email'];
							$address1  = $row['address1'];
							$address2  = $row['address2'];
							$city  = $row['city'];
							$state  = $row['state'];
							$contactperson  = $row['contactperson'];
							$alpha3code  = $row['alpha3code'];
							$selectclient = trim($row['vendorno'])."*". trim($row['company']) ;
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Vendor does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				if($op=='deletevendor')
				{
					$goahead = 1;
					
					if (trim($vendorno) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Vendor ID</strong>");
							</script>
						<?php 
						}else {
							
								$sql_checkpurchaseorder =  "select * from purchaseorder where trim(vendorno) = '$vendorno'";
								$result_checkpurchaseorder = mysqli_query($_SESSION['db_connect'],$sql_checkpurchaseorder);
								$count_checkpurchaseorder = mysqli_num_rows($result_checkpurchaseorder);
									
								if ($count_checkpurchaseorder >=1)
								{
									$goahead = $goahead * 0;
								 ?>	
									<script>
										$('#item_error').html("<strong>This Vendor cannot be deleted because it has been used in transactions.</strong>");
									</script>
						  <?php }
															
						}
					
					if ($goahead ==1 ){
						$sql_deletevendor =  "delete from vendors where trim(vendorno) = '$vendorno'";
						$result_deletevendor = mysqli_query($_SESSION['db_connect'],$sql_deletevendor);
						
						
						$dbobject->apptrail($user,'Vendor',$company ." ".$company,date('d/m/Y H:i:s A'),'Deleted');	
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Vendor Record Deleted</strong>");
							</script>
				  <?php
						
					}
				
				}
		
		
		
				if($op=='saving')
				{
					
					$goahead = 1;
					
					if (trim($vendorno) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Vendor ID</strong>");
							</script>
				  <?php }
						
					
					if (trim($_REQUEST['company']) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Vendor Name</strong>");
							</script>
				  <?php }
						
					
					
						
						if (trim($_REQUEST['contactperson']) =='')
						{
								$goahead = $goahead * 0;
							?>	
								<script>
									$('#item_error').html("<strong>Please specify the Contact Person</strong>");
								</script>
							<?php }	
							
						if (trim($_REQUEST['address1']) =='')
						{
								$goahead = $goahead * 0;
							?>	
								<script>
									$('#item_error').html("<strong>Please specify the Address</strong>");
								</script>
							<?php 
						}		
						if (trim($_REQUEST['city']) =='')
						{
								$goahead = $goahead * 0;
							?>	
								<script>
									$('#item_error').html("<strong>Please specify the City</strong>");
								</script>
							<?php 
						}

						if (trim($_REQUEST['state']) =='')
						{
								$goahead = $goahead * 0;
							?>	
								<script>
									$('#item_error').html("<strong>Please specify the State</strong>");
								</script>
							<?php 
						}
						if (empty($email)) {
								$goahead = $goahead * 0;
							?>	
								<script>
									$('#item_error').html("<strong>Email is required</strong>");
								</script>
							<?php 
						  } else {
							
							if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
							  
							  	$goahead = $goahead * 0;
								?>	
									<script>
										$('#item_error').html("<strong>Invalid email format.</strong>");
									</script>
								<?php 
							}
						  }
						
						if (trim($alpha3code) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Vendor Country</strong>");
							</script>
				  <?php }
					
					
								
					//echo $goahead;
					if ($goahead==1)
					{
						
						$sql_checkVendor = "SELECT * FROM vendors where upper(trim(vendorno)) = upper('$vendorno') ";
						$result_checkVendor = mysqli_query($_SESSION['db_connect'],$sql_checkVendor);
						$count_checkVendor = mysqli_num_rows($result_checkVendor);
						
						if ($count_checkVendor > 0){
							$sql_saveVendor = " update vendors set 
								 company = '$company', 
								 contactperson  = '$contactperson', 
								 phone  = '$phone', 
								 address1  = '$address1', 
								 email  = '$email',  
								 address2 = '$address2', 
								 city  = '$city', 
								 alpha3code  = '$alpha3code', 
								 state  = '$state' 
								where trim(vendorno) = '$vendorno'";
								
							$dbobject->apptrail($user,'Vendor',$company ." ".$company,date('d/m/Y H:i:s A'),'Modified');
						}else{
							$sql_saveVendor = " insert into vendors (  
								alpha3code,vendorno, company, contactperson, phone, 
								email, address1, address2, city, state ) 
								 values ('$alpha3code','$vendorno', '$company' , '$contactperson', '$phone',  '$email', 
								 '$address1' , '$address2', '$city', '$state') ";
								 
							$dbobject->apptrail($user,'Vendor',$company ." ".$company,date('d/m/Y H:i:s A'),'Created');
							
						}
						$result_saveVendor = mysqli_query($_SESSION['db_connect'],$sql_saveVendor);
						
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Vendor Record Saved</strong>");
							</script>
				  <?php
						
					}
					
					
				}
//****			
			

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="vendor" />
		<input type="hidden" name="get_file" id="get_file" value="vendors" />
		<table border ="0"  style="padding:0px;">
			<tr>
				<td colspan="2" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input-group">
						<b>Search by: <i>Name or Code or Phone Number</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Vendor" />
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
					<b>Vendor ID : </b>
				</td>
				<td>
					<input type="text" name="vendorno" id="vendorno" value="<?php echo $vendorno; ?>" <?php if ($vendorno != ''){echo 'readonly';} ?> placeholder="Enter Vendor ID" />
				</td>
				<td>
					<b>Vendor Name : </b>
				</td>
				<td>
					<input type="text" name="company" id="company" value="<?php echo $company; ?>" placeholder="Enter Vendor Name" />
				</td>
			</tr>
			<tr >
				<td >
					<b>Contact Person : </b>
				</td>
				<td>
					<input type="text" name="contactperson" id="contactperson" value="<?php echo $contactperson; ?>"  placeholder="Enter Contact Person" />
				</td>
				<td>
					<b>Email : </b>
				</td>
				<td>
					<input type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter Vendor Email" />
				</td>
			</tr>
			<tr >
				<td >
					<b>Address1 : </b>
				</td>
				<td colspan="3">
					<input type="text" size="60px" name="address1" id="address1" value="<?php echo $address1; ?>"  placeholder="Enter Address Line 1" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Address2 : </b>
				</td>
				<td>
					<input type="text" name="address2" id="address2" value="<?php echo $address2; ?>" placeholder="Enter Address Line 2" />
				</td>
				<td>
					<b>Phone : </b>
				</td>
				<td>
					<input type="tel" name="phone" id="phone" value="<?php echo $phone; ?>"  placeholder="Enter Phone Number" pattern="[0-9]{4,12}" title="Only Digits" />
				</td>
			</tr>
			<tr >
				<td >
					<b>City : </b>
				</td>
				<td>
					<input type="text" name="city" id="city" value="<?php echo $city; ?>"  placeholder="Enter City" />
				</td>
				<td>
					<b>State : </b>
				</td>
				<td>
					<input type="text" name="state" id="state" value="<?php echo $state; ?>" placeholder="Enter State" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Country : </b>
				</td>
				<td colspan="3">
					<?php 
						$k = 0;
						?>
						
						<select name="alpha3code"   id="alpha3code" >
							<option  value="" ></option>
						<?php

						while($k< $count_countries) 
						{
							$row = mysqli_fetch_array($result_countries);
							//$theselectedcatg = trim($row['catcd'])."*  ". trim($row['catdesc']) ;
						?>
							<option  value="<?php echo trim($row['alpha3code']);?>" <?php  echo ($alpha3code== trim($row['alpha3code']) ?"selected":""); ?>>
								<?php echo trim($row['country']) ;?> 
							</option>
							
						<?php 
							$k++;
							} //End If Result Test	
						?>								
						</select>
				</td>
				
			</tr>
		</table>
		<table>
			
			<tr>
				
				<td >
				
					  <input type="button" name="refreshbutton" title="Click to prepare form for a New Vendor creation" id="submit-button" value="Refresh" 
						onclick="javascript:  getpage('vendors.php?','page');" />
							
				</td>
				<td >
				
					  <input type="button" name="deletebutton"  id="submit-button" value="Delete" 
						onclick="deletevendor();" />
							
				</td>
				
				<td  >
				
					  <input type="button" name="savebutton" id="submit-button" value="Save" 
						onclick="savevendor();" />
							
				</td>
				<td>
					<?php $calledby = 'vendors'; $reportid = 49; include("specificreportlink.php");  ?>
				</td>
			</tr>
		
	</table>
	</div>	

			<?php } ?>
	</form>
	<br />
	 <input type="button" name="closebutton" id="submit-button" value="Back" 
						onclick="javascript:  getpage('finance.php?','page');
							">
	<br />
</div>

<script>
	
	
	function savevendor(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_vendorno = $('#vendorno').val();$form_address1 = $('#address1').val(); var $form_company = $('#company').val();
			var $form_address2 = $('#address2').val();var $form_email = $('#email').val();var $form_city = $('#city').val();
				var $form_contactperson = $('#contactperson').val();var $form_phone = $('#phone').val();var $form_state = $('#state').val();
				var $form_alpha3code = $('#alpha3code').val();
			
		
			var $goahead = 1;
					
			if ($form_vendorno =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Vendor ID ");
			}	
		
			if ($form_company =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Vendor Name ");
			}	
			
			if ($form_alpha3code.trim() =='')
			{
				$goahead = $goahead * 0;
				alert("Please Select a Country ");
			}	
			
			if ($form_address1 =='')
			{
				$goahead = $goahead * 0;
				alert("Please specify the Address");
			}	
						
			if ($form_phone =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter a Phone Number");
			}		
			if ($form_contactperson =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter a Contact Person");
			}
			if ($form_state =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter State");
			}
			if ($form_city =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter City");
			}
			
			if ($form_phone.trim() =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter a Phone Number");
			}else{
				if(isNaN($form_phone)){
					$goahead = $goahead * 0;
					alert("Please Enter a Valid Phone Number");
				
				}
				
			}		
			
			if ($goahead == 1) {
				getpage('vendors.php?op=saving&vendorno='+$form_vendorno
					+'&company='+$form_company+'&alpha3code='+$form_alpha3code
					+'&contactperson='+$form_contactperson+'&phone='+$form_phone+'&address1='+$form_address1+'&address2='+$form_address2
					+'&city='+$form_city+'&state='+$form_state+'&email='+$form_email,'page');						
			}
	
		}
	}


	function deletevendor(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_vendorno = $('#vendorno').val();$form_address1 = $('#address1').val(); var $form_company = $('#company').val();
			var $form_address2 = $('#address2').val();var $form_email = $('#email').val();var $form_city = $('#city').val();
				var $form_contactperson = $('#contactperson').val();var $form_phone = $('#phone').val();var $form_state = $('#state').val();
				
			

			var $goahead = 1;
					
			if ($form_vendorno =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Vendor ID ");
			}	
		
			
			if ($goahead == 1) {
				getpage('vendors.php?op=deletevendor&vendorno='+$form_vendorno
					+'&company='+$form_company
					+'&contactperson='+$form_contactperson+'&phone='+$form_phone+'&address1='+$form_address1+'&address2='+$form_address2
					+'&city='+$form_city+'&state='+$form_state+'&email='+$form_email,'page');						
			}
	
		}
	}	
</script>