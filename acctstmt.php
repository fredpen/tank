<?php 
	
	include "printheader.php";
?>

<div align ="center" id="data-form" > 

	<?php 
		

		include "basicparameters.php";	
		
		$startdate = substr($startdate,8,2)."/".substr($startdate,5,2)."/".substr($startdate,0,4);
		$enddate = substr($enddate,8,2)."/".substr($enddate,5,2)."/".substr($enddate,0,4);


			$query = "SELECT exprefno refno,descriptio AS descriptn,expensdate pmtdate, amount, " .
					" 2 advrefund1,'Other Expenditure' source , dd_no, bank_code, pmtmode " .
					" FROM expense WHERE  STR_TO_DATE(expensdate , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(expensdate , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') " .
					" UNION " .
		" SELECT  refno,descriptn,pmtdate, amount, advrefund1,'Deposit/Refund   ' AS source " .
					", dd_no, bank_code, pmtmode FROM payments WHERE  STR_TO_DATE(pmtdate , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(pmtdate , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') " .
					" UNION " .
		" SELECT  refno,descriptn,pmtdate, amount, 1 AS advrefund1,'Other Income     ' AS source ".
					", dd_no, bank_code, pmtmode FROM otherincome WHERE  STR_TO_DATE(pmtdate , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(pmtdate , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') ";

			$query_summary1 = "SELECT exprefno refno,descriptio AS descriptn,expensdate pmtdate, amount, " .
					" 2 advrefund1,'Other Expenditure' source , dd_no, bank_code, pmtmode " .
					" FROM expense WHERE  STR_TO_DATE(expensdate , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
					" and STR_TO_DATE(expensdate , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') " .
					" UNION " .
			" SELECT  refno,descriptn,pmtdate, amount, advrefund1,'Deposit/Refund   ' AS source " .
						", dd_no, bank_code, pmtmode FROM payments WHERE  STR_TO_DATE(pmtdate , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(pmtdate , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') " .
						" UNION " .
			" SELECT  refno,descriptn,pmtdate, amount, 1 AS advrefund1,'Other Income     ' AS source ".
						", dd_no, bank_code, pmtmode FROM otherincome WHERE  STR_TO_DATE(pmtdate , '%d/%m/%Y') >= STR_TO_DATE('" . $startdate . "', '%d/%m/%Y')" .
						" and STR_TO_DATE(pmtdate , '%d/%m/%Y') <= STR_TO_DATE('" . $enddate . "', '%d/%m/%Y') ";
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			
			$result_summary1 = mysqli_query($_SESSION['db_connect'],$query_summary1);
			$numrows_summary1 = mysqli_num_rows($result_summary1);

			$summary_income = 0;$summary_expense = 0;
			if ($numrows_summary1 > 0){
				$k=0;
				while($k<$numrows_summary1) 
				{
					$k++;
					
					$row = mysqli_fetch_array($result_summary1);
					
					$holdvalue = $row['advrefund1']=='1'?$row["amount"]:0;
					$summary_income = $summary_income + $holdvalue;	
					$holdvalue = $row['advrefund1']=='2'?$row["amount"]:0 ;
					$summary_expense = $summary_expense	+ 	$holdvalue;	
				}
			}
			
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
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong>Statement of Acount (Corporate)</strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Pmt Date:</th>
									<th   class="Odd">Pmt Ref</th>
									<th   class="Odd">Description</th>
									<th   class="Odd">Source</th>
									<th   class="Odd">Bank Ref</th>
									<th   class="Odd">Income</th>
									<th   class="Odd">Expenditure</th>
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
										<td  ><?php echo $row['pmtdate'];?></td>
										<td  ><?php echo $row["refno"];?></td>
										<td  ><?php echo trim($row["descriptn"]);?></td>
										<td  ><?php echo trim($row["source"]);?></td>
										<td  ><?php echo trim($row["bank_code"])."-".trim($row["dd_no"]);?></td>
										<td   align="right"><?php echo number_format(($row['advrefund1']=='1'?$row["amount"]:0),2);?></td>
										<td   align="right"><?php echo number_format(($row['advrefund1']=='2'?$row["amount"]:0),2);?></td>
										<td  ></td>
									</tr>
							<?php 
									//} //End For Loop
								} //End If Result Test	
							?>
									<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td  >&nbsp;</td>
										<td  ></td>
										<td  ></td>
										<td  ></td>
										<td  ><strong>Summary :</strong></td>
										<td  ></td>
										<td  > </td>
										<td   align="right"><strong><?php echo number_format($summary_income,2);?></strong></td>
										<td   align="right"><strong><?php echo number_format($summary_expense,2);?></strong></td>
										<td  ></td>
									</tr>							
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