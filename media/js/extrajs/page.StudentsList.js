
   
   
   var table = $('#studentList').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url+'dashboard/fetch_students_data',
            "type": "GET",
            "data": function(d) {
                d.batch = $('#batch_no').val();
            }
        },
        "columns": [   
            { "data": null,
                "render": function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
              "searchable": false
             },         
            { "data": null, "render": function(data, type, row) {
                return row.Student_Name + ' <br /> ' + row.Date;
            }},
            { "data": "Batch_Name" },
            { "data": "Finger1" , "render": function(data, type, row) {
                return '<img src="' + data + '" class="modify_image" height="100px" width="100px">';
            }},
            { "data": "Finger2" , "render": function(data, type, row) {
                return '<img src="' + data + '" class="modify_image" height="100px" width="100px">';
            }},
            { "data": "Finger3" , "render": function(data, type, row) {
                return '<img src="' + data + '" class="modify_image" height="100px" width="100px">';
            }},
            { "data": "Finger4" , "render": function(data, type, row) {
                return '<img src="' + data + '" class="modify_image" height="100px" width="100px">';
            }},
            { "data": "Finger5" , "render": function(data, type, row) {
                return '<img src="' + data + '" class="modify_image" height="100px" width="100px">';
            }},
            { "data": null , "width": "100px", "render": function(data, type, row) {
                return `<button type="button" class="btn btn-square btn-success m-2" onclick="editStudent(${row.id})"><i class="fa fa-edit"></i></button>`;
            }}
        ],
        "scrollX": false,
        "scrollY": false,
        "dom": '<"row"<"col-12 col-md-6"l><"col-12 col-md-6"f>><"row"<"col-12"tr>><"row"<"col-12 col-md-5"i><"col-12 col-md-7"p>>',
        "classes": {
            "sLengthSelect": "form-select form-select-sm",
            "sFilterInput": "form-control form-control-sm"
        },
        "createdRow": function(row, data, dataIndex) {
            $(row).find('td:first-child').html(dataIndex + 1);
        }
    });

    

    $('#batch_no').on('change', function() {
        table.ajax.reload();        
    });        
   
    $('#batchList').DataTable();
    $('#update_student').on('click', updateStudent);

    
function editStudent(studentId) {
    // Fetch student data via AJAX and populate the form fields in the modal
    // Then, open the modal
    $.ajax({
      url: base_url + "dashboard/get_student_data/" + studentId,
      type: "GET",
      dataType: "json",
      success: function (data) {
        $('#edit_student_id').val(data.id);
        $('#edit_student_name').html(data.Student_Name);
        // Set the selected batch based on text value
        $("#edit_batch_no option").each(function() {
            if ($(this).text() === data.Batch_Name) {
                $(this).prop('selected', true);
            }
        });
        $('#editStudentModal').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error fetching student data: " + errorThrown);
      }
    });
  }
  
  function updateStudent() {
    // Get the values from the input fields
    const studentId = $('#edit_student_id').val();
    const batchNo = $('#edit_batch_no').val();

    // Perform an AJAX request to update the student details
    $.ajax({
        url: base_url + 'dashboard/update_student_data',
        type: 'POST',
        data: {
            'id': studentId,
            'batch_no': batchNo
        },
        success: function (response) {
            // Handle the response from the server (e.g., show a success message or reload the table)
            $('#editStudentModal').modal('hide');
            table.ajax.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle any errors that occur during the request
            console.error(textStatus, errorThrown);
        }
    });
}

