/*//Validates the 1.form div for  result,2 the url it is going to , 3.operation type which is arbitrary, 4. name of form submitting
function getformelements(getit,pager,operationtype,formval)
{
var str = '';
//alert("What is the problem");

var elem = document.getElementById(formval).elements;
//var elem2 = document.getElementById(formval).elements;
//var checkit='';
//for(var m = 0; m < elem2.length; m++)
//{
//	document.getElementById(elem2[m].name).style.color="#000000";
//}
for(var i = 0; i < elem.length; i++)
{
   if(elem[i].className=="required"){
	  
		   if(elem[i].value==""){	
			 var valtype = elem[i].title
			  document.getElementById(elem[i].name).style.color="#CC0000";
			  alert("Please enter the "+valtype);
			  document.formval.elem[i].name.focus;
			  return false;
			}
    }
	 if(elem[i].className=="numberRequired"){	
		      var intval = parseInt(elem[i].value);
			  if(isNaN(intval)||intval==""){	
				  var valtype2 = elem[i].title
				  document.getElementById(elem[i].name).style.color="#CC0000";
				  alert("Please enter a number value for "+valtype2);
				  document.formval.elem[i].name.focus;
				  return false;
		      }
		   
	  }
	  
	  if(elem[i].className=="number"){	
	         if(elem[i].value!=""){
		      var intval = parseInt(elem[i].value);
			  if(isNaN(intval)){	
				  var valtype2 = elem[i].title
				  document.getElementById(elem[i].name).style.color="#CC0000";
				  alert("Please enter a number value for "+valtype2);
				  document.formval.elem[i].name.focus;
				  return false;
		      }
		 }
		   
	  }
	  
	   if(elem[i].className=="email"){
		       var emailtype = elem[i].title
			   var emailval = elem[i].value;
			   if(emailval!=""){
				  with (emailval)
				  {
					  apos=emailval.indexOf("@");
					  dotpos=emailval.lastIndexOf(".");
					  if (apos<1||dotpos-apos<2){
					   document.getElementById(elem[i].name).style.color="#CC0000";
					   alert("Please enter "+emailtype);
					   document.formval.elem[i].name.focus;
					   return false;
					  }
				  }
			   }
		   
	  }
	  
	   if(elem[i].className=="emailRequired"){	
		       var emailtype = elem[i].title
			   var emailval = elem[i].value;
			  with (emailval)
			  {
				  apos=emailval.indexOf("@");
				  dotpos=emailval.lastIndexOf(".");
				  if (apos<1||dotpos-apos<2||emailval==""){
				   document.getElementById(elem[i].name).style.color="#CC0000";
				   alert("Please enter "+emailtype);
				   document.formval.elem[i].name.focus;
				   return false;
				  }
			  }
		   
	  }
	  
	  if(elem[i].className=="check"){	
			   if(elem[i].checked==true){
				   elem[i].value="Y";
			   }
			   else{
				   elem[i].value="N";
			   }
			
		   
	  }
	  
	  
	  
	  
	  

str += elem[i].name+"="+elem[i].value +"&";
}
//if(checkit=="Error"){
//	return false;
//}
//alert(operationtype);
str+="operation="+operationtype;
var nextpage= gotopage(getit,str,pager);

}


//Submits the form to a page
function gotopage(getit2,str2,pager)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }

var url=pager
url=url+"?"+str2;
//alert(url);
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChangedPost(getit2)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangedPost(getit2) 
{ 
 
document.getElementById(getit2).innerHTML=xmlHttp.responseText 

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
*/