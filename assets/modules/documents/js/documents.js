var base_url = $('input[name="base_url"]').val();
var method = $('input[name="basemethod"]').val();
$(document).ready(function(){

    if(method == 'scanbarcode') {
        setInterval(function(){
            var focusbox;
            focusbox = $('.barcodeInput')[0];
            focusbox.focus();
           });
    } else {
        documentTable();
    }

    $(document).on('click','.addDocument',function(e){
        e.preventDefault();
    });

    // Document Validation
    $('.docfile').change(function () {
        var error_file = '';
        var files = $('.docfile')[0].files;
        for (var i = 0; i < files.length; i++) {
            var name = $(this)[0].files[i].name;
            var ext = name.split('.').pop().toLowerCase();
            if ($.inArray(ext, ['zip','png','jpg','jpeg','png','pdf','docx','doc','xlsx','xls']) == -1) {
                error_file += '<p>Invalid file type</p>';
            }
            var oFReader = new FileReader();
            oFReader.readAsDataURL($(this)[0].files[i]);
            var f = $(this)[0].files[i];
            var fsize = f.size || f.fileSize;
            console.log(fsize);
            if (fsize > 92309291091) {
                error_file += '<p> Document file size is too big to upload </p>';
            }
        }
        if (error_file != "") {
            ctr+=1;
            $('.docfile').val('');
            $('.docfile').next('.err').html(error_file);
            return false;
        }else{
            ctr = 0;
            $('.docfile').next('.err').html("");
        }
    });

    $(document).on('submit','.form_addDocument',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_addDocument')[0]);
        form_data.append( 'docfile', $( '#docfile' )[0].files);
        var sendAjaxVar = sendAjax({ url: base_url + 'documents/addDocument', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_addDocument')[0].reset();
                documentTable();
                $('#modal_addDocument').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // Remove Document
    $(document).on('click','.removeDocument',function(e){
        e.preventDefault();
        var file_id = $(this).data('id');
        var file_path = $(this).data('path');
        var barcode_path = $(this).data('barpath');
        confirm_swal('Are you sure you want to remove this Document?', 'Remove').then(function (val) {
            if (val === true) {
                const sendAjaxVar = sendAjax({
                    url: base_url + 'documents/removeDocument',
                    data: { file_id: file_id, file_path: file_path, barcode_path: barcode_path }
                });
                if (sendAjaxVar) {
                    swal(sendAjaxVar.msg, sendAjaxVar.status);
                    documentTable();
                }
            }
        });
    });

    $(document).on('click', '.barcodeImage', function(e) {
        e.preventDefault();
        var barcode = $(this).data('barpath');
        var win = window.open('about:blank', "_new");
            win.document.open();
            win.document.write([
                '<html>',
                '   <head>',
                '   </head>',
                '   <body onload="window.print()" onafterprint="window.close()">',
                '       <img src="' + barcode + '"/>',
                '   </body>',
                '</html>'
            ].join(''));
            win.document.close();
    });

    $(document).on('change', '.division', function(e) {
        let val = $(this).find(':selected').val();
        let gen = ['Gawad Kalasag', 'Minutes of the Meeting', 'MDRRMC Resolutions & Guidelines', 'Seal of Good Local Governance', 'Awards and Certificates', 'Others'];
        let adminfinance = ['Travel Orders', 'Purchase Orders', 'PPMP', 'Attendance', 'Payroll', 'Others'];
        let training = ['Activity Proposals', 'Meetings', 'Post Activity Reports', 'Documentation', 'Training Manuals', 'Certificates', 'Others'];
        let operations = ['Activities', 'Documentations', 'Reports'];
        var html = `<div class="col-md-6 categDiv">
                        <div class="form-group">`;
                        if(val == 'General') {
                            html += `<label for="category" class="control-label">Category</label>
                            <select name="category" class="form-control category">
                            <option value="" selected hidden> - Please Select - </option>`;
                            $.each(gen, function(key, value) {
                                html += `<option value="`+value+`">`+value+`</option>`;
                            });
                            html += `</select>`;
                        } else if (val == 'Admin & Finance') {
                            html += `<label for="category" class="control-label">Category</label>
                            <select name="category" class="form-control divCategory">
                            <option value="" selected hidden> - Please Select - </option>`;
                            $.each(adminfinance, function(key, value) {
                                html += `<option value="`+value+`">`+value+`</option>`;
                            });
                            html += `</select>`;
                        } else if (val == 'Training & Planning') {
                            html += `<label for="category" class="control-label">Category</label>
                            <select name="category" class="form-control category">
                            <option value="" selected hidden> - Please Select - </option>`;
                            $.each(training, function(key, value) {
                                html += `<option value="`+value+`">`+value+`</option>`;
                            });
                            html += `</select>`;
                        } else {
                            html += `<label for="category" class="control-label">Category</label>
                            <select name="category" class="form-control category">
                            <option value="" selected hidden> - Please Select - </option>`;
                            $.each(operations, function(key, value) {
                                html += `<option value="`+value+`">`+value+`</option>`;
                            });
                            html += `</select>`;
                        }
        html +=             `<small class="err"></small>
                    </div>
                </div>
                <div class="col-md-6 othersDiv"></div>
                <div class="col-md-6 repOthersDiv"></div>`;

        $('.divContainer').html(html);
    });

    $(document).on('change', '.category', function(e) {
        let val = $(this).find(':selected').val();
        let reports = ['Incident Reports', 'SitRep', 'Responders Logbook', 'PDRA', 'PDNA', 'RDNA', 'Relief Operations', 'CCCM Reports', 'Others'];
        var html = '';
        if(val == 'Reports') {
            html += `<div class="form-group">
                        <label for="reports" class="control-label">Reports</label>
                        <select name="reports" class="form-control reports">
                        <option value="" selected hidden> - Please Select - </option>`;
                        $.each(reports, function(key, value) {
                            html += `<option value="`+value+`">`+value+`</option>`;
                        });
            html +=     `</select>
                        <small class="err"></small>
                    </div>`;
        } else if(val == 'Others') {
            html += `<div class="form-group">
                        <label for="reports" class="control-label">Others</label>
                        <input type="text" class="form-control" name="others" placeholder="Enter Other Category">
                        <small class="err"></small>
                    </div>`;
                        
        } else {
            html += ``;
        }
        $('.othersDiv').html(html)
    });

    $(document).on('change', '.reports', function(e) {
        let val = $(this).find(':selected').val();
        var html = '';
        if(val == 'Others') {
            html += `<div class="form-group">
                        <label for="reports" class="control-label">Others</label>
                        <input type="text" class="form-control" name="others" placeholder="Enter Other Category">
                        <small class="err"></small>
                    </div>`;
        } else {
            html += ``;
        }
        $('.repOthersDiv').html(html)
    });

    $(document).on('keyup','.barcodeInput', function() {
        barcode = $(this).val();
        var html = '';
        var data = sendAjax({ url: base_url + 'documents/fetchBarcodeScan', data: { barcode: barcode}});
        clearError();
        if(data) {
            html += `<div class="col-md-12">
                <div class="form-group">
                <a href="`+base_url+data.file_path+`" target="_blank"><img src="`+base_url+`/assets/build/images/avatar.gif" class="scanImage"></a>
                <p class="scanDivision">`+data.file_division+`</p>
                <p class="scanType">`+data.file_type+`</p>
                <p class="scanTitle">`+data.file_name+`</p>
                </div>
            </div>`;
        } else {
            html += '';
        }
        $('.scanResult').html(html);

    });

    $(document).on('click', '.filterBtn', function() {
        var division = $('.byDivision').val();
        var category = $('.byCategory').val();
        documentTable(division,category);
    });

}); // End of Document Ready

// Document Table Function
function documentTable(division = 'All', category = '') {
    $('#tbl_documents').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "destroy":    true,
        "order": [[0, 'desc']],
        "columns": [
            { "data": "file_name", "width":"20%"},
            { "data": "file_division", "width":"10%"},
            { "data": "file_type", "width":"10%" },
            { "data": "date_added", "width":"10%" },
            {
                "data": "file_id", "width":"25%", "render": function (data, type, row, meta) {
                    var str = '';
                        str += '<a href="javascript:void(0);" data-barpath="'+base_url+row.barcode_path+'" class="btn btn-sm btn-outline-success barcodeImage" title="Click to View Barcode"><i class="fa fa-eye"></i> Barcode</a>&nbsp;';
                        str += '<a href="'+base_url+row.file_path+'" target="_blank" class="btn btn-sm btn-outline-success downloadDoc" title="Click to download"><i class="fa fa-download"></i> Download</a>&nbsp;';
                        // str += '<button data-toggle="modal" data-target="#modal_updateDocument" data-id="'+row.file_id+'" class="btn btn-sm btn-outline-warning updateDocument" title="Click to update"><i class="fa fa-edit"></i> Edit</button>&nbsp;';
                        str += '<button data-id="'+row.file_id+'" data-path="'+row.file_path+'" data-barpath="'+row.barcode_path+'" class="btn btn-sm btn-outline-danger removeDocument" title="Click to remove"><i class="fa fa-times-circle"></i> Remove</button>';
                    return str;
                }
            },
        ],
        "language": { "search": '', "searchPlaceholder": "Search keyword...","infoFiltered": "" },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url + "documents/getDocumentList",
            "type": "POST",
            "data": {division:division,category:category},
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [4], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],
    });
}

