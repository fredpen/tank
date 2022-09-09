<?php 
	ob_start();
	include_once "session_track.php";
?>

<script type="text/javascript" src="js/dynamic_search.js"></script>
<script type="text/javascript" src="js/dynamic_search_script.js"></script>
<div align ="center" id="data-form" > 
	<input type="button" name="closebutton" id="submit-button" title="Close"  value="Close" onclick="javascript:  $('#data-form').hide();">	

	<?php 
		require_once("lib/mfbconnect.php"); 
		
	?>


	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<form action="" method="get" id="form1">
		<h3><strong><font size='10'>Generate Loading Slip 
		
		</font></strong></h3>
		<?php
			if ($_SESSION['genloadingslip']==1){
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
			$apprem = !isset($_REQUEST['apprem'])?"":$_REQUEST['apprem'];
			$item = !isset($_REQUEST['item'])?'':$dbobject->test_input($_REQUEST['item']);
			$custno = !isset($_REQUEST['custno'])?'':$dbobject->test_input($_REQUEST['custno']);
			$ccompany = !isset($_REQUEST['ccompany'])?'':$dbobject->test_input($_REQUEST['ccompany']);
			$tcompany = !isset($_REQUEST['tcompany'])?'':$dbobject->test_input($_REQUEST['tcompany']);
			$vehcno = !isset($_REQUEST['vehcno'])?'':$dbobject->test_input($_REQUEST['vehcno']);
			$trasno = !isset($_REQUEST['trasno'])?'':$dbobject->test_input($_REQUEST['trasno']);
			$drivername = !isset($_REQUEST['drivername'])?'':$dbobject->test_input($_REQUEST['drivername']);	
			$loccd = !isset($_REQUEST['loccd'])?'':$dbobject->test_input($_REQUEST['loccd']);
			$displaywhat = !isset($_REQUEST['displaywhat'])?1:$dbobject->test_input($_REQUEST['displaywhat']);
			$fieldtosearch = !isset($_REQUEST['fieldtosearch'])?'':$dbobject->test_input($_REQUEST['fieldtosearch']);
			$lookfor = !isset($_REQUEST['lookfor'])?'':$dbobject->test_input($_REQUEST['lookfor']);
			$approval = !isset($_REQUEST['approval'])?'':$dbobject->test_input($_REQUEST['approval']);
			$approval1 = !isset($_REQUEST['approval1'])?'':$dbobject->test_input($_REQUEST['approval1']);
			$loc_date = !isset($_REQUEST['loc_date'])?'':$dbobject->test_input($_REQUEST['loc_date']);
			$appr_date = !isset($_REQUEST['appr_date'])?'':$dbobject->test_input($_REQUEST['appr_date']);
			$prodcount = !isset($_REQUEST['prodcount'])?0:$dbobject->test_input($_REQUEST['prodcount']);
			$escort = !isset($_REQUEST['escort'])?"":$dbobject->test_input($_REQUEST['escort']);
			$motorboy = !isset($_REQUEST['motorboy'])?"":$dbobject->test_input($_REQUEST['motorboy']);
			$deliveryaddress1 = !isset($_REQUEST['deliveryaddress1'])?"":$dbobject->test_input($_REQUEST['deliveryaddress1']);
			$trantype = !isset($_SESSION['trantype'])?0:$_SESSION['trantype'];
			
			//echo $reqst_by.' user<br />';
			$count_getpmtdetails = 0;
			
			$keyword = !isset($_REQUEST['keyword'])?"":$dbobject->test_input(trim($_REQUEST['keyword']));
			$searchin = !isset($_REQUEST['searchin'])?"":$dbobject->test_input($_REQUEST['searchin']);
			
			
	
			
			$products_icitem_var = Array();
			$productArray = Array();
			
			$sql_client = "select distinct * FROM arcust WHERE 1=1 order by trim(company)";
			switch ($_SESSION['trantype']) 
			{
			
				case  3:
					$sql_client = "select distinct * FROM arcust WHERE trim(custno) = '99000999' order by trim(company)";
					break;
				case  4:
					$sql_client = "select distinct * FROM arcust WHERE trim(custno) = '99900999' order by trim(company)";
					
					
			}
	
			$result_client = mysqli_query($_SESSION['db_connect'],$sql_client);
			$count_client = mysqli_num_rows($result_client);
			
			$k=0;
			while ($k<$count_client){
				$row = mysqli_fetch_array($result_client);
				$client_var[$k]['custno']=$row['custno'];
				$client_var[$k]['company']=$row['company'];
				
				$k++;
			}
			
			$brv_var = Array();
			$sql_brv = "select distinct * FROM tbvehc WHERE 1=1 order by vehcno";
			$result_brv = mysqli_query($_SESSION['db_connect'],$sql_brv);
			$count_brv = mysqli_num_rows($result_brv);
			$k=0;
			while ($k<$count_brv){
				$row = mysqli_fetch_array($result_brv);
				$brv_var[$k]['trasno']=$row['trasno'];
				$brv_var[$k]['company']=$row['company'];
				$brv_var[$k]['vehcno']=$row['vehcno'];
				?>
				<input type="hidden" id="h_trasno<?php echo trim($brv_var[$k]['vehcno']);?>" value="<?php echo trim($brv_var[$k]['trasno']); ?>"  />
				<input type="hidden" id="h_tcompany<?php echo trim($brv_var[$k]['vehcno']);?>" value="<?php echo trim($brv_var[$k]['company']); ?>"  />
					
				<?php	
				$k++;
			}
					
			$sql_products_icitem = "select distinct * FROM icitem WHERE 1=1 order by trim(itemdesc)";
			$result_products_icitem = mysqli_query($_SESSION['db_connect'],$sql_products_icitem);
			$count_products_icitem = mysqli_num_rows($result_products_icitem);
			

			$k=0;
			while ($k<$count_products_icitem){
				$row = mysqli_fetch_array($result_products_icitem);
				$products_icitem_var[$k]['item']=$row['item'];
				$products_icitem_var[$k]['itemdesc']=$row['itemdesc'];
				
				$k++;
			}
			
			
			$sql_loccd = "select distinct * FROM lmf WHERE 1=1 order by trim(loc_name)";
			$result_loccd = mysqli_query($_SESSION['db_connect'],$sql_loccd);
			$count_loccd = mysqli_num_rows($result_loccd);
			
			$k=0;
			while ($k<$count_loccd){
				$row = mysqli_fetch_array($result_loccd);
				$lmf_var[$k]['loccd']=$row['loccd'];
				$lmf_var[$k]['loc_name']=$row['loc_name'];
				
				$k++;
			}
			
			
			if($op=='Searchrequest'){
				$sql_request = "select *  from headdata where approve_ok = 1 and ".trim($fieldtosearch)."  like '%".trim($lookfor)."%'  and trantype = $trantype ";
				$result_request = mysqli_query($_SESSION['db_connect'],$sql_request);
				$count_request = mysqli_num_rows($result_request);
				if ($count_request >=1){
					$row = mysqli_fetch_array($result_request);
					$request= $row['request'];
					$approval= $row['approval'];
					$approval1= $row['approval1'];
					$custno= $row['custno'];
					$ccompany= $row['ccompany'];
					$loc_date= $row['loc_date'];
					$appr_date= $row['appr_date'];
					
				}else 	
				{
					$request= $lookfor;
				?>
					<script>
					
					$('#item_error').html("<strong>Requisition Does Not Exist Or Is Not Approved or Access Denied due to wrong Channel</strong>");
					</script>
				<?php	
				}	
			}	
	
	
	
			if($op=='getselectclient')
				{
					$filter = "";
					
					$sql_Q = "SELECT * FROM arcust where  ";
					
					$filter="  upper(trim(custno)) = upper('$custno')  ";
					
											
					
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
						$custno    = $row['custno'];
						$company   = $row['company'];
						
					}else 	
					{
					?>
						<script>
						
						$('#item_error').html("<strong>Customer does not exist</strong>");
						</script>
					<?php	
					}	
					
					
				}	
			
			if($op=='searchkeyword'){
				if (trim($keyword) !=''){
					
					$sql_request = "select *  from arcust where custno  like '%".trim($keyword)."%'";
					//echo $sql_request."<br />";
					$result_request = mysqli_query($_SESSION['db_connect'],$sql_request);
					$count_request = mysqli_num_rows($result_request);
					//echo "<br/>".$sql_request."<br/>";
					if ($count_request >=1){
						$row = mysqli_fetch_array($result_request);
						$custno    = $row['custno'];
						$company   = $row['company'];
						$displaywhat= 2;
					}else 	
					{
					?>
						<script>
						
						$('#item_error').html("<strong>Customer does not exist</strong>");
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
			

			if($op=='getdetails'){
				
				
					$sql_request = "SELECT a.* FROM headdata a, loadings b  
						  WHERE trim(a.request) =  trim(b.request) AND  
						  trim(a.custno) = '$custno' AND 
						  trim(a.loccd) = '$loccd' AND  
						  trim(b.item) = '$item' AND  
						  a.approve_ok =1 AND b.qty_asked > b.qty_booked  and a.trantype = $trantype ";
				
					//echo $sql_request."<br />";
					$result_request = mysqli_query($_SESSION['db_connect'],$sql_request);
					$count_request = mysqli_num_rows($result_request);
					//echo "<br/>".$sql_request."<br/>";
					if ($count_request >=1){
						$row = mysqli_fetch_array($result_request);
						$custno    = $row['custno'];
						$company   = $row['ccompany'];
						
					}else 	
					{
					?>
						<script>
						
						$('#item_error').html("<strong>Records not found for given parameters or Access Denied due to wrong Channel</strong>");
						</script>
					<?php	
					}
				
			}
			
			
			
			if($op=='saveslip')
			{
				$theRequestArray = Array();
				$theItemArray = Array();
				$theToloadqtyArray = Array();
				$no_recs_to_load = 0;
				$goahead = 1;
				//if (gettype($prodcount)!=gettype($goahead)){$prodcount = 0;echo 'type not integer - $prodcount<br />';echo gettype($prodcount).'<-count ahead-> '. gettype($goahead);}
				
				for ($i=0; $i < $prodcount; $i++)
					{
						$theRequestArray[$i] = $dbobject->test_input($_REQUEST['requestno'.$i]);
						$theItemArray[$i] = $dbobject->test_input($_REQUEST['item'.$i]);
						$theToloadqtyArray[$i] = $dbobject->test_input($_REQUEST['itemqty'.$i]);
						if ($theToloadqtyArray[$i]>0){$no_recs_to_load += 1;}
					}
				
				if ($no_recs_to_load == 0){$goahead = 0;}
				
				
				
				
				if ($goahead==1)
				{
					//obtain 2char code
					$sql_xchar2 = "select distinct a.xchar2 FROM lmf a, headdata b WHERE trim(a.loccd)= trim(b.loccd) and trim(b.request) = '". $theRequestArray[0] . "' limit 1 ";
					$result_xchar2 = mysqli_query($_SESSION['db_connect'],$sql_xchar2);
					$count_xchar2 = mysqli_num_rows($result_xchar2);
					
					//echo $sql_xchar2;
					if ($count_xchar2){
						$row = mysqli_fetch_array($result_xchar2);
						$xchar2 =$row['xchar2'];
					}else {	
						$goahead = 0;
						
						?>
							<script>
							
							$('#item_error').html("<strong>Two Character Code was not defined for Location</strong>");
							</script>
						<?php	
					}
				}
				
				if ($goahead==1)
				 
				{
					
					// generate loading slip number
				
					
					$nextno = 1;
					$slip_no = $xchar2.'LS'.date("d").date("m").date("Y").$nextno;
				   
					//check usage
					$sql_check_usage = "select * from invoice where trim(slip_no) = '$slip_no'";
					$result_check_usage = mysqli_query($_SESSION['db_connect'],$sql_check_usage);
					$count_check_usage = mysqli_num_rows($result_check_usage);
					if ($count_check_usage >=1)
					{
						$Reqno_in_use = 1;
						while ($Reqno_in_use==1){
							$nextno++;
							$slip_no = $xchar2.'LS'.date("d").date("m").date("Y").$nextno;
							$sql_check_usage_again = "select * from invoice where trim(slip_no) = '$slip_no'";
							$result_check_usage_again = mysqli_query($_SESSION['db_connect'],$sql_check_usage_again);
							$count_check_usage_again = mysqli_num_rows($result_check_usage_again);
							if ($count_check_usage_again ==0)
							{
								$Reqno_in_use = 0;
							}
							
						}
						
					}

					
					if ($displaywhat==1)
					{
						$sql_request = "select *  from headdata where approve_ok = 1 and trim(request) = '". $theRequestArray[0] . "'";
						
						
					}else {
						
						$sql_request = "SELECT a.* FROM headdata a, loadings b  
						  WHERE trim(a.request) =  trim(b.request) AND  
						  trim(a.custno) = '$custno' AND 
						  trim(a.loccd) = '$loccd' AND  
						  trim(b.item) = '$item' AND  
						  a.approve_ok =1 AND b.qty_asked > b.qty_booked limit 1";
				
						
					}
					//echo $sql_request;
					$result_request = mysqli_query($_SESSION['db_connect'],$sql_request);
					$count_request = mysqli_num_rows($result_request);
					if ($count_request >=1){
						$row = mysqli_fetch_array($result_request);
						$request= $row['request'];
						$approval= $row['approval'];
						$approval1= $row['approval1'];
						$custno= $row['custno'];
						$ccompany= $row['ccompany'];
						$loc_date= $row['loc_date'];
						$appr_date= $row['appr_date'];
						$total_cost = $row['total_cost'];
						$reqamount = $row['reqamount'];
						$targetbase= $row['targetbase'];
						$met_target= $row['met_target'];
						$the_target= $row['the_target'];
						$slabused = $row['slabused'];
						$d_regime = $row['d_regime'];
						
					}
					if ($displaywhat==2)
					{
						$reqamount = 0 ;$total_cost = 0 ;
						$targetbase = 0; $met_target = 0;
						$the_target =0; $slabused =''; $d_regime = 0;
						$request = 'MULTIPLE_APPR';
						$approval = "MUL_$slip_no" ;
						$approval1 = "MUL_$slip_no";
					}
					/////
					
					
					$sql_saveslipheader = " insert into invoice ( escort,motorboy,
						 salespsn,slip_no, custno, ccompany, loccd, loc_name,reqst_by,loc_date, 
						 appr_date, py,mv, total_cost,vehcno,tcompany,reqamount,
						 appvd_by, approve_ok,trasno,trantype ,targetbase, 
						 met_target, the_target,slabused, d_regime,request, approval, approval1,bu, 
						 rcvloc, rcv_locnm,deliveryaddress1  )
						 values 
						 ('$escort','$motorboy','" . $row['salespsn'] . "','$slip_no','$custno', '" .
						 $row['ccompany'] . "','" . $row['loccd'] . "', '".
						 $row['loc_name'] . "','$reqst_by', '" .
						 $row['loc_date'] . "', '" . $row['appr_date'] . "', '".
						 $row['py'] . "','" . $row['mv'] . "',$total_cost,'$vehcno','$tcompany',$reqamount,'" .
						$row['appvd_by'] . "'," . $row['approve_ok'] . ",'$trasno'," . $_SESSION['trantype'] . " , 
						$targetbase , $met_target ,$the_target ,'$slabused',$d_regime,'$request','$approval','$approval1','" . $row['bu'] . "','" .
						$row['rcvloc'] . "','" . $row['rcv_locnm'] . "','$deliveryaddress1' )";
		
					$result_saveslipheader = mysqli_query($_SESSION['db_connect'],$sql_saveslipheader);
					
					$Query_vehicle = "update tbvehc set outstanding = 1, oustanding_doc = '$slip_no', oustanding_date = '" . date("d/m/Y h:i:s A") .  "'  WHERE TRIM(vehcno) = '$vehcno'" ;
					$result_vehicle = mysqli_query($_SESSION['db_connect'],$Query_vehicle);
							
					//echo $sql_saveslipheader;
					for ($i=0; $i < $prodcount; $i++)
					{
						$theRequestArray[$i] = $dbobject->test_input($_REQUEST['requestno'.$i]);
						$theItemArray[$i] = $dbobject->test_input($_REQUEST['item'.$i]);
						$theToloadqtyArray[$i] = $dbobject->test_input($_REQUEST['itemqty'.$i]);
						
						if ($theToloadqtyArray[$i]>0)
						{
							$sql_update_loadings = "update loadings set  
								 qty_booked = qty_booked + " . $theToloadqtyArray[$i] .
								 " where trim(request) = '" . $theRequestArray[$i] . "' and  
								 trim(item) = '" . $theItemArray[$i] . "'";
							
							//echo $sql_update_loadings;
							$result_update_loadings = mysqli_query($_SESSION['db_connect'],$sql_update_loadings);
							
							$sql_get_details = "select * from loadings  
								 where trim(request) = '" . $theRequestArray[$i] . "' and  
								 trim(item) = '" . $theItemArray[$i] . "'";
								 
							$result_get_details = mysqli_query($_SESSION['db_connect'],$sql_get_details);	 
							
							$count_get_details = mysqli_num_rows($result_get_details);
							if ($count_get_details >=1)
							{
								$row = mysqli_fetch_array($result_get_details);
								$sql_save_inv_detl = " insert into inv_detl  
									(slip_no, slip_date, item, itemdesc, qty_asked,  
									 qty_booked,bprice,disc,duprice,vatduprice,price,cost,trantype,lineno , 
									 totlineno,drivername,loaded_by,request)  values ('$slip_no','" . date("d/m/Y h:i:s A") .  "','" . $theItemArray[$i] . "','" .
									$row['itemdesc'] . "'," . $row['qty_asked'] . "," . $theToloadqtyArray[$i] . "," . $row['bprice'] . "," .
									$row['disc'] . "," . $row['duprice'] . "," . $row['vatduprice'] . "," . $row['price'] . "," .
									$theToloadqtyArray[$i] * $row['price'] . " ,". $_SESSION['trantype'] . " ," . $row['lineno'] . " ," . $row['totlineno'] .
									",'$drivername','" . $_SESSION['username_sess'] . "','" . $theRequestArray[$i] . "') ";
									
								$result_save_inv_detl = mysqli_query($_SESSION['db_connect'],$sql_save_inv_detl);
								
								if ($displaywhat==2)
								{
									$sql_update_invoice = "update invoice set 
										 total_cost = total_cost + " . $theToloadqtyArray[$i] * $row['price'] .
										 " where trim(slip_no) = '$slip_no'" ;
								
									$result_update_invoice = mysqli_query($_SESSION['db_connect'],$sql_update_invoice);
								}
								
							}		
						}
						
						
					}
					
									
					
					
					?>	
						<script>
							$('#item_error').html("<strong>Loading Slip Generated</strong>");
						</script>
					<?php 
							

						$savetrail = $dbobject->apptrail($_SESSION['username_sess'],'Loading Slip',$slip_no,date("d/m/Y h:i:s A"),'Generated');
						$dbobject->workflow($_SESSION['username_sess'],'Loading Slip Created, Waybill Required',$slip_no,date('d/m/Y H:i:s A'),5,3,'brvloading');
						
						
				}else
				{
					?>	
						<script>
							$('#item_error').html("<strong>Loading Slip Not Generated</strong>");
						</script>
					<?php 
				}

						
				
			}
			
			
					
	// retrieve product		
			$single_approval_product_count = 0;
			$multiple_approval_product_count = 0;
			if ($displaywhat==1){
				$sql_products =  "SELECT a.item,a.itemdesc, a.qty_asked, a.price, a.cost, a.qty_booked, a.request, a.voided_qty FROM headdata b, loadings a" .
					" where trim(b.request) = trim(a.request) and trim(b.request) = '" . trim($request)."'  and b.approve_ok = 1 and a.qty_asked > a.qty_booked ";
			}else {
				$sql_products = "SELECT b.* FROM headdata a, loadings b  
						 WHERE trim(a.REQUEST) =  trim(b.request) AND  
						 trim(a.custno) = '$custno' AND  
						 trim(a.loccd) = '$loccd' AND 
						 trim(b.item) = '$item' AND 
						 a.approve_ok =1 AND b.qty_asked > b.qty_booked";
				
			}
			
			
			//echo $sql_products."<br/>";
			$show_void_button = 1;
			$result_products = mysqli_query($_SESSION['db_connect'],$sql_products);
			$count_products = mysqli_num_rows($result_products);
			for ($i=0;$i<$count_products;$i++){
				$row = mysqli_fetch_array($result_products);
				$productArray[$i]['item'] = $row['item'];
				$productArray[$i]['itemdesc'] = $row['itemdesc'];
				$productArray[$i]['qty_asked'] = $row['qty_asked'];
				$productArray[$i]['qty_booked'] = $row['qty_booked'];
				$productArray[$i]['price'] = $row['price'];
				$productArray[$i]['cost'] = $row['cost'];
				$productArray[$i]['request'] = $row['request'];
				$productArray[$i]['voided_qty'] = $row['voided_qty'];
				$productArray[$i]['request'] = $row['request'];
				if ($row['qty_asked'] <= $row['qty_booked']){$show_void_button = $show_void_button * 0;}
				 
			}
			
			if ($displaywhat==1)
			{
				$single_approval_product_count = $count_products;
			}else {
				$multiple_approval_product_count = $count_products;
			}
			
			
			 if ($single_approval_product_count == 0 && $multiple_approval_product_count == 0 && $request !='' ) {
				?>	
					<script>
						$('#item_error').html("<strong>Loading Slip Completely Generated for this Requisition <br/> Or Requisition does not exist</strong>");
					</script>
				<?php 
			 }
			
//****
		//echo md5(md5('SOREMI').md5('mypassword11'));
		//echo md5(md5('A1HSE14E').md5('mypassword11'));
		?>
		
		<input type="hidden" name="operation" id="operation" value="<?php echo $op; ?>" />
		<input type="hidden" name="thetablename" id="thetablename" value="customer" />
		<input type="hidden" name="get_file" id="get_file" value="generateloadingslip" />
		<table border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px">
			<tr >
				<td align="center">
					&nbsp;&nbsp;<input type="radio" name="displaywhat" id="singleapproval" value="singleapproval" <?php if ($displaywhat==1){echo 'checked';} ?>
							onclick="javascript: refreshoption();"/>&nbsp;&nbsp;<b>Slip based on an approval</b>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td align="center">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="displaywhat" id="multipleapproval" value="multipleapproval" <?php if ($displaywhat==2){echo 'checked';} ?>
						onclick="javascript: refreshoption();"/>&nbsp;&nbsp;<b>Slip Based on multiple Approvals</b>&nbsp;&nbsp;&nbsp;
				</td>
				
				</tr>
		</table>
		<br/>
		<div  style="color:red;" id = "item_error" align = "center"  ></div><?php  if (isset($slip_no)){echo '<b>'.$slip_no.'</b>';} ?>
		<div  id="singleapproval_table" <?php if ($displaywhat==1){echo 'style="display:block;"';}else {echo 'style="display:none;"';} ?> >
		<table style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px" border="0"  >
			<tr>
				<td><strong>Request No :</strong></td>
				<td  colspan="2">
					<input type="text" name="request" onKeyup="javascript: suggestentry(this.id,'approvals');" id="request" value="<?php echo $request; ?>" class="required-text" >
					<div id="requestdisplay"></div>
				</td>
				
				
				<td>
					<input type="button" name="Searchrequest" id="submit-button" value="Get Record" onclick="javascript:var $form_request = $('#request').val(); 
										 getpage('generateloadingslip.php?op=Searchrequest&displaywhat=1&lookfor='+$form_request+'&fieldtosearch=request&request ='+$form_request,'page');">				
				</td>
				
			</tr>
			<tr>
				<td><strong>Customer: </strong></td>
				<td >
					<?php echo $custno . " : ". $ccompany; ?> &nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				
				<td><strong>Approval No: </strong> </td>
				<td>
					<?php echo $approval1 . $approval; ?> 
				</td>
				
			</tr>
			<tr>
				<td><strong>Requisition Date : </strong></td>
				<td >
					<?php echo $loc_date; ?> &nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				
				<td><strong>Approval Date : </strong> </td>
				<td>
					<?php echo $appr_date; ?> 
				</td>
				
			</tr>
		</table>
		</div>
		
		<div  id="multipleapproval_table"  <?php if ($displaywhat==1){echo 'style="display:none;"';}else {echo 'style="display:block;"';} ?> >
		<table  border="0" style="border:1px solid black;padding:1px;border-collapse:separate;border-radius:15px"  >
			<tr>
				<td colspan="5">
					<div class="input-group">
						<b>Search by: <i>Name or Code or Phone Number</i> </b>&nbsp;
						<input type="text" size="35px" id="search" placeholder="Search for Customer" />
						<input name="keyword" type="hidden" class="table_text1"  id="keyword" value="<?php echo $keyword; ?>" />
					
					</div>
					<!-- Suggestions will be displayed in below div. -->
					
					   <div id="display"></div>
				</td>  
				
			</tr>
			
			<tr><td colspan="5" ><hr></td></tr>
			<tr>
				<td >
					<b>Customer ID</b>
				</td>
				<td colspan="4">
					<input type="text" name="custno" id="custno" value="<?php echo $custno; ?>"  placeholder="Enter Customer ID" />
					&nbsp;&nbsp; <?php echo $company ;?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Supply Location</b>
				</td>
				
				<td valign="center" colspan="4">
						<?php 
						$k = 0;
						?>
						<br/>
						<select name="loccd"   id="loccd" >
							<option  value="" ></option>
						<?php

						while($k< $count_loccd) 
						{
							
						?>
							<option  value="<?php echo trim($lmf_var[$k]['loccd']);?>" <?php  echo ($loccd== trim($lmf_var[$k]['loccd'])?"selected":""); ?>>
								<?php echo trim($lmf_var[$k]['loc_name']) ;?> 
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
					<b>Product</b>
				</td>
				<td colspan="3">
					<?php 
					$k = 0;
					?>
					<select name="item"   id="item" 
					
					>
						<option  value="" ></option>
					<?php
					
					
					
					while($k< $count_products_icitem) 
					{
						//$row = mysqli_fetch_array($result_client);
						
					?>
						<option  value="<?php echo trim($products_icitem_var[$k]['item']) ;?>" <?php  echo ($item== trim($products_icitem_var[$k]['item']) ?"selected":""); ?>>
							<?php echo trim($products_icitem_var[$k]['itemdesc']) ;?> 
						</option>
						
					<?php 
						$k++;
						} //End If Result Test	
					?>								
					</select>
				</td>
				<td>
					<input type="button" name="getdetails" id="submit-button" value="Get Details" onclick="javascript: mygetdetails();">				
				</td>
			</tr>
			
			
		</table>
		</div>
		
		<br>
		<?php if ($single_approval_product_count > 0 || $multiple_approval_product_count > 0) {?>
			<h3><strong>Products </strong></h3>
		<?php }?>
		<div style="overflow-x:auto;" id="single_approval_product_row" <?php if ($displaywhat==1){echo 'style="display:block;"';}else {echo 'style="display:none;"';} ?>>
		<?php if ($single_approval_product_count > 0) {?>
		<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="productlistTable">
			<thead>
				<tr class="right_backcolor">
					<th nowrap="nowrap" class="Corner">&nbsp;</th>
					<th nowrap="nowrap" class="Odd">S/N</th>
					<th nowrap="nowrap" class="Odd">Item</th>
					<th nowrap="nowrap" class="Odd">Description</th>
					<th nowrap="nowrap" class="Odd">Req. Qty</th>
					<th nowrap="nowrap" class="Odd">Price</th>
					<th nowrap="nowrap" class="Odd">Cost</th>
					<th nowrap="nowrap" class="Odd">Qty To Load</th>
					<th nowrap="nowrap" class="Odd">Available Qty</th>
					
					
					<th nowrap="nowrap">&nbsp;</th>
				</tr>
			</thead>
			<?php 
				$k = 0;
				
				
				while($k<$single_approval_product_count) 
				{
					$k++;
					$i = $k -1;

			?>
			
					<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?>  >
						<td nowrap="nowrap">&nbsp;</td>
						<td nowrap="nowrap"><?php echo $k;?></td>
						<td nowrap="nowrap"><?php echo $productArray[$i]['item'];?></td>
						<td nowrap="nowrap"><?php echo $productArray[$i]["itemdesc"];?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["qty_asked"],2);?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["price"],2);?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["cost"],2);?></td>
						<td nowrap="nowrap" align="right">
							<input type="text"  title="Enter Quantity to Load" id="single<?php echo $i;?>" size="5px" value="0" onChange="checkqty(this.id);" >
							<input type="hidden"  id="maxsingle<?php echo $i;?>" value="<?php echo $productArray[$i]["qty_asked"] - $productArray[$i]["qty_booked"] ;?>"  >
							<input type="hidden"  id="reqsingle<?php echo $i;?>" value="<?php echo $productArray[$i]["request"] ;?>"  >
							<input type="hidden"  id="itemsingle<?php echo $i;?>" value="<?php echo $productArray[$i]["item"] ;?>"  >
							
						</td>
						<td nowrap="nowrap" align="right">
							<input type="text" style="background:transparent;border:none;"  tabindex="-1" id="availsingle<?php echo $i;?>" size="5px" value="<?php echo number_format($productArray[$i]["qty_asked"] - $productArray[$i]["qty_booked"],2);?>" readonly />
						</td>
						
						<td nowrap="nowrap"></td>
					</tr>
					
					
			<?php 
					
					//End For Loop
				} //End If Result Test	
			?>
		</table>
			<?php } ?>
		</div>
		<input type="hidden" id="single_approval_product_count" value="<?php echo $single_approval_product_count;?>" />
		<input type="hidden" id="multiple_approval_product_count" value="<?php echo $multiple_approval_product_count;?>" />
		
		<div style="overflow-x:auto;" id="multiple_approval_product_row"  <?php  if ($displaywhat==1){echo 'style="display:none;"';} ?> >
		<?php if ($multiple_approval_product_count > 0) {?>
		<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="multipleproductlistTable"  >
			<thead>
				<tr class="right_backcolor">
					<th nowrap="nowrap" class="Corner">&nbsp;</th>
					<th nowrap="nowrap" class="Odd">S/N</th>
					<th nowrap="nowrap" class="Odd">Request Number</th>
					<th nowrap="nowrap" class="Odd">Item</th>
					<th nowrap="nowrap" class="Odd">Description</th>
					<th nowrap="nowrap" class="Odd">Req. Qty</th>
					<th nowrap="nowrap" class="Odd">Price</th>
					<th nowrap="nowrap" class="Odd">Cost</th>
					<th nowrap="nowrap" class="Odd">Qty To Load</th>
					<th nowrap="nowrap" class="Odd">Available Qty</th>
					
					
					<th nowrap="nowrap">&nbsp;</th>
				</tr>
			</thead>
			<?php 
				$k = 0;
				
				
				while($k<$multiple_approval_product_count) 
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
						<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["qty_asked"],2);?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["price"],2);?></td>
						<td nowrap="nowrap" align="right"><?php echo number_format($productArray[$i]["cost"],2);?></td>
						<td nowrap="nowrap" align="right">
							<input type="text"  title="Enter Quantity to Load" id="multiple<?php echo $i;?>" size="5px" onChange="checkqty(this.id);" >
							<input type="hidden"  id="maxmultiple<?php echo $i;?>" value="<?php echo $productArray[$i]["qty_asked"] - $productArray[$i]["qty_booked"] ;?>"  >
							<input type="hidden"  id="reqmultiple<?php echo $i;?>" value="<?php echo $productArray[$i]["request"] ;?>"  >
							<input type="hidden"  id="itemmultiple<?php echo $i;?>" value="<?php echo $productArray[$i]["item"] ;?>"  >
							
						</td>
						<td nowrap="nowrap" align="right">
							<input type="text" style="background:transparent;border:none;" tabindex="-1" id="availmultiple<?php echo $i;?>" size="5px" value="<?php echo number_format($productArray[$i]["qty_asked"] - $productArray[$i]["qty_booked"],2);?>" readonly />
						</td>
						
						<td nowrap="nowrap"></td>
					</tr>
					
			<?php 
					
					//End For Loop
				} //End If Result Test	
			?>
		</table>
		<?php } ?>
		</div>
		
		<div>
			<table width="90%">
				<tr>
					<td>
						<b>Delivery Address</b>
					</td>
					<td colspan="3">
						<textarea cols="52" name="deliveryaddress1"  id="deliveryaddress1" ><?php echo $deliveryaddress1; ?> </textarea>
						
					</td>
				</tr>
				<tr>
					<td>
						<b>Truck Number</b>
					</td>
					<td>
						<input type="text" name="selectbrv"  onKeyup="javascript: suggestentry(this.id,'brvdef'); $('#selectbrvdisplay').hide();" id="selectbrv" value="<?php echo $vehcno; ?>" class="required-text" >
						<div id="selectbrvdisplay"></div>
					</td>
					
					<td>
						<input type="hidden" id="trasno" value="<?php echo $trasno; ?>" readonly style="color:gray" />
						<input type="hidden" id="tcompany" value="<?php echo $tcompany; ?>" readonly style="color:gray" />
						<input type="hidden" id="h_trasno" value=""  />
						<input type="hidden" id="h_tcompany" value=""  />
					
						<b>Driver Name</b>
					</td>
					<td>
						<input type="text" id="drivername" value="<?php echo trim($drivername) ;?>" title="Enter BRV Driver Name" />
					</td>
				</tr>
				<tr>
					<td>
						<b>Escort</b>
					</td>
					<td>	
						<input type="text" id="escort" value="<?php echo trim($escort) ;?>" title="Enter Security Escort Name" />
					</td>
					<td>
						<b>Motor Boy</b>
					</td>
					<td>
						<input type="text" id="motorboy" value="<?php echo trim($motorboy) ;?>" title="Enter Motor Boy's Name" />
					</td>
				</tr>
			</table>		
		</div>		
		<table>
		  <tr>
			
			
			<td  align="right" nowrap="nowrap">
				<label>
				  <input type="button" name="approvebutton" id="submit-button" title="Generate Loading Slip" value="Generate" 
					onclick="javascript: generateslip();">
				</label>
			</td>
			
			
			
			<td>
				<?php $calledby = 'generateloadingslip'; $reportid = 39; include("specificreportlink.php");  ?>
			</td>
		  </tr>
		  
		</table>

			<?php } ?>
	</form>
	<br/>
	  <input type="button" name="closebutton" id="submit-button" value="Back" 
		onclick="javascript:  getpage('s_and_d.php?op=refresh','page');
			">
	<br/>
