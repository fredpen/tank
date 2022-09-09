function authorizeinfo2(divid,viewpage,fieldinit,fieldfinal,init1,init2)
{
	//alert("help");
	xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
  
  var operation = "authorize";
  
  var divtag = divid
var url = viewpage
url= url+"?operation="+operation+"&fieldinit="+fieldinit+"&fieldfinal="+fieldfinal+"&init1="+init1+"&init2="+init2;
//url=url+"&r="+document.getElementById('v_type').value;
//alert(url);
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChangeauth(divtag)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}



function cancelinfo22(divid,viewpage,fieldinit,fieldfinal,init1,init2)
{
	//alert("help");
	xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
  
  var canceloperation = "authorize";
  
  var divtag = divid
var url = viewpage
url= url+"?canceloperation="+canceloperation+"&fieldinit="+fieldinit+"&fieldfinal="+fieldfinal+"&init1="+init1+"&init2="+init2;
//url=url+"&r="+document.getElementById('v_type').value;
//alert(url);
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChangeauth(divtag)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangeauth(divtag) 
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

function checkfunc(){
	
	//alert("help function");
	
}