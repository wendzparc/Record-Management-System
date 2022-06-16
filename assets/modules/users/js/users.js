var base_url = $('input[name="base_url"]').val();
$(document).ready(function(){

    // Calling Function
    usersTable();

    // Prevent Default on Clicking
    $(document).on('click','.addUser',function(e){
        e.preventDefault();
    });

    // Add User
    $(document).on('submit','.form_addUser',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_addUser')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'users/addManager', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_addUser')[0].reset();
                usersTable();
                $('#modal_addManager').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // Update User Status
    $(document).on('click','.updateUserStatus',function(){
        var user_id = $(this).data('id');
        var user_status = $(this).data('status');
        if (user_status == 1) {
            confirm_swal('Deactivate this User?', 'Deactivate').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'users/userStatus',
                        data: { user_id: user_id, user_status: user_status }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        usersTable();
                    }
                }
            });
        } else{
            confirm_swal('Activate this User?', 'Activate').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'users/userStatus',
                        data: { user_id: user_id, user_status: user_status }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        usersTable();
                    }
                }
            });
        }
    });

    // Remove User
    $(document).on('click','.removeUser',function(e){
        e.preventDefault();
        var user_id = $(this).data('id');
        confirm_swal('Are you sure you want to remove this User?', 'Remove').then(function (val) {
            if (val === true) {
                const sendAjaxVar = sendAjax({
                    url: base_url + 'users/removeUser',
                    data: { user_id: user_id }
                });
                if (sendAjaxVar) {
                    swal(sendAjaxVar.msg, sendAjaxVar.type);
                    usersTable();
                }
            }
        });
    });

    // Fetch User Information
    $(document).on('click','.updateUser',function(){
        user_id = $(this).data('id');
        var data = sendAjax({ url: base_url + 'users/getUserInfo', data: { user_id: user_id}});
        $('.form_updateUser')[0].reset();
        input('input[name="user_id"]', user_id);
        input('input[name="username"]', data.username);
        input('input[name="user_type"]', data.user_type);
        input('input[name="email"]', data.email);
        input('input[name="firstname"]', data.firstname);
        input('input[name="middlename"]', data.middlename);
        input('input[name="lastname"]', data.lastname);
        input('input[name="phone"]', data.phone);
        input('input[name="address"]', data.address);
        input('input[name="office"]', data.office);
        input('input[name="division"]', data.division);
        $('.form_addUser')[0].reset();
    });

    // Update User
    $(document).on('submit','.form_updateUser',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_updateUser')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'users/updateUser', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_updateUser')[0].reset();
                usersTable();
                $('#modal_updateUser').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

}); // End of Document Ready

function usersTable() {
    $('#tbl_users').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "responsive": true,
        "destroy":    true,
        "order": [[0, 'desc']], //Initial no order.
        "columns": [
            { "data": "fullname", "width":"15%"},
            { "data": "username", "width":"10%"},
            { "data": "office", "width":"10%" },
            { "data": "division", "width":"15%" },
            { "data": "phone", "width":"10%" },
            {
                "data": "user_type", "width":"10%", "render": function (data, type, row, meta) {
                    var str = '';
                    if(row.user_type == 1) {
                        str += `<span class="label label-success">Admin</span>`;
                    } else if(row.user_type == 2) {
                        str += `<span class="label label-info">Manager</span>`;
                    } else {
                        str += `<span class="label label-warning">User</span>`;
                    }
                    return str;
                }
            },
            {
                "data": "user_status", "width":"10%", "render": function (data, type, row, meta) {
                    var str = '';
                    if(row.user_status == 1) {
                        str += `<span class="label label-success">Active</span>`;
                    } else if(row.user_status == 2) {
                        str += `<span class="label label-warning">Deactivated</span>`;
                    } else {
                        str += `<span class="label label-danger">For Approval</span>`;
                    }
                    return str;
                }
            },
            {
                "data": "user_id", "width":"25%", "render": function (data, type, row, meta) {
                    var str = '';
                        if (row.user_status == 1) {
                            str += '<button data-id="'+row.user_id+'" data-status="'+row.user_status+'" class="btn btn-sm btn-outline-dark updateUserStatus" title="Click to enable"><i class="fa fa-lock"></i> Deactivate</button>&nbsp;';
                        
                        } else if(row.user_status == 3) {
                            str += '<button data-id="'+row.user_id+'" data-status="'+row.user_status+'" class="btn btn-sm btn-outline-info updateUserStatus" title="Click to approve"><i class="fa fa-check"></i> Approve</button>&nbsp;';
                        
                        } else if(row.user_status == 2) {
                            str += '<button data-id="'+row.user_id+'" data-status="'+row.user_status+'" class="btn btn-sm btn-outline-success updateUserStatus" title="Click to disable"><i class="fa fa-unlock"></i> Activate</button>&nbsp;';
                        }
                        str += '<button data-toggle="modal" data-target="#modal_updateUser" data-id="'+row.user_id+'" class="btn btn-sm btn-outline-warning updateUser" title="Click to update"><i class="fa fa-edit"></i> Edit</button>&nbsp;';
                        str += '<button data-id="'+row.user_id+'" class="btn btn-sm btn-outline-danger removeUser" title="Click to remove"><i class="fa fa-times-circle"></i> Remove</button>';
                    return str;
                }
            },
        ],
        "language": { "search": '', "searchPlaceholder": "Search keyword...","infoFiltered": "" },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url + "users/getUsersList",
            "type": "POST",
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [6], //first column / numbering column
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
                console.log(response);
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

