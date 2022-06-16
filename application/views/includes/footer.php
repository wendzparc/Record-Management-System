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
        </script>
    </body>
</html>
