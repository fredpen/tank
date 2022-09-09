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
		<h3><strong><font size='5'>Customer Category Pricing Policy </font></strong></h3>
		<?php
			if ($_SESSION['somasters']==1)
			{
				include("lib/dbfunctions.php");
				$dbobject = new dbfunction();
				$role_id = "";
				
				$user = $_SESSION['username_sess'];
				$op = !isset($_REQUEST['op'])?'':$dbobject->test_input($_REQUEST['op']);	
				$item = !isset($_REQUEST['item'])?'':$dbobject->test_input($_REQUEST['item']);
				$itemdesc = !isset($_REQUEST['itemdesc'])?'':$dbobject->test_input($_REQUEST['itemdesc']);
				$custno = !isset($_REQUEST['custno'])?'':$dbobject->test_input($_REQUEST['custno']);
				$company = !isset($_REQUEST['company'])?'':$dbobject->test_input($_REQUEST['company']);
				$vat = !isset($_REQUEST['vat'])?0:$dbobject->test_input($_REQUEST['vat']);
				$disctype = !isset($_REQUEST['disctype'])?1:$dbobject->test_input($_REQUEST['disctype']);
				$srvchg = !isset($_REQUEST['srvchg'])?0:$dbobject->test_input($_REQUEST['srvchg']);
				$nfr = !isset($_REQUEST['nfr'])?0.00:$dbobject->test_input($_REQUEST['nfr']);
				$dmargin = !isset($_REQUEST['dmargin'])?0.00:$dbobject->test_input($_REQUEST['dmargin']);
				$misc = !isset($_REQUEST['misc'])?0.00:$dbobject->test_input($_REQUEST['misc']);
				$slabid = !isset($_REQUEST['slabid'])?'':$dbobject->test_input($_REQUEST['slabid']);
				$netprice = !isset($_REQUEST['netprice'])?0.00:$dbobject->test_input($_REQUEST['netprice']);
				$otprice = !isset($_REQUEST['otprice'])?0.00:$dbobject->test_input($_REQUEST['otprice']);	
				$selectitem = !isset($_REQUEST['selectitem'])?'':$dbobject->test_input($_REQUEST['selectitem']);
				$catcd = !isset($_REQUEST['catcd'])?'':$dbobject->test_input($_REQUEST['catcd']);
				$catdesc = !isset($_REQUEST['catdesc'])?'':$dbobject->test_input($_REQUEST['catdesc']);
				
				$roleid = !isset($_REQUEST['roleid'])?0:$_REQUEST['roleid'];
				
				$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
				$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
				
				$slabdef_var = Array();
				$sql_slabdef = "select distinct * FROM slabdef WHERE 1=1 order by trim(slabdesc)";
				$result_slabdef = mysqli_query($_SESSION['db_connect'],$sql_slabdef);
				$count_slabdef = mysqli_num_rows($result_slabdef);
					
				$k=0;
				while ($k<$count_slabdef){
					$row = mysqli_fetch_array($result_slabdef);
					$slabdef_var[$k]['slabid']=$row['slabid'];
					$slabdef_var[$k]['slabdesc']=$row['slabdesc'];
					
					$k++;
				}
				
				$sql_for_report = "select * from reptable where reportid = 60";
				$result_for_report = mysqli_query($_SESSION['db_connect'],$sql_for_report);
				$count_for_report = mysqli_num_rows($result_for_report);
				
				if ($count_for_report > 0){
					$rowreport = mysqli_fetch_array($result_for_report);
					
				}
				
				
				
				$sql_item = "select distinct * FROM icitem WHERE 1=1 order by itemdesc";
				$result_item = mysqli_query($_SESSION['db_connect'],$sql_item);
				$count_item = mysqli_num_rows($result_item);
				
				$sql_Customer_Category = "select catcd,catdesc FROM catg where cattype='C' ORDER BY catdesc";
				$result_Customer_Category = mysqli_query($_SESSION['db_connect'],$sql_Customer_Category);
				$count_Customer_Category = mysqli_num_rows($result_Customer_Category);
									
				if($op=='getselectitem')
					{
						$filter = "";
						
						$sql_Q = "SELECT * FROM icitem where  ";
						$filter="  upper(trim(item)) = upper('$item')  ";
						
												
						
						$orderby = "   ";
						$orderflag	= " ";
						$order = $orderby." ".$orderflag;
						$sql_QueryStmt = $sql_Q.$filter.$order. " limit 1";
							
						//echo "<br/> sql_Q ".$sql_Q;	
						//echo "<br/>".$sql_QueryStmt."<br/>";
						$result_QueryStmt = mysqli_query($_SESSION['db_connect'],$sql_QueryStmt);
						$count_QueryStmt = mysqli_num_rows($result_QueryStmt);
						
						if ($count_QueryStmt >0){
							$row       = mysqli_fetch_array($result_QueryStmt);
							$item    = $row['item'];
							$itemdesc   = $row['itemdesc'];
							$otprice   = $row['otprice'];
							$selectitem = trim($row['item'])."*". trim($row['itemdesc']) ;
							
							$sql_grprice = "select * from grprice where trim(custno)= '$catcd' and trim(item)= '$item'";
							$result_grprice = mysqli_query($_SESSION['db_connect'],$sql_grprice);
							$count_grprice = mysqli_num_rows($result_grprice);
							if ($count_grprice > 0)
							{
								$row  = mysqli_fetch_array($result_grprice);
							
								$srvchg  = $row['srvchg'];
								$nfr  = $row['nfr'];
								$dmargin  = $row['dmargin'];
								$disctype  = $row['disctype'];
								$misc  = $row['misc'];
								$slabid  = $row['slabid'];
								$vat  = $row['vat'];
							}
							
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Item does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				
			
			
				if($op=='searchkeyword')
					{
						$filter=" AND trim(item) like '%$keyword%'   ";
						
						$sql_Q = "SELECT * FROM icitem where ";
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
							$item    = $row['item'];
							$itemdesc   = $row['itemdesc'];
							$otprice   = $row['otprice'];
							
							$sql_grprice = "select * from grprice where trim(custno)= '$catcd' and trim(item)= '$item'";
							$result_grprice = mysqli_query($_SESSION['db_connect'],$sql_grprice);
							$count_grprice = mysqli_num_rows($result_grprice);
							if ($count_grprice > 0)
							{
								$row  = mysqli_fetch_array($result_grprice);
								
								$srvchg  = $row['srvchg'];
								$nfr  = $row['nfr'];
								$dmargin  = $row['dmargin'];
								$disctype  = $row['disctype'];
								$misc  = $row['misc'];
								$slabid  = $row['slabid'];
								$vat  = $row['vat'];
							}
							
							
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Item does not exist</strong>");
							</script>
						<?php	
						}	
						
						
					}			
					
				if($op=='delete')
				{
					
					$goahead = 1;
					
					if (trim($item) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Item ID</strong>");
							</script>
				  <?php }
						
					
						  
								
					//echo $goahead;
					if ($goahead==1)
					{
						
						{
					
							$sql_delete_grprice = " delete from grprice 
							where trim(item) = '$item' and trim(custno) = '$catcd'";
						}
							
						$result_delete_grprice = mysqli_query($_SESSION['db_connect'],$sql_delete_grprice);
						
						
						
						$dbobject->apptrail($user,'Customer Category Pricing',$catcd." ".$itemdesc,date('d/m/Y H:i:s A'),'Deleted');
						 ?>	
							<script>
								$('#item_error').html("<strong>Customer Category Pricing Policy Record Deleted</strong>");
							</script>
						<?php
				  
					}
				}
					
				if($op=='saving')
				{
					
					$goahead = 1;
					
					if (trim($item) =='')
						{
							$goahead = $goahead * 0;
						 ?>	
							<script>
								$('#item_error').html("<strong>Please specify Item ID</strong>");
							</script>
				  <?php }
						
					
						  
								
					//echo $goahead;
					if ($goahead==1)
					{
						$sql_grprice = "select * from grprice where trim(custno)= '$catcd' and trim(item)= '$item'";
							$result_grprice = mysqli_query($_SESSION['db_connect'],$sql_grprice);
							$count_grprice = mysqli_num_rows($result_grprice);
							if ($count_grprice > 0)
							{
						
								$sql_save_grprice = " update grprice set 
										 srvchg  = $srvchg ,
										 nfr  = $nfr ,
										 disctype  = $disctype ,
										 dmargin  = $dmargin ,
										 misc  = $misc ,
										 vat  = $vat ,
										 slabid  = '$slabid' 
										 where trim(item) = '$item' and trim(custno) = '$catcd'";
										 
								$dbobject->apptrail($user,'Customer Category Pricing',$catcd." ".$itemdesc,date('d/m/Y H:i:s A'),'Modified');
							}
							else {
								$sql_save_grprice =" insert into grprice (custno, item, srvchg,dmargin, nfr,misc, vat,slabid,disctype )  
									  values ( '$catcd','$item',$srvchg,$dmargin, $nfr, $misc, $vat,'$slabid',$disctype ) ";
									  
								$dbobject->apptrail($user,'Customer Category Pricing',$catcd." ".$itemdesc,date('d/m/Y H:i:s A'),'Created');
								
							}
						$result_save_grprice = mysqli_query($_SESSION['db_connect'],$sql_save_grprice);
						//echo $sql_save_grprice;
						
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Group Pricing Policy Record Saved</strong>");
							</script>
				  <?php
						
					}
					
					
				}
		
			$holdmargin = $otprice + $srvchg - $dmargin + $nfr + $misc;
			$netprice = (($vat * $holdmargin)/100) +  $holdmargin;
			//echo $selectedchart;

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="custno" id="custno" value="<?php echo $custno; ?>" />
		<input type="hidden" name="company" id="company" value="<?php echo $company; ?>" />
		
		<input type="hidden" name="thetablename" id="thetablename" value="item" />
		<input type="hidden" name="get_file" id="get_file" value="group_price_policy" />
		
		<table border ="0"  style="padding:0px;">
			<tr>
				<td colspan="2" style="color:red;" id = "item_error" align = "left"  ></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="input-group">
						<b>Search by: <i>Name or Code</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Product" />
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
			<tr>
				<td valign="top">
					<b>Business Category : </b>
				</td>
				<td colspan="3">
					<?php 
						$k = 0;
						?>
						<select name="catcd"   id="catcd" 
							onChange="javascript: retrievegrprice();"
						
						>
							<option  value="" ></option>
						<?php

						while($k< $count_Customer_Category) 
						{
							$row = mysqli_fetch_array($result_Customer_Category);
							//$theselectedcatg = trim($row['catcd'])."*". trim($row['catdesc']) ;
						?>
							<option  value="<?php echo trim($row['catcd']) ;?>" <?php  echo ($catcd== trim($row['catcd']) ?"selected":""); ?>>
								<?php echo trim($row['catdesc']) ;?> 
							</option>
							
						<?php 
							$k++;
							} //End If Result Test	
						?>								
						</select>
				</td>
				
			</tr>
			
			<tr >
				<td nowrap="nowrap">
					<b>Item ID : </b>
				</td>
				<td colspan="3" >
					<?php echo $item; ?> <input type="hidden" name="item" id="item" value="<?php echo $item; ?>" />
				</td>
				
				
				
			</tr>
			<tr >
				
				<td>
					<b>Item Description : </b>
				</td>
				<td colspan="3">
					<?php echo $itemdesc; ?> <input type="hidden" name="itemdesc" id="itemdesc" value="<?php echo $itemdesc; ?>" />
				</td>
				
			</tr>
		</table>
		<table border="0"  >
			<tr >
				<td align="center" >
					
					
						<input type="radio" name="disctype" id="cshflat" <?php if ($disctype==1){echo 'checked';}?>  onClick="javascript: disctyperefresh(this.id);" />&nbsp;&nbsp;Flat Discount
				</td>
				<td>
						<input type="radio" name="disctype" id="cshslab" <?php if ($disctype==2){echo 'checked';}?>  onClick="javascript: disctyperefresh(this.id);" />&nbsp;&nbsp;Slab Discount
					
				</td>
				
				
				<td >
				
					  <input type="button" name="refreshbutton" id="submit-button" value="Refresh" 
						onclick="javascript:  	getpage('group_price_policy.php','page');" />
							
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
							
						getpage('reportheader.php?calledby=group_price_policy&reportname='+reportname+'&reportdesc='+reportdesc+'&thestartdate='+startdate+'&location='+location+'&product='+product+'&purchaseorder='+purchaseorder+'&vendor='+vendor+'&customer='+customer+'&salesperson='+salespsn,'page');" />
				</td>
				<?php } ?>
			</tr>
		</table>
		<div id="showflatdiv"  <?php if ($disctype !=1){echo 'style="display:none"';}?> >
			<table border="0"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
				<tr>
					<td>
						<b>Service Charge</b>
					</td>
					<td>
						<input type="number" id="srvchg" name="srvchg" value="<?php echo $srvchg; ?>" min="0" max="999999"  onChange= "javascript: refreshoption(); "/>

					</td>
					<td>
						<b>Non Fuel Retail</b>
					</td>
					<td>
						<input type="number" id="nfr" name="nfr" value="<?php echo $nfr; ?>" min="0" max="999999"  onChange= "javascript: refreshoption(); "/>

					</td>
				</tr>
				<tr>
					<td>
						<b>Margin</b>
					</td>
					<td>
						<input type="number" id="dmargin" name="dmargin" value="<?php echo $dmargin; ?>" min="0" max="999999"  onChange= "javascript: refreshoption();" />

					</td>
					<td>
						<b>Misc Charges</b>
					</td>	
					<td>
						<input type="number" id="misc" name="misc" value="<?php echo $misc; ?>" min="0" max="999999"  onChange= "javascript: refreshoption(); "/>

					</td>
				</tr>
				<tr>
					<td>
						<b>Vat</b>
					<td>
						 <input type="number" id="vat" name="vat" value= "<?php echo number_format($vat,2); ?>" min="0" max="999999" onChange= "javascript: refreshoption(); "/>

					</td>
					<td>
						<b>Default Base Price</b><br />
						<b>Net Price</b>
					<td>
						<?php echo number_format($otprice,2); ?> <input type="hidden" id="otprice" value= "<?php echo number_format($otprice,2); ?>" />
						<br />
						<input id="netprice" title= "netprice = Base Price + Service Charge - Dealer Margin + Non Fuel Retail + Miscellaneous plus vat value" style="background-color:lightgray" type="number" name="netprice" value="<?php echo $netprice; ?>" readonly  min="0" max="999999"/>

					</td>
				</tr>
			</table>
		</div>
		<div id="showslabdiv"  <?php if ($disctype !=2){echo 'style="display:none"';}?> >
			<table border="0"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
				
				
				<tr >
					<td>
						<b>Please Select Discount Slab Definition</b>
					</td>
					<td >
						<?php 
							$k = 0;
							?>
							
							<select name="slabid"   id="slabid"   >
								<option  value="" ></option>
							<?php

							while($k< $count_slabdef) 
							{
								

							?>
								<option  value="<?php echo trim($slabdef_var[$k]['slabid']) ;?>" <?php  echo ($slabid== trim($slabdef_var[$k]['slabid']) ?"selected":""); ?>>
									<?php echo trim($slabdef_var[$k]['slabdesc']) ;?> 
								</option>
								
							<?php 
								$k++;
								} //End If Result Test	
							?>								
							</select>
					</td>
				</tr>
				
				
			</table>
		</div>
		<table>
			
			<tr>
				
				<td  >
				
					  <input type="button" name="savebutton" id="submit-button" value="Save" 
						onclick="savecustomerdiscount('save');" />
							
				</td>
				
				<td  >
				
					  <input type="button" name="deletebutton" id="submit-button" value="Delete" 
						onclick="savecustomerdiscount('del');" />
							
				</td>
				
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
	function retrievegrprice()
	{
		
		
		var $form_catcd = $('#catcd').val();var $form_item = $('#item').val(); var $form_itemdesc = $('#itemdesc').val();  
		if ($form_catcd != '' && $form_item != '')
		{
			getpage('group_price_policy.php?op=getselectitem&item='+$form_item+'&itemdesc='+$form_itemdesc+'&catcd='+$form_catcd
			,'page');
		}
			
			
	}

	function disctyperefresh(id)
	{
		
		
		var flatdiscount = document.getElementById('showflatdiv');
		var slabdiscount = document.getElementById('showslabdiv');
		
		if (id=="cshflat")
		{
			flatdiscount.style.display = "block";
			slabdiscount.style.display = "none";
		}else
		{
			flatdiscount.style.display = "none";
			slabdiscount.style.display = "block";
		}
			
	}
	
function refreshoption() 
	{
		var nfr = document.getElementById('nfr').value;
		var misc = document.getElementById('misc').value;
		var dmargin = document.getElementById('dmargin').value;
		var srvchg = document.getElementById('srvchg').value;
		var otprice = document.getElementById('otprice').value;
		var vat = document.getElementById('vat').value;
		var holdmargin = 0;
		var netprice = document.getElementById('netprice');
		
		
		holdmargin = Number(otprice) + Number(srvchg) - Number(dmargin) + Number(nfr) + Number(misc);
		netprice.value = ((Number(vat) * Number(holdmargin))/100) +  Number(holdmargin);
		
		
    }
		
	
	function savecustomerdiscount(action){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_item = $('#item').val();$form_custno = $('#custno').val(); var $form_company = $('#company').val();
			var $form_itemdesc = $('#itemdesc').val();
			var $form_vat = $('#vat').val();var $form_srvchg = $('#srvchg').val();
			var $form_nfr = $('#nfr').val();var $form_dmargin = $('#dmargin').val();
			var $form_misc = $('#misc').val();var $form_slabid = $('#slabid').val();
			var $form_otprice = $('#otprice').val();var $form_catcd = $('#catcd').val();
			
			var radiodisctype = document.getElementsByName('disctype');
			
			
			var $disctype = 0;
			for(i = 0; i < 2; i++) 
			{
				if(radiodisctype[i].checked){
					if (i==0){
						$disctype = 1;
					}else {
						$disctype = 2;
					}
				}
				
				
				
			}
			
			var $goahead = 1;
					
			if ($form_item.trim() =='')
			{
				$goahead = $goahead * 0;
				alert("Please Enter Item ID ");
			}	
		
			
			
			if ($goahead == 1) {
				if (action=='save')
				{
					thegetpage='group_price_policy.php?op=saving&item='+$form_item
						+'&custno='+$form_custno+'&itemdesc='+$form_itemdesc
						+'&company='+$form_company+'&catcd='+$form_catcd
						+'&srvchg='+$form_srvchg
						+'&nfr='+$form_nfr+'&vat='+$form_vat
						+'&dmargin='+$form_dmargin+'&otprice='+$form_otprice
						+'&disctype='+$disctype+'&misc='+$form_misc+'&slabid='+$form_slabid;
				}else {
					thegetpage='group_price_policy.php?op=delete&item='+$form_item
						+'&custno='+$form_custno+'&itemdesc='+$form_itemdesc
						+'&company='+$form_company+'&catcd='+$form_catcd
						+'&srvchg='+$form_srvchg
						+'&nfr='+$form_nfr+'&vat='+$form_vat
						+'&dmargin='+$form_dmargin+'&otprice='+$form_otprice
						+'&disctype='+$disctype+'&misc='+$form_misc+'&slabid='+$form_slabid;		
					//alert(thegetpage);					
				}
	
				getpage(thegetpage,'page');						
			}
	
		}
	}


		
</script>