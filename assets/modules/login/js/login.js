var base_url = $('input[name="base_url"]').val();
var ctr = 0;

$(document).ready(function(){
 
    $(document).on('click', '.btnRegister', function(e) {
        e.preventDefault();
    });

    // Register Applicant
    $(document).on('submit','.form_registerApplicant',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_registerApplicant')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'login/register', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal('Registered Successfully! <br /> Please wait for Admin Approval.', sendAjaxVar.status);
                $('.form_registerApplicant')[0].reset();
                $('#modal_registerApplicant').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    $("#carousel").owlCarousel({
        nav:false,
        margin:0,
        autoplay: true,
        loop: true,
        dots:true,
        responsive:{
            0 : {
                items: 1
            },
            601 : {
                    items: 1
            },
            801 : {
                items: 1
            },
            1011 : {
                items: 1
            },
            1101 : {
                items: 1
            },
            1401 : {
                items: 1
            }
        
        }
        });

});

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

