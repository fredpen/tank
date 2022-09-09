<?php 
	ob_start();
	include_once "session_track.php";
?>


<style>
	td {padding:5px;}
	
</style>
<script type="text/javascript" src="js/dynamic_search_script.js"></script>

<div align ="center" id="data-form" > 

	<?php 
		require_once("lib/mfbconnect.php"); 
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong><font size='10'>Item Pricing </font></strong></h3>
		<?php
			if ($_SESSION['ivmasters']==1)
			{
				include("lib/dbfunctions.php");
				$dbobject = new dbfunction();
				$role_id = "";
				
				$user = $_SESSION['username_sess'];
				$op = !isset($_REQUEST['op'])?'':$_REQUEST['op'];	
				$item = !isset($_REQUEST['item'])?'':$_REQUEST['item'];
				$itemdesc = !isset($_REQUEST['itemdesc'])?'':$dbobject->test_input($_REQUEST['itemdesc']);
				$retail = !isset($_REQUEST['retail'])?1:$dbobject->test_input($_REQUEST['retail']);
				$retflat = !isset($_REQUEST['retflat'])?0:$dbobject->test_input($_REQUEST['retflat']);
				$recent = !isset($_REQUEST['recent'])?0.00:$dbobject->test_input($_REQUEST['recent']);
				$retslab = !isset($_REQUEST['retslab'])?'':$dbobject->test_input($_REQUEST['retslab']);
				$ow = !isset($_REQUEST['ow'])?1:$dbobject->test_input($_REQUEST['ow']);
				$owflat = !isset($_REQUEST['owflat'])?0:$dbobject->test_input($_REQUEST['owflat']);
				$owcent = !isset($_REQUEST['owcent'])?0.00:$dbobject->test_input($_REQUEST['owcent']);
				$owslab = !isset($_REQUEST['owslab'])?'':$dbobject->test_input($_REQUEST['owslab']);
				$pr = !isset($_REQUEST['pr'])?1:$dbobject->test_input($_REQUEST['pr']);
				$prflat = !isset($_REQUEST['prflat'])?0:$dbobject->test_input($_REQUEST['prflat']);
				$prcent = !isset($_REQUEST['prcent'])?0.00:$dbobject->test_input($_REQUEST['prcent']);
				$prslab = !isset($_REQUEST['prslab'])?'':$dbobject->test_input($_REQUEST['prslab']);
				$vat = !isset($_REQUEST['vat'])?0:$dbobject->test_input($_REQUEST['vat']);
				$scprice = !isset($_REQUEST['scprice'])?0:$dbobject->test_input($_REQUEST['scprice']);
				$otprice = !isset($_REQUEST['otprice'])?0:$dbobject->test_input($_REQUEST['otprice']);
				$prvalidity = !isset($_REQUEST['prvalidity'])?date('Y-m-d'):$dbobject->test_input($_REQUEST['prvalidity']);
				$owscprice = !isset($_REQUEST['owscprice'])?0:$dbobject->test_input($_REQUEST['owscprice']);
				$owotprice = !isset($_REQUEST['owotprice'])?0:$dbobject->test_input($_REQUEST['owotprice']);
				$owprvalid = !isset($_REQUEST['owprvalid'])?date('Y-m-d'):$dbobject->test_input($_REQUEST['owprvalid']);
				$prscprice = !isset($_REQUEST['prscprice'])?0:$dbobject->test_input($_REQUEST['prscprice']);
				$protprice = !isset($_REQUEST['protprice'])?0:$dbobject->test_input($_REQUEST['protprice']);
				$prprvalid = !isset($_REQUEST['prprvalid'])?date('Y-m-d'):$dbobject->test_input($_REQUEST['prprvalid']);
				
				
				$chartcode = !isset($_REQUEST['chartcode'])?'':$dbobject->test_input($_REQUEST['chartcode']);
				$description = !isset($_REQUEST['description'])?'':$dbobject->test_input($_REQUEST['description']);
				$volfactor = !isset($_REQUEST['volfactor'])?'':$dbobject->test_input($_REQUEST['volfactor']);
				$pack = !isset($_REQUEST['pack'])?'':$dbobject->test_input($_REQUEST['pack']);
					
				$selectitem = !isset($_REQUEST['selectitem'])?'':$dbobject->test_input($_REQUEST['selectitem']);
				
				
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
				
				$sql_item = "select distinct * FROM icitem WHERE 1=1 order by itemdesc";
				$result_item = mysqli_query($_SESSION['db_connect'],$sql_item);
				$count_item = mysqli_num_rows($result_item);
				
				$sql_chart_of_account = "select * from chart_of_account where TRIM(UCASE(description)) like '%INVENTORY%' ";
				$result_chart_of_account = mysqli_query($_SESSION['db_connect'],$sql_chart_of_account);
				$count_chart_of_account = mysqli_num_rows($result_chart_of_account);
				
									
				if($op=='getselectitem')
					{
						$filter = "";
						
						$sql_Q = "SELECT * FROM icitem where  ";
						$item = '';		
						if(trim($selectitem)<>'')
							{
								//echo $selectitem;
								$itemdetails = explode("*",$selectitem);
								$item = $itemdetails[0];
								
							}
						
							$filter="  upper(trim(item)) = upper('$item')  ";
						
												
						
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
							$item    = $row['item'];
							$itemdesc   = $row['itemdesc'];
							$vat = $row['vat'];
							$scprice = $row['scprice'];
							$otprice  = $row['otprice'];
							$prvalidity  = $row['prvalidity'];
							$owscprice  = $row['owscprice'];
							$owotprice  = $row['owotprice'];
							$owprvalid  = $row['owprvalid'];
							$prscprice  = $row['prscprice'];
							$protprice  = $row['protprice'];
							$prprvalid  = $row['prprvalid'];
							$retail  = $row['retail'];
							$retflat  = $row['retflat'];
							$recent  = $row['recent'];
							$retslab  = $row['retslab'];
							$ow  = $row['ow'];
							$owflat  = $row['owflat'];
							$owcent  = $row['owcent'];
							$owslab  = $row['owslab'];
							$pr  = $row['pr'];
							$prflat  = $row['prflat'];
							$prcent  = $row['prcent'];
							$prslab  = $row['prslab'];
							
							$selectitem = trim($row['item'])."*". trim($row['itemdesc']) ;
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
							$vat = $row['vat'];
							$scprice = $row['scprice'];
							$otprice  = $row['otprice'];
							$prvalidity  = $row['prvalidity'];
							$owscprice  = $row['owscprice'];
							$owotprice  = $row['owotprice'];
							$owprvalid  = $row['owprvalid'];
							$prscprice  = $row['prscprice'];
							$protprice  = $row['protprice'];
							$prprvalid  = $row['prprvalid'];
							$retail  = $row['retail'];
							$retflat  = $row['retflat'];
							$recent  = $row['recent'];
							$retslab  = $row['retslab'];
							$ow  = $row['ow'];
							$owflat  = $row['owflat'];
							$owcent  = $row['owcent'];
							$owslab  = $row['owslab'];
							$pr  = $row['pr'];
							$prflat  = $row['prflat'];
							$prcent  = $row['prcent'];
							$prslab  = $row['prslab'];
							
							
							$selectitem = trim($row['item'])."*". trim($row['itemdesc']) ;
						}else 	
						{
						?>
							<script>
							
							$('#item_error').html("<strong>Item does not exist</strong>");
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
						//2022-02-03
						$thisday =substr($prvalidity,8,2);
						$thismth =substr($prvalidity,5,2); 
						$thisY = substr($prvalidity,0,4); 
						
						$prvalidity = $thisday.'/'.$thismth.'/'.$thisY;
						
						$thisday =substr($owprvalid,8,2);
						$thismth =substr($owprvalid,5,2); 
						$thisY = substr($owprvalid,0,4); 
						
						$owprvalid = $thisday.'/'.$thismth.'/'.$thisY;
						
						$thisday =substr($prprvalid,8,2);
						$thismth =substr($prprvalid,5,2); 
						$thisY = substr($prprvalid,0,4); 
						
						$prprvalid = $thisday.'/'.$thismth.'/'.$thisY;
						
						$sql_saveIcitem = " update icitem set 
								vat = $vat ,
								 scprice = $scprice ,
								 otprice  = $otprice, 
								 prvalidity  = '$prvalidity' ,
								 owscprice  = $owscprice ,
								 owotprice  = $owotprice ,
								 owprvalid  = '$owprvalid',
								 prscprice  = $prscprice ,
								 protprice  = $protprice ,
								 prprvalid  = '$prprvalid' ,
								 retail  = $retail ,
								 retflat  = $retflat ,
								 recent  = $recent ,
								 retslab  = '$retslab' ,
								 ow  = $ow ,
								 owflat  = $owflat ,
								 owcent  = $owcent ,
								 owslab  = '$owslab' ,
								 pr  = $pr ,
								 prflat  = $prflat ,
								 prcent  = $prcent ,
								 prslab  = '$prslab' 
								 where trim(item) = '$item'";
						
						$result_saveIcitem = mysqli_query($_SESSION['db_connect'],$sql_saveIcitem);
						
												
						$dbobject->apptrail($user,'Item Pricing',$itemdesc,date('d/m/Y H:i:s A'),'Modified');
						
						 ?>	
							<script>
								$('#item_error').html("<strong>Item Record Saved</strong>");
							</script>
				  <?php
						
					}
					
					
				}
		
			$selectedchart = trim($chartcode)."*". trim($description) ;
			
					
				if (date('Y-m-d',strtotime($prvalidity)) != date('Y-m-d') )
				{
					$thisday =substr($prvalidity,0,2);
					$thismth =substr($prvalidity,3,2); 
					$thisY = substr($prvalidity,6,4); 
					
					$newd = $thismth.'/'.$thisday.'/'.$thisY;
					$prvalidity = date('Y-m-d',strtotime($newd));
					
				}
				
				if (date('Y-m-d',strtotime($owprvalid)) != date('Y-m-d'))
				{
					//echo 'Before '.$owprvalid.'<br />' ;
					$thisday =substr($owprvalid,0,2);
					$thismth =substr($owprvalid,3,2); 
					$thisY = substr($owprvalid,6,4); 
					
					$newd = $thismth.'/'.$thisday.'/'.$thisY;
					$owprvalid = date('Y-m-d',strtotime($newd));
					//echo $owprvalid ;
				}
				
				if (date('Y-m-d',strtotime($prprvalid)) != date('Y-m-d'))
				{
					$thisday =substr($prprvalid,0,2);
					$thismth =substr($prprvalid,3,2); 
					$thisY = substr($prprvalid,6,4); 
					
					$prprvalid = $thismth.'/'.$thisday.'/'.$thisY;
					$newd = $thismth.'/'.$thisday.'/'.$thisY;
					$prprvalid = date('Y-m-d',strtotime($newd));
				}
				
			
			//echo $selectedchart;

		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="item" />
		<input type="hidden" name="get_file" id="get_file" value="item_pricing" />
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
			<tr >
				<td nowrap="nowrap">
					<b>Item ID : </b>
				</td>
				<td colspan="2" >
					<?php echo $item; ?> <input type="hidden" name="item" id="item" value="<?php echo $item; ?>" />
				</td>
				
				
				<td >
				
					  <input type="button" name="refreshbutton" id="submit-button" value="Refresh" 
						onclick="javascript:  getpage('item_pricing.php?','page');" />
							
				</td>
			</tr>
			<tr >
				
				<td>
					<b>Item Description : </b>
				</td>
				<td colspan="2">
					<?php echo $itemdesc; ?> 
				</td>
				<td>
					<b>Vat</b>&nbsp;&nbsp;<input type="number" id="vat" name="vat" value="<?php echo $vat; ?>" min="0.00" max="99.99">
				</td>
			</tr>
			<tr >
				<td>
				</td>
				<td>
					<b>Self Collection Price</b>
				</td>
				<td><b>Other Price</b>
				</td>
				<td><b>Price Validity</b>
				</td>
				
			</tr>
			<tr >
				<td>
					<b>Cash Sales </b>
				</td>
				<td >
					<input type="number" id="scprice" name="scprice" value="<?php echo $scprice; ?>"   min="0" max="99999999" />
				</td>
				<td >
					<input type="number" id="otprice" name="otprice" value="<?php echo $otprice; ?>"   min="0" max="99999999" />
				</td>
				<td >
					<input type="date" id="prvalidity" name="prvalidity" value="<?php echo $prvalidity; ?>" >
				</td>
			</tr>
			<tr >
				<td>
					<b>Own Use </b>
				</td>
				<td >
					<input type="number" id="owscprice" name="owscprice" value="<?php echo $owscprice; ?>"   min="0" max="99999999" />
				</td>
				<td >
					<input type="number" id="owotprice" name="owotprice" value="<?php echo $owotprice; ?>"   min="0" max="99999999" />
				</td>
				<td >
					<input type="date" id="owprvalid" name="owprvalid" value="<?php echo $owprvalid; ?>" >
				</td>
			</tr>
			<tr >
				<td>
					<b>Product Default </b>
				</td>
				<td >
					<input type="number" id="prscprice" name="prscprice" value="<?php echo $prscprice; ?>"  min="0" max="99999999" />
				</td>
				<td >
					<input type="number" id="protprice" name="protprice" value="<?php echo $protprice; ?>"  min="0" max="99999999" />
				</td>
				<td >
					<input type="date" id="prprvalid" name="prprvalid" value="<?php echo $prprvalid; ?>" >
				</td>
			</tr>
		</table>
		
		<div id="showdiscountdiv" style="display:none">
			<table border="0"  style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
				<tr >
					<td colspan="4" align="center">
						<b>Product Discount Defination</b>
					</td>
				</tr>
				
				<tr >
					<td>
						<b>Select Discount Type</b>
					</td>
					<td>
						<b>Flat</b>
					</td>
					<td><b>Percentage</b>
					</td>
					<td><b>Slab</b>
					</td>
					
				</tr>
				<tr >
					<td nowrap="nowrap">
						<input type="radio" name="retail" id="cshflat" <?php if ($retail==1){echo 'checked';}?>  onClick="javascript: refreshoption(this.name);" />Flat 
						&nbsp;&nbsp;<input type="radio" name="retail" id="cshpercent" <?php if ($retail==3){echo 'checked';}?>  onClick="javascript: refreshoption(this.name);" />Percent 
						&nbsp;&nbsp;<input type="radio" name="retail" id="cshslab" <?php if ($retail==2){echo 'checked';}?>  onClick="javascript: refreshoption(this.name);" />Slab 
						&nbsp;&nbsp;<b>Retail</b>
					</td>
					<td >
						
						<input type="number" id="retailflat" name="retailflat" value="<?php echo $retflat; ?>" min="0" max="999999" <?php if ($retail !=1){echo 'style="display:none"';}?> />
					</td>
					<td >
						<?php 
							$k = 0.00;
							
							?>
							<select name="retailcent"   id="retailcent" <?php if ($retail !=3){echo 'style="display:none"';}?> >
								<option  value="" ></option>
							<?php

							while($k< 100) 
							{
								
							?>
								<option  value="<?php echo $k ;?>" <?php  echo (number_format($recent,2)== number_format($k,2) ?"selected":""); ?>>
									<?php echo number_format($k,2) ;?> 
								</option>
								
							<?php 
								$k = $k + 0.01;
								} //End If Result Test	
							?>								
							</select>
					</td>
					<td >
						<?php 
							$k = 0;
							?>
							
							<select name="retailslab"   id="retailslab" <?php if ($retail !=2){echo 'style="display:none"';}?>>
								<option  value="" ></option>
							<?php

							while($k< $count_slabdef) 
							{
								

							?>
								<option  value="<?php echo trim($slabdef_var[$k]['slabid']) ;?>" <?php  echo ($retslab== trim($slabdef_var[$k]['slabid']) ?"selected":""); ?>>
									<?php echo trim($slabdef_var[$k]['slabdesc']) ;?> 
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
						<input type="radio" name="ow" id="ownflat" <?php if ($ow==1){echo 'checked';}?>  onClick="javascript: refreshoption(this.name);" />Flat 
						&nbsp;&nbsp;<input type="radio" name="ow" id="owncent" <?php if ($ow==3){echo 'checked';}?>  onClick="javascript: refreshoption(this.name);" />Percent 
						&nbsp;&nbsp;<input type="radio" name="ow" id="ownslab" <?php if ($ow==2){echo 'checked';}?>  onClick="javascript: refreshoption(this.name);" />Slab
						&nbsp;&nbsp;<b>Own Use</b>
						
					</td>
					<td >
						<input type="number" id="owflat" name="owflat" value="<?php echo $owflat; ?>" min="0" max="999999" <?php if ($ow !=1){echo 'style="display:none"';}?>/>
					</td>
					<td >
						<?php 
							$k = 0.00;
							?>
							<select name="owcent"   id="owcent" <?php if ($ow !=3){echo 'style="display:none"';}?> >
								<option  value="" ></option>
							<?php

							while($k< 100) 
							{
								
							?>
								<option  value="<?php echo $k ;?>" <?php  echo (number_format($owcent,2)== number_format($k,2) ?"selected":""); ?>>
									<?php echo number_format($k,2) ;?> 
								</option>
								
							<?php 
								$k = $k + 0.01;
								} //End If Result Test	
							?>								
							</select>
					</td>
					<td >
						<?php 
							$k = 0;
							?>
							
							<select name="owslab"   id="owslab" <?php if ($ow != 2){echo 'style="display:none"';}?> >
								<option  value="" ></option>
							<?php

							while($k< $count_slabdef) 
							{
								

							?>
								<option  value="<?php echo trim($slabdef_var[$k]['slabid']) ;?>" <?php  echo ($owslab== trim($slabdef_var[$k]['slabid']) ?"selected":""); ?>>
									<?php echo trim($slabdef_var[$k]['slabdesc']) ;?> 
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
						<input type="radio" name="pr" id="proflat" <?php if ($pr==1){echo 'checked';}?> onClick="javascript: refreshoption(this.name);" />Flat 
						&nbsp;&nbsp;<input type="radio" name="pr" id="procent" <?php if ($pr==3){echo 'checked';}?> onClick="javascript: refreshoption(this.name);" />Percent 
						&nbsp;&nbsp;<input type="radio" name="pr" id="proslab" <?php if ($pr==2){echo 'checked';}?> onClick="javascript: refreshoption(this.name);" />Slab 
						&nbsp;&nbsp;<b>Default</b>
						
					</td>
					<td >
						<input type="number" id="prflat" name="prflat" value="<?php echo $prflat; ?>" min="0" max="999999" <?php if ($pr !=1){echo 'style="display:none"';}?> />
					</td>
					<td >
						<?php 
							$k = 0.00;
							?>
							<select name="prcent"   id="prcent"  <?php if ($pr !=3){echo 'style="display:none"';}?>>
								<option  value="" ></option>
							<?php

							while($k< 100) 
							{
								
							?>
								<option  value="<?php echo $k ;?>" <?php  echo (number_format($prcent,2)== number_format($k,2) ?"selected":""); ?>>
									<?php echo number_format($k,2) ;?> 
								</option>
								
							<?php 
								$k = $k + 0.01;
								} //End If Result Test	
							?>								
							</select>
					</td>
					<td >
						<?php 
							$k = 0;
							?>
							
							<select name="prslab"   id="prslab"  <?php if ($pr !=2){echo 'style="display:none"';}?> >
								<option  value="" ></option>
							<?php

							while($k< $count_slabdef) 
							{
								

							?>
								<option  value="<?php echo trim($slabdef_var[$k]['slabid']) ;?>" <?php  echo ($prslab== trim($slabdef_var[$k]['slabid']) ?"selected":""); ?>>
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
				
				<td>
					<input type="button" name="closebutton" id="submit-button" value="Back" 
						onclick="javascript:  getpage('item_master.php?','page');"/>
				</td>
				<td nowrap="nowrap">
					<label>
					  <input type="button" name="itemsetting" id="submit-button" value="Item Settings" 
						onclick="javascript: getpage('item_settings.php?','page');">
					</label>
				</td>
				
				<td >
				
					  <input type="button" name="showthediscount" id="submit-button" value="Show Discount" 
						onclick="javascript:  showdiscount();" />
							
				</td>
				
				<td  >
				
					  <input type="button" name="savebutton" id="submit-button" value="Save" 
						onclick="saveicitem();" />
							
				</td>
				
			</tr>
		
	</table>
	</div>	

			<?php } ?>
	</form>
</div>

<script>
	function showdiscount()
	{
		
		var discountbutton = document.getElementsByName('showthediscount');
		var discount = document.getElementById('showdiscountdiv');
		
		if (discountbutton[0].value=="Show Discount")
		{
			discount.style.display = "block";
			discountbutton[0].value="Hide Discount";
		}else
		{
			discount.style.display = "none";
			discountbutton[0].value="Show Discount";
		}
			
	}
	
	function refreshoption(radioname) 
	{
		var theradio = document.getElementsByName(radioname);
		var flat = document.getElementById(radioname+'flat');
		var cent = document.getElementById(radioname+'cent');
		var slab = document.getElementById(radioname+'slab');
		
		flat.style.display = "none";
		cent.style.display = "none";
		slab.style.display = "none";
		for(i = 0; i < theradio.length; i++) 
		{
			if(theradio[i].checked){
				if (i==0){
					flat.style.display = "block";
				}else if (i==1){
					cent.style.display = "block";
				}else {
					slab.style.display = "block";
				}
			}
			
		}
    }
	
	
	
	function saveicitem(){
		if (confirm('Are you sure the entries are correct?')) 
		{
			
			var $form_item = $('#item').val();$form_vat = $('#vat').val(); var $form_otprice = $('#otprice').val();var $form_scprice = $('#scprice').val();
			var $form_prvalidity = $('#prvalidity').val();var $form_owscprice = $('#owscprice').val();var $form_owotprice = $('#owotprice').val();
			var $form_owprvalid = $('#owprvalid').val();var $form_prscprice = $('#prscprice').val();var $form_protprice = $('#protprice').val();
			var $form_prprvalid = $('#prprvalid').val();
			var $form_retailflat = $('#retailflat').val();var $form_retailcent = $('#retailcent').val();var $form_retailslab = $('#retailslab').val();
			var $form_owflat = $('#owflat').val();var $form_owcent = $('#owcent').val();var $form_owslab = $('#owslab').val();
			var $form_prflat = $('#prflat').val();var $form_prcent = $('#prcent').val();var $form_prslab = $('#prslab').val();
			
			var radioretail = document.getElementsByName('retail');
			var radioow = document.getElementsByName('ow');
			var radiopr = document.getElementsByName('pr');
			
			var $retail = 0;var $pr = 0;var $ow = 0; 
			for(i = 0; i < 3; i++) 
			{
				if(radioretail[i].checked){
					if (i==0){
						$retail = 1;
					}else if (i==1){
						$retail = 3;
					}else {
						$retail = 2;
					}
				}
				
				if(radioow[i].checked){
					if (i==0){
						$ow = 1;
					}else if (i==1){
						$ow = 3;
					}else {
						$ow = 2;
					}
				}
				
				if(radiopr[i].checked){
					if (i==0){
						$pr = 1;
					}else if (i==1){
						$pr = 3;
					}else {
						$pr = 2;
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
				thegetpage='item_pricing.php?op=saving&item='+$form_item
					+'&vat='+$form_vat
					+'&scprice='+$form_scprice+'&otprice='+$form_otprice+'&prvalidity='+$form_prvalidity+'&owscprice='+$form_owscprice
					+'&owotprice='+$form_owotprice+'&owprvalid='+$form_owprvalid+'&prscprice='+$form_prscprice
					+'&protprice='+$form_protprice+'&prprvalid='+$form_prprvalid
					+'&retail='+$retail+'&ow='+$ow+'&pr='+$pr
					+'&retflat='+$form_retailflat+'&recent='+$form_retailcent+'&retslab='+$form_retailslab
					+'&owflat='+$form_owflat+'&owcent='+$form_owcent+'&owslab='+$form_owslab
					+'&prflat='+$form_prflat+'&prcent='+$form_prcent+'&prslab='+$form_prslab;		
				//alert(thegetpage);	
				getpage(thegetpage,'page');						
			}
	
		}
	}


		
</script>