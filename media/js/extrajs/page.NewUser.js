$(document).ready(function ($) {
 

/*======================= BEGIN: New User Page ====================================*/

$("#frmNewUser").validate({
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
			"first_name": {
				required: true
			},
			"last_name": {
				required: true
			},
			"username": {
				required: true,
				minlength: 3,
				maxlength: 50
			},
			"password": {
				required: true,
				minlength: 3,
				maxlength: 50
			},
			"user_email": {
				required: true
			},
			"role":{
			    required: true
			},
			"total_allow_students": {
				required: true
			},
			"user_photo": {
				extension: "jpg|png|JPG|PNG|jpeg|JPEG"
			},
			
		},	
		//perform an AJAX post to Api
		submitHandler: function() {
		var formData = new FormData($("#frmNewUser")[0]);
		$.ajax({
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
		url: base_url+'dashboard/submit_user_data',
		data: formData,
		type: 'POST',
		cache: false,
		contentType: false,
		processData: false,
		crossDomain: true,
		success: function (data, textStatus, xhr) {
			
		if(data==200)
			{
			$("#user_success").show();
			$("#user_success").html('<span class="badge badge-success">Congrats! User have been successfully created.</span>');
			$('#frmNewUser')[0].reset();
			$(".image_error_user_photo").html("");
			$("#user-photo").html("");
			$("#fileprogress").html("");
			}
		else
		{
			$("#user_success").show();
			$("#user_success").html('<span class="badge badge-danger">Username is already Exist. Please fill different username.</span>');
			$("#fileprogress").html("");
		}					
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(errorThrown);
		}
	});

		}
	});	

/*======================= END: New User Page =====================================*/



				
});


//Image Attachements Process
$(".upload_photo").click(function (){
	var fname=jQuery(this).data("name");
	jQuery("#"+fname).click();	
});

$("#user_photo").change(function (){  
  var pname="user-photo";  
  var file = this.files[0];  
  var  size = file.size/(1024*1024);
  var  type = file.type;
  //alert(type);
  if(size>2)
  {
	$(".image_error_user_photo").removeClass("hide");
	$(".image_error_user_photo").html('<span class="badge badge-danger">Please select another file. Please limit your file to a maximum of 2MB (2024 KB) in size.</span>'); 
  }
  else if(size<=2 && (type=="image/jpeg" || type=="image/jpg" || type=="image/png"))
  {
	  readURL(this,pname);	 
	 $(".image_error_user_photo").addClass("hide");
  }
  else
  {	
	$(".image_error_user_photo").removeClass("hide");
	$(".image_error_user_photo").html('<span class="badge badge-danger">Please upload jpg,jpeg amd png file only.</span>');
  }
  });
  $("#role").change(function (){  
	  	if($(this).val()=="operator") {
			$(".distributor-select").show();
		} else {
			$(".distributor-select").hide();
		}
		if($(this).val()=="distributor") {
			$(".allow-students").show();
		} else {
			$(".allow-students").hide();
		}

	});
  
  
  
//Read Image url
function readURL(input,pname) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();				
				reader.onload = function (e) {
					$('#'+pname).html('<img src="'+e.target.result+'" width="125" height="114" />');
					
				}
            
            reader.readAsDataURL(input.files[0]);
		  }
    }
