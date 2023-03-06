<?php
define('ROOT_CSS', str_replace("\\", '/', dirname(__FILE__)));
define(
    'PATH_CSS',
    ROOT_CSS == $_SERVER['DOCUMENT_ROOT']
        ? '' : substr(ROOT_CSS, strlen($_SERVER['DOCUMENT_ROOT']))
);
?>
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.theme.min.css">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/select2/css/select2.min.css"> 
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css">

<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo PATH; ?>/backend/AdminLTE-3.2.0/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?php echo PATH; ?>/addon/bootstrap-select/dist/css/bootstrap-select.min.css">

<style>
    .select-custom {
        background-color: white;
        border: 1px solid #ced4da;
    }

    div.bootstrap-select .select-custom:hover,
    div.bootstrap-select .select-custom:focus,
    div.bootstrap-select .select-custom:active {
        outline: none !important;
        border-color: #80bdff;
    }
    div.bootstrap-select .dropdown-toggle::after {
        margin-top: 0px !important;
        display: inline-block;
        margin-left: .255em;
        vertical-align: .255em;
        content: "";
        border-top: .3em solid #888;
        border-right: .3em solid transparent;
        border-bottom: 0;
        border-left: .3em solid transparent;
        transition:  all 0.4s linear;
    }
</style>