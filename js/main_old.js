$(function() {
	$('h4.alert').hide().fadeIn(700);
	$('<span class="exit">X</span>').appendTo('h4.alert');
	
	$('span.exit').click(function() {
		$(this).parent('h4.alert').fadeOut('slow');						   
	});
});


function gettellername(){
//alert(data);
var tellername = $("#till_account :selected").text();
//alert(tellername);
$.ajax({ 
   type: "POST", 
   url: "utilities.php", 
   data: "op=tellerusername&tellername="+tellername, 
   success: function(msg){ 
     //alert( "Data Saved: " + msg ); 
	 //alert(data);
	 //$("#tr_payoption").append(msg);
	 $("#tellerfullname").html(msg);
	 $("#accname").val(tellername);
	 $("#tellertill").html($("#till_account :selected").val());
	 //alert( $("#accname").val());
   } 
 });

}

function checklogin(formurl){
	
		$('#error_label_login').ajaxStart(function(){
		//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
		$('#error_label_login').html('<img src="images/loading.gif" alt="" />loading please wait . . .');
		});
	
		var data = $("#username").val();
		var data2 = $("#password").val();
		//alert(data+":"+data2);
		//error_label_login
		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op=checklogin&username="+data+"&password="+data2, 
		   success: function(msg){  
			msg =  jQuery.trim(msg); 
			 $("#error_label_login").html('logging you in ...').show();
				if(msg==''){
					$("#error_label_login").html('Please enter a valid Username and Password').show();
				}
				else if(msg=='0'){
					$("#error_label_login").html('Invalid username or password').show();
				}
				else if(msg=='1'){	
					$("#member_data").val(msg);
					//alert($("#member_data").val());
				 $("#form1").attr("action",formurl);
				 $("#form1").submit();
				}
				else if(msg=='2'){
					$("#error_label_login").html('Your user profile has been disabled').show();
				}
				else if(msg=='3'){
					$("#error_label_login").html('Your user profile has been locked').show();
				}
				else if(msg=='4'){
					$("#error_label_login").html('You are not allowed to login on Sunday').show();
				}
				else if(msg=='5'){
					$("#error_label_login").html('You are not allowed to login on Monday').show();
				}
				else if(msg=='6'){
					$("#error_label_login").html('You are not allowed to login on Tuesday').show();
				}
				else if(msg=='7'){
					$("#error_label_login").html('You are not allowed to login on Wednesday').show();
				}
				else if(msg=='8'){
					$("#error_label_login").html('You are not allowed to login on Thursday').show();
				}
				else if(msg=='9'){
					$("#error_label_login").html('You are not allowed to login on Friday').show();
				}
				else if(msg=='10'){
					$("#error_label_login").html('You are not allowed to login on Saturday').show();
				}
				else if(msg=='11'){
					$("#error_label_login").html('You are not allowed to login at this time <br> The time is not within the working hours').show();
				}
				else if(msg=='12'){
					$("#error_label_login").html('Your profile has been Locked, please contact Administrator').show();
				}
				else if(msg=='13'){
					$("#error_label_login").html('Your password has expired, <br><a href=\'change_password_exp.php?id='+data+'\'> click here to change password </a>').show();
				}
				else if(msg=='14'){
					$("#error_label_login").html('You are required to change your password, <br><a href=\'change_password_logon.php?id='+data+'\'> click here to change password </a>').show();
				}
				else if(msg=='15'){
					$("#error_label_login").html('Server Operations is currently running. Pls wait for a few minutes.. ').show();
				}
				else{
					alert("Yes");
					$("#error_label_login").html('Invalid username or password').show();
				}
		   } 
		 });
		//alert(data);
		return false;
}

function doSearch(url){
	 $.blockUI({ message: "<img src='images/ajax-loader.gif' /> " }); 
	
	//calldialogBlock(loadingScreen);
	//$.loading({onAjax:true,mask:true});

	//waitingDialog({title: "Hi", message: "I'm loading..."});
	//$("#loadingScreen").block();
	//waitingDialog({title: "Please wait", message: "I'm loading..."});
	//closeWaitingDialog();
	//alert('Got here');
	//$("#form1").submit();
	//if($("#keyword").val()!=""){$("#pageNo").get(0).value = 1;}
	var data = getdata();
	//alert("@ Search : "+data);
	//loadpage('branch_list.php',data,'page');
	//$("#loadingScreen").unblock();
	 
	getpage(url+'?'+data,'page');
	//$.unblockUI();
	
	//calldialogUnblock(loadingScreen);
	
}


function doSearchsp(url){
	 $.blockUI({ message: "<img src='images/ajax-loader.gif' /> " }); 
	var data = getdata2();
	//alert(data);
	getpage(url+'?'+data,'page');
	$.unblockUI();
	
	//calldialogUnblock(loadingScreen);
	
}

function loadpage(url,data,divname){
	$(divname).ajaxStart(function(){
		//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
		$(divname).html('<img src="images/loading.gif" alt="" />loading please wait . . .');
	});
	
	$.ajax({ 
		   type: "POST", 
		   url: url, 
		   data: data, 
		   success: function(msg){  
			 //alert(msg);
			 //$("#form1").submit();
			 $(divname).html(msg);
		   } 
		 });
	//$(divname).html(url);
}

function getdata(){
	var data = "";
	$("#form1").serialize();
	$.each($("input, select, textarea"), function(i,v) {
    var theTag = v.tagName;
    var theElement = $(v);
	var theName = theElement.attr('name');
    var theValue = escape(theElement.val());
	var classname = theElement.attr('class');
	//alert('name : '+theName+"   value :"+theValue+"  class :"+classname);
	if(classname=='required-text'){
		if(!check_textvalues(theElement)) data = "error";
	}
	if(classname=='required-number'){
		if(!check_numbers(theElement)) data = "error";
	}
	if(classname=='currency'){
		theValue = removecomma(theElement.val());
		if(theValue=="" || theValue==0) { data = "error";
		$("#display_message").html('please enter number for '+theElement.attr('title'));
			$("#display_message").show('fast');
			theElement.focus();
			$("#display_message").click();
			return false;
		}
		else
		if(isNaN(theValue)) { data = "error";
		$("#display_message").html('please enter number for '+theElement.attr('title'));
			$("#display_message").show('fast');
			theElement.focus();
			$("#display_message").click();
			return false;
		}
	}
	if(classname=='required-email'){
		if(!check_email(theElement)) data = "error";
		
	}
	if(classname=='required-alphanumeric'){
		if(!check_password_aplhanumeric(theElement)) data = "error";
	}
	if(data!='error'){
		data = data+theName+"="+theValue+"&";
	}
	});
	//alert(data);
	return data;
}

function check_textvalues(formElement){
	if(triminput(formElement.val())==''){
		$("#display_message").html('please enter value for '+formElement.attr('title'));
		$("#display_message").show('fast');
		formElement.focus();
		$("#display_message").click();
		return false;
	}else return true;
}

function check_numbers(formElement) {
		if(triminput(formElement.val())==''){
			$("#display_message").html('please enter number for '+formElement.attr('title'));
			$("#display_message").show('fast');
			formElement.focus();
			$("#display_message").click();
			return false;
		}
		if(isNaN(formElement.val())){
			$("#display_message").html('please enter number for '+formElement.attr('title'));
			$("#display_message").show('fast');
			formElement.focus();
			$("#display_message").click();
			return false;
		}else return true;	
}

function check_numbers_currency(formElement) {
		if(removecomma(formElement.val())==''){
			$("#display_message").html('please enter number for '+formElement.attr('title'));
			$("#display_message").show('fast');
			formElement.focus();
			$("#display_message").click();
			return false;
		}
		if(removecomma(isNaN(formElement.val()))){
			$("#display_message").html('please enter number for '+formElement.attr('title'));
			$("#display_message").show('fast');
			formElement.focus();
			$("#display_message").click();
			return false;
		}else return true;	
}


function check_email(formElement){
	emailRegEx = /^[^@]+@[^@]+.[a-z]{2,}$/i;
	if((formElement.val()).search(emailRegEx) == -1){
		$("#display_message").html('please enter valid email for '+formElement.attr('title'));
		$("#display_message").show('fast');
		formElement.focus();
		$("#display_message").click();
		return false;
	}else return true;
}

function check_password_aplhanumeric(formElement){
		var f1 = /[A-Z]/
		var f2 = /[a-z]/
		var f3 = /[0-9]/
		
		if((f1.test(formElement.val()) || f2.test(formElement.val())) && f3.test(formElement.val())){
		//alert('passed');
        return true;
		}else {
		$("#display_message").html('please enter alphanumeric as password');
		$("#display_message").show('fast');
		//alert('failed');
		formElement.focus();
		$("#display_message").click();
		return false;
		}
		
}

function triminput(inputString) 
{
	
	var removeChar = ' ';
	var returnString = inputString;

	if (removeChar.length)

	{

	  while(''+returnString.charAt(0)==removeChar)

		{

		  returnString=returnString.substring(1,returnString.length);

		}

		while(''+returnString.charAt(returnString.length-1)==removeChar)

	  {

	    returnString=returnString.substring(0,returnString.length-1);

	  }

	}

	return returnString;
}

function toggleOption(){
	$("input[type=checkbox][checked]").each(
		  function() {
		   $(this).val('1');
		   //alert($(this).val());
		  }
	);
	
}

function toggleOption2(){
	$("input[type=checkbox][checked]").each(
		  function() {
		   $(this).val('1');
		   //alert($(this).val());
		  }
	);
	
}

function disable_id(){
	$("input[type=button]").each(
		  function() {
		   var idname = $(this).attr('id');
                   $("#"+idname).attr('disabled',true);   		  
		 }
	);
	
}


function enable_id(){
	//alert("Yes");
	$("input[type=button]").each(
		  function() {
		   var idname = $(this).attr('id');
		  // alert(idname);
                   $("#"+idname).attr('disabled',false);   		  
		 }
	);
	
}


function checkOption(obj){
	if(obj.checked){
		obj.value='1';
		//alert(obj.value)
	}else{
		obj.value='0';
		obj.checked=false;
		//alert(obj.value);
	}
	
}

function checkoptiondiv(obj,divname){
	if(obj.checked){
		//obj.value='1';
		$('#'+divname).show('slow');
	}else{
		//obj.value='0';
		$('#'+divname).hide();
	}
	
}

function loadroles(){
	var data = escape($('#menu_id').val());
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getnonexistrole&menu_id="+data, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#non_exist_role").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
   // for existing roles
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getexistrole&menu_id="+data, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#exist_role").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });  
}

function goFirst(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(fpage!=1){
		$("#fpage").get(0).value = '1';
		$("#pageNo").get(0).value = 1;
		doSearch(dpage);
	}else{
		return false;
	}

}

function goLast(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(lpage!=fpage){
		$("#fpage").get(0).value = lpage;
		$("#pageNo").get(0).value = lpage;
		doSearch(dpage);
	}else{
		return false;
	}

}
function goPrevious(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(fpage !=1){
		$("#fpage").get(0).value = fpage-1;
		$("#pageNo").get(0).value = fpage-1;
		doSearch(dpage);
	}else{
		return false;
	}

}

function goNext(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if((lpage > fpage)){
		$("#fpage").get(0).value = fpage+1;
		$("#pageNo").get(0).value = fpage+1;
		doSearch(dpage);
	}else{
		return false;
	}

}

function callpage(page){
var data = getdata();
//alert(data);
	if(data!='error') {
		$("#display_message").ajaxStart(function(){
			//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
			$("#display_message").html('<img src="images/loading.gif" alt="" />loading please wait . . .');
		});

		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op="+page+"&"+data, 
		   success: function(msg){ 
			 //alert( "Data Saved: " + msg ); 
			 //alert(msg);
			 $("#display_message").html(msg);
			 $("#display_message").show("fast");
					 $("#display_message").click();	
			if(page=="close_account"){
				 $("#subbtn").attr('disabled','disabled');
			}
		   } 
		 });
	}
}

function callpage_saveloan(page){
 //disable_id();	
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });	
var data = getdata();
//alert(data);
	if(data!='error') {
		$("#display_message").ajaxStart(function(){
			//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
			$("#display_message").html('<img src="images/loading.gif" alt="" />loading please wait . . .');
		});

		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op="+page+"&"+data, 
		   success: function(msg){ 
			 //alert( "Data Saved: " + msg ); 
			 //alert(msg);
			 $("#display_message").html(msg);
			 $("#display_message").show("fast");
			$("#display_message").click();	
			
		   } 
		 });
		
	}
	$.unblockUI();
	enable_id();
}


function callpagepost(page,opt,returnpage,divid){
	 //disable_id();
	$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Processing ...</b></font>" });
var data = getdata();
$.unblockUI();
var poststatus = false;
//alert($("#require_auth").val());
		if(data!='error') {
		$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Processing ...</b></font>" });
		
		if(opt=='continue' && $("#require_auth").val()=='1'){
			var ans = confirm(" This transaction requires authorization \n Do you want to continue ?");
			if(ans==true){
				poststatus = true;
			}else{
				poststatus = false;
			}
		}
		else if(opt=='continue_act2act' && $("#require_auth").val()=='1'){
			var ans = confirm("This transfer requires authorization \n Do you want to continue ?");
			if(ans==true){
				poststatus = true;
			}else{
				poststatus = false;
			}
		}
		else if(opt=='continue_act2imp' && $("#require_auth").val()=='0'){
				poststatus = true;	
		}
		else if(opt=='continue' && $("#require_auth").val()=='2'){
			var ans = confirm("This transaction will not mature until the cheque is cleared \n Do you want to continue ?");
			if(ans==true){
				poststatus = true;
			}else{
				poststatus = false;
			}
		}
		else if(opt=='continue' && $("#require_auth").val()=='0'){
			poststatus = true;
		}
		if(opt=='cancel'){
			var ans = confirm("are you sure you want to cancel this transaction . . .");
			if(ans==true){
				poststatus = true;
			}else{
				poststatus = false;
			}
		}
		$.unblockUI();
		if(poststatus==true){
			$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Processing ...</b></font>" });
		$.ajax({ 
			   
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op="+page+"&"+data, 
		   success: function(msg){ 
			//alert( "Data Saved: " + msg ); 
			//alert(msg);
			 //$("#display_message").html(msg);
			 //$("#display_message").show("fast");
			  //enable_id();
			 $("#responsedata").get(0).value = msg;
			 //alert(msg);
			 
			 pageloader(returnpage,divid);
			 $.unblockUI();
			
		   } 
		 });
		} // end poststatus
		
	}
	//enable_id();
	
	
	
}

function getpage(str,divid) 
{ 
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
//alert(str);
//alert(str);
	//var data = getdata();
	//alert(data);
			/*
			
			$(divid).ajaxStart(function(){
			$(divid).html('');
			$(divid).html('<img src="images/loading.gif" alt="" />loading please wait . . .');
			});
			*/	if(str!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str, 
			   data: '', 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				// alert(msg);
				 $('#'+divid).html(msg);
				 //$("#display_message").fadeIn("slow");
				 $.unblockUI();
			   } 
			 });
			
			}// end if
			//$.unblockUI();
}

function pageloader(str,divid) 
{ 
    $.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
	var data = getdata();
	//alert(data);
	$.unblockUI();
	if(str=='bulk_payment_verify.php'){
		var amount = parseFloat($('#amount').val());
		var balance = parseFloat($('#from_balance').val());
		var bal_limit = parseFloat($('#from_balance_limit').val());
			//alert(amount+'  '+balance+'  '+bal_limit);
		if(amount > (balance-bal_limit)){
			$("#display_message").html("please ensure total amount is not greater than <br> account balance less balance limit");
			$("#display_message").show("slow");
			data = 'error';
		}
	}
	
	//alert(data);
	if(data!='error') {
		$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });

	$.ajax({ 
	   type: "POST", 
	   url: str, 
	   data: data, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 $('#'+divid).html(msg);
		 //$("#display_message").fadeIn("slow");
		 
          $.unblockUI();
	   } 
	 });
	}
}

function addrole(){
	return !$('#non_exist_role option:selected').remove().appendTo('#exist_role'); 
}

function removerole(){
	return !$('#exist_role option:selected').remove().appendTo('#non_exist_role');
}

function selectalldata(){
	$("#exist_role *").attr("selected","selected");
}

function selectalllist(list){
	$("#"+list+" *").attr("selected","selected");
}

function showHide(currdiv){
	if($('#override_wh').attr('checked')){
		$('#extend_div').show('slow');
	}
	else {
		$('#extend_div').hide('slow');
	}
}

