//JavaScript Documentvar xmlHttp
function getRate(str)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="viewRate.php"
url=url+"?rate="+str
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged7 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged7() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("displayrate").innerHTML=xmlHttp.responseText 
 } 
}


//JavaScript Documentvar xmlHttp
function getviewsearch(str,crit)
{ 
//var joh = CallJS('Demo()');
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="viewSearch.php"
url=url+"?search="+str+"&criteria="+crit
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged9
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged9() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("showsearch").innerHTML=xmlHttp.responseText 
 } 
}


//JavaScript Documentvar xmlHttp
function returnSearch()
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
 
 var id = document.getSearch_form.acid.value
//var url="getPolicy2.php?q="+str
var url="customerpersonalinfo.php"
url=url+"?id="+id
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged10
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged10() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("page").innerHTML=xmlHttp.responseText 
 } 
}

function getViewDeposit(str,crit)
{ 
//var joh = CallJS('Demo()');
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="cusDeposit.php"
url=url+"?search="+str+"&criteria="+crit
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged9
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}

////////////////////////////////

function get2ViewDeposit(str,crit)
{ 
//var joh = CallJS('Demo()');
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="cus2Deposit.php"
url=url+"?search="+str+"&criteria="+crit
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged9
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
//////////////////////////////////////////


function stateChanged9() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("showsearch").innerHTML=xmlHttp.responseText 
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