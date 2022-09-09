

function checklogin(formurl){
	
		$('#error_label_login').ajaxStart(function(){
		//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
		$('#error_label_login').html('<img src="images/loading.gif" alt="" />loading please wait . . .');
		});
	
		 var themodule = document.getElementsByName("trantype");
		 var data3 = 0;
		 for (var i=0;i < themodule.length; i++){
			 if (themodule[i].checked)
				 data3 =themodule[i].value;
		 }
		 
		 var data = $("#username").val();
		 var data2 = $("#inputPassword").val();
		 
		 if ((data =='') || (data2== ''))
		 {
			 $('#error_label_login').html('<img src="images/loading.gif" alt="" />Enter log in details . . .');
			 return false;
		 };
		//alert(data+":"+data2);
		//data = "IYALLA";
		//data2="IYALLA";
		//error_label_login
		$.ajax({ 
		   async: true,
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op=checklogin&username="+data+"&password="+data2+"&themodule="+data3, 
		   success: function(msg){  
				//msg =  jQuery.trim(msg); 
				//alert(msg);
				 $("#error_label_login").html('logging you in ...').show();
				if(msg==''){
					$("#error_label_login").html('Please enter a valid Username and Password').show();
				}
				else if(msg=='0'){
					$("#error_label_login").html('Invalid username or password').show();
				}
				else if(msg=='3'){
					$("#error_label_login").html('You do not have access to selected Module').show();
				}
				else if(msg=='1'){	
					//$("#member_data").val(msg);
					//alert($("#member_data").val());
					// header("Location: mainmenu.php"); 
					//die("Redirecting to: mainmenu.php"); 				
					//alert(formurl)
					$("#form1").attr("action",formurl);
					$("#form1").submit();
				}
				else {	
					$("#error_label_login").html('Invalid username or password').show();
				}
		   } 
		 });
			//alert(data);
			
		return false;
}



function getpage(str,divid) 
{ 
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
//alert(str);
//alert(str);
	//var data = getdata();
	//alert(data);
			/*
			
			$(divid).ajaxStart(function(){
			$(divid).html('');
			$(divid).html('<img src="images/loading.gif" alt="" />loading please wait . . .');
			});
			*/	if(str!='#'){
			$.ajax({ 
			   async: true,
			   type: "POST", 
			   url: str, 
			   data: '', 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				// alert(msg);
				 $('#'+divid).html(msg);
				 //$("#display_message").fadeIn("slow");
				 $.unblockUI();
			   } 
			 });
			
			}// end if
			//$.unblockUI();
}



function doSearch(url){
	 $.blockUI({ message: "<img src='images/ajax-loader.gif' /> " }); 
	var data = getdata();
	 
	getpage(url+'?'+data,'page');

}



function getdata(){
	var data = "";
	$("#form1").serialize();
	$.each($("input, select, textarea"), function(i,v) {
    var theTag = v.tagName;
    var theElement = $(v);
	var theName = theElement.attr('name');
    var theValue = escape(theElement.val());
	var classname = theElement.attr('class');
	//alert('name : '+theName+"   value :"+theValue+"  class :"+classname);
	if(classname=='required-text'){
		if(!check_textvalues(theElement)) data = "error";
	}
	if(classname=='required-number'){
		if(!check_numbers(theElement)) data = "error";
	}
	if(classname=='currency'){
		theValue = removecomma(theElement.val());
		if(theValue=="" || theValue==0) { data = "error";
		$("#display_message").html('please enter number for '+theElement.attr('title'));
			$("#display_message").show('fast');
			theElement.focus();
			$("#display_message").click();
			return false;
		}
		else
		if(isNaN(theValue)) { data = "error";
		$("#display_message").html('please enter number for '+theElement.attr('title'));
			$("#display_message").show('fast');
			theElement.focus();
			$("#display_message").click();
			return false;
		}
	}
	if(classname=='required-email'){
		if(!check_email(theElement)) data = "error";
		
	}
	if(classname=='required-alphanumeric'){
		if(!check_password_aplhanumeric(theElement)) data = "error";
	}
	if(data!='error'){
		data = data+theName+"="+theValue+"&";
	}
	});
	//alert(data);
	return data;
}



function goFirst(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(fpage!=1){
		$("#fpage").get(0).value = '1';
		$("#pageNo").get(0).value = 1;
		doSearch(dpage);
	}else{
		return false;
	}

}

