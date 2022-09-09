//JavaScript Documentvar xmlHttp
function getPolicy2(str)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="customersearch2.php"
url=url+"?q="+str
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged22
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged22() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("todisplay").innerHTML=xmlHttp.responseText 
 } 
}


//JavaScript Documentvar xmlHttp
function getPolicy3(str)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="customersearch3.php"
url=url+"?q="+str
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged25
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged25() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("more").innerHTML=xmlHttp.responseText 
 } 
}





function getSearchResult()
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var infos = document.newaccount_form.infos.value
var crit = document.newaccount_form.select1[document.newaccount_form.select1.selectedIndex].value;
if(infos==""){
 //alert("Please Enter a value")
 document.newaccount_form.infos.focus
 return false;
}
var url="customersearch4.php"
url=url+"?infos="+infos+"&criter="+crit
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged30
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged30() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("showlist").innerHTML=xmlHttp.responseText 
 } 
}



function diplaySearchList()
{ 
//var joh = CallJS('Demo()');
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="customersearch4.php"
url=url
//url=url+"&r="+document.getElementById('v_type').value;
url=url
xmlHttp.onreadystatechange=stateChanged26
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged26() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("showlist").innerHTML=xmlHttp.responseText 
 } 
}




function getdeposit(str)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="depositsearch.php"
url=url+"?q="+str
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChangeddep
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangeddep() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("todisplay").innerHTML=xmlHttp.responseText 
 } 
}

//////////////////////////////////////////////////////////////
function get2deposit(str)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="deposit2search.php"
url=url+"?q="+str
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChangeddep
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangeddep() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("todisplay").innerHTML=xmlHttp.responseText 
 } 
}









///////////////////////////////////////////////////////////////////////////
function getDeposit2(str)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="depositSearch3.php"
url=url+"?q="+str
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged25
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged25() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("more").innerHTML=xmlHttp.responseText 
 } 
}


/////////////////////////////////////////////////////////////////////
function get2Deposit2(str)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="deposit3Search3.php"
url=url+"?q="+str
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged25
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged25() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("more").innerHTML=xmlHttp.responseText 
 } 
}



////////////////////////////////////////////////////////////////////

function diplayDepositList()
{ 
//var joh = CallJS('Demo()');
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="depositSearch4.php"
url=url
//url=url+"&r="+document.getElementById('v_type').value;
url=url
xmlHttp.onreadystatechange=stateChanged26
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged26() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("showlist").innerHTML=xmlHttp.responseText 
 } 
}

////////////////////////////////////////////////////////////////////////
function diplay2DepositList()
{ 
//var joh = CallJS('Demo()');
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="deposit2Search4.php"
url=url
//url=url+"&r="+document.getElementById('v_type').value;
url=url
xmlHttp.onreadystatechange=stateChanged26
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged26() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("showlist").innerHTML=xmlHttp.responseText 
 } 
}




//////////////////////////////////////////////////////////////////////

function getDepResult()
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var infos = document.newaccount_form.infos.value
var crit = document.newaccount_form.select1[document.newaccount_form.select1.selectedIndex].value;
if(infos==""){
 //alert("Please Enter a value")
 document.newaccount_form.infos.focus
 return false;
}
var url="depositSearch4.php"
url=url+"?infos="+infos+"&criter="+crit
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged30
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////

function get2DepResult()
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var infos = document.newaccount_form.infos.value
var crit = document.newaccount_form.select1[document.newaccount_form.select1.selectedIndex].value;
if(infos==""){
 //alert("Please Enter a value")
 document.newaccount_form.infos.focus
 return false;
}
var url="deposit2Search4.php"
url=url+"?infos="+infos+"&criter="+crit
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged30
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}


/////////////////////////////////


function stateChanged30() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("showlist").innerHTML=xmlHttp.responseText 
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