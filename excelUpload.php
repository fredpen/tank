<style>

 #data-form  {
    background-color:#F2F7F9;
	width:650px;
    padding:10px;
    margin: 10px auto;    
    border: 6px solid #8FB5C1;
    -moz-border-radius:15px;
    -webkit-border-radius:15px;
    border-radius:15px;
    position:relative;
}


</style>
<div align ="center" id="data-form" > 
	<?php 
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{	
		include "printheader.php";
		?>

		<a href="#" class="noprint" onclick="window.close();return false"><h3><font size='12'>Close Window</font></h3></a>
		
		<?php
			require('library/php-excel-reader/excel_reader2.php');
			require('library/SpreadsheetReader.php');
		

			
		  $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet','text/csv','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
		  //echo  $_FILES["fileToUploadexcel"]["type"];
		  if(in_array($_FILES["fileToUploadexcel"]["type"],$mimes)){

			$query_clear = "delete from uploadjournalworkarea where 1=1 ";

			$result_clear = mysqli_query($_SESSION['db_connect'],$query_clear);
			
			//obtain array of chart of account
			$query_get_chart = "select * from chart_of_account where 1=1 ";

			$result_get_chart = mysqli_query($_SESSION['db_connect'],$query_get_chart);
			
			$count_get_chart = mysqli_num_rows($result_get_chart);
			$chartOfAccountArray = Array();
			
			
			if ($count_get_chart > 0)
			{
				for ($ch=0; $ch < $count_get_chart; $ch++)
				{
					$row = mysqli_fetch_array($result_get_chart);
					$key = "'".trim($row['chartcode'])."'";
					$chartOfAccountArray[$key] = $row['chartcode'];
					
				}
				
			}
			
				//print_r($chartOfAccountArray);
				
			//$uploadFilePath = 'tmpfolder/'.basename($_FILES['fileToUploadexcel']['name']);
			$uploadFilePath = 'tmpfolder/directjournal.xlsx';
			
			move_uploaded_file($_FILES['fileToUploadexcel']['tmp_name'], $uploadFilePath);


			$Reader = new SpreadsheetReader($uploadFilePath);


			$totalSheet = count($Reader->sheets());


			//echo "You have total ".$totalSheet." sheets".
			?>
				<div style="max-height: 500px; overflow-y:auto;overflow-x:auto;" >
			
			<?php
			
			$html="<table border='1'>";
			$html.="<tr><th>Code</th><th>Description</th><th>Debit</th><th>Credit</th><th>Day</th><th>Month</th><th>Year</th><th>Status</th></tr>";


			/* For Loop for all sheets */
			for($i=0;$i<$totalSheet;$i++){


			  $Reader->ChangeSheet($i);


			  foreach ($Reader as $Row)
			  {
				
				$chartcode = isset($Row[0]) ? $Row[0] : '';
				$description = isset($Row[1]) ? $Row[1] : '';
				$debit = isset($Row[2]) ? $Row[2] : 0;
				$credit = isset($Row[3]) ? $Row[3] : 0;
				$dd = isset($Row[4]) ? $Row[4] : 0;
				$mm = isset($Row[5]) ? $Row[5] : 0;
				$yyyy = isset($Row[6]) ? $Row[6] : 0;

				if (trim($chartcode) !='')
				{
					$uploadexcel = 1;
					$thekey = "'".trim($chartcode)."'";
					if (array_key_exists($thekey,$chartOfAccountArray))
					  {
							$codestatus = "Account Code is Valid";
					  }
					else
					  {
							$codestatus = "Account Code is Not Valid";
							$uploadexcel =0;
					  }
					
					if (! is_numeric($debit))
					{
						$codestatus = $codestatus . " : Debit Amount Field is not numeric.";
						$uploadexcel =0;
						
					}
					
					if (! is_numeric($credit))
					{
						$codestatus = $codestatus . " : Credit Amount Field is not numeric.";
						$uploadexcel =0;
						
					}
					
					if ((! is_numeric($dd)))
					{
						$codestatus = $codestatus . " : Day Field is not numeric.";
						$uploadexcel =0;
						
					}
					
					if ((! is_numeric($mm)))
					{
						$codestatus = $codestatus . " : Month Field is not numeric.";
						$uploadexcel =0;
						
					}
					
					if ((! is_numeric($yyyy)))
					{
						$codestatus = $codestatus . " : Year Field is not numeric.";
						$uploadexcel =0;
						
					}
					
					if ($uploadexcel ==0)
					{
						$codestatus = $codestatus . " : Record is dropped.";
					}
					
					$html.="<tr>";
					$html.="<td>".$chartcode."</td>";
					$html.="<td>".$description."</td>";
					$html.="<td>".$debit."</td>";
					$html.="<td>".$credit."</td>";
					$html.="<td>".$dd."</td>";
					$html.="<td>".$mm."</td>";
					$html.="<td>".$yyyy."</td>";
					$html.="<td>".$codestatus."</td>";
					
					$html.="</tr>";
					
					if ($uploadexcel ==1)
					{
						$query = "insert into uploadjournalworkarea(chartcode,description,debit,credit,dd,mm,yyyy) values('$chartcode','$description',$debit,$credit,$dd,$mm,$yyyy)";
					
						$result = mysqli_query($_SESSION['db_connect'],$query);
					}
					
				}
				//echo "<br>".$query."</br>";
				
			   }


			}


			$html.="</table> ";
			echo $html;
			
			?>
				</div >
			
			<?php
			//echo "<br />Data Inserted in dababase";


		  }else { 
			echo "<br/><h3>Sorry, Selected File type is not allowed. Select an Excel file with the predefined format.</h3>"; 
		  }


		}else {echo "<br/>Sorry."; }


	?>
</div>	