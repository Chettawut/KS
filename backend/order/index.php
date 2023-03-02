<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../');
    exit;
}
include_once('../conn.php');
$TITLE = "ใบรับงาน (Sales Order)";
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$TITLE?></title>

    <?php
    include_once('css.php');
    include_once('../../config.php');
    include_once('../import_css.php');
    include_once ROOT_CSS . '/func.php';
    ?>

    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            padding: .46875rem .75rem;
            height: calc(2.25rem + 2px);
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow { 
            padding: 0.46875rem 0.75rem;
            height: calc(2.25rem + 2px);
        }
    </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo PATH; ?>/backend/img/logo_fb.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <?php include_once ROOT_CSS . '/menu_head.php'; ?>

        <?php include_once ROOT_CSS . '/menu_left.php'; ?>


        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> <i class="nav-icon fas fa-receipt"></i> <?=$TITLE?></h1>
                        </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <form data-ajax="false" target="_blank" method="post">
                                <div data-role="fieldcontain">
                                    <div class="btn-group" id="btnAddSO" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add"><i class="fa fa fa-tags" aria-hidden="true"></i>
                                            เพิ่มใบงาน
                                        </button>
                                        <button type="button" id="btnRefresh" class="btn btn-primary"><i class="fas fa-sync-alt" aria-hidden="true"></i> Refresh</button>
                                    </div>
                                    <div class="btn-group" id="btnBack" style="display:none;" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-success">
                                            <i class="fa fa fa-tags" aria-hidden="true"></i>
                                            ย้อนกลับ
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <table name="tableList" id="tableList" class="table table-bordered table-striped w-100"></table>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <?php include_once('modal/modal_add.php'); ?>
        <?php include_once('modal/modal_edit.php'); ?>
        <?php include_once('modal/modal_attach_file.php'); ?> 
    </div>

    <?php
    include_once ROOT_CSS . '/import_js.php';


    include_once('js.php');
    ?>

</body>

</html>
<?php

?>