$(document).ready(function ($) {


/*======================= Login Page ====================================*/
//User name check
$("#frmLogin").validate({
	highlight: function(element) {
				$(element).closest('.form-group').addClass('has-error');
				},
	unhighlight: function(element) {
				$(element).closest('.form-group').removeClass('has-error');
				},
	errorElement: 'span',
	errorClass: 'badge badge-danger',
	errorPlacement: function(error, element) {
	if(element.parent('.input-group').length) {
		error.insertAfter(element.parent());
	} else {
		error.insertAfter(element);
	}
	},
		rules: {
			"uname": {
				required: true,
				minlength: 3,
				maxlength: 100
			},
			"password": {
				required: true,
				minlength: 3,
				maxlength: 50
			}				
		},	
		
		//perform an AJAX post to Api
		submitHandler: function() {
		var formData = $("#frmLogin").serialize();		
		$.ajax({
		url: base_url+'login/submit_data',
		data: formData,
		type: 'POST',
		dataType: 'text',
		crossDomain: true,
		success: function (data, textStatus, xhr) {
			
		if(data==200)
			{
				window.location= base_url+'dashboard';
			}
		else if(data==201)
		{
			$("#register_success").show();
			$("#register_success").html('<span class="badge badge-danger">Invalid login information. Please try again.</span>');
		}
		else
		{
			$("#register_success").show();
			$("#register_success").html('<span class="badge badge-danger">Please select all the information.</span>');
		}
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(errorThrown);
		}
	});

} 
	});	

/*========================================= Code end ====================*/

				
});
