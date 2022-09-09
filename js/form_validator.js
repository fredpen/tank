
function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {
    alert(alerttxt);return false;
    }
  else
    {
    return true;
    }
  }
}


/*function checkExist(){
	xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		 {
		 alert ("Browser does not support HTTP Request")
		 return
		 }
		 //alert("Just Testing");
		var checkname = document.newaccount_form.accname.value; 
		var url="verifyaccname.php?checkname="+checkname;
		
		url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=stateChanged99 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
		}
		////////////////////////////////
		function stateChanged99() 
		{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 document.getElementById("checkex").innerHTML=xmlHttp.responseText 
		 } 
	
	
}*/


function checkAccRate(){
	xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		 {
		 alert ("Browser does not support HTTP Request")
		 return
		 }
		 //alert("Just Testing");
		 if(document.newaccount_form.acrate.checked==true){
				 var acctyperate = document.newaccount_form.acctype.selectedIndex;
				  if(acctyperate==""){
					 alert("Account type is required to overide Account Rates!")
					 document.newaccount_form.acctype.focus();
					 return false;
				 }
				 document.newaccount_form.acrate.value="1";	
				 var acctype = document.newaccount_form.acctype[document.newaccount_form.acctype.selectedIndex].value;

		   }
	   else{
	       document.newaccount_form.acrate.value="0";	
           }
		var ratetype = document.newaccount_form.acrate.value; 
		var url="overide.php?ratetype="+ratetype+"&acctype="+acctype;
		//alert(url);
		
		url=url+"&sid="+Math.random()
		xmlHttp.onreadystatechange=stateChangedrate 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
		}
		////////////////////////////////
		function stateChangedrate() 
		{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		 { 
		 document.getElementById("rate").innerHTML=xmlHttp.responseText 
		 } 
	
	
}