function moveUpList(listField) {
   if ( listField.length == -1) {  // If the list is empty
      alert("There are no values which can be moved!");
   } else {
      var selected = listField.selectedIndex;
      if (selected == -1) {
         alert("You must select an entry to be moved!");
      } else {  // Something is selected 
         if ( listField.length == 0 ) {  // If there's only one in the list
            alert("There is only one entry!\nThe one entry will remain in place.");
         } else {  // There's more than one in the list, rearrange the list order
            if ( selected == 0 ) {
               alert("The first entry in the list cannot be moved up.");
            } else {
               // Get the text/value of the one directly above the hightlighted entry as
               // well as the highlighted entry; then flip them
               var moveText1 = listField[selected-1].text;
               var moveText2 = listField[selected].text;
               var moveValue1 = listField[selected-1].value;
               var moveValue2 = listField[selected].value;
               listField[selected].text = moveText1;
               listField[selected].value = moveValue1;
               listField[selected-1].text = moveText2;
               listField[selected-1].value = moveValue2;
               listField.selectedIndex = selected-1; // Select the one that was selected before
            }  // Ends the check for selecting one which can be moved
         }  // Ends the check for there only being one in the list to begin with
      }  // Ends the check for there being something selected
   }  // Ends the check for there being none in the list
   return false;
}

function moveDownList(listField) {
   if ( listField.length == -1) {  // If the list is empty
      alert("There are no values which can be moved!");
   } else {
      var selected = listField.selectedIndex;
      if (selected == -1) {
         alert("You must select an entry to be moved!");
      } else {  // Something is selected 
         if ( listField.length == 0 ) {  // If there's only one in the list
            alert("There is only one entry!\nThe one entry will remain in place.");
         } else {  // There's more than one in the list, rearrange the list order
            if ( selected == listField.length-1 ) {
               alert("The last entry in the list cannot be moved down.");
            } else {
               // Get the text/value of the one directly below the hightlighted entry as
               // well as the highlighted entry; then flip them
               var moveText1 = listField[selected+1].text;
               var moveText2 = listField[selected].text;
               var moveValue1 = listField[selected+1].value;
               var moveValue2 = listField[selected].value;
               listField[selected].text = moveText1;
               listField[selected].value = moveValue1;
               listField[selected+1].text = moveText2;
               listField[selected+1].value = moveValue2;
               listField.selectedIndex = selected+1; // Select the one that was selected before
            }  // Ends the check for selecting one which can be moved
         }  // Ends the check for there only being one in the list to begin with
      }  // Ends the check for there being something selected
   }  // Ends the check for there being none in the list
   return false;
}

function getstyle(){
	var ele = $('#heading_text').css("background-color");
	//alert(color);
}

function checktranstype(){
	var balance_limit = parseFloat($('#balance_limit').val());
	var cot_limit = parseFloat($('#cot_rate').val());
	var avail_bal = parseFloat($('#avil_bal').val());
	var cust_balance = parseFloat($('#cust_balance').val());
	var ov_type = $('#ov_type').val();
	
	//alert(ov_type);
	var amount = parseFloat($('#amount').val());
	var totlimit = ((cot_limit*amount)+balance_limit);
	//alert($('#cashtype').val());
	//alert(cust_balance-amount);
	if($('#cashtype').val()=='WRW' && (balance_limit > (cust_balance-amount)) && ov_type=='0'){
		//$('#postbtn').attr("disabled","disabled");
		$("#display_message").html('Customer account has reached the Balance Limit');
		$("#display_message").show();
		//$("#display_message").dialog();
		return false;
	}
	else if($('#cashtype').val()=='WRW' && (totlimit > cust_balance) && ov_type=='0'){
		//$('#postbtn').attr("disabled","disabled");
		$("#display_message").html('Customer account has reached the Balance Limit for COT Charges');
		$("#display_message").show();
		//$("#display_message").dialog();
		return false;
	}
	else if($('#cashtype').val()=='WRW' && (avail_bal < amount) && ov_type=='1'){
		//$('#postbtn').attr("disabled","disabled");
		$("#display_message").html('Customer account has reached the Overdraft Limit');
		$("#display_message").show();
		//$("#display_message").dialog();
		return false;
	}
	else{
		$('#postbtn').attr("disabled","");
		//$("#display_message").html('Customer account is OK');
		//$("#display_message").dialog();
		pageloader('cusDeposit_verify.php','showsearch');
	}
}

function loadfilter(){
	var data = escape($('#act_tra').val());
	var data2 = escape($('#actype').val());
	var data3 = escape($('#all').val());
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getnonexfilter&tran_id="+data+"&filter="+data2+"&check="+data3, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#exist_acct").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
   // for existing roles 
}

function loadfilter2(){
	var data = escape($('#act_tra').val());
	var data2 = escape($('#actype').val());
	var data3 = escape($('#all').val());
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getnonexfilter2&tran_id="+data+"&filter="+data2+"&check="+data3, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#exist_acct").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
   // for existing roles 
}


function loadfilter3(){
	var data = escape($('#act_tra').val());
	var data2 = escape($('#actype').val());
	var data3 = escape($('#all').val());
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getnonexfilter3&tran_id="+data+"&filter="+data2+"&check="+data3, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#exist_acct").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
   // for existing roles 
}


function displaytransfer(value){
	var data = escape($('#exist_acct').val());
   $.ajax({ 
	   type: "POST", 
	   url: "viewtransfer.php", 
	   data: "op=transfer&viewtransfer="+data+"&transfer_id="+value,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#"+value+"").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
   // for existing roles 
}

function getaccountdata() {
	var data = $('#fixed_acctno').val();
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=accountdata&acct_no="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 if(msg=='1'){
			 
			 alert("Sorry the account is already on schedule..");
		 }
		 else if(msg==''){
		 $("#acct_no").get(0).value = '';
		 $("#acct_name").get(0).value = '';
		  $("#principal").get(0).value = '';
		 $("#span_acct_no").html('');
		 $("#span_acct_no").html('');
		 $("#span_acct_name").html('');
		 }else{
		 var arr_data = msg.split("/");
		 $("#acct_no").get(0).value = arr_data[0];
		 $("#acct_name").get(0).value = arr_data[1];
		 $("#gl_code").get(0).value = arr_data[3];
		  $("#principal").get(0).value = arr_data[4];
		 $("#span_acct_no").html(arr_data[0]);
		 $("#span_acct_name").html(arr_data[1]);
		 	//getfixeddepositfee_acct(arr_data[3]);
		 }
		 //$("#display_message").show("fast");
	   } 
  });
}

function getfixeddepositfee_acct(glcode) {
	var data = glcode;
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=fixeddepositdata&gl_code="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 if(msg==''){
		 $("#interest_payable_acct_no").get(0).value = '';
		 $("#span_fixed_dep_int_acctno").html('');
		 }else{
		 var arr_data = msg.split("/");
		 $("#interest_payable_acct_no").get(0).value = arr_data[0];
		 $("#span_fixed_dep_int_acctno").html(arr_data[0]);
		 }
		 //$("#display_message").show("fast");
	   } 
  });
}
	function closepage(divid){
		$('#'+divid).html('');
	}





//Close Account
function closeacctinfo(){
	var data = $('#acno').val();
	var data2 = $('#acno2').val();
	var check = $('#checkbox').val();
	//alert(data);
	//alert(data2);
	//alert(check);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getcloseacctinfo&acno="+data+"&acno2="+data2+"&check="+check,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		if(msg!=""){
		var splitval = msg.split('_');
		          $("#acno3").html(splitval[0]);
		          $("#acname").html(splitval[1]);
                  $("#acofficer").html(splitval[2]);
		          $("#addr").html(splitval[3]);
                  $("#city").html(splitval[4]);
		          $("#state").html(splitval[5]);
                  $("#country").html(splitval[6]);
		          $("#tel").html(splitval[7]);
                  $("#createdDate").html(splitval[8]);
		          $("#acccno").get(0).value=splitval[0];
				  $("#acccname").get(0).value=splitval[1];
				  $("#actype").html(splitval[9]);
				   $("#accid").get(0).value=splitval[10];
				   $("#bal").html(splitval[11]);
				    $("#gltype").get(0).value=splitval[12];
					//$("#gltypes").html(splitval[22]);
					//alert(splitval[21]);
				   if(splitval[12]<=0){
					    //$("#subbtn").attr('disabled','disabled');
				   }
				   else{
					    //$("#subbtn").attr('disabled',false);
				   }  
		}
		else{
			
			   $("#acno3").html("");
		          $("#acname").html("");
                  $("#acofficer").html("");
		          $("#fname").html("");
                  $("#mname").html("");
		          $("#lname").html("");
                  $("#gender").html("");
		          $("#addr").html("");
                  $("#city").html("");
		          $("#state").html("");
                  $("#country").html("");
		          $("#tel").html("");
                  $("#email").html("");
		          $("#ocp").html("");
                  $("#createdDate").html("");
		          $("#dob").html("");
		          $("#acccno").get(0).value="";
				  $("#acccname").get(0).value="";
				  $("#img1").attr('src','');
				  $("#img2").attr('src','');
				  $("#actype").html("");
		          $("#acofficer").html("");
			
		}
		  
		  
		  
		  
		 //$("#display_message").show("fast");
	   } 
  });
}

function getallval()
{
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getallvalues", 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#acno2").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
}

//Update account officer
function getUpdateVal()
{
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getUpdateVal", 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#acno2").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
}

function getCloseVal()
{
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCloseValues", 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#acno2").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
}



function removeval()
{
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=removevalues", 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#acno2").html(msg);
		 $("#acname").get(0).value="";
	   } 
  });
}





function getaccount(){
	var data = $('#acno').val();
	var data2 = $('#acno2').val();
	var check = $('#checkbox').val();
	//alert(data);
	//alert(data2);
	//alert(check);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getaccount&acno="+data+"&acno2="+data2+"&check="+check,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split(',');
		 $("#acname").get(0).value = splitval[0];
		  $("#acofficer").get(0).value = splitval[1];
		 //$("#display_message").show("fast");
	   } 
  });
}

function chkpassword(opt){
	if($("#userpassword").val()!= $("#confirm_userpassword").val()){
		$("#display_message").html('Passwords do not match');
		//$('#postbtn').attr("disabled","disabled");
	}else{
		callpage(opt);
	}
}

function calldialogBlock(divid){
$('#'+divid).dialog();
$.blockUI({ message: $('#'+divid) });
//setTimeout($.unblockUI, 3000);
}

function calldialogUnblock(divid){
$('#'+divid).dialog();
//$.blockUI({ message: $('#'+divid) });
$.unblockUI({ message: $('#'+divid) });
}

function calldialog(divid){
$('#'+divid).dialog({
			bgiframe: true,
			modal: true,
			buttons: {
				Ok: function() {
					$(this).dialog('destroy');
				}
			}
		});
}

function calcValuedate(){
	var data = $('#operation_date').val();
	var data2 = $('#instrument_type').val();
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=value_date&operation_date="+data+"&instrument_type="+data2,
	   success: function(msg){ 
		//alert(msg);
		 $("#value_date").get(0).value = msg;
	   } 
  });
}

function calcValuedate2(){
	var data = $('#opdate').val();
	var data2 = $('#instrument_type').val();
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=value_date2&operation_date="+data+"&instrument_type="+data2,
	   success: function(msg){ 
		//alert(msg);
		 $("#value_date").get(0).value = msg;
	   } 
  });
}

function loadbeneficiaries(){
	var data = $('#no_of_beneficiaries').val();
   	var ben_len = parseInt(data);
   if(parseInt(data) > 0){
   		var i = 0
   		var add_data = "";
		for(i=0; i< ben_len; ++i){
add_data += "<tr><td  nowrap>Account No:<input name='ben_account[]' type='text' class='required-number' id='ben_account' title='account no'></td>  <td width='2'>&nbsp;</td><td nowrap>Amount : <input name='ben_amount[]' type='text' class='required-number' id='ben_amount' size='18' title='amount'></td><td width='11' nowrap>&nbsp;</td></tr>";
		}
		$('#beneficiary_div').html(add_data);
   }
}

function loadbeneficiariesadd(){
	var add_ben = $('#add_ben').val();
   	var add_amount = $('#add_amount').val();
	var  getben = getBeneficiary(add_ben,add_amount);
/*var add_data = "<tr><td  nowrap>Account No:<input name='ben_account[]' type='text' class='required-number' id='ben_account' title='account no' value='"+getben+"'></td>  <td width='2'>&nbsp;</td><td nowrap>Amount : <input name='ben_amount[]' type='text' class='required-number' id='ben_amount' size='18' title='amount' value='"+add_amount+"'></td><td width='11' nowrap>&nbsp;</td></tr>";
		$('#beneficiary_div').append(add_data);
		 $('#add_ben').get(0).value="";
   	     $('#add_amount').get(0).value="";*/
   }


function getBeneficiary(add_ben,add_amount){
	var total = parseFloat($('#total').val());  
	var add_m = parseFloat($('#add_amount').val());
	var add_m2 = $('#add_ben').val();
	if((isNaN(add_m))||(add_m<=0)||(add_m2=="")) { 
	   alert("Please enter the beneficiary account no and amount ");
	}
	else {
	//alert(total);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getBeneficiary&acno="+add_ben,
	   success: function(msg){ 
	    //alert(msg);
	   var sp = msg.split('/');
		var add_data = "<tr id='"+sp[0]+"'><td  nowrap>Account No:<input name='ben_account[]' type='text' class='required-number' id='ben_account' title='account no' value='"+sp[0]+"'></td>  <td width='2'>&nbsp;</td><td nowrap>Amount : <input name='ben_amount[]' type='text' class='required-number' id='ben_amount' size='18' title='amount' value='"+add_amount+"'></td><td width='11' nowrap><input type='button' value='Remove' onclick=removetable('"+sp[0]+"','"+add_amount+"')></td></tr><tr id='"+sp[0]+1111+"'><td  nowrap>Narration::<textArea name='narration[]' type='textarea' cols='15' rows='2' class='required-text' id='narration' title='Narration' ></textArea></td>  <td width='2'>&nbsp;</td><td nowrap>"+sp[1]+"</td><td> Bal: "+sp[2]+"</td></tr>";
		$('#beneficiary_div').append(add_data);
		var dat = parseFloat(add_amount);
		//alert(dat);
		var sumtotal = (total+dat).toFixed(2);
		//alert(sumtotal);
		 $('#add_ben').get(0).value="";
   	     $('#add_amount').get(0).value="";
		 $('#total').get(0).value=sumtotal;
		var amt = parseFloat($('#amount').val());
		if((amt==sumtotal)&&(sumtotal>0)&&(!isNaN(amt))){
				$("#subbtn").attr('disabled', false);
		}else{
			 $("#subbtn").attr('disabled','disabled');
			  }
	   } 
  });
	}
}

function removetable(removeRow,getadd_amount){
	//alert(getadd_amount);
	var getval = parseFloat(getadd_amount);
	var benadd = parseFloat($('#total').val());
	benadd-=getval;
	$('#total').get(0).value=benadd;
    $('#'+removeRow).remove();	1
	$('#'+removeRow+1111).remove();	
}

function getdivcontent(divid){
	/*
	var data = $('#'+divid);
	alert(document.all('reportdiv').innerHTML);
	*/
	var data = "<table>";
	var table = document.getElementById('userlistTable');
	var x = table.rows
	//alert(x.length);
	for(var i=0; i<x.length; i++){
	var row = table.rows[i];
	data += "<tr>"+row.innerHTML+"</tr>";
	}
	data+="</table>";
	//$('#cover_div').html(data);
	//$('#cover_div').show('slow');
	pageloader("download.php?alldata="+escape(data),'');
	//alert(data);
	//window.open("download.php?alldata="+escape(data),"_blank");
}

function CreateExcelSheet(myTable)
{
	var tablename = myTable;
	var tabl = $('#userlistTable');
	var x = userlistTable.rows
	alert(x.length);
	var alldata = "";
	var xls = new ActiveXObject("Excel.Application")
	xls.visible = true
	xls.Workbooks.Add
	for (i = 0; i < x.length; i++)
	{
	var y = x[i].cells
	
		for (j = 0; j < y.length; j++)
		{
		xls.Cells( i+1, j+1).Value = y[j].innerText
		//alldata+=y[j].innerText;
		}
	}
	/*
	var tabl = document.getElementById('userlistTable');
	var l = tabl.rows.length;
	alert( 'Number of table rows: ' + l );
	var alldata = '';
	for ( var i = 0; i < l; i++ )
	{
	var tr = tabl.rows[i];
	//alert( 'Found ' + tr.nodeName + ' ' + i );
	for (j = 0; j < tr.length; j++)
		{
		//xls.Cells( i+1, j+1).Value = y[j].innerText
		alldata+= '|' +tr.childNodes[j].innerText;
		}
	//var cll = tr.childNodes[1];
	//alert( 'Found a ' + cll.nodeName );
	//var ct = cll.innerHTML.replace( /<[^<>]+>/g, '' );
	//alert( cll.nodeName + ' contains text: ' + ct );
	//s += '|' + cll.innerText;
	}
	alert('result:\n' + alldata);
	window.open("download.php?alldata="+escape(alldata),"_blank");
	*/
}
function calldownload(){
	//
	var data = $('#sql').val();
	var data2 = $('#filename').val();
	//alert(data);
	window.open("download.php?sql="+escape(data)+"&filename="+data2,"mydownload","status=0,toolbar=0");
}

