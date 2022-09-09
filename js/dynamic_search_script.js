//Getting value from "ajax.php".

function fill(Value) {

   //Assigning value to "search" div in "search.php" file.

   $('#search').val(Value);
   //$('#keyword').val()Value;
	var keyword = document.getElementById("keyword");
	var get_file = $('#get_file').val();
	keyword.value = Value;
   //Hiding "display" div in "search.php" file.
	
   $('#display').hide();
	
	var $form_keyword = $('#keyword').val();
	getpage(get_file+'.php?op=searchkeyword&keyword='+$form_keyword,'page');
}

$(document).ready(function() {

   //On pressing a key on "Search box" in "search.php" file. This function will be called.

   $("#search").keyup(function() {

       //Assigning search box value to javascript variable named as "name".

       var name = $('#search').val();
	   var tablename = $('#thetablename').val();
       //Validating, if "name" is empty.

       if (name == "") {

           //Assigning empty value to "display" div in "search.php" file.

           $("#display").html("");

       }

       //If name is not empty.

       else {

           //AJAX is called.

           $.ajax({

               //AJAX type is "Post".

               type: "POST",

               //Data will be sent to "ajax.php".

               url: "ajax.php",

               //Data, that will be sent to "ajax.php".

               data: {

                   //Assigning value of "name" into "search" variable.

                   search: name,thetablename: tablename

               },

               //If result found, this funtion will be called.

               success: function(html) {

                   //Assigning result to "display" div in "search.php" file.

                   $("#display").html(html).show();

               }

           });

       }

   });

});