$(function() {

    $('.styled').uniform();

    $('.datatable-responsive-row-control').DataTable({
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

    $("#searchform").validate({
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
            inputsearch: {
                required: true
            }
        },
        messages: {
            inputsearch: {
                required: "Silahkan Isi"
            }
        },
        // submitHandler: function () {
            
        //     var post_data = new FormData($('#searchform')[0]);
            
        //     $.ajax({ 
        //             url : $('#searchform').attr("action"),
        //             type: "POST",
        //             data : post_data,
        //             contentType: false,
        //             cache: false,
        //             processData:false,
        //             dataType:"JSON",
        //             success: function(data) {
        //                 console.log(data);
        //               if (data.code == 200)
        //               {
        //                 eval(data.aksi);
        //               }else{
        //                 notif('Error',data.message,'bg-danger');
        //               }
        //             },
        //             error: function(data){
        //                notif('Error',data.statusText,'bg-danger');
        //             }
        //         });

        // }
    });

    // var listPengaduan = [];
    // $.post($('#alamatList').val(), {}, function(resp){
    //     var result = JSON.parse(resp);
    //     $('.datatable-responsive-row-control').DataTable({
    //         data:result,
    //         responsive: {
    //             details: {
    //                 type: 'column',
    //                 target: 'tr'
    //             }
    //         },
    //         columnDefs: [
    //             {
    //                 className: 'control',
    //                 orderable: false,
    //                 targets:   0
    //             },
    //             { 
    //                 width: "100px",
    //                 targets: [2]
    //             },
    //             { 
    //                 orderable: true,
    //                 targets: [2]
    //             }
    //         ],
    //         order: [1, 'asc']
    //     });
    // });

  //   $("#btn-search").click(function(){ // Ketika tombol simpan di klik
  //   // Ubah text tombol search menjadi SEARCHING... 
  //   // Dan tambahkan atribut disable pada tombol nya agar tidak bisa diklik lagi
  //   $(this).html("SEARCHING...").attr("disabled", "disabled");
    
  //   $.ajax({
  //     url: baseurl + 'siswa/search', // File tujuan
  //     type: 'POST', // Tentukan type nya POST atau GET
  //     data: {keyword: $("#keyword").val()}, // Set data yang akan dikirim
  //     dataType: "json",
  //     beforeSend: function(e) {
  //       if(e && e.overrideMimeType) {
  //         e.overrideMimeType("application/json;charset=UTF-8");
  //       }
  //     },
  //     success: function(response){ // Ketika proses pengiriman berhasil
  //       // Ubah kembali text button search menjadi SEARCH
  //       // Dan hapus atribut disabled untuk meng-enable kembali button search nya
  //       $("#btn-search").html("SEARCH").removeAttr("disabled");
        
  //       // Ganti isi dari div view dengan view yang diambil dari controller siswa function search
  //       $("#view").html(response.hasil);
  //     },
  //     error: function (xhr, ajaxOptions, thrownError) { // Ketika terjadi error
  //       alert(xhr.responseText); // munculkan alert
  //     }
  //   });
  // }):



});
