<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ../../');
        exit;
    }
    include_once('../conn.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการผู้ใช้ (User)</title>

    <?php 
    include('css.php'); 
    include_once('../config.php');
    include_once ROOT .'/func.php';
    include_once ROOT .'/import_css.php';
    ?>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo PATH; ?>/AdminLTE-3.2.0/dist/img/AdminLTELogo.png"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <?php include_once ROOT . '/menu_head.php'; ?>

        <?php include_once ROOT . '/menu_left.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">

                            <h1 class="m-0"><i class="fas fa-users"></i> จัดการผู้ใช้งาน (User)</h1>
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
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#modal_add"><i class="fa fa-plus-circle"
                                                aria-hidden="true"></i>
                                            เพิ่มผู้ใช้</button>
                                        <button type="button" id="btnRefresh" class="btn btn-primary"><i
                                                class="fas fa-sync-alt" aria-hidden="true"></i> Refresh</button>
                                    </div>
                                    <div class="btn-group" id="btnBack" style="display:none;" role="group"
                                        aria-label="Basic example">
                                        <button type="button" class="btn btn-success"><i class="fa fa fa-tags"
                                                aria-hidden="true"></i>
                                            ย้อนกลับ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <table name="tableUser" id="tableUser" class="table table-bordered table-striped">
                                <thead style=" background-color:#D6EAF8;">
                                    <tr>
                                        <th width="25%">Username</th>
                                        <th width="25%">ชื่อ</th>
                                        <th width="25%">นามสกุล</th>
                                        <th width="25%" style="text-align:center">ประเภท</th>


                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </section>

            <?php include_once('modal/modal_add.php');?>
            <?php include_once('modal/modal_edit.php');?>
        </div>

        <?php 
    
    include_once ROOT . '/import_js.php';
    

    include_once('js.php'); 
    ?>
</body>

</html>