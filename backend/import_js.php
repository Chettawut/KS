<?php
define('ROOT_JS', str_replace("\\", '/', dirname(__FILE__)));
define(
    'PATH_JS',
    ROOT_JS == $_SERVER['DOCUMENT_ROOT'] ? '' : substr(ROOT_JS, strlen($_SERVER['DOCUMENT_ROOT']))
);
?>

<!-- jQuery -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<!-- <script src="<?php echo PATH_JS; ?>/AdminLTE-3.2.0/plugins/jqvmap/jquery.vmap.min.js"></script> -->
<!-- <script src="<?php echo PATH_JS; ?>/AdminLTE-3.2.0/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
<!-- jQuery Knob Chart -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/moment/moment.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
</script>
<!-- Summernote -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>
<!-- AdminLTE App -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.js"></script>
<!-- <script src="AdminLTE-3.2.0/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/dist/js/pages/dashboard.js"></script> -->
<script src="<?php echo PATH; ?>/addon/bootstrap-select/dist/js/bootstrap-select.js"></script>
<!-- <script src="<?php echo PATH; ?>/addon/bootstrap-select/dist/js/i18n/defaults-*.min.js"></script> -->

<script>
    $(document).ready(function() { 
        const store = localStorage.getItem('menu'); 
        const menu = !!store ? JSON.parse(store) : null;
        if(!!menu){
            const m = $(`a.main-link[menu-id=${menu.menuId}]`);
            const s = $(`a[sub-menu-id=${menu.subMenuId}]`);
            const lt = m.closest("li.nav-item");

            m.addClass("active");
            s.addClass("active");
            lt.addClass("menu-open");
        }
        setTimeout(() => {
            $(".preloader .animation__shake").hide();
            $(".preloader").height("0px");
        }, 800);
    });

    $(document).on("mousedown mouseup click", "a.nav-link", function(){
        const pAction = $(this).attr("group-id");
        const menuId = $(this).attr("menu-id");
        const subMenuId = $(this).attr("sub-menu-id");
        localStorage.setItem('menu', JSON.stringify({menuId : menuId, subMenuId:subMenuId}));
        if(!!pAction){
            const groupId = $(this).attr("group-id");
            const groupName = $(this).attr("group-name");
            //const typeId = $(this).attr("type-id");
            //const typeName = $(this).attr("type-name");
            const stored = {
                groupId : groupId,
                groupName : groupName,
                //typeId : typeId,
                //typeName : typeName
            }
            localStorage.setItem('acmenu', JSON.stringify(stored));
            $(this).blur();
        }else{
            localStorage.removeItem('acmenu');
        } 
    });
</script>