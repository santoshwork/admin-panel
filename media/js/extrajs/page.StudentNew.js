$(document).ready(function ($) {
	/*======================= Login Page ====================================*/
	//User name check
	$("#frmStudentNew").validate({
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
				"student_name": {
					required: true
				},
				"mobile_no": {
					required: true
				},
				"batch_no": {
					required: true
				},
				"address": {
					required: true
				},
				"finger1Value": {
					required: true
				},
				"finger2Value": {
					required: true
				},
				"finger3Value": {
					required: true
				},
				"finger4Value": {
					required: true
				},
				"finger5Value": {
					required: true
				}			
			},	
			
			//perform an AJAX post to Api
		submitHandler: function() {
			var formData = $("#frmStudentNew").serialize();

			$.ajax({		
			url: base_url+'dashboard/submit_student_data',
			data: formData,
			type: 'POST',
			dataType: 'text',
			crossDomain: true,
			xhr: function() {
				var xhr = new window.XMLHttpRequest();					
				xhr.upload.addEventListener("progress", function(evt) {
				  if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
					percentComplete = parseInt(percentComplete * 100);
					$("#fileprogress").removeClass("hide");						
					$("#fileprogress").html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:'+percentComplete+'%">'+percentComplete+'% </div></div>');
					if (percentComplete === 100) 
					{
					 $("#fileprogress").html("");
					}
				  }
				}, false);
			
				return xhr;
			  },
			success: function (data, textStatus, xhr) {
				console.log(data);
			if(data==200)
				{				
					$("#user_success").html('<span class="badge badge-success">Congrats! Student have been successfully stored.</span>');
					$('#frmStudentNew')[0].reset();
				}
			else if(data ==205)
			{				
				$("#user_success").html('<span class="badge badge-danger">You have reached total students limitation. Please contact developer to increame students limit</span>');
				$('#frmStudentNew')[0].reset();
			} else {				
				$("#user_success").html('<span class="badge badge-danger">Student Details already exist.</span>');
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
	
let flag = 0;
let quality = 90; //(1 to 100) (recommanded minimum 55)
let timeout = 20; // seconds (minimum=10(recommanded), maximum=60, unlimited=0 )


function captureFinger(fingerVal) {
	
	try { 	
					
		var res = CaptureFinger(quality, timeout);
		
		if (res.httpStaus) {
				flag = 1;
			
			if (res.data.ErrorCode == "0") {
				if( fingerVal<5 ) {
					alert("Image"+fingerVal+" is captured successfully. Proceed to capture Image"+(fingerVal+1))
					document.getElementById('finger'+fingerVal+'Value').value = "data:image/bmp;base64,"+ res.data.BitmapData; 
				} else if( fingerVal== 5) {
					alert("All Images are captured successfully. Please Proceed to save the information")
					document.getElementById('finger'+fingerVal+'Value').value = "data:image/bmp;base64,"+ res.data.BitmapData;
				}
				                  
			} else {
				alert("Image not captured.")
				
			}
		}
		else {
			console.log(res);
		}
	}
	catch (e) {
		console.log(e);
	}
	return false;
}
