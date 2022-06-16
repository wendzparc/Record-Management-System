    <!-- Essential javascripts for application to work-->
    <input type="hidden" name="base_url" value="<?php echo base_url()?>">
    <script src="<?php echo base_url()?>assets/build/js/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/build/js/popper.min.js"></script>
    <script src="<?php echo base_url()?>assets/build/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/build/js/sweetalert2.min.js"></script>
    <script src="<?php echo base_url()?>assets/build/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?php echo base_url()?>assets/build/js/plugins/pace.min.js"></script>
    <script src="<?php echo base_url()?>assets/build/js/plugin.js"></script>
    <?php
        __load_assets__($__assets__,'js');
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#login-form').on('submit', function(e) {
                if($('#uname').val() == "") {
                    e.preventDefault();
                    $('#uname').next().html('Please input username!');
                    return false;
                } else if($('#pass').val() == "") {
                    e.preventDefault();
                    $('#pass').next().html('Please input password!');
                    return false;
                } else {
                    return true;
                }
            });
        });
    </script>
    </body>
</html>