function sendAjax(param = {},isReturn = true){
    if(isReturn === false){
        var return_response = null;
        $.ajax({
            url:param.url,
            type: 'post',
            data:param.data,
            async:false,
            processData: false,
            contentType: false,
            dataType:'json',
            beforeSend: function() {
              $('.overlay').show();
            },
            success:function(response){
                $('.overlay').hide();
                return_response = response;
            },error:function(e){
                console.log(e);
            }
        });
        return return_response;
    } else {
        var return_data = null;
        $.ajax({
            url:param.url,
            type: 'post',
            data:param.data,
            async:false,
            dataType:'json',
            success:function(response){
                return_data = response;
            },error:function(e){
                console.log(e);
            }
        });

        if(isReturn){
            return return_data;
        }
    }
}

function confirm_swal(text,confirmBtnText){
    var isSuccess = false;
    return new Promise(function(resolve, reject) {
        Swal.fire({
            title: 'Are you sure?',
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmBtnText
        }).then((result) => {
            if (result.value) {
                resolve(true);
            } else {
                resolve(false);
            }
        });
   });
}

function swal(content,response = 'success'){
    if(response == 'success'){
        Swal.fire("Success",content,response);
    }else{
        Swal.fire("Error",content,response);
    }
}

function clearError() {
    $('.err').html('');
}

function input(element,value){
    $(element).val(value);
}