function validate_customer_form()
{
//var branch2 = document.newaccount_form.branch.selectedIndex;	
//var branch = document.newaccount_form.branch[document.newaccount_form.branch.selectedIndex].value;	
var accname = document.newaccount_form.accname.value;
var accname5 = document.getElementById("checkex").innerHTML;
var acctype2 = document.newaccount_form.acctype.selectedIndex;
var acctype = document.newaccount_form.acctype[document.newaccount_form.acctype.selectedIndex].value;
var fname = document.newaccount_form.fname.value;
var mname = document.newaccount_form.mname.value;
var lname = document.newaccount_form.lname.value;
var gender2 = document.newaccount_form.gender.selectedIndex;
var gender = document.newaccount_form.gender[document.newaccount_form.gender.selectedIndex].value;
var address = document.newaccount_form.address.value;
var city = document.newaccount_form.city.value;
var state2 = document.newaccount_form.state.selectedIndex;
var state = document.newaccount_form.state[document.newaccount_form.state.selectedIndex].value;
var country2 = document.newaccount_form.country.selectedIndex;
var country = document.newaccount_form.country[document.newaccount_form.country.selectedIndex].value;;
var mobtel = document.newaccount_form.mobtel.value;
var homephone = document.newaccount_form.homephone.value;
var workphone = document.newaccount_form.workphone.value;
var fax = document.newaccount_form.fax.value;
var email = document.newaccount_form.email.value;
var dob = document.newaccount_form.dob.value;
var occupation = document.newaccount_form.occupation.value;
var employername = document.newaccount_form.employername.value;
var employaddr = document.newaccount_form.employaddr.value;
var employcity = document.newaccount_form.employcity.value;
var employstate = document.newaccount_form.employstate[document.newaccount_form.employstate.selectedIndex].value;
var employcountry = document.newaccount_form.employcountry[document.newaccount_form.employcountry.selectedIndex].value;

var nok = document.newaccount_form.nok.value;
var nokaddr = document.newaccount_form.nokaddr.value;
var nokemail = document.newaccount_form.nokemail.value;
var noktel = document.newaccount_form.noktel.value;
var nokcity = document.newaccount_form.nokcity.value;
var nokstate2 = document.newaccount_form.nokstate.selectedIndex;
var nokstate = document.newaccount_form.nokstate[document.newaccount_form.nokstate.selectedIndex].value;
var nokcountry2 = document.newaccount_form.nokcountry.selectedIndex;
var nokcountry = document.newaccount_form.nokcountry[document.newaccount_form.nokcountry.selectedIndex].value;

var grouptype2 = document.newaccount_form.grouptype.selectedIndex;
var grouptype = document.newaccount_form.grouptype[document.newaccount_form.grouptype.selectedIndex].value;


var signatory = document.newaccount_form.signatory.value;
var comment = document.newaccount_form.comment.value;
var acrate = document.newaccount_form.acrate.value;
if(acrate==1){
	//alert(acrate);
	//return false;

var intRate = document.newaccount_form.intRate.value;
var cotRate = document.newaccount_form.cotRate.value;
var depRate = document.newaccount_form.depRate.value;
}
//var smsWith = document.newaccount_form.smsWith.value;
//var smsDep = document.newaccount_form.smsDep.value;
//var allSms = document.newaccount_form.allSms.value;
//var emailWith = document.newaccount_form.emailWith.value;
//var emailDep = document.newaccount_form.emailDep.value;
//var allEmail = document.newaccount_form.allEmail.value;
   
 if(document.newaccount_form.smsWith.checked==true){
	document.newaccount_form.smsWith.value="Y";	
}
else{
	document.newaccount_form.smsWith.value="N";
}
var smsWith = document.newaccount_form.smsWith.value;
//alert(smsWith);

if(document.newaccount_form.smsDep.checked==true){
	document.newaccount_form.smsDep.value="Y";	
}
else{
	document.newaccount_form.smsDep.value="N";	
}
var smsDep = document.newaccount_form.smsDep.value;
//alert(smsDep);

if(document.newaccount_form.allSms.checked==true){
	document.newaccount_form.allSms.value="Y";
}
else{
	document.newaccount_form.allSms.value="N";	
}
var allSms = document.newaccount_form.allSms.value;
//alert(allSms);

if(document.newaccount_form.emailWith.checked==true){
	document.newaccount_form.emailWith.value="Y"
}
else{
	document.newaccount_form.emailWith.value="N";	 
}
var emailWith = document.newaccount_form.emailWith.value;
//alert(emailWith);

if(document.newaccount_form.emailDep.checked==true){
	document.newaccount_form.emailDep.value="Y"
}
else{
	document.newaccount_form.emailDep.value="N";	 
}
var emailDep = document.newaccount_form.emailDep.value;
//alert(emailDep);

if(document.newaccount_form.allEmail.checked==true){
	document.newaccount_form.allEmail.value="Y"
}
else{
	document.newaccount_form.allEmail.value="N";	 
}
var allEmail = document.newaccount_form.allEmail.value;
//alert(allEmail);
    
  if(accname==""){
  
  alert("Account Name Required!")
  document.newaccount_form.accname.focus();
  return false;
  }
  if(accname5!=""){
  //alert(accname5);	  
  alert("Account Name Already Exist!")
  document.newaccount_form.accname.focus();
  return false;
  }
   if(acctype2==""){
  alert("Account Type Required!")
  document.newaccount_form.acctype.focus();
  return false;
  }
   if(fname==""){
  alert("First Name Required!")
  document.newaccount_form.fname.focus();
  return false;
  }
  if(mname==""){
  alert("Middle Name Required!")
   document.newaccount_form.mname.focus();
  return false;
  }
   if(lname==""){
  alert("Last Name Required!")
   document.newaccount_form.lname.focus();
  return false;
  }
   if(gender2==""){
  alert("Please Select Gender!")
   document.newaccount_form.gender.focus();
  return false;
  }
  if(address==""){
  alert("Address is Required!")
   document.newaccount_form.address.focus();
  return false;
  }
   if(city==""){
  alert("City is Required!")
   document.newaccount_form.city.focus();
  return false;
  }
   if(state2==""){
  alert("Please select a State")
   document.newaccount_form.state.focus();
  return false;
  }
  if(country2==""){
  alert("Please Select a Country")
   document.newaccount_form.country.focus();
  return false;
  }
   if(mobtel==""){
  alert("Phone number is Required!")
   document.newaccount_form.mobtel.focus();
  return false;
  }
   if(isNaN(mobtel)){	
	alert("Please enter a valid phone number");
	document.newaccount_form.mobtel.focus();
	return false;
	}
  
  if(signatory==""){
  alert("Please Account sinatory is Required!")
  document.newaccount_form.signatory.focus();
  return false;
  }
  
  if(email==""){
  alert("E-mail Address is Required!")
  document.newaccount_form.email.focus();
  return false;
  }
  
  
  
  
  
  
  
 //Validate email
 with (email)
	 {
	  apos=email.indexOf("@");
	  dotpos=email.lastIndexOf(".");
	  if (apos<1||dotpos-apos<2){
		alert("Please enter a valid Email Address ");
		document.newaccount_form.email.focus();
		return false;
	 }
    }
  
  
  //emailcheck = validate_email(email);
  //if(emailcheck==false){
	// alert("E-mail Address is Invalid!")
 // document.newaccount_form.email.focus();
 //return false; 
  
 // }
  
   if(dob==""){
  alert("Date of Birth is Required")
   document.newaccount_form.dob.focus();
  return false;
  }
   if(occupation==""){
  alert("Occcupation is required")
   document.newaccount_form.occupation.focus();
  return false;
  }
  if(nok==""){
  alert("Next of Kin is Required")
   document.newaccount_form.nok.focus();
  return false;
  }
  
   if(nokaddr==""){
  alert("E-mail Address is Required!")
  document.newaccount_form.nokaddr.focus();
  return false;
  }
  
  if(nokcity==""){
  alert("E-mail Address is Required!")
  document.newaccount_form.nokcity.focus();
  return false;
  }
  
  
   if(nokstate2==""){
  alert("Please select a State")
   document.newaccount_form.nokstate.focus();
  return false;
  }
  if(nokcountry2==""){
  alert("Please Select a Country")
   document.newaccount_form.nokcountry.focus();
  return false;
  }
  
   if(noktel==""){
  alert("Phone number is Required!")
   document.newaccount_form.noktel.focus();
  return false;
  }
   if(isNaN(noktel)){	
	alert("Please enter a valid phone number");
	document.newaccount_form.noktel.focus();
	return false;
	}
  
   if(grouptype2==""){
  alert("Please select Account group type")
   document.newaccount_form.grouptype2.focus();
  return false;
  }
  
  
  if(comment==""){
  alert("Please put a comment in the comment box")
   document.newaccount_form.comment.focus();
  return false;
  }
  
  //alert("Wait... while your information is Processed")
  var joh = CallJS('Demo()');

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="auth.php?q="+str
var url="process.php"
url=url+"?accname="+accname+"&acctype="+acctype+"&fname="+fname+"&mname="+mname
+"&lname="+lname+"&gender="+gender+"&address="+address+"&city="+city+"&state="+state+"&country="+country
+"&mobtel="+mobtel+"&signatory="+signatory+"&homephone="+homephone+"&workphone="+workphone+"&fax="+fax+"&email="+email+"&dob="+dob+"&occupation="+occupation+"&employername="+employername+
"&employaddr="+employaddr+"&employcity="+employcity+"&employstate="+employstate+"&employcountry="+employcountry+"&nok="+nok+"&smsWith="+smsWith+"&smsDep="+smsDep+"&allSms="+allSms+"&emailWith="+emailWith+"&emailDep="+emailDep+"&allEmail="+allEmail+"&comment="+comment+"&cotRate="+cotRate+"&depRate="+depRate+"&intRate="+intRate+"&acrate="+acrate+"&nokaddr="+nokaddr+"&nokemail="+nokemail+"&noktel="+noktel+"&nokcity="+nokcity+"&nokstate="+nokstate+"&nokcountry="+nokcountry+"&grouptype="+grouptype;
//alert(url);
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged2 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged2() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("page").innerHTML=xmlHttp.responseText 
 } 
}



