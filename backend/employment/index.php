<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../');
    exit;
}
include_once('../conn.php');
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เคสลูกค้า (Employer)</title>

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

<body class="hold-transition sidebar-mini  ">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo PATH; ?>/backend/img/logo_fb.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <?php include_once ROOT_CSS . '/menu_head.php'; ?>

        <?php include_once ROOT_CSS . '/menu_left.php'; ?>

        <div class="content-wrapper" style="min-height: 1604.44px;">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1
                            style="letter-spacing: 0.7px;"
                            >จัดการ การจ้างงาน(Employment)</h1>
                        </div>
 
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="error-page d-flex flex-column align-items-center w-100">
                    <h2 class="headline text-danger"
                    style="    
                    font-weight: 500;
                    text-shadow: 2.6px 1px 3px #b1b1b1;
                    font-size: 7.6vw;
                    letter-spacing: 13px;"
                    >Coming soon</h2>
                    <div class="error-content"> 
 
                    </div>
                </div>

            </section>

        </div>

        <?php include_once('modal/modal_add.php'); ?>
        <?php include_once('modal/modal_edit.php'); ?>

    </div>

    <?php
    include_once ROOT_CSS . '/import_js.php';


    include_once('js.php');
    ?>

</body>

</html>
<?php

?>