function goLast(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(lpage!=fpage){
		$("#fpage").get(0).value = lpage;
		$("#pageNo").get(0).value = lpage;
		doSearch(dpage);
	}else{
		return false;
	}

}
function goPrevious(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(fpage !=1){
		$("#fpage").get(0).value = fpage-1;
		$("#pageNo").get(0).value = fpage-1;
		doSearch(dpage);
	}else{
		return false;
	}

}

function goNext(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if((lpage > fpage)){
		$("#fpage").get(0).value = fpage+1;
		$("#pageNo").get(0).value = fpage+1;
		doSearch(dpage);
	}else{
		return false;
	}

}




function printDiv(seldiv)
{
  var divToPrint=document.getElementById(seldiv);
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html><link rel="stylesheet" type="text/css" href="css/main.css"><body>'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  //setTimeout(function(){newWin.close();},20);
}

function calldownload(){
	//
	var data = $('#sql').val();
	var data2 = $('#filename').val();
	//alert(data);
	window.open("download.php?sql="+escape(data)+"&filename="+data2,"mydownload","status=0,toolbar=0");
}

function readtabledata(tableId, fil)
{
	
	//alert('Starting...');
	var tabl = document.getElementById(tableId);
	var l = tabl.rows.length;
	//alert( 'Number of table rows: ' + l );
	var s = '';
	for ( var i = 0; i < l; i++ )
	{
	var tr = tabl.rows[i];
	var tr_cols = tr.childNodes;
	var tr_cols_len = tr_cols.length;
		
		var data = '';
		var alldata = '';
		// Read the content of each td
		for( var j=0; j < tr_cols_len; j++){
		var cll = tr.childNodes[j];
		var ct = cll.innerHTML; 
		ct= jQuery.trim(ct);//.replace( /<[^<>]+>/g, '' );
		if(ct=='') continue;
		if(ct!=undefined)data = ct+"@";
		alldata = alldata + data;
		//alert(alldata.length);
		}
		alldata = alldata.substr(0,alldata.length-1);
		s += alldata + "|";
	}
	/*var schl = $("#school").val();
	var acyr = $("#academicyear").val();
	var subj = $("#subject").val();*/
	//var fil = acyr+'-'+schl+'-'+subj+'.xls';
	s = s.substr(0,s.length-1);
	//s = escape(s);
	//alert('result:\n' + s);
	$('#data').get(0).value = s;
	$('#datafilename').get(0).value = fil;
	$("#form1").attr("action","generateexcel2.php");
	$("#form1").attr("target","_blank");
	$("#form1").submit();
	

}


function guestsearch(formurl,formur2){
	
		$('#error_label_vehicle').ajaxStart(function(){
		$('#error_label_vehicle').html('<img src="images/loading.gif" alt="" />loading please wait . . .').show();
		});
	
		 var data = $("#vehicleno").val();
		 var data2 = $("#company").val();
		 //alert(data);
		 //alert(data2);
		if ( data != "" )
		{
			$.ajax({ 
			   type: "POST", 
			   url: "utilities.php", 
			   data: "op=guestsearch&vehicleno="+data, 
			   success: function(msg){  
				msg =  jQuery.trim(msg); 
					
				 $("#error_label_vehicle").html('Retrieving Image ...').show();
					//alert(msg);
					if(msg=="0"){
						$("#error_label_vehicle").html('Vehicle does not exist in our database ').show();
					}
					else if(msg=="1"){	
						$("#error_label_vehicle").html('Vehicle found ...').show();
						$("#form1").attr("action",formurl);
						$("#form1").submit();
					}
			   } 
			   
			   
			 });			
		}
		if  ( data == "") 
		{
			if  ( data2 == "" )
			{
				
				$("#error_label_vehicle").html('No Transporter name was entered ').show();
			} 
			else
			{			
				$.ajax({ 
				   type: "POST", 
				   url: "utilities.php", 
				   data: "op=guestsearch1&company="+data2, 
				   success: function(msg){  
					msg =  jQuery.trim(msg); 
						
					 $("#error_label_vehicle").html('Retrieving Details ...').show();
						//alert(msg);
						if(msg=="0"){
							$("#error_label_vehicle").html('Transporter does not exist in our database ').show();
						}
						else if(msg=="1"){	
							$("#error_label_vehicle").html('Transporter found ...').show();
							$("#form1").attr("action",formur2);
							$("#form1").submit();
						}
				   } 
				   
				   
				 });				
			}
		}
		//$("#error_label_vehicle").html('Please').show();
		return false;
}
