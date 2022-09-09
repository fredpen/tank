<?php require_once("lib/mfbconnect.php"); 
require_once("lib/dbfunctions.php");
	  $dbobject = new dbfunction();
	
?>
<!-- <link rel="stylesheet" type="text/css" href="css/style.css" /> -->
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="css/main.css">
<script type="text/javascript" src="js/selectuser.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript" src="js/createnew.js"></script>
<script type="text/javascript" src="js/form_validator.js"></script>
<script type="text/javascript" src="js/gen_validator.js"></script>
<script type="text/javascript" src="js/getAuthorize.js"></script>
<script type="text/javascript" src="js/getRate.js"></script>
<script type="text/javascript" src="js/pagination.js"></script>
<script type="text/javascript" src="js/progress.js"></script>
<script type="text/javascript" src="js/validate_post.js"></script>
<script type="text/javascript" src="date/datepicker.js"></script>
<script type="text/javascript" src="js/authorize_edit.js"></script>
<script type="text/javascript" src="js/jquery.formatCurrency.js"></script>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) 
{ //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
	
		<!--	<div id="banner">
			<div id="welcome">
			  <h3>Conoil Plc</h3>
			</div><!--close welcome-->
			<!--<div id="welcome_slogan">
			  <h3>Stock Monitoring Application</h3>
			</div><!--close welcome_slogan-->				  
				
		 <!--</div><!--close banner-->	
<?php include "workflowstatus.php";?>	

	<div id="head-inner" align="center" style="background-color:white;">
		<table width="80%" border="0" cellspacing="0" cellpadding="0" >
		  <tr>
			<td  align="left" nowrap="nowrap" class="userdata"><b>You Are Welcome: </b>&nbsp;
				&nbsp;<?php echo trim($_SESSION['username_sess']);?>&nbsp;, <?php echo trim($_SESSION['username']);?></td>
			<td align="center"> <b>Your Role : </b><?php echo trim($_SESSION['role_id_sess']);?> </td>
			
			<td align="center"> <b>Current Channel : </b>
					<?php switch ($_SESSION['trantype']) {
						case 1:
							echo ' - Cash';
							break;
						case  2:
							echo ' - Credit';
							break;
						case  3:
							echo ' - Own Use';
							break;
						case  4:
							echo ' - Product Transfer';
							
							
					}
					?>
			
			 </td>
			
			<?php if ($count_workflow == 0) { ?>
			<td   align="right" >No Pending Activity Was Detected</td>
			<?php } else { ?>
			<td   align="right" >Pending Activity For You <a href="javascript: getpage('workflow.php','page');">Click here for details(<?php echo $count_workflow; ?>) </a></td>
			<?php } ?>
			
		  </tr>
		</table>
	</div>
<?php include "menu.php";?>
