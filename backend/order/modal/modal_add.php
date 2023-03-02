<div class="modal fade bd-example-modal-xl" tabindex="-1" id="modal_add" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content w3-flat-turquoise">
            <div class="modal-header bg-gradient-secondary">
                <h5 class="modal-title">เพิ่มลูกจ้าง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="modalAdd" id="modalAdd" method="POST" style="padding:10px;" action="javascript:void(0);" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">ค้นหาลูกค้า(นายจ้าง) :</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%; height: 100%;" name="empcode" data-placeholder="เลือกนายจ้าง" data-allow-clear="true" onchange="customerSelected(event)" required>
                                <!--  -->
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">ประเภทใบงาน :</label>

                            <select class="custom-select form-control" name="sotype" id="sotype" placeholder="เลือกประเภทใบงาน" required>
                                <option value="">เลือกประเภทใบงาน</option>
                                <option value="90">90 วัน</option>
                                <option value="30">30 วัน</option>
                                <option value="99">เด๋วขอเข้าพรุ่งนี้</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">รหัสลูกค้า(นายจ้าง) :</label>
                            <input type="text" class="form-control" id="empcode" value="" readonly>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">ชื่อลูกค้า :</label>
                            <input type="text" class="form-control" id="empname" value="" disabled="true">
                        </div>
                    </div>
                    <div class="form-row">

                    </div>
                </form>
                <div class="section-attach-file">
                    <div class="card">
                        <div class="card-header border-0 w-100 d-flex align-items-center justify-content-between">
                            <h4 class="card-title col-6" style="font-size: 0.9rem; font-weight: 600;">รายการ(ลูกจ้าง)</h4>
                            <div class="card-tools col-6 text-right">
                                <button class="btn btns-tool btn-sm btn-primary btn-add-row">
                                    <i class="far fa-plus-square mr-2"></i>
                                    <span>เพิ่มรายการ</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body table-responsives overflow-auto pt-0" style="max-height:36vh;">
                            <table class="table table-striped table-valign-middle table-bordered table-hovers" id="attachFileList">
                                <thead class="sticky-top table-defalut">
                                    <tr>
                                        <th style="width: 100px;">ลำดับ</th>
                                        <th >รายการ(ลูกค้า)</th>
                                        <th >ราคา</th>
                                        <th style="width: 120px;">การชำระเงิน</th>
                                        <th >หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" align="center" class="bg-secondary-50">ไม่มีข้อมูลไฟล์</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col text-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" form="modalAdd" class="btn btn-primary">เพิ่ม</button>
                </div>
            </div>
        </div>
    </div>
</div>