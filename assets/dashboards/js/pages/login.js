$(function() {

	// Style checkboxes and radios
	$('.styled').uniform();

	$("#form-login").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        //debug: true,
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            if ($(element).parent().hasClass('has-success')){
            	$(element).parent().removeClass('has-success');
            	$(element).parent().addClass('has-error');
            }
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {
        	
        	if (element.parent().hasClass('has-success')) {
        		element.parent().removeClass('has-success');
        	}
        	element.parent().addClass('has-error');

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        success: function(label, element) {
        	if (label.parent().hasClass('has-error')) {
        		label.parent().removeClass('has-error');
        	}
        	label.parent().addClass('has-success');
            label.addClass("validation-valid-label").text("Successfully")
        },
        rules: {
            password: {
                required: true,
                minlength: 5,
                maxlength: 15
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Insert your email",
                email: "Your email must be in the format name@domain.com"
            },
            password: {
            	required: "Insert your password",
            	minlength: jQuery.validator.format(" {0} character needed"),
                maxlength: jQuery.validator.format(" {0} character maximum")
            }
        },
        submitHandler: function () {
        	
        	var post_data = new FormData($('#form-login')[0]);
        	
        	$.ajax({ 
                    url : $('#form-login').attr("action"),
                    type: "POST",
                    data : post_data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    dataType:"JSON",
                    success: function(data) {
                      if (data.code == 200)
                      {
                        eval(data.aksi);
                      }else if (data.code == 366){
                        $( "#form-login" ).validate().showErrors({
                            "email": data.message
                          });
                        notif('Error',data.message,'bg-danger');
                      }else if (data.code == 367){
                        $( "#form-login" ).validate().showErrors({
                            "password": data.message
                          });
                        notif('Error',data.message,'bg-danger');
                      }else{
                        notif('Error',data.message,'bg-danger');
                      }
                    },
                    error: function(data){
                       notif('Error',data.statusText,'bg-danger');
                    }
                });

        }
    });

});
