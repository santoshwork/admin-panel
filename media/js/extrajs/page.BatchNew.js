$(document).ready(function ($) {
	/*======================= Login Page ====================================*/
	//User name check
	$("#frmNewBatch").validate({
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
				"batch_name": {
					required: true
				}
			},	
			
			//perform an AJAX post to Api
		submitHandler: function() {
			var formData = $("#frmNewBatch").serialize();
			$.ajax({		
			url: base_url+'dashboard/submit_batch_data',
			data: formData,
			type: 'POST',
			dataType: 'text',
			crossDomain: true,
			success: function (data, textStatus, xhr) {
				console.log(data);
			if(data==200)
				{				
				$("#user_success").html('<span class="badge badge-success">Congrats! Batch have been successfully created.</span>');
				$('#frmNewBatch')[0].reset();
				}
			else if(data==205)
			{				
				$("#user_success").html('<span class="badge badge-success">You have reached your batch creation limitation. Please contact developer</span>');
				$('#frmNewBatch')[0].reset();
			}
			else
			{
				$("#user_success").show();
				$("#user_success").html('<span class="badge badge-danger">Batch Details already exist.</span>');
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