function ClickHereToPrint(){
	try{
		//var oIframe = document.getElementById(’ifrmPrint’);
		var oContent = document.getElementById('branch_div').innerHTML;
		var oDoc = oContent; //(oIframe.contentWindow || oIframe.contentDocument);
		if (oDoc.document) oDoc = oDoc.document;
		oDoc.write("<head><title>title</title>");
		oDoc.write("</head><body onload='this.focus(); this.print();'>");
		oDoc.write(oContent + "</body>");
		oDoc.close();
		}
		catch(e){
		self.print();
	}
}

function printDiv(seldiv)
{
  var divToPrint=document.getElementById(seldiv);
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html><link rel="stylesheet" type="text/css" href="css/main.css"><body>'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  //setTimeout(function(){newWin.close();},20);
}

function printDoc(seldiv)
{
  var divToPrint=document.getElementById(seldiv);
  var newWin=window.open('','Print-Window','width=30,height=20');
  newWin.document.open();
  newWin.document.write('<?php header("Content-disposition: attachment; filename="data.doc"); header("Content-type: application vnd.ms-word"); ?><html><link rel="stylesheet" type="text/css" href="css/main.css"><body>'+divToPrint.innerHTML+'</body></html>');
  //newWin.document.close();
  //setTimeout(function(){newWin.close();},20);
}


function getselectedItemname(){
	var instname = $('#instrument_inst :selected').text();
	//alert(instname);
	$("#instrument_inst_name").get(0).value = instname;
}
/**********************************************************************************/
/********************** JAVASCRIPT FUNCTIONS DONE BY ISAIAH ***********************/
function getvalue(){
	var dat1 = parseFloat($("#unitcost").get(0).value);
	var dat2 = parseFloat($("#unit").get(0).value);
	var dat3 = parseFloat($("#contribution").get(0).value);
	var dat4 = parseFloat($("#facility").get(0).value);
	var dat5 = parseFloat($("#interest").get(0).value).toFixed(2);
	var dat6 = parseFloat($("#duration").get(0).value).toFixed(2);
	$("#annualinterest").html(dat5);
	$("#duration2").html(dat6);
	if($("#unit").get(0).value==""){
		$("#amount").get(0).value=0.00;
		$("#requiredamount").get(0).value = 0.00;
	}else{
		$("#amount").get(0).value = dat1 * dat2;
		var reqamt = (dat1 * dat2).toFixed(2);
		 $("#requiredamount").get(0).value = reqamt;
	}
	
	if($("#contribution").get(0).value==""){
		$("#financed").get(0).value = 0.00;
		$("#contriamount").get(0).value = 0.00;
	}else{
		var contribamt = ((dat3 / 100) * $("#requiredamount").get(0).value).toFixed(2);
		$("#contriamount").get(0).value = contribamt;
		var financed = reqamt - contribamt;
		$("#financed").get(0).value = financed;
		$("#financed2").get(0).value = parseFloat($("#financed").get(0).value).toFixed(2);
		$("#financed2").html($("#financed2").get(0).value);
		
	}
	
	if($("#facility").get(0).value==""){
		$("#facilityAmount").get(0).value = 0.00;
	}else{
		$("#facilityAmount").get(0).value = ((dat4 / 100) * $("#contriamount").get(0).value * $("#duration").get(0).value).toFixed(2);
		var totlalcontrib = (parseFloat($("#contriamount").get(0).value) + parseFloat($("#facilityAmount").get(0).value)).toFixed(2);
		$("#totalcontrib").get(0).value = totlalcontrib;
	}
	
	if($("#facility").get(0).value==""){
		$("#totalcost").get(0).value = 0.00;
	}else{
		//doSearch('leaseReport.php');
	}
	var numrepay = dat6 * 12;
		
		var monthlyrepay = (totlalcontrib / numrepay) + ((dat5/100) * financed * dat6) / numrepay;
		var yearlyPlusint = monthlyrepay *12;
		var fincharges = (yearlyPlusint * dat6) - financed;
		 $("#monthlyrepay").html(monthlyrepay);
		 $("#payment_times").html(numrepay);
		 $("#yearlyprinc_interest").html(yearlyPlusint);
		 $("#principalamount").html(financed);
		 $("#financecharges").html(fincharges);
		 $("#totalcost").html(yearlyPlusint * dat6);
		 $("#concat").get(0).value= dat5 +"/"+dat6;
	//alert($("#amount").get(0).value);	
}

var xmlhttp;

function dolease()
{
	var intt = $("#interest").get(0).value;
	var finn = $("#financed").get(0).value;
	var datt = $("#facility").get(0).value;
	var dura = $("#duration").get(0).value;
	var tcontr = $("#financed").get(0).value;
	var yr = $("#eyear").get(0).value;
	var mnth = $("#emonth").get(0).value;
	var sdate = mnth+"-"+yr;
	$("#startdate").html(sdate);
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="lease.php";
url=url+"?intt="+intt;
url=url+"&finn="+finn;
url=url+"&datt="+datt;
url=url+"&dura="+dura;
url=url+"&tcontr="+tcontr;
url=url+"&yr="+yr;
url=url+"&mnth="+mnth;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged()
{
if (xmlhttp.readyState==4)
{
document.getElementById("response").innerHTML=xmlhttp.responseText;
}
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
/********************** END OF JAVASCRIPT DONE BY TAYO ****************************/
/**********************************************************************************/


/**********************************************************************************/
/********************** JAVASCRIPT FUNCTIONS DONE BY TAYO *************************/
function selectvalue(hdvalue,tbname,hdvalue2,tdval,tdval2,sname){
	 
	//alert(valsel);
	//alert(frzcode);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
   data: "op=gethdvaue&hdvalue="+hdvalue+"&tbname="+tbname+"&hdvalue2="+hdvalue2+"&tdval="+tdval+
   "&tdval2="+tdval2,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 $("#"+sname).html(msg);
		   //$("#display_message").show("fast");
	   } 
  });
}

function selectvalue1(hdvalue,tbname,hdvalue2,tdval,tdval2,sname){
	 
	//alert(valsel);
	//alert(frzcode);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
   data: "op=gethdvaue1&hdvalue="+hdvalue+"&tbname="+tbname+"&hdvalue2="+hdvalue2+"&tdval="+tdval+
   "&tdval2="+tdval2,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 $("#"+sname).html(msg);
		   //$("#display_message").show("fast");
	   } 
  });
}

function selectvalue2(hdvalue,tbname,hdvalue2,tdval,tdval2,sname){
	 
	//alert(valsel);
	//alert(frzcode);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
   data: "op=gethdvaue2&hdvalue="+hdvalue+"&tbname="+tbname+"&hdvalue2="+hdvalue2+"&tdval="+tdval+
   "&tdval2="+tdval2,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 $("#"+sname).html(msg);
		   //$("#display_message").show("fast");
	   } 
  });
}

function selectvalue3(hdvalue,tbname,hdvalue2,tdval,tdval2,sname){
	 
	//alert(valsel);
	//alert(frzcode);
	//alert(hdvalue);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
   data: "op=gethdvaue3&hdvalue="+hdvalue+"&tbname="+tbname+"&hdvalue2="+hdvalue2+"&tdval="+tdval+
   "&tdval2="+tdval2,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 $("#"+sname).html(msg);
		   //$("#display_message").show("fast");
	   } 
  });
}


//Get Customer Account
function getCustomerAccount(){
	var data = $('#acctno').val();
     //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerAccount&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split(',');
		          $("#span_acname").html(splitval[1]);
				  $("#acname").get(0).value = splitval[1];
		          $("#span_acno").html(splitval[0]);
				  $("#acno").get(0).value = splitval[0];
                  $("#span_curbal").html(splitval[2]);
				  $("#curbal").get(0).value = splitval[2];
				  $("#acid").get(0).value = splitval[3];
				  $("#gl_type").get(0).value = splitval[4];
				  if(splitval[5] != ""){
				   $("#particulars").get(0).value = splitval[5];
				  }
		 //$("#display_message").show("fast");
	   } 
  });
}

//Get Customer Loan Account
function getCustomerLoanAccount(){
	var data = $('#acctno2').val();
     //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerAccount&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split(',');
				  $("#loan_acname").get(0).value = splitval[1];
				  $("#loan_acno").get(0).value = splitval[0];
				  getCustomerLoanfee(splitval[0]);
		 //$("#display_message").show("fast");
	   } 
  });
}

function gettranval(valsel,frzcode){
	//alert(valsel);
	//alert(frzcode);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getvaltransval&valsel="+valsel+"&frzcode="+frzcode,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		//alert(msg)
		if(msg=='NW'){
		 $("#postbtn").attr('disabled','disabled');
		}else{
			$("#postbtn").attr('disabled', false);
		}
		   //$("#display_message").show("fast");
	   } 
  });
}

function gettranval2(valfrz){
	var amount = parseFloat($('#amount').val());
	var frzamt = $('#frzamt').val();
	var acct_status = $('#actstatus').val();
	var cashtype = $('#cashtype').val();
	var ov_type = $('#ov_type').val();
	if(cashtype==""){
		alert("Please select transaction type");
		$("#amount").get(0).value = "";
		return false;
	}
	var cust_balance = $('#ledge_balance').val();
	var balance_limit = parseFloat($('#balance_limit').val());
	//alert(balance_limit);
	var avil_bal = parseFloat($('#avil_bal').val());
	var cot_limit = parseFloat($('#cot_rate').val());
	//alert(cot_limit);
	var totlimit = ((cot_limit * amount) + amount + balance_limit);
	//alert(totlimit);
	if(cashtype=='WRW' && (totlimit > cust_balance) && ov_type=='0'){
		if((amount=="")||(amount==0.00)){
		}
		else {
		alert(" Insufficient fund.. Pls check the amount");
		$("#amount").get(0).value = "";
		return false;
		}
	}
	//$('#amount').formatCurrency();
	//alert(avil_bal);
	//alert(cashtype);
	//alert(amount);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getvaltransval2&amount="+amount+"&frzamt="+frzamt+"&valfrz="+valfrz+"&cashtype="+cashtype+"&cust_balance="+cust_balance+"&balance_limit="+balance_limit,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		//alert(msg)
		if(msg=='NW'){
			alert("The transaction has exceeded the limit permitted");
		 $("#postbtn").attr('disabled','disabled');
		 $("#amount").get(0).value = "";
		}else{
			$("#postbtn").attr('disabled', false);
		}
		if((amount>avil_bal)&&(cashtype=="WRW")){
			alert("The transaction has exceeded the limit allowed");
		 $("#postbtn").attr('disabled','disabled');
		 $("#amount").get(0).value = "";
		}
		
		if((avil_bal<=0)&&(cashtype=="WRW")){
			alert("This Transaction is not allowed");
		 $("#postbtn").attr('disabled','disabled');
		 $("#amount").get(0).value = "";
		}
		if((acct_status==1)&&(cashtype=="WRW")){
			alert("This Account is not Active.");
		 $("#postbtn").attr('disabled','disabled');
		 $("#amount").get(0).value = "";
		}
		   //$("#display_message").show("fast");
	   } 
  });
}

function shoall(valtype){
  if(valtype=="LOAN"){
	   $("#pfee").show();
		$("#plabel").show();
  }
  else{
	  $("#pfee").hide();
		$("#plabel").hide();
  }
}

function getfee(valtype){
	$("#sp").html(valtype);  
}	

function getInstrument(){
	var tran = $('#instrument_no').val();

  // alert(data);
	//alert(data2);
	//alert(check);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=gettransaction&instrument="+tran,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		 if(msg!=""){
		 $("#trd").html(msg);
		 $("#postbtn").attr('disabled','disabled');
		 }
		 else{
			 $("#trd").html("");
			 $("#postbtn").attr('disabled', false);
		 }
		   //$("#display_message").show("fast");
	   } 
  });
}

//Get Customer Account
function getCustomerPenalty(){
	var data = $('#loan_acno').val();
     //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerPenalty&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		          $("#pfee").val(msg);
				 
		 //$("#display_message").show("fast");
	   } 
  });
}

//Get Customer Account
function getCustomerfee(){
	var data = $('#loan_acno').val();
    //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerfee&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var resultval = msg.split("/");
		          $("#loan_fee").val(resultval[0]);
				  $("#dfee").html(resultval[1]);
				 
		 //$("#display_message").show("fast");
	   } 
  });
}

//Get Customer Account
function getCustomerLoanfee(loanaccno){
	var data = loanaccno; //$('#loan_acno').val();
    //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "loan_fees.php", 
	   data: "op=getCustomerfee&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		//var resultval = msg.split("/");
		  //        $("#loan_fee").val(resultval[0]);
			//	  $("#dfee").html(resultval[1]);
				 
		 $("#loanfeediv").html(msg);
	   } 
  });
}


function callpagepersonnel(page){
var data = getdata();
//alert(data);
	if(data!='error') {
		$("#display_message").ajaxStart(function(){
			//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
			$("#display_message").html('<img src="images/loading.gif" alt="" />loading please wait . . .');
		});

		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op="+page+"&"+data, 
		   success: function(msg){ 
			 //alert( "Data Saved: " + msg ); 
			 //alert(msg);
			 var msg1 = msg.split("/");
			 $("#display_message").html(msg1[0]);
			 $("#display_message").show("fast");
			 $("#display_message").click();
			 if(msg1[1]=="1"){
			$('#container-1').disableTab(1);
			$('#container-1').disableTab(2);
			$('#container-1').disableTab(3);
			$('#container-1').disableTab(4);
		    $('#container-1').disableTab(5);
		    $('#container-1').enableTab(6);
			 $('#subbtn').hide();
			 $('#done').show();
			 }
		   } 
		 });
	}
}
/********************** END OF JAVASCRIPT DONE BY TAYO ****************************/
/**********************************************************************************/
//Paul Tero, July 2001
//http://www.tero.co.uk/des/
//
//Optimised for performance with large blocks by Michael Hayworth, November 2001
//http://www.netdealing.com
//
//THIS SOFTWARE IS PROVIDED "AS IS" AND
//ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
//IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
//ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
//FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
//DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
//OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
//HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
//LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
//OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
//SUCH DAMAGE.

