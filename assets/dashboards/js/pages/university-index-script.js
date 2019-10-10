$(function() {
    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice' });

    $('.select2').select2();
    
    $('.datatable-responsive-row-control').DataTable({
        "scrollX": true,
          responsive: {
              details: {
                  type: 'column',
                  target: 'tr'
              }
          },
          columnDefs: [
              {
                  className: 'control',
                  orderable: false,
                  targets:   0
              },
              { 
                  width: "100px",
                  targets: [2]
              },
              { 
                  orderable: true,
                  targets: [2]
              }
          ],
          order: [1, 'asc']
      });


     $.ajax({
            type:'POST',
            url: $('#getField1').val(),
            dataType:"JSON",
            success: function(data) {
                $('#Field1').select2({
                    placeholder: 'Pick Field',
                    data: data
                });
            }
        });

     $.ajax({
            type:'POST',
            url: $('#getField2').val(),
            dataType:"JSON",
            success: function(data) {
                $('#Field2').select2({
                    placeholder: 'Pick Field',
                    data: data
                });
            }
        });

     $.ajax({
            type:'POST',
            url: $('#getField3').val(),
            dataType:"JSON",
            success: function(data) {
                $('#Field3').select2({
                    placeholder: 'Pick Field',
                    data: data
                });
            }
        });

     $.ajax({
            type:'POST',
            url: $('#getField4').val(),
            dataType:"JSON",
            success: function(data) {
                $('#Field4').select2({
                    placeholder: 'Pick Field',
                    data: data
                });
            }
        });

     $.ajax({
            type:'POST',
            url: $('#getField5').val(),
            dataType:"JSON",
            success: function(data) {
                $('#Field5').select2({
                    placeholder: 'Pick Field',
                    data: data
                });
            }
        });

     $.ajax({
            type:'POST',
            url: $('#getMou').val(),
            dataType:"JSON",
            success: function(data) {
                $('#Mou').select2({
                    placeholder: 'MOU Accepted',
                    data: data
                });
            }
        });

      $("#pengaduan-form").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            if ($(element).parent().hasClass('has-success')){
                $(element).parent().removeClass('has-success');
                $(element).parent().addClass('has-error');
            }
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);

            if ($(element).parent().hasClass('has-error')){
                $(element).parent().removeClass('has-error');
                $(element).parent().addClass('has-success');
            }
            
        },

        errorPlacement: function(error, element) {
            
            if (element.parent().hasClass('has-success')) {
                element.parent().removeClass('has-success');
            }
            element.parent().addClass('has-error');

            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }
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
            Kondisi: {
                required: true,
            }

        },
        messages: {
            Kondisi: {
                required: "Insert Keyword"
            }
        }
    });
    
});

function showModal(target,index,tipe){
    var urlx = '';
    var datax = '';
    if (tipe == 'add')
    {
      urlx = target;
      datax= {};
    }else{
      urlx = target;
      datax = {id:index};
    }
   
    $.post(urlx, datax , function(mod) {
        $('#tampilModal').html(mod);
        $('#modalPortal').modal({show: true , backdrop : true , keyboard: true});
    });
}

$(document).on("click", "#submit-dokumen", function () {
    $("#dokumen-form").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            if ($(element).parent().hasClass('has-success')){
                $(element).parent().removeClass('has-success');
                $(element).parent().addClass('has-error');
            }
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);

            if ($(element).parent().hasClass('has-error')){
                $(element).parent().removeClass('has-error');
                $(element).parent().addClass('has-success');
            }
            
        },

        errorPlacement: function(error, element) {
            
            if (element.parent().hasClass('has-success')) {
                element.parent().removeClass('has-success');
            }
            element.parent().addClass('has-error');

            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }
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
        submitHandler: function () {
            
            var post_data = new FormData($('#dokumen-form')[0]);

            $.ajax({ 
                    url : $('#dokumen-form').attr("action"),
                    type: "POST",
                    data : post_data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    dataType:"JSON",
                    success: function(data) {
                    console.log(data);
                      if (data.code == 200)
                      {
                        window.location.reload();
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