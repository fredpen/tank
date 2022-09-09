//JavaScript Documentvar xmlHttp

function checkExist2(){
	xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		 {
		 alert ("Browser does not support HTTP Request")
		 return
		 }
		 //alert("Just Testing");
		var checkname = document.createnew.accname.value; 
		var url="verifyaccname.php?checkname="+checkname;
		
		url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=stateChanged100
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
		}
		////////////////////////////////
		function stateChanged100() 
		{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 document.getElementById("checkex").innerHTML=xmlHttp.responseText 
		 } 
	
	
}


function checkAccRate2(){
	xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		 {
		 alert ("Browser does not support HTTP Request")
		 return
		 }
		 //alert("Just Testing");
		 if(document.createnew.acrate.checked==true){
				 var acctyperate = document.createnew.acctypes.selectedIndex;
				  if(acctyperate==""){
					 alert("Account type is required to overide Account Rates!")
					 document.createnew.acctypes.focus();
					 return false;
				 }
				 document.createnew.acrate.value="1";	
				 var acctype = document.createnew.acctypes[document.createnew.acctypes.selectedIndex].value;

		   }
	   else{
	       document.createnew.acrate.value="0";	
           }
		var ratetype = document.createnew.acrate.value; 
		var url="overide.php?ratetype="+ratetype+"&acctype="+acctype;
		//alert(url);
		
		url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=stateChangedrate2 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
		}
		////////////////////////////////
		function stateChangedrate2() 
		{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 document.getElementById("rate").innerHTML=xmlHttp.responseText 
		 } 
	
	
}




 function checktype(acctypeval,usertype){
	 if(acctypeval==usertype){
		 var answer = confirm ("Are you sure you want to open another "+usertype)
				if (answer){
					alert("You have decided to open another "+usertype)
						return false;
   				  }
 					return answer 
	 }
  	//alert(acctypeval+"="+usertype)
}




function selectMan(str)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="getPolicy2.php?q="+str
var url="uploadmandatebutton.php"
url=url+"?getpicure="+str
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChangedppp 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChangedppp() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("displaypic").innerHTML=xmlHttp.responseText 
 } 
}


//Validates the form div first , name of form and the operation type
function createnew_account(getit,pager,operationtype,formval)
{
var str = '';

var elem = document.getElementById(formval).elements;
var checkit='';
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
if(checkit=="Error"){
	return false;
}
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
 var accname5 = document.getElementById("checkex").innerHTML;
 if(accname5!=""){
  alert("Account Name Already Exist!")
  document.createnew.accname.focus();
  return false;
  }
//var url="getPolicy2.php?q="+str
var url=pager
url=url+"?"+str2;
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=function()
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
     stateChanged2(getit2)
	
 }
}
 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged2(getit2) 
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