//des
//this takes the key, the message, and whether to encrypt or decrypt
function des (key, message, encrypt, mode, iv, padding) {
  //declaring this locally speeds things up a bit
  var spfunction1 = new Array (0x1010400,0,0x10000,0x1010404,0x1010004,0x10404,0x4,0x10000,0x400,0x1010400,0x1010404,0x400,0x1000404,0x1010004,0x1000000,0x4,0x404,0x1000400,0x1000400,0x10400,0x10400,0x1010000,0x1010000,0x1000404,0x10004,0x1000004,0x1000004,0x10004,0,0x404,0x10404,0x1000000,0x10000,0x1010404,0x4,0x1010000,0x1010400,0x1000000,0x1000000,0x400,0x1010004,0x10000,0x10400,0x1000004,0x400,0x4,0x1000404,0x10404,0x1010404,0x10004,0x1010000,0x1000404,0x1000004,0x404,0x10404,0x1010400,0x404,0x1000400,0x1000400,0,0x10004,0x10400,0,0x1010004);
  var spfunction2 = new Array (-0x7fef7fe0,-0x7fff8000,0x8000,0x108020,0x100000,0x20,-0x7fefffe0,-0x7fff7fe0,-0x7fffffe0,-0x7fef7fe0,-0x7fef8000,-0x80000000,-0x7fff8000,0x100000,0x20,-0x7fefffe0,0x108000,0x100020,-0x7fff7fe0,0,-0x80000000,0x8000,0x108020,-0x7ff00000,0x100020,-0x7fffffe0,0,0x108000,0x8020,-0x7fef8000,-0x7ff00000,0x8020,0,0x108020,-0x7fefffe0,0x100000,-0x7fff7fe0,-0x7ff00000,-0x7fef8000,0x8000,-0x7ff00000,-0x7fff8000,0x20,-0x7fef7fe0,0x108020,0x20,0x8000,-0x80000000,0x8020,-0x7fef8000,0x100000,-0x7fffffe0,0x100020,-0x7fff7fe0,-0x7fffffe0,0x100020,0x108000,0,-0x7fff8000,0x8020,-0x80000000,-0x7fefffe0,-0x7fef7fe0,0x108000);
  var spfunction3 = new Array (0x208,0x8020200,0,0x8020008,0x8000200,0,0x20208,0x8000200,0x20008,0x8000008,0x8000008,0x20000,0x8020208,0x20008,0x8020000,0x208,0x8000000,0x8,0x8020200,0x200,0x20200,0x8020000,0x8020008,0x20208,0x8000208,0x20200,0x20000,0x8000208,0x8,0x8020208,0x200,0x8000000,0x8020200,0x8000000,0x20008,0x208,0x20000,0x8020200,0x8000200,0,0x200,0x20008,0x8020208,0x8000200,0x8000008,0x200,0,0x8020008,0x8000208,0x20000,0x8000000,0x8020208,0x8,0x20208,0x20200,0x8000008,0x8020000,0x8000208,0x208,0x8020000,0x20208,0x8,0x8020008,0x20200);
  var spfunction4 = new Array (0x802001,0x2081,0x2081,0x80,0x802080,0x800081,0x800001,0x2001,0,0x802000,0x802000,0x802081,0x81,0,0x800080,0x800001,0x1,0x2000,0x800000,0x802001,0x80,0x800000,0x2001,0x2080,0x800081,0x1,0x2080,0x800080,0x2000,0x802080,0x802081,0x81,0x800080,0x800001,0x802000,0x802081,0x81,0,0,0x802000,0x2080,0x800080,0x800081,0x1,0x802001,0x2081,0x2081,0x80,0x802081,0x81,0x1,0x2000,0x800001,0x2001,0x802080,0x800081,0x2001,0x2080,0x800000,0x802001,0x80,0x800000,0x2000,0x802080);
  var spfunction5 = new Array (0x100,0x2080100,0x2080000,0x42000100,0x80000,0x100,0x40000000,0x2080000,0x40080100,0x80000,0x2000100,0x40080100,0x42000100,0x42080000,0x80100,0x40000000,0x2000000,0x40080000,0x40080000,0,0x40000100,0x42080100,0x42080100,0x2000100,0x42080000,0x40000100,0,0x42000000,0x2080100,0x2000000,0x42000000,0x80100,0x80000,0x42000100,0x100,0x2000000,0x40000000,0x2080000,0x42000100,0x40080100,0x2000100,0x40000000,0x42080000,0x2080100,0x40080100,0x100,0x2000000,0x42080000,0x42080100,0x80100,0x42000000,0x42080100,0x2080000,0,0x40080000,0x42000000,0x80100,0x2000100,0x40000100,0x80000,0,0x40080000,0x2080100,0x40000100);
  var spfunction6 = new Array (0x20000010,0x20400000,0x4000,0x20404010,0x20400000,0x10,0x20404010,0x400000,0x20004000,0x404010,0x400000,0x20000010,0x400010,0x20004000,0x20000000,0x4010,0,0x400010,0x20004010,0x4000,0x404000,0x20004010,0x10,0x20400010,0x20400010,0,0x404010,0x20404000,0x4010,0x404000,0x20404000,0x20000000,0x20004000,0x10,0x20400010,0x404000,0x20404010,0x400000,0x4010,0x20000010,0x400000,0x20004000,0x20000000,0x4010,0x20000010,0x20404010,0x404000,0x20400000,0x404010,0x20404000,0,0x20400010,0x10,0x4000,0x20400000,0x404010,0x4000,0x400010,0x20004010,0,0x20404000,0x20000000,0x400010,0x20004010);
  var spfunction7 = new Array (0x200000,0x4200002,0x4000802,0,0x800,0x4000802,0x200802,0x4200800,0x4200802,0x200000,0,0x4000002,0x2,0x4000000,0x4200002,0x802,0x4000800,0x200802,0x200002,0x4000800,0x4000002,0x4200000,0x4200800,0x200002,0x4200000,0x800,0x802,0x4200802,0x200800,0x2,0x4000000,0x200800,0x4000000,0x200800,0x200000,0x4000802,0x4000802,0x4200002,0x4200002,0x2,0x200002,0x4000000,0x4000800,0x200000,0x4200800,0x802,0x200802,0x4200800,0x802,0x4000002,0x4200802,0x4200000,0x200800,0,0x2,0x4200802,0,0x200802,0x4200000,0x800,0x4000002,0x4000800,0x800,0x200002);
  var spfunction8 = new Array (0x10001040,0x1000,0x40000,0x10041040,0x10000000,0x10001040,0x40,0x10000000,0x40040,0x10040000,0x10041040,0x41000,0x10041000,0x41040,0x1000,0x40,0x10040000,0x10000040,0x10001000,0x1040,0x41000,0x40040,0x10040040,0x10041000,0x1040,0,0,0x10040040,0x10000040,0x10001000,0x41040,0x40000,0x41040,0x40000,0x10041000,0x1000,0x40,0x10040040,0x1000,0x41040,0x10001000,0x40,0x10000040,0x10040000,0x10040040,0x10000000,0x40000,0x10001040,0,0x10041040,0x40040,0x10000040,0x10040000,0x10001000,0x10001040,0,0x10041040,0x41000,0x41000,0x1040,0x1040,0x40040,0x10000000,0x10041000);

  //create the 16 or 48 subkeys we will need
  var keys = des_createKeys (key);
  var m=0, i, j, temp, temp2, right1, right2, left, right, looping;
  var cbcleft, cbcleft2, cbcright, cbcright2
  var endloop, loopinc;
  var len = message.length;
  var chunk = 0;
  //set up the loops for single and triple des
  var iterations = keys.length == 32 ? 3 : 9; //single or triple des
  if (iterations == 3) {looping = encrypt ? new Array (0, 32, 2) : new Array (30, -2, -2);}
  else {looping = encrypt ? new Array (0, 32, 2, 62, 30, -2, 64, 96, 2) : new Array (94, 62, -2, 32, 64, 2, 30, -2, -2);}

  //pad the message depending on the padding parameter
  if (padding == 2) message += "        "; //pad the message with spaces
  else if (padding == 1) {temp = 8-(len%8); message += String.fromCharCode (temp,temp,temp,temp,temp,temp,temp,temp); if (temp==8) len+=8;} //PKCS7 padding
  else if (!padding) message += "\0\0\0\0\0\0\0\0"; //pad the message out with null bytes

  //store the result here
  result = "";
  tempresult = "";

  if (mode == 1) { //CBC mode
    cbcleft = (iv.charCodeAt(m++) << 24) | (iv.charCodeAt(m++) << 16) | (iv.charCodeAt(m++) << 8) | iv.charCodeAt(m++);
    cbcright = (iv.charCodeAt(m++) << 24) | (iv.charCodeAt(m++) << 16) | (iv.charCodeAt(m++) << 8) | iv.charCodeAt(m++);
    m=0;
  }

  //loop through each 64 bit chunk of the message
  while (m < len) {
    left = (message.charCodeAt(m++) << 24) | (message.charCodeAt(m++) << 16) | (message.charCodeAt(m++) << 8) | message.charCodeAt(m++);
    right = (message.charCodeAt(m++) << 24) | (message.charCodeAt(m++) << 16) | (message.charCodeAt(m++) << 8) | message.charCodeAt(m++);

    //for Cipher Block Chaining mode, xor the message with the previous result
    if (mode == 1) {if (encrypt) {left ^= cbcleft; right ^= cbcright;} else {cbcleft2 = cbcleft; cbcright2 = cbcright; cbcleft = left; cbcright = right;}}

    //first each 64 but chunk of the message must be permuted according to IP
    temp = ((left >>> 4) ^ right) & 0x0f0f0f0f; right ^= temp; left ^= (temp << 4);
    temp = ((left >>> 16) ^ right) & 0x0000ffff; right ^= temp; left ^= (temp << 16);
    temp = ((right >>> 2) ^ left) & 0x33333333; left ^= temp; right ^= (temp << 2);
    temp = ((right >>> 8) ^ left) & 0x00ff00ff; left ^= temp; right ^= (temp << 8);
    temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1);

    left = ((left << 1) | (left >>> 31)); 
    right = ((right << 1) | (right >>> 31)); 

    //do this either 1 or 3 times for each chunk of the message
    for (j=0; j<iterations; j+=3) {
      endloop = looping[j+1];
      loopinc = looping[j+2];
      //now go through and perform the encryption or decryption  
      for (i=looping[j]; i!=endloop; i+=loopinc) { //for efficiency
        right1 = right ^ keys[i]; 
        right2 = ((right >>> 4) | (right << 28)) ^ keys[i+1];
        //the result is attained by passing these bytes through the S selection functions
        temp = left;
        left = right;
        right = temp ^ (spfunction2[(right1 >>> 24) & 0x3f] | spfunction4[(right1 >>> 16) & 0x3f]
              | spfunction6[(right1 >>>  8) & 0x3f] | spfunction8[right1 & 0x3f]
              | spfunction1[(right2 >>> 24) & 0x3f] | spfunction3[(right2 >>> 16) & 0x3f]
              | spfunction5[(right2 >>>  8) & 0x3f] | spfunction7[right2 & 0x3f]);
      }
      temp = left; left = right; right = temp; //unreverse left and right
    } //for either 1 or 3 iterations

    //move then each one bit to the right
    left = ((left >>> 1) | (left << 31)); 
    right = ((right >>> 1) | (right << 31)); 

    //now perform IP-1, which is IP in the opposite direction
    temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1);
    temp = ((right >>> 8) ^ left) & 0x00ff00ff; left ^= temp; right ^= (temp << 8);
    temp = ((right >>> 2) ^ left) & 0x33333333; left ^= temp; right ^= (temp << 2);
    temp = ((left >>> 16) ^ right) & 0x0000ffff; right ^= temp; left ^= (temp << 16);
    temp = ((left >>> 4) ^ right) & 0x0f0f0f0f; right ^= temp; left ^= (temp << 4);

    //for Cipher Block Chaining mode, xor the message with the previous result
    if (mode == 1) {if (encrypt) {cbcleft = left; cbcright = right;} else {left ^= cbcleft2; right ^= cbcright2;}}
    tempresult += String.fromCharCode ((left>>>24), ((left>>>16) & 0xff), ((left>>>8) & 0xff), (left & 0xff), (right>>>24), ((right>>>16) & 0xff), ((right>>>8) & 0xff), (right & 0xff));

    chunk += 8;
    if (chunk == 512) {result += tempresult; tempresult = ""; chunk = 0;}
  } //for every 8 characters, or 64 bits in the message

  //return the result as an array
  return result + tempresult;
} //end of des



//des_createKeys
//this takes as input a 64 bit key (even though only 56 bits are used)
//as an array of 2 integers, and returns 16 48 bit keys
function des_createKeys (key) {
  //declaring this locally speeds things up a bit
  pc2bytes0  = new Array (0,0x4,0x20000000,0x20000004,0x10000,0x10004,0x20010000,0x20010004,0x200,0x204,0x20000200,0x20000204,0x10200,0x10204,0x20010200,0x20010204);
  pc2bytes1  = new Array (0,0x1,0x100000,0x100001,0x4000000,0x4000001,0x4100000,0x4100001,0x100,0x101,0x100100,0x100101,0x4000100,0x4000101,0x4100100,0x4100101);
  pc2bytes2  = new Array (0,0x8,0x800,0x808,0x1000000,0x1000008,0x1000800,0x1000808,0,0x8,0x800,0x808,0x1000000,0x1000008,0x1000800,0x1000808);
  pc2bytes3  = new Array (0,0x200000,0x8000000,0x8200000,0x2000,0x202000,0x8002000,0x8202000,0x20000,0x220000,0x8020000,0x8220000,0x22000,0x222000,0x8022000,0x8222000);
  pc2bytes4  = new Array (0,0x40000,0x10,0x40010,0,0x40000,0x10,0x40010,0x1000,0x41000,0x1010,0x41010,0x1000,0x41000,0x1010,0x41010);
  pc2bytes5  = new Array (0,0x400,0x20,0x420,0,0x400,0x20,0x420,0x2000000,0x2000400,0x2000020,0x2000420,0x2000000,0x2000400,0x2000020,0x2000420);
  pc2bytes6  = new Array (0,0x10000000,0x80000,0x10080000,0x2,0x10000002,0x80002,0x10080002,0,0x10000000,0x80000,0x10080000,0x2,0x10000002,0x80002,0x10080002);
  pc2bytes7  = new Array (0,0x10000,0x800,0x10800,0x20000000,0x20010000,0x20000800,0x20010800,0x20000,0x30000,0x20800,0x30800,0x20020000,0x20030000,0x20020800,0x20030800);
  pc2bytes8  = new Array (0,0x40000,0,0x40000,0x2,0x40002,0x2,0x40002,0x2000000,0x2040000,0x2000000,0x2040000,0x2000002,0x2040002,0x2000002,0x2040002);
  pc2bytes9  = new Array (0,0x10000000,0x8,0x10000008,0,0x10000000,0x8,0x10000008,0x400,0x10000400,0x408,0x10000408,0x400,0x10000400,0x408,0x10000408);
  pc2bytes10 = new Array (0,0x20,0,0x20,0x100000,0x100020,0x100000,0x100020,0x2000,0x2020,0x2000,0x2020,0x102000,0x102020,0x102000,0x102020);
  pc2bytes11 = new Array (0,0x1000000,0x200,0x1000200,0x200000,0x1200000,0x200200,0x1200200,0x4000000,0x5000000,0x4000200,0x5000200,0x4200000,0x5200000,0x4200200,0x5200200);
  pc2bytes12 = new Array (0,0x1000,0x8000000,0x8001000,0x80000,0x81000,0x8080000,0x8081000,0x10,0x1010,0x8000010,0x8001010,0x80010,0x81010,0x8080010,0x8081010);
  pc2bytes13 = new Array (0,0x4,0x100,0x104,0,0x4,0x100,0x104,0x1,0x5,0x101,0x105,0x1,0x5,0x101,0x105);

  //how many iterations (1 for des, 3 for triple des)
  var iterations = key.length > 8 ? 3 : 1; //changed by Paul 16/6/2007 to use Triple DES for 9+ byte keys
  //stores the return keys
  var keys = new Array (32 * iterations);
  //now define the left shifts which need to be done
  var shifts = new Array (0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0);
  //other variables
  var lefttemp, righttemp, m=0, n=0, temp;

  for (var j=0; j<iterations; j++) { //either 1 or 3 iterations
    left = (key.charCodeAt(m++) << 24) | (key.charCodeAt(m++) << 16) | (key.charCodeAt(m++) << 8) | key.charCodeAt(m++);
    right = (key.charCodeAt(m++) << 24) | (key.charCodeAt(m++) << 16) | (key.charCodeAt(m++) << 8) | key.charCodeAt(m++);

    temp = ((left >>> 4) ^ right) & 0x0f0f0f0f; right ^= temp; left ^= (temp << 4);
    temp = ((right >>> -16) ^ left) & 0x0000ffff; left ^= temp; right ^= (temp << -16);
    temp = ((left >>> 2) ^ right) & 0x33333333; right ^= temp; left ^= (temp << 2);
    temp = ((right >>> -16) ^ left) & 0x0000ffff; left ^= temp; right ^= (temp << -16);
    temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1);
    temp = ((right >>> 8) ^ left) & 0x00ff00ff; left ^= temp; right ^= (temp << 8);
    temp = ((left >>> 1) ^ right) & 0x55555555; right ^= temp; left ^= (temp << 1);

    //the right side needs to be shifted and to get the last four bits of the left side
    temp = (left << 8) | ((right >>> 20) & 0x000000f0);
    //left needs to be put upside down
    left = (right << 24) | ((right << 8) & 0xff0000) | ((right >>> 8) & 0xff00) | ((right >>> 24) & 0xf0);
    right = temp;

    //now go through and perform these shifts on the left and right keys
    for (var i=0; i < shifts.length; i++) {
      //shift the keys either one or two bits to the left
      if (shifts[i]) {left = (left << 2) | (left >>> 26); right = (right << 2) | (right >>> 26);}
      else {left = (left << 1) | (left >>> 27); right = (right << 1) | (right >>> 27);}
      left &= -0xf; right &= -0xf;

      //now apply PC-2, in such a way that E is easier when encrypting or decrypting
      //this conversion will look like PC-2 except only the last 6 bits of each byte are used
      //rather than 48 consecutive bits and the order of lines will be according to 
      //how the S selection functions will be applied: S2, S4, S6, S8, S1, S3, S5, S7
      lefttemp = pc2bytes0[left >>> 28] | pc2bytes1[(left >>> 24) & 0xf]
              | pc2bytes2[(left >>> 20) & 0xf] | pc2bytes3[(left >>> 16) & 0xf]
              | pc2bytes4[(left >>> 12) & 0xf] | pc2bytes5[(left >>> 8) & 0xf]
              | pc2bytes6[(left >>> 4) & 0xf];
      righttemp = pc2bytes7[right >>> 28] | pc2bytes8[(right >>> 24) & 0xf]
                | pc2bytes9[(right >>> 20) & 0xf] | pc2bytes10[(right >>> 16) & 0xf]
                | pc2bytes11[(right >>> 12) & 0xf] | pc2bytes12[(right >>> 8) & 0xf]
                | pc2bytes13[(right >>> 4) & 0xf];
      temp = ((righttemp >>> 16) ^ lefttemp) & 0x0000ffff; 
      keys[n++] = lefttemp ^ temp; keys[n++] = righttemp ^ (temp << 16);
    }
  } //for each iterations
  //return the keys we've created
  return keys;
} //end of des_createKeys



