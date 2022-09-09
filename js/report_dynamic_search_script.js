//Getting value from "ajax.php".

function fill(thecontrol,Value) {

   //Assigning value to "search" div in "search.php" file.

   $('#'+thecontrol).val(Value);
   //$('#keyword').val()Value;
	//var keyword = document.getElementById("keyword");
	//var get_file = $('#get_file').val();
	//keyword.value = Value;
   //Hiding "display" div in "search.php" file.
	
   $('#'+thecontrol+'display').hide();
	
	//var $form_keyword = $('#keyword').val();
	//getpage(get_file+'.php?op=searchkeyword&keyword='+$form_keyword,'page');
}

function suggestentry(thecontrol,thesource)
{
	      //Assigning search box value to javascript variable named as "name".

       var name = $('#'+thecontrol).val();
	   var tablename = thesource;
	   var thecontrol = thecontrol;
       //Validating, if "name" is empty.

       if (name == "") {

           //Assigning empty value to "display" div in "search.php" file.

           $("#"+thecontrol+"display").html("");

       }

       //If name is not empty.

       else {

           //AJAX is called.

           $.ajax({

               //AJAX type is "Post".

               type: "POST",

               //Data will be sent to "ajax.php".

               url: "report_ajax.php",

               //Data, that will be sent to "ajax.php".

               data: {

                   //Assigning value of "name" into "search" variable.

                   search: name,thetablename: tablename,thecontrol: thecontrol

               },

               //If result found, this funtion will be called.

               success: function(html) {

                   //Assigning result to "display" div in "search.php" file.

                   $("#"+thecontrol+"display").html(html).show();

               }

           });

       }
}
