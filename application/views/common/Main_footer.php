</div>

</div><!-- headerbar -->

</div><!-- mainpanel -->

</section>

<script src="<?php echo  base_url('components/js/jquery-ui-1.10.3.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/jquery-migrate-1.2.1.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/bootstrap.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/modernizr.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/jquery.sparkline.min.js');?>"></script
<script src="<?php echo  base_url('components/js/toggles.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/retina.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/jquery.cookies.js');?>"></script>



<script src="<?php echo  base_url('components/js/jquery.autogrow-textarea.js');?>"></script>
<script src="<?php echo  base_url('components/js/jquery.maskedinput.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/jquery.mousewheel.js');?>"></script>
<script src="<?php echo  base_url('components/js/select2.min.js');?>"></script>

<script src="<?php echo  base_url('components/js/flot/jquery.flot.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/flot/jquery.flot.resize.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/flot/jquery.flot.symbol.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/flot/jquery.flot.crosshair.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/flot/jquery.flot.categories.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/flot/jquery.flot.pie.min.js');?>"></script>

<script src="<?php echo  base_url('components/js/custom.js');?>"></script>

<script src="<?php echo  base_url('components/js/dashboard.js');?>"></script>
<script src="<?php echo  base_url('components/js/dropzone.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/bootstrap-timepicker.min.js');?>"></script>
<script src="<?php echo  base_url('components/js/charts.js');?>"></script>

<script>
    jQuery(document).ready(function() {

            "use strict";

            // Tags Input
            jQuery('#tags').tagsInput({width: 'auto'});

             //Date Picker
            jQuery('#datepicker').datepicker();
            // Select2
            jQuery(".select2").select2({
                width: '100%'
            });
            // Spinner
            var spinner = jQuery('#spinner').spinner();
            spinner.spinner('value', 0);
            });
    </script>
</body>
</html>