////////////////////////////// TEST //////////////////////////////
function stringToHex (s) {
  var r = "0x";
  var hexes = new Array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
  for (var i=0; i<s.length; i++) {r += hexes [s.charCodeAt(i) >> 4] + hexes [s.charCodeAt(i) & 0xf];}
  return r;
}

$(function() {
		//$("#checkin_date").datepicker();
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth();
		var curr_year = d.getFullYear();
		var myStartDate = new Date(curr_year,curr_month,curr_date); 
		$("#checkin_date").datepicker({ showOn: 'both', buttonImageOnly: true, buttonImage: 'images/ew_calendar.gif', buttonText: 'date', dateFormat: $.datepicker.W3C, minDate: myStartDate });
	});
	
	$(function() {
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth();
		var curr_year = d.getFullYear();
		var myStartDate2 = new Date(curr_year,curr_month,curr_date); 
		$("#checkout_date").datepicker({ showOn: 'both', buttonImageOnly: true, buttonImage: 'images/ew_calendar.gif', buttonText: 'date', dateFormat: $.datepicker.W3C, minDate: myStartDate2 });
	});
	
	$(function() {
		//$("#checkin_date").datepicker();
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth();
		var curr_year = d.getFullYear();
		var myStartDate = new Date(curr_year,curr_month,curr_date); 
		$("#option_date").datepicker({ showOn: 'both', buttonImageOnly: true, buttonImage: 'images/ew_calendar.gif', buttonText: 'datepicker', dateFormat: $.datepicker.W3C, minDate: myStartDate });
	});
	
$(function() {
		//$("#checkin_date").datepicker();
		var d = new Date();
		var curr_date = d.getDate();
		var curr_month = d.getMonth();
		var curr_year = d.getFullYear();
		var myStartDate = new Date(curr_year,curr_month,curr_date); 
		$("#opdate").datepicker({ showOn: 'both', buttonImageOnly: true, buttonImage: 'images/ew_calendar.gif', buttonText: 'datepicker', dateFormat: $.datepicker.W3C, minDate: myStartDate });
	});



	$(function() {
		
		var qitem = $("#qitem"),
			qty = $("#qty"),
			ap = $("#ap"),
			allFields = $([]).add(qitem).add(qty),
			tips = $("#validateTips");

		function updateTips(t) {
			tips.text(t).effect("highlight",{},1500);
		}

		function checkLength(o,n,min,max) {

			if ( o.val().length > max || o.val().length < min ) {
				o.addClass('ui-state-error');
				updateTips("Length of " + n + " must be between "+min+" and "+max+".");
				return false;
			} else {
				return true;
			}

		}

		function checkRegexp(o,regexp,n) {

			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass('ui-state-error');
				updateTips(n);
				return false;
			} else {
				return true;
			}

		}
		
		$("#dialog2").dialog({
			bgiframe: true,
			autoOpen: false,
			height: 300,
			modal: true,
			buttons: {
				'Add Item': function() {
					var bValid = true;
					allFields.removeClass('ui-state-error');

                      bValid=true;
					//bValid = bValid && checkLength(qitem,"Item",3,50);
					//bValid = bValid && checkLength(qty,"Quantity",1,2);

					//bValid = bValid && checkRegexp(qitem,/^[a-z]([0-9a-z_])+$/i,"Quantity may consist of a-z, 0-9, underscores, begin with a letter.");
					//bValid = bValid && checkRegexp(qty,/^([0-9])+$/i,"Quantity may consist of only 0-9 ");
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
					 
					
					if (bValid) {
					$('#users tbody').append('<tr>' +
					"<td><input name='iten[]' type='text' class='required-text' title=' Item' size='50'  id='iten[]' value="+qitem.val()+"></td>" + 
							"<td><input name='qt[]' type='text' size='5' class='required-number' title=' Quantity' id='qt[]' value="+qty.val()+"></td>"  + "</td>" +"<td><input name='ap[]' type='text' size='5' title=' Quantity' id='ap[]' ></td>"  + "</td>"+'</tr>'); 
						$(this).dialog('destroy');
					}
				},
				Cancel: function() {
					$(this).dialog('destroy');
				}
			},
			close: function() {
				allFields.val('').removeClass('ui-state-error');
			}
		});
		
		
		
		$('#create-user').click(function() {
			$('#dialog2').dialog('open');
		})
		.hover(
			function(){ 
				$(this).addClass("ui-state-hover"); 
			},
			function(){ 
				$(this).removeClass("ui-state-hover"); 
			}
		).mousedown(function(){
			$(this).addClass("ui-state-active"); 
		})
		.mouseup(function(){
				$(this).removeClass("ui-state-active");
		});

	});

//Get Customer Loan Account
function realease_req(uniqid){
	//alert(nowdate);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=releasereq&uniq="+uniqid,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split('/');
		     if(splitval[0]=='1'){
				  $("#done").html("");
				 //  $("#prt").html("<a href=\"javascript: printDiv('req');\">Print</a>");
				    $("#display_message").html(splitval[1]);
			         $("#display_message").show("fast");
					 $("#display_message").click();		
			 }
			 else {
				 
				  $("#display_message").html(splitval[1]);
			         $("#display_message").show("fast");
					 $("#display_message").click();	
			 }
				 
	   } 
  });
}

function calcInterest(){
	var interest = 0.00;
	var loan_amount = parseFloat(removecomma($("#loan_amt").val()));
	var loan_int_perctage = parseFloat(removecomma($("#loan_int").val()))/100;
	if($("#rate_spec").val()=='1'){
		if($("#loan_type").val()=='2'){
		interest = loan_amount * loan_int_perctage;
		$('#rep_nodays').get(0).value=1;
		}
		else if($("#loan_type").val()=='1'){
		interest = loan_amount * loan_int_perctage;
		//$("#tenure_option").val('30');
		$('#rep_nodays').get(0).value=30;
		}
	}
	else if($("#rate_spec").val()=='12'){
		if($("#loan_type").val()=='2'){
		interest = (loan_amount * loan_int_perctage)/12;
		$('#rep_nodays').get(0).value=1;
		}
		else if($("#loan_type").val()=='1'){
		interest = (loan_amount * loan_int_perctage)/12;
		$("#tenure_option").val('30');
		$('#rep_nodays').get(0).value=1;
		}
	}
	else if($("#rate_spec").val()=='0'){
		if($("#loan_type").val()=='2'){
		interest = loan_amount * loan_int_perctage;
		$('#rep_nodays').get(0).value=1;
		}
		else if($("#loan_type").val()=='1'){
		interest = loan_amount * loan_int_perctage;
		$("#tenure_option").get(0).value=$("#tenure").val();
		$('#rep_nodays').get(0).value=$("#tenure").val();
		}
	}
	$("#int_amt").get(0).value = interest.toFixed(2);
	$("#int_amount").html(interest.toFixed(2));
	
}

function calcRepayAmount(){
	var total_interest = 0.00;
	var loan_amount = parseFloat(removecomma($("#loan_amt").val()));
	var calc_int_amt = parseFloat($("#int_amt").val());
	var loan_int = parseFloat($("#loan_int").val());
	var tenure = $('#tenure').val();
	var tenure_option = $('#tenure_option').val();
	var rep_nodays = $('#rep_nodays').val();
	var rate_spec = $("#rate_spec").val();
	var charge_upfront = $("#charge_upfront").val();
	var rate_spec_days = 0;
		
	
	var div_by = 1;
	//alert(div_by);
	if(tenure!=''){
		//alert(tenure);
		if(tenure_option=='1' && rate_spec=='1'){
			if(tenure<30){
				div_by = 1;
				//alert(div_by);
			}
			else{
		div_by = Math.ceil(tenure/30);
			}
		}
		else if(tenure_option=='1' && rate_spec=='12'){
		div_by = Math.ceil(tenure/360);
		}
		else if(tenure_option=='30' && rate_spec=='1'){
		div_by = tenure;
		}
		else if(tenure_option=='30' && rate_spec=='12'){
		div_by = (tenure*30)/12;
		}
		
		
	total_interest = div_by * calc_int_amt;
	$('#total_int_amt').get(0).value = total_interest.toFixed(2) ;
	$('#total_int_amount').html(total_interest.toFixed(2));
	
	 if( rate_spec=='1' && tenure_option=='1' && tenure<30 ){
	 $("#total_int_amt").get(0).value=$("#int_amt").val();
	 total_interest = $("#int_amt").val();
	 $('#total_int_amount').html(total_interest);
	 //alert(total_interest);
	 //alert("This");
	 }
	
	showMatureDate();
	}
	
	var repay_amount = 0.00;
	var repay_principal = 0.00;
	var repay_interest = 0.00;
	if(rep_nodays!=''){
		//alert(rep_nodays);
		if(tenure_option=='30') { tenure = tenure * 30 };
			repay_amount = ((loan_amount / tenure) * rep_nodays)+calc_int_amt;
			
			 if( rate_spec=='1' && tenure_option=='1' && tenure<30 && charge_upfront=='1'){
				repay_amount = ((loan_amount / tenure) * rep_nodays) 
			//	alert(repay_amount);
			    repay_principal = (loan_amount/tenure)* rep_nodays;
				repay_interest = calc_int_amt;
				$('#rep_amt').get(0).value = repay_amount.toFixed(2);
				$('#repay_principal').get(0).value = repay_principal.toFixed(2);
				$('#repay_principalspan').html(repay_principal.toFixed(2));
				$('#repay_interest').get(0).value = '';
				$('#repay_interestspan').html();	
			 }
			 else{
			
			//alert(repay_amount);
			repay_principal = (loan_amount/tenure)* rep_nodays;
			repay_interest = calc_int_amt;
			$('#rep_amt').get(0).value = repay_amount.toFixed(2);
			$('#repay_principal').get(0).value = repay_principal.toFixed(2);
			$('#repay_principalspan').html(repay_principal.toFixed(2));
			$('#repay_interest').get(0).value = repay_interest.toFixed(2);
			$('#repay_interestspan').html(repay_interest.toFixed(2));
			 }
			
			
			var no_of_payments = Math.ceil(tenure/rep_nodays);
			var interest = repay_interest;
			total_interest = calc_int_amt;
			//alert(total_interest);
			if($("#loan_type").val()=='1' && rep_nodays!=''){
				//alert('Reducing '+no_of_payments);
				//interest = (loan_amount * loan_int_perctage)/12;
				for(var i=1; i<no_of_payments; i++){
					loan_amount = loan_amount - repay_principal;
					//$('#display_message').append(loan_amount+'<br/>');
					interest = (loan_amount * (loan_int/100));
					if(rate_spec=='12') interest = interest/12;
					total_interest = total_interest + interest;
					//alert('Loan Amount '+loan_amount+'\n Interest '+interest+'\n Total Interest '+total_interest);
					//$('#display_message').append('Loan Amount '+loan_amount+'\n Interest '+interest+'\n Total Interest '+total_interest);
					//$('#display_message').append(interest+'/'+total_interest+"~");
				}
				$('#display_message').show();
				$('#total_int_amount').html(total_interest);
				$('#repay_timesspan').html(no_of_payments);
				$('#repay_times').get(0).value = no_of_payments;
			}
	// For Flat Interest
	else if($("#loan_type").val()=='2' && rep_nodays!=''){
		   
		    if( rate_spec=='1' && tenure_option=='1' && tenure<30 && charge_upfront=='1'){
				
				interest = calc_int_amt;
				total_interest = 0.00;
				//alert('Flat '+no_of_payments);
				//interest = (loan_amount * loan_int_perctage)/12;
				$('#display_message').html('');
				for(var i=1; i<=no_of_payments; i++){
					//$('#display_message').append(loan_amount+'<br/>');
					if(rate_spec=='1') interest = (loan_amount * (loan_int/100));
					if(rate_spec=='12') interest = interest/12;
					total_interest =  interest;
					//$('#display_message').append(interest+'     '+total_interest+'<br/>');
				}
				var repay_principal = parseFloat(removecomma($('#repay_principal').val()));
				$('#total_int_amount').html(total_interest.toFixed(2));
				$('#total_int_amt').get(0).value = total_interest.toFixed(2) ;
				$('#repay_interestspan').html();
				$('#repay_interest').get(0).value = 0;
				$('#rep_amt').get(0).value = repay_principal;
				$('#repay_timesspan').html(no_of_payments);
				$('#repay_times').get(0).value = no_of_payments;
				
				
			}
			else{
		
		
				interest = calc_int_amt;
				total_interest = 0.00;
				interest_span_val = 0.00;
				//alert('Flat '+no_of_payments);
				//interest = (loan_amount * loan_int_perctage)/12;
				$('#display_message').html('');
				//for(var i=1; i<=no_of_payments; i++){
					//$('#display_message').append(loan_amount+'<br/>');
					if(rate_spec=='1') interest = (loan_amount * (loan_int / 100)) * ((tenure)/30);
					if(rate_spec=='12') { var calval = (((tenure)/30)/12); //alert(calval); 
					interest = (loan_amount * (loan_int / 100)) * calval; }
					total_interest = total_interest + interest;
					//alert(total_interest);
					interest_span_val = total_interest / no_of_payments;
					//$('#display_message').append(interest+'     '+total_interest+'<br/>');
				//}
				var repay_principal = parseFloat(removecomma($('#repay_principal').val()));
				$('#total_int_amount').html(total_interest.toFixed(2));
				$('#total_int_amt').get(0).value = total_interest.toFixed(2) ;
				$('#repay_interestspan').html(interest_span_val.toFixed(2));
				$('#repay_interest').get(0).value = interest.toFixed(2);
				$('#rep_amt').get(0).value = interest_span_val+repay_principal;
				$('#repay_timesspan').html(no_of_payments);
				$('#repay_times').get(0).value = no_of_payments;
			}
		}
	}
}
/////////////////////////////////////////


