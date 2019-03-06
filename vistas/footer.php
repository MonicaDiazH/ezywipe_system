<!-- Main Footer -->
<footer class="main-footer">
  <!-- Default to the left -->
  <strong>Copyright &copy; 2019 <a href="#">COMAR SYSTEM </a>.</strong> All rights reserved.
</footer>

<!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../public/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../public/dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="../public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../public/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
   Both of these plugins are recommended to enhance the
   user experience. -->

<!-- Bootstrap Select Latest compiled and minified JavaScript -->
<script src="../public/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<!-- AlertifyJS -->
<script src="../public/plugins/alertifyjs/alertify.min.js"></script>
<!--bootstrap - treeview-->
<script src="../public/bower_components/bootstrap-treeview/dist/bootstrap-treeview.min.js"></script>
<!-- bootstrap datepicker -->
<script src="../public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
</body>
</html>

<script type="text/javascript">
var url = window.location;
  //sidebar-menu
  $('ul.sidebar-menu a').filter(function() {
    return this.href == url;
  }).parent().addClass('active');

  //treeview
  $('ul.treeview-menu a').filter(function() {
    return this.href == url;
  }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
</script>