</div>


<script>
	function generateslip()
	{
		
		if (confirm('Are you sure the entries are correct?')) {
			var $goahead = 1;
			var $form_vehcno = $('#selectbrv').val(); 
			var $form_drivername = $('#drivername').val(); 
			var $form_trasno = $('#trasno').val(); 
			var $form_tcompany = $('#tcompany').val(); 
			var $form_single_approval_product_count = $('#single_approval_product_count').val(); 
			var $form_multiple_approval_product_count = $('#multiple_approval_product_count').val(); 
			var $escort = $('#escort').val(); 
			var $motorboy = $('#motorboy').val(); 
			var $deliveryaddress1 = $('#deliveryaddress1').val(); 
			
			var theradio = document.getElementsByName('displaywhat');
			for(i = 0; i < theradio.length; i++) 
			{
				if(theradio[i].checked){
					if (i==0){
						$displaywhat = 1;
					}
					else {
						$displaywhat = 2;
					}
				}
				
			}
			
			
			if ($displaywhat == 2)
			{
				var $form_custno = $('#custno').val();var $form_loccd = $('#loccd').val();var $form_item = $('#item').val();
				if($form_custno==''){
					$goahead *=0;
					alert('Please Specify Customer ID');
				}
				
				if($form_loccd==''){
					$goahead *=0;
					alert('Please Specify Location');
				}
				
				if($form_item==''){
					$goahead *=0;
					alert('Please Specify Product');
				}
				
			}
			
			if ((Number($form_single_approval_product_count)==0) && (Number($displaywhat)==1))
			{
				alert('Loading Slip Product Details not available');
				$goahead = $goahead * 0;
			}
			
			if ((Number($displaywhat)==2) && (Number($form_multiple_approval_product_count)==0))
			{
				alert('Loading Slip Product Details not available');
				$goahead = $goahead * 0;
			}
			
			
			var productstring ='';
			if ($displaywhat == 1)
			{
				for(i=0;i< $form_single_approval_product_count;i++){
					//alert(myArrayOfItems[i]);
					var qtytoload = document.getElementById('single'+i).value;
					var maxqtytoload = document.getElementById('maxsingle'+i).value;
					var request = document.getElementById('reqsingle'+i).value;
					var item = document.getElementById('itemsingle'+i).value;
					if (Number(qtytoload)>Number(maxqtytoload))
					{
						alert('One of the Loading Slip quantity request to load is more than available');
						$goahead = $goahead * 0;
						
					}
					//alert('The quantity'+theqty);
					productstring = productstring +'&item'+i+'='+item+'&itemqty'+i+'='+qtytoload+'&requestno'+i+'='+request+'&prodcount='+$form_single_approval_product_count+'&trasno='+$form_trasno+'&tcompany='+$form_tcompany;
				}
			}
			
			if ($displaywhat == 2)
			{
				for(i=0;i< $form_multiple_approval_product_count;i++){
					//alert(myArrayOfItems[i]);
					var qtytoload = document.getElementById('multiple'+i).value;
					var maxqtytoload = document.getElementById('maxmultiple'+i).value;
					var request = document.getElementById('reqmultiple'+i).value;
					var item = document.getElementById('itemmultiple'+i).value;
					if (Number(qtytoload)>Number(maxqtytoload))
					{
						alert('One of the Loading Slip quantity request to load is more than available');
						$goahead = $goahead * 0;
						
					}
					//alert('The quantity'+theqty);
					productstring = productstring +'&item'+i+'='+item+'&itemqty'+i+'='+qtytoload+'&requestno'+i+'='+request+'&prodcount='+$form_multiple_approval_product_count+'&trasno='+$form_trasno+'&tcompany='+$form_tcompany;
				}
				productstring = productstring + '&custno='+$form_custno+'&item='+$form_item+'&loccd='+$form_loccd;
			}
			
			
			if ($form_vehcno=='')
			{
				alert('Please Enter a Valid BRV');
				$goahead = $goahead * 0;
			}
			if ($form_drivername=='')
			{
				alert("Please Enter Driver's Name");
				$goahead = $goahead * 0;
			}
			
			if ($goahead == 1)
			{
				productstring = productstring + '&vehcno='+$form_vehcno+'&drivername='+$form_drivername
				+'&escort='+$escort+'&motorboy='+$motorboy+'&deliveryaddress1='+$deliveryaddress1;
				//alert('generateloadingslip.php?op=saveslip&displaywhat='+$displaywhat+productstring);
				getpage('generateloadingslip.php?op=saveslip&displaywhat='+$displaywhat+productstring,'page');
			}
			
		}	
					
	}
	
	function refreshoption() 
	{
		var theradio = document.getElementsByName('displaywhat');
		var multipleapproval_table = document.getElementById('multipleapproval_table');
		var singleapproval_table = document.getElementById('singleapproval_table');
		var single_approval_product_row = document.getElementById('single_approval_product_row');
		var multiple_approval_product_row = document.getElementById('multiple_approval_product_row');
		
		multipleapproval_table.style.display = "none";
		singleapproval_table.style.display = "none";
		multiple_approval_product_row.style.display = "none";
		single_approval_product_row.style.display = "none";
		
		for(i = 0; i < theradio.length; i++) 
		{
			if(theradio[i].checked){
				if (i==0){
					singleapproval_table.style.display = "block";
					single_approval_product_row.style.display = "block";
				}
				else {
					multipleapproval_table.style.display = "block";
					multiple_approval_product_row.style.display = "block";
				}
			}
			
		}
    }
	
	function mygetdetails()
	{
		
		var $goahead = 1;var $form_custno = $('#custno').val();var $form_loccd = $('#loccd').val();var $form_item = $('#item').val();
		if($form_custno==''){
			$goahead *=0;
			alert('Please Specify Customer ID');
		}
		
		if($form_loccd==''){
			$goahead *=0;
			alert('Please Specify Location');
		}
		
		if($form_item==''){
			$goahead *=0;
			alert('Please Specify Product');
		}
		
		if ($goahead==1){
			getpage('generateloadingslip.php?op=getdetails&displaywhat=2&custno='+$form_custno+'&item='+$form_item+'&loccd='+$form_loccd,'page');
		}
		
	}
	
	function checkqty(theid)
	{
		
		var $form_theid = $('#'+theid).val();
		var $form_maxtheid = $('#max'+theid).val();
		var availqty = document.getElementById('avail'+theid);
		var element = document.getElementById(theid);
		if (Number($form_theid)<0)
		{ 
			alert('Value should not be less than Zero');
			element.value = 0;
			
		}
		if (Number($form_maxtheid) < Number($form_theid))
		{
			alert('Value should not be greater than Available Quantity of '+$form_maxtheid);
			element.value = 0;
			
		}
		if(isNaN(element.value)){
			element.value = 0;
			alert("Please Enter a Valid Value");
			
		
		}
		availqty.value = $form_maxtheid - element.value;
	}
	
</script>