function calcRepayAmount2(){
	var total_interest = 0.00;
	var loan_amount = parseFloat(removecomma($("#loan_amt").val()));
	var amtpaid = parseFloat(removecomma($("#contr_amount").val()));
	if(amtpaid>0){
		loan_amount=loan_amount-amtpaid;
	}
	var calc_int_amt = parseFloat($("#int_amt").val());
	var loan_int = parseFloat($("#loan_int").val());
	var tenure = $('#tenure').val();
	var tenure_option = $('#tenure_option').val();
	var rep_nodays = $('#rep_nodays').val();
	var rate_spec = $("#rate_spec").val();
	var charge_upfront = $("#charge_upfront").val();
	var rate_spec_days = 0;
		
	
	var div_by = 1;
	//alert(div_by);
	if(tenure!=''){
		//alert(tenure);
		if(tenure_option=='1' && rate_spec=='1'){
			if(tenure<30){
				div_by = 1;
				//alert(div_by);
			}
			else{
		div_by = Math.ceil(tenure/30);
			}
		}
		else if(tenure_option=='1' && rate_spec=='12'){
		div_by = Math.ceil(tenure/360);
		}
		else if(tenure_option=='30' && rate_spec=='1'){
		div_by = 1;
		}
		else if(tenure_option=='30' && rate_spec=='12'){
		div_by = tenure/12;
		}
		
		
	total_interest = div_by * calc_int_amt;
	$('#total_int_amt').get(0).value = total_interest.toFixed(2) ;
	$('#total_int_amount').html(total_interest.toFixed(2));
	
	 if( rate_spec=='1' && tenure_option=='1' && tenure<30 ){
	 $("#total_int_amt").get(0).value=$("#int_amt").val();
	 total_interest = $("#int_amt").val();
	 $('#total_int_amount').html(total_interest);
	 //alert(total_interest);
	 //alert("This");
	 }
	
	showMatureDate();
	}
	
	var repay_amount = 0.00;
	var repay_principal = 0.00;
	var repay_interest = 0.00;
	if(rep_nodays!=''){
		//alert(rep_nodays);
		if(tenure_option=='30') { tenure = tenure * 30 };
			repay_amount = ((loan_amount / tenure) * rep_nodays)+calc_int_amt;
			
			 if( rate_spec=='1' && tenure_option=='1' && tenure<30 && charge_upfront=='1'){
				repay_amount = ((loan_amount / tenure) * rep_nodays) 
			//	alert(repay_amount);
			    repay_principal = (loan_amount/tenure)* rep_nodays;
				repay_interest = calc_int_amt;
				$('#rep_amt').get(0).value = repay_amount.toFixed(2);
				$('#repay_principal').get(0).value = repay_principal.toFixed(2);
				$('#repay_principalspan').html(repay_principal.toFixed(2));
				$('#repay_interest').get(0).value = '';
				$('#repay_interestspan').html();	
			 }
			 else{
			
			//alert(repay_amount);
			repay_principal = (loan_amount/tenure)* rep_nodays;
			repay_interest = calc_int_amt;
			$('#rep_amt').get(0).value = repay_amount.toFixed(2);
			$('#repay_principal').get(0).value = repay_principal.toFixed(2);
			$('#repay_principalspan').html(repay_principal.toFixed(2));
			$('#repay_interest').get(0).value = repay_interest.toFixed(2);
			$('#repay_interestspan').html(repay_interest.toFixed(2));
			 }
			
			
			var no_of_payments = Math.ceil(tenure/rep_nodays);
			var interest = repay_interest;
			total_interest = calc_int_amt;
			//alert(total_interest);
			if($("#loan_type").val()=='1' && rep_nodays!=''){
				//alert('Reducing '+no_of_payments);
				//interest = (loan_amount * loan_int_perctage)/12;
				for(var i=1; i<no_of_payments; i++){
					loan_amount = loan_amount - repay_principal;
					//$('#display_message').append(loan_amount+'<br/>');
					interest = (loan_amount * (loan_int/100));
					if(rate_spec=='12') interest = interest/12;
					total_interest = total_interest + interest;
					//alert('Loan Amount '+loan_amount+'\n Interest '+interest+'\n Total Interest '+total_interest);
					//$('#display_message').append('Loan Amount '+loan_amount+'\n Interest '+interest+'\n Total Interest '+total_interest);
					//$('#display_message').append(interest+'/'+total_interest+"~");
				}
				$('#display_message').show();
				$('#total_int_amount').html(total_interest);
				$('#repay_timesspan').html(no_of_payments);
				$('#repay_times').get(0).value = no_of_payments;
			}
	// For Flat Interest
	else if($("#loan_type").val()=='2' && rep_nodays!=''){
		   
		    if( rate_spec=='1' && tenure_option=='1' && tenure<30 && charge_upfront=='1'){
				
				interest = calc_int_amt;
				total_interest = 0.00;
				//alert('Flat '+no_of_payments);
				//interest = (loan_amount * loan_int_perctage)/12;
				$('#display_message').html('');
				for(var i=1; i<=no_of_payments; i++){
					//$('#display_message').append(loan_amount+'<br/>');
					if(rate_spec=='1') interest = (loan_amount * (loan_int/100));
					if(rate_spec=='12') interest = interest/12;
					total_interest =  interest;
					//$('#display_message').append(interest+'     '+total_interest+'<br/>');
				}
				var repay_principal = parseFloat(removecomma($('#repay_principal').val()));
				$('#total_int_amount').html(total_interest.toFixed(2));
				$('#total_int_amt').get(0).value = total_interest.toFixed(2) ;
				$('#repay_interestspan').html();
				$('#repay_interest').get(0).value = 0;
				$('#rep_amt').get(0).value = repay_principal;
				$('#repay_timesspan').html(no_of_payments);
				$('#repay_times').get(0).value = no_of_payments;
				
				
			}
			else{
		
		
				interest = calc_int_amt;
				total_interest = 0.00;
				interest_span_val = 0.00;
				//alert('Flat '+no_of_payments);
				//interest = (loan_amount * loan_int_perctage)/12;
				$('#display_message').html('');
				//for(var i=1; i<=no_of_payments; i++){
					//$('#display_message').append(loan_amount+'<br/>');
					if(rate_spec=='1') interest = (loan_amount * (loan_int/100)) * tenure/30;
					if(rate_spec=='12') interest = interest/12;
					total_interest = total_interest + interest;
					interest_span_val = total_interest / no_of_payments;
					//$('#display_message').append(interest+'     '+total_interest+'<br/>');
				//}
				var repay_principal = parseFloat(removecomma($('#repay_principal').val()));
				$('#total_int_amount').html(total_interest.toFixed(2));
				$('#total_int_amt').get(0).value = total_interest.toFixed(2) ;
				$('#repay_interestspan').html(interest_span_val.toFixed(2));
				$('#repay_interest').get(0).value = interest.toFixed(2);
				$('#rep_amt').get(0).value = interest_span_val+repay_principal;
				$('#repay_timesspan').html(no_of_payments);
				$('#repay_times').get(0).value = no_of_payments;
			}
		}
	}
}






///////////////////////////////////////

function calcRepayAmountLease(){
	var total_interest = 0.00;
	var interest = 0.00;
	var loan_amount = parseFloat(removecomma($("#loan_amt").val()));
	var amtpaid = parseFloat(removecomma($("#contr_amount").val()));
	if(amtpaid>0){
		loan_amount=loan_amount-amtpaid;
	}
	var calc_int_amt = parseFloat($("#int_amt").val());
	var loan_int = parseFloat($("#loan_int").val());
	var tenure = $('#tenure').val();
	var tenure_option = $('#tenure_option').val();
	var rep_nodays = $('#rep_nodays').val();
	var rate_spec = $("#rate_spec").val();
	var rate_spec_days = 0;
	var loan_int_perctage = parseFloat(removecomma($("#loan_int").val()))/100;
	
	if($("#rate_spec").val()=='1'){// for Per month
		if($("#loan_type").val()=='2'){ // for Flat rate
			if(tenure_option=='1'){
			interest = loan_amount * loan_int_perctage;
			$('#rep_nodays').get(0).value=1;
			}
			if(tenure_option=='30'){
		      interest = loan_amount * loan_int_perctage;
		      $('#rep_nodays').get(0).value=30;
			}
		}
		else if($("#loan_type").val()=='1'){
		interest = loan_amount * loan_int_perctage;
		$("#tenure_option").val('30');
		$('#rep_nodays').get(0).value=30;
		}
	}
	else if($("#rate_spec").val()=='12'){
		if($("#loan_type").val()=='2'){
		interest = (loan_amount * loan_int_perctage)/12;
		$('#rep_nodays').get(0).value=1;
		}
		else if($("#loan_type").val()=='1'){
		interest = (loan_amount * loan_int_perctage)/12;
		$("#tenure_option").val('30');
		$('#rep_nodays').get(0).value=1;
		}
	}
	$("#int_amt").get(0).value = interest.toFixed(2);
	$("#int_amount").html(interest.toFixed(2));
	
	var div_by = 1;
	if(tenure!=''){
		if(tenure_option=='1' && rate_spec=='1'){
		div_by = Math.ceil(tenure/30);
		}
		else if(tenure_option=='1' && rate_spec=='12'){
		div_by = Math.ceil(tenure/360);
		}
		else if(tenure_option=='30' && rate_spec=='1'){
		div_by = tenure;
		}
		else if(tenure_option=='30' && rate_spec=='12'){
		div_by = tenure/12;
		}
	total_interest = div_by * calc_int_amt;
	$('#total_int_amt').get(0).value = total_interest.toFixed(2) ;
	$('#total_int_amount').html(total_interest.toFixed(2));
	showMatureDate();
	}
	
	var repay_amount = 0.00;
	var repay_principal = 0.00;
	var repay_interest = 0.00;
	if(rep_nodays!=''){
		if(tenure_option=='30') tenure = tenure * 30;
			repay_amount = ((loan_amount / tenure) * rep_nodays)+calc_int_amt;
			repay_principal = (loan_amount/tenure)* rep_nodays;
			repay_interest = calc_int_amt;
			$('#rep_amt').get(0).value = repay_amount.toFixed(2);
			$('#repay_principal').get(0).value = repay_principal.toFixed(2);
			$('#repay_principalspan').html(repay_principal.toFixed(2));
			$('#repay_interest').get(0).value = repay_interest.toFixed(2);
			$('#repay_interestspan').html(repay_interest.toFixed(2));
			
			var no_of_payments = Math.ceil(tenure/rep_nodays);
			var interest = repay_interest;
			total_interest = calc_int_amt;
			//alert(total_interest);
			if($("#loan_type").val()=='1' && rep_nodays!=''){
				//alert('Reducing '+no_of_payments);
				//interest = (loan_amount * loan_int_perctage)/12;
				for(var i=1; i<no_of_payments; i++){
					loan_amount = loan_amount - repay_principal;
					//$('#display_message').append(loan_amount+'<br/>');
					interest = (loan_amount * (loan_int/100));
					if(rate_spec=='12') interest = interest/12;
					total_interest = total_interest + interest;
					//alert('Loan Amount '+loan_amount+'\n Interest '+interest+'\n Total Interest '+total_interest);
					//$('#display_message').append('Loan Amount '+loan_amount+'\n Interest '+interest+'\n Total Interest '+total_interest);
					//$('#display_message').append(interest+'/'+total_interest+"~");
				}
				$('#display_message').show();
				$('#total_int_amount').html(total_interest);
				$('#repay_timesspan').html(no_of_payments);
				$('#repay_times').get(0).value = no_of_payments;
			}
	// For Flat Interest
	else if($("#loan_type").val()=='2' && rep_nodays!=''){
				interest = calc_int_amt;
				total_interest = 0.00;
				//alert('Flat '+no_of_payments);
				//interest = (loan_amount * loan_int_perctage)/12;
				$('#display_message').html('');
				for(var i=1; i<=no_of_payments; i++){
					//$('#display_message').append(loan_amount+'<br/>');
					if(rate_spec=='1') interest = (loan_amount * (loan_int/100)) * rep_nodays/30;
					if(rate_spec=='12') interest = interest/12;
					total_interest = total_interest + interest;
					//$('#display_message').append(interest+'     '+total_interest+'<br/>');
				}
				var repay_principal = parseFloat(removecomma($('#repay_principal').val()));
				$('#total_int_amount').html(total_interest.toFixed(2));
				$('#total_int_amt').get(0).value = total_interest.toFixed(2) ;
				$('#repay_interestspan').html(interest.toFixed(2));
				$('#repay_interest').get(0).value = interest.toFixed(2);
				$('#rep_amt').get(0).value = interest+repay_principal;
				$('#repay_timesspan').html(no_of_payments);
				$('#repay_times').get(0).value = no_of_payments;
			}
	}
}

function doFrequency(){
	var tenureopt = $('#tenure_option').val();
	if(tenureopt=='1'){
		$('#rep_nodays').get(0).value=0;
		if($("#loan_type").val()=='1'){
		$('#display_message').html('Tenure Option must be Monthly for Reducing Balance');
		$('#display_message').click();
		}
	}
	else if(tenureopt=='30'){
		$('#rep_nodays').get(0).value=30;
	}	
}

function monthsahead(noofmonths) {
    var today = new Date();
    var date = new Date(today.getYear(),today.getMonth() + noofmonths,today.getDate(),today.getHours(),today.getMinutes(),today.getSeconds());
    return date.getDate() + nths(date.getDate()) + ' ' + months[date.getMonth() + 1] + ' ' + y2k(date.getYear());
}

function daysahead(ddate,noofdays) {
    var pdate = ddate.split("-");
	var fullyear = pdate[0];
	var fullmonth = pdate[1];
	var fullday = pdate[2];
	var startdate = new Date ( fullyear, fullmonth-1, fullday-1 );
    var date = new Date(startdate.getFullYear(),startdate.getMonth(),startdate.getDate()+noofdays);
    return date.getYear() +'-'+(date.getMonth() + 1)+ '-' + date.getDate();
}

function showMatureDate(){
	var startdate = $('#checkin_date').val();
	//alert(startdate);
	var tenure = $('#tenure').val();
	//alert(tenure);
	var tenure_option = $('#tenure_option').val();
	//alert(tenure_option);
	if(tenure_option=='1') tenure = tenure * 1;
	else if(tenure_option=='30') tenure = tenure * 30;
	if(tenure!='' && startdate!=''){
	$.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=dateadd&startdate="+startdate+"&tenure="+tenure,
		   success: function(msg){ 
		   //alert(msg)
			 $('#maturity_date').html(msg);
			 $('#maturity_date_hid').get(0).value=msg;
		   } 
	  });	
	}
}

function fv(fc){
	$('#'+fc).formatCurrency();	
	if(fc=='amount'){
	}
}



function callpagesubmit(urlstr,divid){
var data = getdata();
//alert(data);

        $.ajax({
           type: "POST",
           url: urlstr,
           data: data,
           success: function(msg){
             //alert( "Data Saved: " + msg );
             //alert(msg);
             //$("#display_message").html(msg);
             //$("#display_message").show("fast");
            $('#'+divid).html(msg);
           }
         });
}

function getOtherAccounts(){
	var data = $('#acctno').val();
     //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getOtherAccounts&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split('/');
		var val_count = splitval.length;
		//alert(val_count);
			//$("#acctno2 *").attr("selected","selected");
			//$('#acctno2 option:selected').remove();
			$('#acctno2').empty()
			$('#loan_acname').get(0).value='';
			$('#loan_acno').get(0).value='';
		    for(var i=0; i<val_count; i++){
			if(splitval[i]=='')continue;
			var innerval = splitval[i].split('-');
			$("select[name='acctno2']").append(new Option(splitval[i], innerval[1]));
			}
	   } 
  });
}



function removecomma(inputString)
{
    var returnString = inputString.replace(/[,]/g,'');
    return returnString;
}

function pageloader2(str,divid) 
{ 
    $.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
	
	//alert(data);
	var data = getdata();
	$.unblockUI();
	if(str=='staff_payment.php'){
	$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
		var accountname = $('#acno').val();
		//alert(curbal);
	var totamt = parseFloat($('#totamt').val());
	//alert(totamt);
			if(accountname==""){
				alert(" Pls Select a valid account");
				$.unblockUI();
				return false;
				
			}
			$.unblockUI();
	}

	//alert(data);
	if(data!='error') {
	$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
	$.ajax({ 
	   type: "POST", 
	   url: str, 
	   data: data, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 $.unblockUI();
		 $('#'+divid).html(msg);
		 //$("#display_message").fadeIn("slow");
	   } 
	 });
	}
}

function getSalaryAcinfo(){
	var data = $('#acctno').val();
    // alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerAccount&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		if(msg!=''){
		var splitval = msg.split(',');
		          $("#span_acname").html(splitval[1]);
				  $("#acname").get(0).value = splitval[1];
		          $("#span_acno").html(splitval[0]);
				  $("#acno").get(0).value = splitval[0];
                  $("#span_curbal").html(splitval[2]);
				  $("#curbal").get(0).value = splitval[2];
		 //$("#display_message").show("fast");
		}
		else{
			$("#span_acname").html("");
				  $("#acname").get(0).value = "";
		          $("#span_acno").html("");
				  $("#acno").get(0).value = "";
                  $("#span_curbal").html("");
				   $("#curbal").get(0).value = "";
		}
	   } 
  });
}

function callpagepost_staff(page,opt,returnpage,divid){
	 //disable_id();
	$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
	
var data = getdata();
//alert(page);
//alert(data);
$.unblockUI();

var poststatus = false;
//alert($("#require_auth").val());
	if(data!='error') {
	  $.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
		/*$("#display_message").ajaxStart(function(){
			//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
			$("#display_message").html('<img src="images/loading.gif" alt="" />loading please wait . . .');
		});*/
		
			var ans = confirm("are you sure you want to continue this transaction . . .");
			if(ans==true){
				poststatus = true;
			}else{
				poststatus = false;
			}
		
		//alert(poststatus);
		if(poststatus==true){
var data = getdata();
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op="+page+"&"+data, 
		   success: function(msg){ 
			 //alert( "Data Saved: " + msg ); 
			//alert(msg);
			 //$("#display_message").html(msg);
			 //$("#display_message").show("fast");
			 $("#responsedata").get(0).value = msg;
			 //alert(msg);
			 $.unblockUI();
			 pageloader(returnpage,divid);
			  
		   } 
		 });
		} // end poststatus
	}
	//$.unblockUI();
	//enable_id();
}


//Get Customer Loan Account
function getCustomerLoanAccount22(LNC){
	var data = $('#acctno2').val();
     //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerAccount&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split(',');
				  $("#loan_acname").get(0).value = splitval[1];
				  $("#loan_acno").get(0).value = splitval[0];
				  //alert(splitval[6]);
				  if(undefined !=splitval[6]){
				  $("#loan_int").get(0).value = splitval[6];
				  }
				 // getCustomerLoanfee22(LNC);
				  $("#subbtn").attr('disabled',false);
		          $("#disp").html("");
		 //$("#display_message").show("fast");
	   } 
  });
}


function checkloan_status(){
	var data = $('#acctno2').val();
    //alert(data);
	var data2 = ""
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getloanstatus&acno="+data,
	   success: function(msg){ 
		 data2 = msg
		if(msg>=1){
			alert(" Loan Booking already exist it is either Running , Expired or not yet Authorized");
			$("#disp").html(" Pls check Loan Booking it is either Running , Expired or not yet Authorized ");
			$("#subbtn").attr('disabled','disabled');
		}
	   } 
  });
   return data2;
}






