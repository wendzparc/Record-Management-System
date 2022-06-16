        <input type="hidden" name="base_url" value="<?php echo base_url()?>">
        <input type="hidden" name="basemethod" value="<?php echo $this->router->fetch_method(); ?>">
        <script src="<?php echo base_url()?>assets/build/js/jquery.min.js"></script>
        <script src="<?php echo base_url()?>assets/build/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url();?>assets/build/js/sweetalert2.min.js"></script>
        <script src="<?php echo base_url();?>assets/build/js/select2.min.js"></script>
        <script src="<?php echo base_url();?>assets/build/js/notify.min.js"></script>
        <!-- Essential javascripts for application to work-->
        <script src="<?php echo base_url()?>assets/build/js/popper.min.js"></script>
        <script src="<?php echo base_url() ?>assets/build/js/bootstrap.min.js"></script>
        <!-- <script src="<?php echo base_url()?>assets/build/js/plugins/bootstrap.min.js"></script> -->
        <script src="<?php echo base_url()?>assets/build/js/main.js"></script>
        <!-- The javascript plugin to display page loading on top-->
        <script src="<?php echo base_url()?>assets/build/js/plugins/pace.min.js"></script>
        <!-- Datatables-->
        <script type="text/javascript" src="<?php echo base_url()?>assets/build/js/plugins/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/build/js/plugins/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/build/js/plugins/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>assets/build/js/plugins/dataTables.responsive.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="<?php echo base_url() ?>assets/build/js/perfect-scrollbar.jquery.min.js"></script>
        <!--Wave Effects -->
        <script src="<?php echo base_url() ?>assets/build/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="<?php echo base_url() ?>assets/build/js/sidebarmenu.js"></script>
        <!--stickey kit -->
        <script src="<?php echo base_url() ?>assets/build/js/sticky-kit.min.js"></script>
        <script src="<?php echo base_url() ?>assets/build/js/jquery.sparkline.min.js"></script>
        <!--Custom JavaScript -->
        <script src="<?php echo base_url() ?>assets/build/js/custom.min.js"></script>
        <!-- ============================================================== -->
        <!-- Style switcher -->
        <!-- ============================================================== -->
        <script src="<?php echo base_url() ?>assets/build/js/jQuery.style.switcher.js"></script>
        <script src="<?php echo base_url() ?>assets/build/jqueryui/jquery-ui.min.js"></script>
        <?php
            __load_assets__($__assets__,'js');
        ?>
        <script type="text/javascript">
            $(document).ready(function(){ 
                $('[data-toggle="tooltip"]').tooltip();
            });

            var base_url = $('input[name="base_url"]').val();
            $(document).ready(function(){
                $(document).on('click','.updateProfileBtn',function(){
                    user_id = $(this).data('id');
                    var data = updateAjax({ url: base_url + 'users/getUserInfo', data: { user_id: user_id}});
                    updateClearError();
                    updateInput('input[name="pfirstname"]', data.firstname);
                    updateInput('input[name="pmiddlename"]', data.middlename);
                    updateInput('input[name="plastname"]', data.lastname);
                    updateInput('input[name="paddress"]', data.address);
                    updateInput('input[name="pusername"]', data.username);
                    updateInput('input[name="pemail"]', data.email);
                    updateInput('input[name="pphone"]', data.phone);
                    updateInput('select[name="poffice"]', data.office);
                    updateInput('select[name="pdivision"]', data.division);
                });

                $(document).on('submit','.form_updateProfile',function(e){
                    e.preventDefault();
                    var form_data = new FormData($('.form_updateProfile')[0]);
                    var sendAjaxVar = updateAjax({ url: base_url + 'users/updateMyProfile', data: form_data }, false);
                    if (sendAjaxVar) {
                        updateClearError();
                        if (sendAjaxVar.status == "success") {
                            location.reload();
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

            function updateAjax(param = {},isReturn = true) {
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
            function updateInput(element,value){
                $(element).val(value);
            }
            function updateClearError() {
                $('.err').html('');
            }
        </script>
    </body>
</html>