function edit_customer_form(str3)
{
//var branch2 = document.newaccount_form.branch.selectedIndex;	
//var branch = document.newaccount_form.branch[document.newaccount_form.branch.selectedIndex].value;	
var fname = document.edit_form.fname.value;
var mname = document.edit_form.mname.value;
var lname = document.edit_form.lname.value;
var address = document.edit_form.address.value;
var city = document.edit_form.city.value;
var state2 = document.edit_form.state.selectedIndex;
var state = document.edit_form.state[document.edit_form.state.selectedIndex].value;
var country2 = document.edit_form.country.selectedIndex;
var country = document.edit_form.country[document.edit_form.country.selectedIndex].value;
var mobtel = document.edit_form.mobtel.value;
var homephone = document.edit_form.homephone.value;
var workphone = document.edit_form.workphone.value;
var fax = document.edit_form.fax.value;
var email = document.edit_form.email.value;
var dob = document.edit_form.dob.value;
var occupation = document.edit_form.occupation.value;
var employername = document.edit_form.employername.value;
var employaddr = document.edit_form.employaddr.value;
var employcity = document.edit_form.employcity.value;
//var employstate = document.edit_form.employstate.value;
var employstate = document.edit_form.employstate[document.edit_form.employstate.selectedIndex].value;
//var employcountry = document.edit_form.employcountry.value;
var employcountry = document.edit_form.employcountry[document.edit_form.employcountry.selectedIndex].value;
var nok = document.edit_form.nok.value;

var nokaddr = document.edit_form.nokaddr.value;
var nokemail = document.edit_form.nokemail.value;
var noktel = document.edit_form.noktel.value;
var nokcity = document.edit_form.nokcity.value;
var nokstate2 = document.edit_form.nokstate.selectedIndex;
var nokstate = document.edit_form.nokstate[document.edit_form.nokstate.selectedIndex].value;
var nokcountry2 = document.edit_form.nokcountry.selectedIndex;
var nokcountry = document.edit_form.nokcountry[document.edit_form.nokcountry.selectedIndex].value;
var mcomment = document.edit_form.mcomment.value;



var signatory = document.edit_form.signatory.value;

if(document.edit_form.smsWith.checked==true){
	document.edit_form.smsWith.value="Y";	
}
else{
	document.edit_form.smsWith.value="N";
}
var smsWith = document.edit_form.smsWith.value;

if(document.edit_form.smsDep.checked==true){
	document.edit_form.smsDep.value="Y";	
}
else{
	document.edit_form.smsDep.value="N";	
}
var smsDep = document.edit_form.smsDep.value;

if(document.edit_form.allSms.checked==true){
	document.edit_form.allSms.value="Y";
}
else{
	document.edit_form.allSms.value="N";	
}
var allSms = document.edit_form.allSms.value

if(document.edit_form.emailWith.checked==true){
	document.edit_form.emailWith.value="Y"
}
else{
	document.edit_form.emailWith.value="N";	 
}
var emailWith = document.edit_form.emailWith.value

if(document.edit_form.emailDep.checked==true){
	document.edit_form.emailDep.value="Y"
}
else{
	document.edit_form.emailDep.value="N";	 
}
var emailDep = document.edit_form.emailDep.value

if(document.edit_form.allEmail.checked==true){
	document.edit_form.allEmail.value="Y"
}
else{
	document.edit_form.allEmail.value="N";	 
}
var allEmail = document.edit_form.allEmail.value


    
   if(fname==""){
  alert("First Name Required!")
  document.edit_form.fname.focus();
  return false;
  }
  if(mname==""){
  alert("Middle Name Required!")
   document.edit_form.mname.focus();
  return false;
  }
   if(lname==""){
  alert("Last Name Required!")
   document.edit_form.lname.focus();
  return false;
  }
  if(address==""){
  alert("Address is Required!")
   document.edit_form.address.focus();
  return false;
  }
   if(city==""){
  alert("City is Required!")
   document.edit_form.city.focus();
  return false;
  }
   if(state2==""){
  alert("Please select a State")
   document.edit_form.state.focus();
  return false;
  }
  if(country2==""){
  alert("Please Select a Country")
   document.edit_form.country.focus();
  return false;
  }
   if(mobtel==""){
  alert("Phone number is Required!")
   document.edit_form.mobtel.focus();
  return false;
  }
   if(isNaN(mobtel)){	
	alert("Please enter a valid phone number");
	document.edit_form.mobtel.focus();
	return false;
	}
  
  if(signatory==""){
  alert("Please Account sinatory is Required!")
  document.edit_form.signatory.focus();
  return false;
  }
  
  if(email==""){
  alert("E-mail Address is Required!")
  document.edit_form.email.focus();
  return false;
  }
   if(dob==""){
  alert("Date of Birth is Required")
   document.edit_form.dob.focus();
  return false;
  }
   if(occupation==""){
  alert("You enetered an empty value")
   document.edit_form.occupation.focus();
  return false;
  }
  if(nok==""){
  alert("Next of Kin is Required")
   document.edit_form.nok.focus();
  return false;
  }
  
  
   if(nokaddr==""){
  alert("E-mail Address is Required!")
  document.edit_form.nokaddr.focus();
  return false;
  }
  
  if(nokcity==""){
  alert("E-mail Address is Required!")
  document.edit_form.nokcity.focus();
  return false;
  }
  
  
   if(nokstate2==""){
  alert("Please select a State")
   document.edit_form.nokstate.focus();
  return false;
  }
  if(nokcountry2==""){
  alert("Please Select a Country")
   document.edit_form.nokcountry.focus();
  return false;
  }
  
   if(noktel==""){
  alert("Phone number is Required!")
   document.edit_form.noktel.focus();
  return false;
  }
   if(isNaN(noktel)){	
	alert("Please enter a valid phone number");
	document.edit_form.noktel.focus();
	return false;
	}
  
  if(mcomment==""){
  alert("Comment is Required!")
   document.edit_form.mcomment.focus();
  return false;
  }
  
  
  //alert("Wait... while your information is Processed")
  var joh = CallJS('Demo()');

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var tokenedit = 'edit' 
//var url="auth.php?q="+str
var url="cuspersonalinfo.php"
url=url+"?fname="+fname+"&mname="+mname
+"&lname="+lname+"&address="+address+"&city="+city+"&state="+state+"&country="+country
+"&mobtel="+mobtel+"&signatory="+signatory+"&homephone="+homephone+"&workphone="+workphone+"&fax="+fax+"&email="+email+"&dob="+dob+"&occupation="+occupation+"&employername="+employername+
"&employaddr="+employaddr+"&employcity="+employcity+"&employstate="+employstate+"&employcountry="+employcountry+"&nok="+nok+"&smsWith="+smsWith+"&smsDep="+smsDep+"&allSms="+allSms+"&emailWith="+emailWith+"&emailDep="+emailDep+"&allEmail="+allEmail+"&acccname="+str3+"&tokenedit="+tokenedit+"&nokaddr="+nokaddr+"&nokemail="+nokemail+"&noktel="+noktel+"&nokcity="+nokcity+"&nokstate="+nokstate+"&nokcountry="+nokcountry+"&mcomment="+mcomment;
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged6
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged6() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("page").innerHTML=xmlHttp.responseText 
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


function validate_email(alerttxt)
{
var field = alerttxt;	
with (field)
  {
  apos=value.indexOf("@");
  dotpos=value.lastIndexOf(".");
  if (apos<1||dotpos-apos<2)
    {alert(alerttxt);return false;}
  else {return true;}
  }
}












//JavaScript Documentvar xmlHttp
function validate_login_form()
 
{ 
var user = document.login.username.value;
var pwd = document.login.password.value;
if(user==""){
	alert("You enetered an empty value")
	return false;
}

if(pwd==""){
	alert("You enetered an empty value")
	return false;
}

alert("Wait... while your information is Processed")
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="auth.php?q="+str
var url="auth.php"
url=url+"?user="+user+"&pwd="+pwd
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged2 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged2() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("page").innerHTML=xmlHttp.responseText 
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




function validate_picture()
 
{ 
var pic = document.iform.image.value;
if(pic==""){
	alert("Pls Load a Picture")
	return false;
}

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
//var url="auth.php?q="+str
var url="cuspersonalinfo.php"
url=url
//url=url+"&r="+document.getElementById('v_type').value;
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged3
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}
////////////////////////////////
function stateChanged3() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("page").innerHTML=xmlHttp.responseText 
 } 
}