//Get Customer Account
function getCustomerLoanfee22(loanaccno){
	var data = loanaccno; //$('#loan_acno').val();
    //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "loan_fees22.php", 
	   data: "op=getCustomerfee&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		//var resultval = msg.split("/");
		  //        $("#loan_fee").val(resultval[0]);
			//	  $("#dfee").html(resultval[1]);
				 
		 $("#loanfeediv").html(msg);
	   } 
  });
}

function gettillsum()
{
 var Total = 0;
$("input[id^='amount[']").each(function() { Total += parseFloat(removecomma($('#repay_principal').val())); });
$("#total").val(Total);

}



function  flagaccount(flag_acno){
	var data = flag_acno; //$('#loan_acno').val();
    //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerflag&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		//var resultval = msg.split("/");
		  //        $("#loan_fee").val(resultval[0]);
			//	  $("#dfee").html(resultval[1]);	 
		 $("#display_message").html(msg);
			 $("#display_message").show("fast");
			 $("#display_message").click();
	   } 
  });
}


function  checkExist(){
	var checkname = $('#accname').val(); //$('#loan_acno').val();
    //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "verifyaccname.php", 
	   data: "checkname="+checkname,
	   success: function(msg){ 
		if(msg==1){
		 $("#checkex").html("");
		 $("#submit").attr('disabled',false);
		}
		else {
			 $("#checkex").html(msg);
			$("#submit").attr('disabled','disabled');
		}
			
	   } 
  });
}

$('#pageDemo4').click(function() { 
            $.blockUI({ message: $('#domMessage') }); 
            test(); 
        }); 





function getpageload(str,divid) 
{ 
var data = $('#account_search').val();
//alert(data);

			if(str!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str+"?check1="+data, 
			  // data: "check1="+data, 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				// alert(msg);
				 $('#'+divid).html(msg);
			   } 
			 });
			
			}// end if
}



function getpage_search(str,divid) 
{ 
//$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
//alert(str);
	var data = getdata();
	//alert(data);
	//alert(str);
			/*
			
			$(divid).ajaxStart(function(){
			$(divid).html('');
			$(divid).html('<img src="images/loading.gif" alt="" />loading please wait . . .');
			});
			*/
			if(str!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str+"?data="+data, 
			   data: '', 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				// alert(msg);
				 $('#'+divid).html(msg);
				 //$("#display_message").fadeIn("slow");
				 //$.unblockUI();
			   } 
			 });
			/*	
			 $(divid).ajaxComplete(function(){ 
				$(divid).html(""); 
			 });
			*/
			}// end if
}


function loadfiltermore(ch){
	//var data = escape($('#act_tra').val());
	var data = ch;
	//alert(data);
	var data2 = escape($('#actype').val());
	//var data3 = escape($('#all').val());
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getnonexfiltermore&filter="+data2+"&check="+data, 
	   success: function(msg){ 
		//alert( "Data Saved: " + msg ); 
		 //alert(data);
		 $("#exist_acct").html(msg);
		 //$("#display_message").show("fast");
	   } 
  });
   // for existing roles 
}

function getpageload_post(str,divid) 
{ 
var data =  $('#cus').val();
//alert(data);

			if(str!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str+"?cus="+data, 
			   //data: data, 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				 //alert(msg);
				 $('#'+divid).html(msg);
			   } 
			 });
			
			}// end if
}

function getpageload_post2(str,divid,str2) 
{ 
var data =  $('#cus').val();
//alert(data);

			if(str2!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str2+"?cus="+data, 
			   //data: data, 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				getpageload_post3(str,divid,msg);
				 //$('#'+divid).html(msg);
			   } 
			 });
			
			}// end if
}

function getpageload_post3(str,divid,msg2) 
{ 
//var data =  $('cus').val();
//alert(msg2);

			if(str!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str+"?search="+msg2, 
			   //data: data, 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				 //alert(divid);
				 //alert(msg);
				 $('#'+divid).html(msg);
			   } 
			 });
			
			}// end if
}


//Get Customer Account
function getCustomerAccountloan(){
	var data = $('#acctno').val();
     //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerAccountloan&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split(',');
		          $("#span_acname").html(splitval[1]);
				  $("#acname").get(0).value = splitval[1];
		          $("#span_acno").html(splitval[0]);
				  $("#acno").get(0).value = splitval[0];
                  $("#span_curbal").html(splitval[2]);
				  $("#curbal").get(0).value = splitval[2];
				  $("#acid").get(0).value = splitval[3];
				  $("#gl_type").get(0).value = splitval[4];
				   $("#span_act").html(splitval[5]);
				 /* if(splitval[5] != ""){
				   $("#particulars").get(0).value = splitval[5];
				   var data2 = "<input type='text'  name='agent' id='agent' size='50' value='"+splitval[5]+"'>" ;
				   $("#account_officer_show").html(data2);
				  }
				  else {
				    $("#particulars").get(0).value = "";
					var data_2 = $('#hideout').val();
					//alert(data_2);
					var data2 = "<select  name='agent' id='agent'>"+data_2+"</select>";
					$("#account_officer_show").html(data2);
				  }*/
		 //$("#display_message").show("fast");
	   } 
  });
}




function doSearch_bal(url){
	var data = $('#account_no').val();
     //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerAccountloan&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split(',');
		          $("#span_acname").html(splitval[1]);
				//  $("#acname").get(0).value = splitval[1];
		        //  $("#span_acno").html(splitval[0]);
				//  $("#acno").get(0).value = splitval[0];
                 // $("#span_curbal").html(splitval[2]);
				//  $("#curbal").get(0).value = splitval[2];
				//  $("#acid").get(0).value = splitval[3];
				//  $("#gl_type").get(0).value = splitval[4];
				//  if(splitval[5] != ""){
				//   $("#particulars").get(0).value = splitval[5];
				//  }
				   $("#span_bal1").html(splitval[2]);
				    $("#span_bal2").html(splitval[2]);
		 //$("#display_message").show("fast");
	   } 
  });
	
}


function pageloader_bulk(str,divid) 
{ 
	var data = getdata();
	if(str=='bulk_payment_verify.php'){
		var amount = parseFloat($('#amount').val());
		var balance = parseFloat($('#from_balance').val());
		var bal_limit = parseFloat($('#from_balance_limit').val());
			//alert(amount+'  '+balance+'  '+bal_limit);
		if(amount > (balance-bal_limit)){
			//$("#display_message").html("please ensure total amount is not greater than <br> account balance less balance limit");
			//$("#display_message").show("slow");
			//data = 'error';
		}
	}
	
	//alert(data);
	if(data!='error') {
	$.ajax({ 
	   type: "POST", 
	   url: str, 
	   data: data, 
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		 //alert(msg);
		 $('#'+divid).html(msg);
		 //$("#display_message").fadeIn("slow");
	   } 
	 });
	}
}



function updateacct(loan_no,repay_no){

alert(loan_no);
alert(repay_no);
$.ajax({ 
   type: "POST", 
   url: "utilities.php", 
   data: "op=getUpdate_loan&loan_no="+loan_no+"&repay_no="+repay_no, 
   success: function(msg){ 
    alert( "Data Saved: " + msg ); 
	 
   } 
 });

}

function flagcheck(staffid,setup,ty){

//alert(staffid);
//alert(setup);
//alert(ty);
$.ajax({ 
   type: "POST", 
   url: "utilities.php", 
   data: "op=getflagcheck&staffid="+staffid+"&setup="+setup+"&ty="+ty, 
   success: function(msg){ 
    //alert(msg); 
	 
   } 
 });

}


function getOtherAccounts_forloans(){
	var data = $('#acctno').val();
     //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getOtherAccounts_forloans&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split('/');
		var val_count = splitval.length;
		//alert(val_count);
			//$("#acctno2 *").attr("selected","selected");
			//$('#acctno2 option:selected').remove();
			$('#acctno2').empty()
			$('#loan_acname').get(0).value='';
			$('#loan_acno').get(0).value='';
		    for(var i=0; i<val_count; i++){
			if(splitval[i]=='')continue;
			var innerval = splitval[i].split('-');
			//alert(innerval[0]); alert(innerval[1])
			$("select[name='acctno2']").append(new Option(innerval[0],innerval[1]));
			}
	   } 
  });
}

function getaccount_officer(){
	var data = $('#acno').val();
	//var data2 = $('#acno2').val();
	//var check = $('#checkbox').val();
	//alert(data);
	//alert(data2);
	//alert(check);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getaccount_officer&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split(',');
		 $("#acname").get(0).value = splitval[0];
		  $("#acofficer").get(0).value = splitval[1];
		 //$("#display_message").show("fast");
	   } 
  });
}


function getaccount1(){
	var data = escape($('#acno').val());
	//var data2 = $('#acno2').val();
	//var check = $('#checkbox').val();
	//alert(data);
	//alert(data2);
	//alert(check);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getaccount_officer&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split(',');
		 $("#acname").get(0).value = splitval[0];
		  //$("#acofficer").get(0).value = splitval[1];
		 //$("#display_message").show("fast");
	   } 
  });
}


function updateloanofficer(loan_no,loan_officer){
//alert(loan_no);
//alert(loan_officer);
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
$.ajax({ 
   type: "POST", 
   url: "utilities.php", 
   data: "op=updateloanofficer&loan_no="+loan_no+"&loan_officer="+loan_officer, 
   success: function(msg){ 
   // alert( "Data Saved: " + msg );
	//getpage('loan_payment_rpt2.php','page');
	$.unblockUI();
   } 
 });

}

function geteodstatus(){
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=geteodstatus",
	   success: function(msg){ 
		//alert(msg);
		if(msg==1){
		 add_data = "<center><blink><font color='red' size='4'> You will be logged out in a few moment </font></blink></center>";
		$('#smoothmenu1').append(add_data);
		 $("#eodst").get(0).value = msg;
		}
	   } 
  });
}


function resetstatus(){
	var data = $('#eodst').val();
	if(data==1){
		//alert("Yes");
	var add_data = "<center><blink><font color='red' size='4'> You will be logged out in a few moment </font></blink></center>";
	$('#smoothmenu1').remove(add_data);
	}

}

function lockusers(){
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=lockusers",
	   success: function(msg){ 
		//alert(msg);
		if(msg==1){
		$('input[name=check1]').attr('checked', true);
		}
		else {
			$('input[name=check1]').attr('checked', false);
		}
	   } 
  });
}

function readtabledata(tableId, fil)
{
	
	//alert('Starting...');
	var tabl = document.getElementById(tableId);
	var l = tabl.rows.length;
	//alert( 'Number of table rows: ' + l );
	var s = '';
	for ( var i = 0; i < l; i++ )
	{
	var tr = tabl.rows[i];
	var tr_cols = tr.childNodes;
	var tr_cols_len = tr_cols.length;
		
		var data = '';
		var alldata = '';
		// Read the content of each td
		for( var j=0; j < tr_cols_len; j++){
		var cll = tr.childNodes[j];
		var ct = cll.innerHTML; 
		ct= jQuery.trim(ct);//.replace( /<[^<>]+>/g, '' );
		if(ct=='') continue;
		if(ct!=undefined)data = ct+"@";
		alldata = alldata + data;
		//alert(alldata.length);
		}
		alldata = alldata.substr(0,alldata.length-1);
		s += alldata + "|";
	}
	/*var schl = $("#school").val();
	var acyr = $("#academicyear").val();
	var subj = $("#subject").val();*/
	//var fil = acyr+'-'+schl+'-'+subj+'.xls';
	s = s.substr(0,s.length-1);
	//s = escape(s);
	//alert('result:\n' + s);
	$('#data').get(0).value = s;
	$('#datafilename').get(0).value = fil;
	$("#form1").attr("action","generateexcel2.php");
	$("#form1").attr("target","_blank");
	$("#form1").submit();
	
	
	/*$.ajax({ 
		   type: "POST", 
		   url: "generateexcel.php", 
		   data: "datafilename="+fil+"&dattta="+s, 
		   success: function(msg){ 
			 //alert( "Data Saved: " + msg ); 
			 //alert(msg);
			// $("#exammno").html(msg);
			 //$("#stud").show("fast");
					 //$("#subbtn").click();				 		
		   } 
		 });*/
	
	//window.open("generateexcel.php?datafilename="+fil+"&data="+s);
	
	
	
	
	
	/*$("#"+tableId).table2csv({ callback: function (csv) {
			//alert('result:\n' + csv);
			$("#data").get(0).value = csv;
			$('#datafilename').get(0).value = fil;
			$("#form1").attr('action','generateexcel.php');
			$("#form1").attr('target','_blank');
			$("#form1").submit();
			}
	});*/
}


function readtabledata2(tableId, fil)
{
	
	//alert('Starting...');
	var tabl = document.getElementById(tableId);
	var l = tabl.rows.length;
	//alert( 'Number of table rows: ' + l );
	var s = '';
	for ( var i = 0; i < l; i++ )
	{
	var tr = tabl.rows[i];
	var tr_cols = tr.childNodes;
	var tr_cols_len = tr_cols.length;
		
		var data = '';
		var alldata = '';
		// Read the content of each td
		for( var j=0; j < tr_cols_len; j++){
		var cll = tr.childNodes[j];
		var ct = cll.innerHTML; 
		ct= jQuery.trim(ct);//.replace( /<[^<>]+>/g, '' );
		if(ct=='') continue;
		if(ct!=undefined)data = ct+"@";
		alldata = alldata + data;
		//alert(alldata.length);
		}
		alldata = alldata.substr(0,alldata.length-1);
		s += alldata + "|";
	}
	/*var schl = $("#school").val();
	var acyr = $("#academicyear").val();
	var subj = $("#subject").val();*/
	//var fil = acyr+'-'+schl+'-'+subj+'.xls';
	s = s.substr(0,s.length-1);
	//s = escape(s);
	//alert('result:\n' + s);
	$('#data').get(0).value = s;
	$('#datafilename').get(0).value = fil;
	$("#form1").attr("action","generateexcel3.php");
	$("#form1").attr("target","_blank");
	$("#form1").submit();
	
	
}

function readtabledata3(tableId, fil)
{
	
	//alert('Starting...');
	var tabl = document.getElementById(tableId);
	var l = tabl.rows.length;
	//alert( 'Number of table rows: ' + l );
	var s = '';
	for ( var i = 0; i < l; i++ )
	{
	var tr = tabl.rows[i];
	var tr_cols = tr.childNodes;
	var tr_cols_len = tr_cols.length;
		
		var data = '';
		var alldata = '';
		// Read the content of each td
		for( var j=0; j < tr_cols_len; j++){
		var cll = tr.childNodes[j];
		var ct = cll.innerHTML; 
		ct= jQuery.trim(ct);//.replace( /<[^<>]+>/g, '' );
		if(ct=='') continue;
		if(ct!=undefined)data = ct+"@";
		alldata = alldata + data;
		//alert(alldata.length);
		}
		alldata = alldata.substr(0,alldata.length-1);
		s += alldata + "|";
	}
	/*var schl = $("#school").val();
	var acyr = $("#academicyear").val();
	var subj = $("#subject").val();*/
	//var fil = acyr+'-'+schl+'-'+subj+'.xls';
	s = s.substr(0,s.length-1);
	//s = escape(s);
	//alert('result:\n' + s);
	$('#data').get(0).value = s;
	$('#datafilename').get(0).value = fil;
	$("#form1").attr("action","generateexcel4.php");
	$("#form1").attr("target","_blank");
	$("#form1").submit();
	
	
}


function readtabledata4(tableId, fil,genexel)
{
	
	//alert('Starting...');
	var tabl = document.getElementById(tableId);
	var l = tabl.rows.length;
	//alert( 'Number of table rows: ' + l );
	var s = '';
	for ( var i = 0; i < l; i++ )
	{
	var tr = tabl.rows[i];
	var tr_cols = tr.childNodes;
	var tr_cols_len = tr_cols.length;
		
		var data = '';
		var alldata = '';
		// Read the content of each td
		for( var j=0; j < tr_cols_len; j++){
		var cll = tr.childNodes[j];
		var ct = cll.innerHTML; 
		ct= jQuery.trim(ct);//.replace( /<[^<>]+>/g, '' );
		if(ct=='') continue;
		if(ct!=undefined)data = ct+"@";
		alldata = alldata + data;
		//alert(alldata.length);
		}
		alldata = alldata.substr(0,alldata.length-1);
		s += alldata + "|";
	}
	/*var schl = $("#school").val();
	var acyr = $("#academicyear").val();
	var subj = $("#subject").val();*/
	//var fil = acyr+'-'+schl+'-'+subj+'.xls';
	s = s.substr(0,s.length-1);
	//s = escape(s);
	//alert('result:\n' + s);
	$('#data').get(0).value = s;
	$('#datafilename').get(0).value = fil;
	$("#form1").attr("action",genexel);
	$("#form1").attr("target","_blank");
	$("#form1").submit();
	
	
}



