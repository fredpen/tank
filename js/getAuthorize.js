//JavaScript Documentvar xmlHttp
function authorize(str,divid,destination,accno2)
 
{ 
//var joh = CallJS('Demo()');

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getothers.php?q="+str
//var url="getpaymentpt2.php"
var divtag = divid;
var url = destination;
url= url+"?"+accno2+"="+str
//url=url+"&r="+document.getElementById('v_type').value;
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChangedauthor(divtag)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangedauthor(divtag) 
{ 
 
document.getElementById(divtag).innerHTML=xmlHttp.responseText 

}




function authorizeAccount(str,divid)
 
{ 

//var joh = CallJS('Demo()');
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
url= url+"?accnos="+str
//url=url+"&r="+document.getElementById('v_type').value;
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChangedget(divtag)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangedget(divtag) 
{ 
 
document.getElementById(divtag).innerHTML=xmlHttp.responseText 

}



function authorize2(str,divid)
 
{ 
//var joh = CallJS('Demo()');

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getothers.php?q="+str
//var url="getpaymentpt2.php"

var divtag = divid
var url = "viewAuthorizeAcct2.php"
url= url+"?accno="+str
//url=url+"&r="+document.getElementById('v_type').value;
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChangedauthor(divtag)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangedauthor(divtag) 
{ 
 
document.getElementById(divtag).innerHTML=xmlHttp.responseText 

}



function authorizeAccount2(str,divid)
 
{ 


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
url= url+"?accnos="+str
//url=url+"&r="+document.getElementById('v_type').value;
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChangedget(divtag)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangedget(divtag) 
{ 
 
document.getElementById(divtag).innerHTML=xmlHttp.responseText 

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

