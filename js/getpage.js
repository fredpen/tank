//JavaScript Documentvar xmlHttp
/*function getpage(str,divid)
 
{ 

var joh = CallJS('Demo()')
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getothers.php?q="+str
//var url="getpaymentpt2.php"

var divtag = divid
 var url= str
var joh = CallJS('Demo()')
//url=url+"&r="+document.getElementById('v_type').value;
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChanged2(divtag)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}*/
////////////////////////////////
function stateChanged2(divtag) 
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