jQuery.fn.cleanWhitespace = function() {
    textNodes = this.contents().filter(
        function() { return (this.nodeType == 3 && !/\S/.test(this.nodeValue)); })
        .remove();
}

function changespan(){
	var upper =  $(".upper") .text();
	//alert(upper);
	if(upper=="Debit"){
		upper = "Credit";
	   var lower = "Debit";
	$(".upper").html(upper);
	$(".lower").html(lower);
	} else {
		//alert("Yes");
		 upper = "Debit";
		 //alert(upper);
		var lower = "Credit";
	    $(".upper").html(upper);
		$(".lower").html(lower);
	}
}


function link_together(str,divid){
	$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
//alert(str);
	var data = "";
	
			if(str!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str+"?data="+data, 
			   data: '', 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				// alert(msg);
				 $('#'+divid).html(msg);
				// $("#display_message").fadeIn("slow");
				 $.unblockUI();
			   } 
			 });
			
			}// end if
}



//Get Customer Account
function getCustomerOverdraft(){
	var data = $('#acctno').val();
     //alert(data);
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getCustomerAccountloan&acno="+data,
	   success: function(msg){ 
		 //alert( "Data Saved: " + msg ); 
		//alert(msg);
		var splitval = msg.split(',');
		          $("#span_acname").html(splitval[1]);
				  $("#acname").get(0).value = splitval[1];
		          $("#span_acno").html(splitval[0]);
				  $("#acno").get(0).value = splitval[0];
                  $("#span_curbal").html(splitval[2]);
				  $("#curbal").get(0).value = splitval[2];
				  $("#acid").get(0).value = splitval[3];
				  $("#gl_type").get(0).value = splitval[4];
				  /*if(splitval[5] != ""){
				   $("#particulars").get(0).value = splitval[5];
				   var data2 = "<input type='text'  name='agent' id='agent' size='50' value='"+splitval[5]+"'>" ;
				   $("#account_officer_show").html(data2);
				  }
				  else {
				    $("#particulars").get(0).value = "";
					var data_2 = $('#hideout').val();
					//alert(data_2);
					var data2 = "<select  name='agent' id='agent'>"+data_2+"</select>";
					$("#account_officer_show").html(data2);
				  }*/
		 //$("#display_message").show("fast");
	   } 
  });
}

function checkdetails(){
	var sumtotal = parseFloat($('#total').val());
	var amt = parseFloat($('#amount').val());
		if((amt==sumtotal)&&(sumtotal>0)&&(!isNaN(amt))){
				$("#subbtn").attr('disabled', false);
	  }else{
			 $("#subbtn").attr('disabled','disabled');
	  }
	
}
	
	
	function getdialog(getdetails){
		//alert(getdetails);
	 $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op=getloanhistory&acno="+getdetails,
	   success: function(msg){ 
	   var spp = msg.split('KKK');
		var info="<p id=\"validateTips\">Loan the Details for "+spp[1]+".</p>";
		
		var splitval = spp[0].split('|');
		
		for (i = 0; i < splitval.length; i++){
			if(splitval[i]!=""){
			info +="<fieldset style=\"padding:0; border:0; width:600px;\">";
			var split2 = splitval[i].split('/');
info +="Loan Amount<input type=\"text\" value='"+split2[0]+"' name=\"qitem\" id=\"qitem\""+ 
"class=\"text ui-widget-content ui-corner-all\" />";
info +=	"  Start Date<input type=\"text\" value='"+split2[1]+"' name=\"qty\" id=\"qty\""+ 
"class=\"text ui-widget-content ui-corner-all\" />"; 
info +=   "  End Date<input type=\"text\" value='"+split2[2]+"' name=\"ap\" id=\"ap\""+
"class=\"text ui-widget-content ui-corner-all\" />";
		info+="</fieldset>";
			}
		}
		
		    $('#dialog2').html(info);
			$('#dialog2').dialog('open');
			
			$(function() {
		
			var qitem = $("#qitem"),
			qty = $("#qty"),
			ap = $("#ap"),
			tips = $("#validateTips");

		function updateTips(t) {
			tips.text(t).effect("highlight",{},1500);
		}


		
				$("#dialog2").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 800,
					modal: true,
					buttons: {
						OK: function() {
							$(this).dialog('close');
						}
					},
				});
		

			});
	   } 
  });	
		
		
	 
			
			
}



function callpagefunction(urlstr){
var data = urlstr;
//alert(data);
var url2 = 'html2pdf/samples/sample.simplest.php';
//alert(data);

        $.ajax({
           type: "POST",
           url: url2,
           data: "datastr="+data,
           success: function(msg){
           }
         });
}
	
	
	
	
function doSearchpdf(url){
	// $.blockUI({ message: "<img src='images/ajax-loader.gif' /> " }); 
	var data = getdata();
	//alert(data);
	 var data2 = $('#karray').val();
	 //alert(data2);
	getpage(url+'?'+data+"&data2="+data2,'page');
	//$.unblockUI();
	
	
	
	//calldialogUnblock(loadingScreen);
	
}

function moracheck(){
	var morac = $("#mora").val();
	//alert(morac);
	if(morac=='1'){
		$("#morat").show();
		
	}if(morac=='0'){
		$("#morat").hide();
	}
}

function getdata2(){
	var data = "";
	$("#form1").serialize();
	$.each($("input, select, textarea"), function(i,v) {
    var theTag = v.tagName;
    var theElement = $(v);
	var theName = theElement.attr('name');
	if((theName=="check_del2")||(theName=="check_del")){
	}
	else {
    var theValue = escape(theElement.val());
	var classname = theElement.attr('class');
	//alert('name : '+theName+"   value :"+theValue+"  class :"+classname);
	
	if(classname=='required-text'){
		if(!check_textvalues(theElement)) data = "error";
	}
	if(classname=='required-number'){
		if(!check_numbers(theElement)) data = "error";
	}
	if(classname=='currency'){
		theValue = removecomma(theElement.val());
		if(theValue=="" || theValue==0) { data = "error";
		$("#display_message").html('please enter number for '+theElement.attr('title'));
			$("#display_message").show('fast');
			theElement.focus();
			$("#display_message").click();
			return false;
		}
		else
		if(isNaN(theValue)) { data = "error";
		$("#display_message").html('please enter number for '+theElement.attr('title'));
			$("#display_message").show('fast');
			theElement.focus();
			$("#display_message").click();
			return false;
		}
	}
	if(classname=='required-email'){
		if(!check_email(theElement)) data = "error";
		
	}
	if(classname=='required-alphanumeric'){
		if(!check_password_aplhanumeric(theElement)) data = "error";
	}
	if(data!='error'){
		data = data+theName+"="+theValue+"&";
	} }
	});
	
	//alert(data);
	return data;
}


function goFirst2(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(fpage!=1){
		$("#fpage").get(0).value = '1';
		$("#pageNo").get(0).value = 1;
		doSearchsp(dpage);
	}else{
		return false;
	}

}

function goLast2(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(lpage!=fpage){
		$("#fpage").get(0).value = lpage;
		$("#pageNo").get(0).value = lpage;
		doSearchsp(dpage);
	}else{
		return false;
	}

}
function goPrevious2(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if(fpage !=1){
		$("#fpage").get(0).value = fpage-1;
		$("#pageNo").get(0).value = fpage-1;
		doSearchsp(dpage);
	}else{
		return false;
	}

}

function goNext2(dpage){
	var lpage = parseInt($("#tpages").val());
	var fpage = parseInt($("#fpage").val());
	if((lpage > fpage)){
		$("#fpage").get(0).value = fpage+1;
		$("#pageNo").get(0).value = fpage+1;
		doSearchsp(dpage);
	}else{
		return false;
	}

}

function loadpageload(){
	//$("#display_message").html('<img src="images/loading.gif" alt="" />loading please wait '+displaymsg+' . . .');
	$.blockUI({ message: "<img src='images/ajax-loader.gif' /> Processing End of Day... " }); 
	$.unblockUI();
	//$.unblockUI();
}

function loadpageload2(){
	//$("#display_message").html('<img src="images/loading.gif" alt="" />loading please wait '+displaymsg+' . . .');
	$.blockUI({ message: "<img src='images/ajax-loader.gif' /> End of Day processing Terminated Pls run End of Month... " }); 
	$.unblockUI();
	//$.unblockUI();
}

function eoy(eoy){
   $.ajax({ 
	   type: "POST", 
	   url: "utilities.php", 
	   data: "op="+eoy,
	   success: function(msg){ 
		//alert(msg);
		if(msg==1){
			if(eoy=='eoy'){
		$('input[name=check2]').attr('checked', true);
			}
			 else{
				 $('input[name=check22]').attr('checked', true);
			 }
		}
		else {
			if(eoy=='eoy'){
			$('input[name=check2]').attr('checked', false);
			}else{
				$('input[name=check22]').attr('checked', false);
			}
		}
	   } 
  });
}


function togglepage(glcode,str,divid) 
{ 
var data = $('#report_code').val();
var data2 = $('#opd').val();
//alert(glcode);
//alert(data);
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
			if(str!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str, 
			  data: "glcode="+glcode+"&headcode="+data+"&oper="+data2, 
			   success: function(msg){ 
				 $('#'+divid).html(msg);
				 $.unblockUI();
			   } 
			 });
			$.unblockUI();
			}// end if
}


function togglepage2(str,divid) 
{ 
var data = $('#report_code').val();
var data2 = $('#opd').val();
//alert(glcode);
//alert(data);
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
			if(str!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str, 
			  data: "headcode2="+data+"&oper="+data2, 
			   success: function(msg){ 
				 $('#'+divid).html(msg);
				 $.unblockUI();
			   } 
			 });
			$.unblockUI();
			}// end if
}


function getpagedelete(str,username,divid) 
{ 
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
//alert(str);
//alert(str);
    var ans = confirm(" Are you sure you want to delete  "+username+" ?");
			if(ans==true){
				poststatus = true;
			
		
				if(str!='#'){
					$.ajax({ 
					   type: "POST", 
					   url: str, 
					   data: '', 
					   success: function(msg){ 
						 //alert( "Data Saved: " + msg ); 
						// alert(msg);
						 $('#'+divid).html(msg);
						 //$("#display_message").fadeIn("slow");
						 $.unblockUI();
					   } 
					 });
					$.unblockUI();
					}// end if
					
			 }else{
				$.unblockUI();
			 }
 }
 
 
 function importExcel(){
	var str = $("#exfilename").val();
	var reg_no = $("#reg_no").val();
	//alert(str);
	
	$.blockUI({ message:'<img src="images/loading.gif" alt=""/><br />Extracting File to Database . . .'});
	$.ajax({ 
			   type: "POST", 
			   url: "utilities.php", 
		   	   data: "op=doImportExcel&str="+str+"&reg_no="+reg_no , 
		    	
			   success: function(msg){
				 //alert( "Data Saved: " + msg ); 
				 //alert(msg);
				 if(msg==1){
				// $("#display_message").html("Upload Successfull");
				// $("#display_message").show("fast"); 
				 //getpage('excel_ipload.php?excelid='+reg_no,'content'); 
				     $.ajax({ 
	   					type: "POST", 
					   	url: "excel_ipload.php", 
					  	data: "excelid="+reg_no,
					 	 success: function(msg){
							 
						 var sp = msg.split('|');	 
						 var add_data = sp[0];
						  
						  $('#beneficiary_div').append(add_data);
						  var dat = parseFloat(sp[1]);
						  var total = parseFloat($('#total').val());
						   var sumtotal = (total+dat).toFixed(2);
							//alert(sumtotal);
							 $('#add_ben').get(0).value="";
							 $('#add_amount').get(0).value="";
							 $('#total').get(0).value=sumtotal;
							var amt = parseFloat($('#amount').val());
							if((amt==sumtotal)&&(sumtotal>0)&&(!isNaN(amt))){
									$("#subbtn").attr('disabled', false);
									
							}else{
								 $("#subbtn").attr('disabled','disabled');
								  }
							 $.unblockUI();	  
						   } 
					  });
						  
				 }else{
				 $("#display_message").html(msg);
				 $("#display_message").show("fast");
				 //getpage('set_up_list_auth.php','content');
				 }
				 $.unblockUI();
				 //$("#display_message").html("");
			   } 
			 });
	
	
	}
	
	
	function getBulkOption(val){
		if(val=="2"){
			$("#import_ex").hide();
			$("#disp1").show("fast");
			$("#disp2").show("fast");
			$("#disp3").show("fast");
		}
		else if(val=="1"){
			$("#import_ex").show("fast");
			$("#disp1").hide();
			$("#disp2").hide();
			$("#disp3").hide();
		}
	}
	
	function calculateLoan(){
 //disable_id();
 var 	page = 'calculate_loan';
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });	
var data = getdata();
//alert(data);
	if(data!='error') {
		$("#display_message").ajaxStart(function(){
			//$('#error_label_login').css({background-image: "url(../images/progress_bar.gif)"});
			$("#display_message").html('<img src="images/loading.gif" alt="" />loading please wait . . .');
		});

		$.ajax({ 
		   type: "POST", 
		   url: "utilities.php", 
		   data: "op="+page+"&"+data, 
		   success: function(msg){ 
			 //alert( "Data Saved: " + msg ); 
			 //alert(msg);
			 $("#show_calc").html(msg);
			 $("#show_calc").show("fast");
			//$("#show_calc").click();	
			
		   } 
		 });
		
	}
	$.unblockUI();
	enable_id();
}


function getpage10(str,divid) 
{ 
$.blockUI({ message: "<img src='images/ajax-loader.gif' /> &nbsp; &nbsp;&nbsp;   <font size='2'><b> Loading please wait...</b></font>" });
//alert(str);
//alert(str);
	var data = getdata();
	//alert(data);
			/*
			
			$(divid).ajaxStart(function(){
			$(divid).html('');
			$(divid).html('<img src="images/loading.gif" alt="" />loading please wait . . .');
			});
			*/	if(str!='#'){
			$.ajax({ 
			   type: "POST", 
			   url: str, 
			   data: '', 
			   success: function(msg){ 
				 //alert( "Data Saved: " + msg ); 
				// alert(msg);
				 $('#'+divid).html(msg);
				 //$("#display_message").fadeIn("slow");
				 $.unblockUI();
			   } 
			 });
			
			}// end if
			//$.unblockUI();
}

function doSearch10(url){
	 $.blockUI({ message: "<img src='images/ajax-loader.gif' /> " }); 
	//alert(url);
	//calldialogBlock(loadingScreen);
	//$.loading({onAjax:true,mask:true});

	//waitingDialog({title: "Hi", message: "I'm loading..."});
	//$("#loadingScreen").block();
	//waitingDialog({title: "Please wait", message: "I'm loading..."});
	//closeWaitingDialog();
	//alert('Got here');
	//$("#form1").submit();
	//if($("#keyword").val()!=""){$("#pageNo").get(0).value = 1;}
	var data = getdata();
	//alert("@ Search : "+data);
	//loadpage('branch_list.php',data,'page');
	//$("#loadingScreen").unblock();
	 
	getpage(url+data,'page');
	//$.unblockUI();
	
	//calldialogUnblock(loadingScreen);
	
}


function doSearchrepayloan(url){
	 $.blockUI({ message: "<img src='images/ajax-loader.gif' /> " }); 
	var store_repay = $("#st_val").val();
	//alert(data);
	getpage(url+'?repay='+store_repay,'page');
	$.unblockUI();
	
	//calldialogUnblock(loadingScreen);
	
}

function runloanstatus(){
	var curbal = parseFloat($("#curbal").val());
	var acctno2 = $('#acctno2').val();
	var acno = $('#acno').val();
	var spacno = acctno2.split("_");
	
	var loan_amt = parseFloat(removecomma($('#loan_amt').val()));
	//alert(loan_amt);
	//alert(curbal);
	if(spacno[1]=='30'){
		if(loan_amt>curbal){
			//alert("yes");
			$("#loan_int").get(0).value = 10;
			$("#rate_spec").get(0).value = 12;
			
		}else {
			//alert("Nope");
			$("#loan_int").get(0).value = 7.5;
			$("#rate_spec").get(0).value = 12;
		}
	}else if(spacno[1]=='34'){
			$("#loan_int").get(0).value = 4;
			$("#rate_spec").get(0).value = 1;
			
	}else if(spacno[1]=='33'){
		
			$("#loan_int").get(0).value = 5;
			$("#rate_spec").get(0).value = 1;
	}
	else if(spacno[1]=='31'){
		
			$("#loan_int").get(0).value = 10+5;
			$("#rate_spec").get(0).value = 12;
	}
	
}