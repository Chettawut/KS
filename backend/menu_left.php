<?php
$MENU_ICON = array(
    "รายงานตัว 90 วัน" => '<i class="nav-icon far fa-file-alt"></i>',
    "เปลี่ยนนายจ้าง" => '<i class="nav-icon fas fa-sync"></i>',
    "ต่อวีซ่า" => '<i class="nav-icon fas fa-paper-plane"></i>',
    "ทำพาสปอร์ต" => '<i class="nav-icon fas fa-passport"></i>',
    "นำเข้าแรงงาน MOU" => '<i class="nav-icon fas fa-people-arrows"></i>',
    "ผลิตบัตรชมพู" => '<i class="nav-icon fas fa-address-card"></i>',
    "ต่อใบอนุญาติทำงาน" => '<i class="nav-icon fas fa-business-time"></i>',
    "ขึ้นทะเบียนใหม่" => '<i class="nav-icon fas fa-user-plus"></i>',
);
try {
    $PRODUCT_MENU = array();
    $sql = "select * from productgroup p order by seq;";
    $stmt = $conn->prepare($sql);
    if (!$stmt->execute()) {
        throw new mysqli_sql_exception("Insert data error.");
    }
    $resultSet = $stmt->get_result();
    $res = $resultSet->fetch_all(MYSQLI_ASSOC); //MYSQLI_ASSOC 
    // Free result set
    $stmt->free_result();

    foreach ($res as $x => $val) {
        $sql = "select * from productlists p where productgroupid = ? order by seq;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $val["id"]);
        if (!$stmt->execute()) {
            throw new mysqli_sql_exception("Insert data error.");
        }
        $resultSet = $stmt->get_result();
        $sub = $resultSet->fetch_all(MYSQLI_ASSOC); //MYSQLI_ASSOC 
        // Free result set
        $stmt->free_result();
        array_push($PRODUCT_MENU, array("id" => $val["id"], "group" => $val["productgroupname"], "lists" => $sub));
    }
    //var_dump($PRODUCT_MENU);
} catch (mysqli_sql_exception $e) {


    http_response_code(400);
    echo json_encode(array('status' => '0', 'message' => "Sql fail."));
    die;
} finally {
    mysqli_close($conn);
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo PATH; ?>/backend/" class="brand-link">
        <img src="<?php echo PATH; ?>/backend/img/logo_fb.png" class="brand-image img-circle elevation-3" style="background-color:white;width:45px;margin-top:1px;">
        <span class="brand-text font-weight-light">เทพกระษัตรี</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo PATH; ?>/backend/img/default.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?> </a>
            </div>
        </div>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- <li class="nav-header">Systems</li>
                <li class="nav-item">
                    <a href="<?php echo PATH; ?>/backend/customer" class="nav-link">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>
                        เคสลูกค้า (Customer)
                        </p>
                    </a>
                </li> -->
                <li class="nav-header">เพิ่มข้อมูล</li>
                <li class="nav-item">
                    <a href="<?php echo PATH; ?>/backend/employer" class="nav-link main-link" menu-id="employer">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>นายจ้าง</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo PATH; ?>/backend/worker" class="nav-link main-link" menu-id="worker">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>ลูกจ้าง</p>
                    </a>
                </li>
                <li class="nav-header">สร้างใบงาน</li>
                <?php foreach ($PRODUCT_MENU as $menu) { ?>
                    <li class="nav-item">
                        <a 
                        href="<?php echo PATH; ?>/backend/order?g=<?= $menu['id'] ?>" 
                        class="nav-link main-link" 
                        group-id="<?= $menu["id"] ?>" 
                        group-name="<?= $menu["group"] ?>" 
                        menu-id="order-<?= $menu["id"] ?>"
                        >
                            <?= $MENU_ICON[$menu["group"]] ?>
                            <!-- <p> -->
                                <?= $menu["group"] ?>
                                <!-- <i class="right fas fa-angle-left"></i> -->
                            <!-- </p> -->
                        </a>
                        <!-- <ul class="nav nav-treeview d-none">
                            <?php foreach ($menu["lists"] as $sub) { ?>
                                <li class="nav-item">
                                    <a 
                                    href="<?php echo PATH; ?>/backend/order" 
                                    class="nav-link" 
                                    type-id="<?= $sub["id"] ?>" 
                                    type-name="<?= $sub["productname"] ?>" 
                                    type-group-name="<?= $menu["group"] ?>" 
                                    type-group-id="<?= $menu["id"] ?>"
                                    sub-menu-id="order-<?= $sub["id"] ?>"
                                    menu-id="order-<?= $menu["id"] ?>"
                                    >
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?= $sub["productname"] ?></p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul> -->
                    </li>
                <?php } ?>

                <li class="nav-header">ตั้งค่า</li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link main-link" menu-id="setting">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            จัดการระบบ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo PATH; ?>/backend/user" class="nav-link" sub-menu-id="user" menu-id="setting">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    จัดการผู้ใช้งาน (User)
                                </p>
                            </a>
                        </li> 
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>