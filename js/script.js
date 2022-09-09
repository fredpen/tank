$(function(){

    //set global variables and cache DOM elements for reuse later
    var form = $('#contact-form').find('form'),
        formElements = form.find('input[type!="submit"],textarea'),
        formSubmitButton = form.find('[type="submit"]'),
        errorNotice = $('#errors'),
        successNotice = $('#success'),
        loading = $('#loading'),
        errorMessages = {
            required: ' is a required field',
            email: 'You have not entered a valid email address for the field: ',
            minlength: ' must be greater than '
        }

    //feature detection + polyfills
    formElements.each(function(){
    
        //do feature detection + polyfills here
        
    });
});