
<!--<!-- Begin

function checkAll()
{
var check_del_len = document.authorize_form.check_del.length;
 document.getElementById('st_val').value='';
 
for ( i = 0; i<check_del_len ; i++)
 { 
  document.authorize_form.check_del[i].checked=true;
  document.getElementById('st_val').value+=document.authorize_form.check_del[i].value+',';
 
  }
  fin_str =  document.getElementById('st_val').value;
  
   document.getElementById('st_val').value  = fin_str.replace(',on,','');
   
}

function clearAll()
{
var check_del_len = document.authorize_form.check_del.length;
for ( i = 0; i<check_del_len ; i++)
 {
  document.authorize_form.check_del[i].checked=false;
  document.getElementById('st_val').value='';
  
  }
}


function checkAll2()
{
var check_del_len = document.authorize_edit_form.check_del2.length;
 document.getElementById('st_val2').value='';
 
for ( i = 0; i<check_del_len ; i++)
 { 
  document.authorize_edit_form.check_del2[i].checked=true;
  document.getElementById('st_val2').value+=document.authorize_edit_form.check_del2[i].value+',';
 
  }
  fin_str =  document.getElementById('st_val2').value;
  
   document.getElementById('st_val2').value  = fin_str.replace(',on,','');
   
}


function clearAll2()
{
var check_del_len = document.authorize_edit_form.check_del2.length;
for ( i = 0; i<check_del_len ; i++)
 {
  document.authorize_edit_form.check_del2[i].checked=false;
  document.getElementById('st_val2').value='';
  
  }
}


function test()
{
	
var check_del_len = document.authorize_form.check_del.length;
if(check_del_len==0)
{
 document.getElementById('st_val').value ='';

}
document.getElementById('ch_all').checked =false;
document.getElementById('st_val').value ='';

for ( i = 0; i<check_del_len ; i++)
 {
  if(document.authorize_form.check_del[i].checked)
   {
   document.getElementById('st_val').value+=document.authorize_form.check_del[i].value+',';
    
    }
  }
  
    
  fin_str =  document.getElementById('st_val').value;
  document.getElementById('st_val').value  = fin_str.replace(',on,','');
   
}


function test2()
{
//var ch = document.authorize_edit_form.check_del2.value;	
//alert("Yes2");
var check_del_len = document.authorize_edit_form.check_del2.length;
if(check_del_len==0)
{
 document.getElementById('st_val2').value ='';
 

}

document.getElementById('ch_all2').checked =false;
document.getElementById('st_val2').value ='';

for ( i = 0; i<check_del_len ; i++)
 {
  if(document.authorize_edit_form.check_del2[i].checked)
   {
   document.getElementById('st_val2').value+=document.authorize_edit_form.check_del2[i].value+',';
    
    }
  }
  
    
  fin_str =  document.getElementById('st_val2').value;
  document.getElementById('st_val2').value  = fin_str.replace(',on,','');
  //alert(fin_str);
   
}




function test3()
{
	

		document.getElementById('st_val2').value ='';
		if(document.authorize_edit_form.check_del2.checked){
		document.getElementById('st_val2').value=document.authorize_edit_form.check_del2.value+',';
		}
			fin_str =  document.getElementById('st_val2').value;
		document.getElementById('st_val2').value  = fin_str.replace(',on,','');
		//alert(fin_str);
   
}



function submitValidate(divid)
{
 if(document.getElementById('st_val').value=='')
 {
  alert('Pls click the check box to authorize account');
  return false;
  }
  else
  {
   
   var str = document.getElementById('st_val').value;
  
  xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getothers.php?q="+str
//var url="getpaymentpt2.php"
var divtag = divid
var url = "viewauthorize.php"
url= url+"?authorizenow="+str
//url=url+"&r="+document.getElementById('v_type').value;
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChangeddo(divtag)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangeddo(divtag) 
{ 
 
document.getElementById(divtag).innerHTML=xmlHttp.responseText 

}

 }
 




function submitValidate2(divid)
{
 if(document.getElementById('st_val2').value=='')
 {
  alert('Pls click the check box to authorize account');
  return false;
  }
  else
  {
   
   var storedval = document.getElementById('st_val2').value;
    var accnumber = document.getElementById('accnumber').value;
  
  xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getothers.php?q="+str
//var url="getpaymentpt2.php"
var divtag = divid
var url = "viewAuthorize.php"
url= url+"?authorizefield="+storedval+"&accnumber="+accnumber;
//url=url+"&r="+document.getElementById('v_type').value;
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChangeddo(divtag)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangeddo(divtag) 
{ 
 
document.getElementById(divtag).innerHTML=xmlHttp.responseText 

}

 }



 function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}


 function test5(str)
{
		var valuep = document.getElementById(str).value;
		//alert(valuep);
   
}

function checkAllrep()
{
var check_del_len = document.form1.check_del.length;
//alert(check_del_len);
 document.getElementById('st_val').value='';
 
for ( i = 0; i<check_del_len ; i++)
 { 
  document.form1.check_del[i].checked=true;
  document.getElementById('st_val').value+=document.form1.check_del[i].value+',';
 
  }
  fin_str =  document.getElementById('st_val').value;
  
   document.getElementById('st_val').value  = fin_str.replace(',on,','');
   
}

function clearAllrep()
{
var check_del_len = document.form1.check_del.length;
for ( i = 0; i<check_del_len ; i++)
 {
  document.form1.check_del[i].checked=false;
  document.getElementById('st_val').value='';
  
  }
}




function testrep(t)
{
	
//var check_del_len = document.form1.check_del.length;

var check_del_len =  $('input[type="checkbox"]:checked').length;
//alert(check_del_len);


if(check_del_len==0)
{
 //document.getElementById('st_val').value ='';
 $("#st_val").get(0).value = '';

}
    //ch_all.checked=false;
	$('#ch_all').attr('checked').value = false
    //$("#st_val").get(0).value = '';
	//alert("Yes");
	 //check_del[i].value;
	 //alert("Yes");
	 //alert(document.form1["checkbox"][i].val());
  if(t.checked)
   {
	   //document.form1.check_del[i].checked=true;
	  // alert("Yes");
   	   $("#st_val").get(0).value+=t.value+',';
    
    }
    
  	fin_str =  $("#st_val").val();
  	$("#st_val").get(0).value  = fin_str.replace(',on,','');  
}