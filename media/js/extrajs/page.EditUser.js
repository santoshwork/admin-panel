var userTable = $('#userList').DataTable();

$(document).ready(function ($) {
  $("#frmEditUser").validate({
    highlight: function (element) {
      $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function (element) {
      $(element).closest('.form-group').removeClass('has-error');
    },
    errorElement: 'span',
    errorClass: 'badge badge-danger',
    errorPlacement: function (error, element) {
      if (element.parent('.input-group').length) {
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
      "password": {
        required: true,
        minlength: 3,
        maxlength: 50
      },
      "user_email": {
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
    submitHandler: function () {
      var formData = new FormData($("#frmEditUser")[0]);
      $.ajax({
        xhr: function () {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              percentComplete = parseInt(percentComplete * 100);
              $("#fileprogress").removeClass("hide");
              $("#fileprogress").html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:' + percentComplete + '%">' + percentComplete + '% </div></div>');
              if (percentComplete === 100) {
                $("#fileprogress").html("");
              }
            }
          }, false);

          return xhr;
        },
        url: base_url + 'dashboard/edit_user_data',
        data: formData,
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        crossDomain: true,
        success: function (data, textStatus, xhr) {
          
          if (data == 200) {
            $("#user_success").show();
            $("#user_success").html('<span class="badge badge-success">Congrats! User have been successfully updated.</span>');
            $("#fileprogress").html("");
            $('#editUserModal').modal('hide');
            location.reload();
          } else {
            $("#user_success").show();
            $("#user_success").html('<span class="badge badge-danger">Error on the server. Please try again</span>');
            $("#fileprogress").html("");
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          console.log(errorThrown);
        }
      });

    }
  });
});


function editUser(userId) {
  // Fetch student data via AJAX and populate the form fields in the modal
  // Then, open the modal
  $.ajax({
    url: base_url + "dashboard/get_user_data/" + userId,
    type: "GET",
    dataType: "json",
    success: function (data) {
      $('#edit_user_id').val(data.id);
      $('#first_name').val(data.first_name);
      $('#last_name').val(data.last_name);
      $('#password').val(data.password_human);
      $('#user_email').val(data.email);
      $('#mobile').val(data.mobile);      
      $('#total_allow_students').val(data.total_allow_students);
      $('#active').val(data.active);
      if(data.role == "operator") {
        $('#total_allow_students').hide();
      }
      if (data.user_photo_thumbnail != "") {
        $('#user-photo').html('<img src="' + base_url + 'media/upload/user/' + data.id + '/' + data.user_photo_thumbnail + '" width="125" height="114" />')
      } else {
        $('#user-photo').html('<img src="' + base_url + 'media/img/image-capture.png" width="125" height="114" />')
      }
      $('#editUserModal').modal('show');
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error fetching user data: " + errorThrown);
    }
  });
}



//Image Attachements Process
$(".upload_photo").click(function () {
  var fname = jQuery(this).data("name");
  jQuery("#" + fname).click();
});

$("#user_photo").change(function () {
  var pname = "user-photo";
  var file = this.files[0];
  var size = file.size / (1024 * 1024);
  var type = file.type;
  //alert(type);
  if (size > 2) {
    $(".image_error_user_photo").removeClass("hide");
    $(".image_error_user_photo").html('<span class="badge badge-danger">Please select another file. Please limit your file to a maximum of 2MB (2024 KB) in size.</span>');
  } else if (size <= 2 && (type == "image/jpeg" || type == "image/jpg" || type == "image/png")) {
    readURL(this, pname);
    $(".image_error_user_photo").addClass("hide");
  } else {
    $(".image_error_user_photo").removeClass("hide");
    $(".image_error_user_photo").html('<span class="badge badge-danger">Please upload jpg,jpeg amd png file only.</span>');
  }
});



//Read Image url
function readURL(input, pname) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#' + pname).html('<img src="' + e.target.result + '" width="125" height="114" />');

    }

    reader.readAsDataURL(input.files[0]);
  }
}
function deleteUser(userId) {
  if (confirm("Are you sure you want to delete this user?")) {
      // Send a request to your server to delete the student record
      $.ajax({
          url: base_url + "dashboard/delete_user",
          type: "POST",
          data: {
              "user_id": userId
          },
          success: function(response) {             
              location.reload();
          },
          error: function(error) {
              alert("An error occurred while deleting the student.");
          }
      });
  }
}