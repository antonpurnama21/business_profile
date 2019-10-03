$(function() {

	$(".styled, .multiselect-container input").uniform({ radioClass: 'choice' });

    $('.select2').select2();

    $('.pickadate').pickadate({
        labelMonthNext: 'Bulan selanjutnya',
        labelMonthPrev: 'Bulan sebelumnya',
        labelMonthSelect: 'Pilih bulan lainnya',
        labelYearSelect: 'Pilih tahun lainnya',
        selectMonths: true,
        selectYears: 50,
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
        monthsFull: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        weekdaysShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
    });

    $("#Hour").AnyTime_picker({
        format: "%H:%i"
    });

    $.ajax({
            type:'POST',
            url: $('#getSector').val(),
            dataType:"JSON",
            success: function(data) {
                $('#Sector').select2({
                    placeholder: 'Pick Company Sector',
                    data: data
                });
            }
        });

    $.ajax({
            type:'POST',
            url: $('#getType').val(),
            dataType:"JSON",
            success: function(data) {
                $('#Typedata').select2({
                    placeholder: 'Pick Type data',
                    data: data
                });
            }
        });

        $.ajax({
            type:'POST',
            url: $('#getField').val(),
            dataType:"JSON",
            success: function(data) {
                $('#After').select2({
                    placeholder: 'Pick After Coloumn',
                    data: data
                });
            }
        });

    $.validator.addMethod("nospace", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]*$/.test(value);
    });

        $.validator.addMethod("letteronly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
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
            Email: {
                required: true,
                email: true
            },
            Fieldname: {
                required: true,
                nospace: true,
                minlength: 5
            },
            Lengthdata: {
                required: true,
                digits: true,
                minlength: 1
            }

        },
        messages: {
            Email: {
                required: "Insert Email Address",
                email: "Insert a valid email"
            },
            Typedata: "Select Type Data",
            Lengthdata: {
                required: "Insert Length data",
                digits: "Number Only Please",
                minlength: jQuery.validator.format(" {0} character needed")
            },
            Alter: "Select Alter Column",
            Fieldname: {
                required: "Insert Fieldname, #example : 'FieldName'",
                nospace: "Letter Only Without Space",
                minlength: jQuery.validator.format(" {0} character needed")
            }
        },
        submitHandler: function () {
            
            var post_data = new FormData($('#pengaduan-form')[0]);
            
            $.ajax({ 
                    url : $('#pengaduan-form').attr("action"),
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
                      }else if (data.code == 265)
                      {
                        $( "#pengaduan-form" ).validate().showErrors({
                            "Companyid": data.message
                          });
                        notif('Error',data.message,'bg-danger');
                      }else if (data.code == 266)
                      {
                        $( "#pengaduan-form" ).validate().showErrors({
                            "Fieldname": data.message
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
////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////////////
function getData(target,id,tujuan)
  {
    $.post(target, {id:id} , function(resp) {
       var result = JSON.parse(resp);
       $('#'+tujuan).html('').select2({data: {id:null, text: null}});
       $('#'+tujuan).select2({
            placeholder: 'Silahkan pilih kota',
            data: result
        });
    });
  }