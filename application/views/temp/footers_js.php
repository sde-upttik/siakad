<!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark"> -->
    <!-- Create the tabs -->
    <!-- <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="nav-item"><a href="<?=base_url()?>#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li class="nav-item"><a href="<?=base_url()?>#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-cog fa-spin"></i></a></li>
    </ul> -->
    <!-- Tab panes -->
    <!-- <div class="tab-content"> -->
      <!-- Home tab content -->
      <!-- <div class="tab-pane" id="control-sidebar-home-tab">
      </div> -->
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <!-- <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div> -->
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <!-- /.tab-pane -->
   <!--  </div>
  </aside> -->
  <!-- /.control-sidebar -->

  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

	<!-- jQuery 3 -->
	<script src="<?=base_url()?>assets/components/jquery/dist/jquery.js"></script>

	<!-- jQuery UI 1.11.4 -->
	<script src="<?=base_url()?>assets/components/jquery-ui/jquery-ui.js"></script>

	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>

	<!-- popper -->
	<script src="<?=base_url()?>assets/components/popper/dist/popper.min.js"></script>

	<!-- Bootstrap v4.0.0-beta -->
	<script src="<?=base_url()?>assets/components/bootstrap/dist/js/bootstrap.js"></script>

	<!-- Bootstrap v4.0.0-beta -->
	<script src="<?=base_url()?>assets/components/jquery/dist/FScript.js"></script>

	<!-- FLOT CHARTS
	<script src="<?=base_url()?>assets/components/Flot/jquery.flot.js"></script> -->

	<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized
	<script src="<?=base_url()?>assets/components/Flot/jquery.flot.resize.js"></script>-->

	<!-- FLOT PIE PLUGIN - also used to draw donut charts
	<script src="<?=base_url()?>assets/components/Flot/jquery.flot.pie.js"></script> -->

	<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts
	<script src="<?=base_url()?>assets/components/Flot/jquery.flot.categories.js"></script>-->

	<!-- Sparkline -->
	<!-- <script src="<?=base_url()?>assets/components/jquery-sparkline/dist/jquery.sparkline.js"></script> -->

	<!-- jvectormap -->
	<!-- <script src="<?=base_url()?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->

	<!-- jQuery Knob Chart -->
	<!-- <script src="<?=base_url()?>assets/components/jquery-knob/js/jquery.knob.js"></script> -->

	<!-- daterangepicker -->
	<script src="<?=base_url()?>assets/components/moment/min/moment.min.js"></script>
	<script src="<?=base_url()?>assets/components/bootstrap-daterangepicker/daterangepicker.js"></script>

	<!-- datepicker -->
	<script src="<?=base_url()?>assets/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

	<!-- Bootstrap WYSIHTML5 -->
	<!-- <script src="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script> -->

	<!-- Slimscroll-->
	<script src="<?=base_url()?>assets/components/jquery-slimscroll/jquery.slimscroll.js"></script>

	<!-- iCheck -->
	<script src="<?=base_url()?>assets/plugins/iCheck/icheck.js"></script>

	<!-- bootstrap-colorpicker -->
	<script src="<?=base_url()?>assets/components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>


	<!-- FastClick
	<script src="<?=base_url()?>assets/components/fastclick/lib/fastclick.js"></script>-->

	<!-- maximum_admin App -->
	<script src="<?=base_url()?>assets/js/template.js"></script>

	<!-- maximum_admin horizontal-layout -->
	<script src="<?=base_url()?>assets/js/horizontal-layout.js"></script>

	<!-- maximum_admin dashboard demo (This is only for demo purposes) -->
	<!-- <script src="<?=base_url()?>assets/js/pages/dashboard.js"></script> -->

	<!-- maximum_admin for demo purposes -->
	<!-- <script src="<?=base_url()?>assets/js/demo.js"></script> -->

	<!-- This is data table -->
    <script src="<?=base_url()?>assets/plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js"></script>

	<!-- maximum_admin for Data Table -->
	<script src="<?=base_url()?>assets/js/pages/data-table.js"></script>

	<!-- Sweet Alert Wawan -->
	<script src="<?=base_url()?>assets/plugins/sweetalert/dist/sweetalert.min.js"></script>

	<!-- Fandu Select2 (Silahkan hapus jika ada kendala, tapi konfirmasi dulu) -->
	<script src="<?=base_url()?>assets/components/select2/dist/js/select2.full.js"></script>
	<script src="<?=base_url()?>assets/js/pages/advanced-form-element.js"></script>

	<script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.js"></script>
	<script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

	<!-- bootstrap time picker -->
	<script src="<?=base_url()?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/jasny/jasny-bootstrap.min.js"></script>

    <!-- SweetAlert2(P) Wawan Matikan karena sudah di include sweet alert-->
    <!-- <script src="<?=base_url()?>assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script> -->

	<?php if(isset($footerSection)){ echo $footerSection;} ?>
