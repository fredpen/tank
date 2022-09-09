var xmlHttp

function pagination(page)
{
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var url="viewauthorize2.php";
url = url+"?starting="+page;
//url = url+"&search_text="+document.form1.search_text.value;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged44;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
} 

function stateChanged44() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("page").innerHTML=xmlHttp.responseText;
}
}

function pagination2(page)
{
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var url="viewauthorize4.php";
url = url+"?starting="+page;
//url = url+"&search_text="+document.form1.search_text.value;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangededit;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
} 

function stateChangededit() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("page").innerHTML=xmlHttp.responseText;
}
}




function paginationloan(page)
{
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var url="authorize_loan2.php";
url = url+"?starting="+page;
//url = url+"&search_text="+document.form1.search_text.value;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedloan;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
} 

function stateChangedloan() 
{ 
if (xmlHttp.readyState==4)
{ 
document.getElementById("page").innerHTML=xmlHttp.responseText;
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
  // Internet Explorer
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