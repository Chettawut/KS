<div class="modal fade bd-example-modal-xl" tabindex="-1" id="modal_edit" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content w3-flat-turquoise">
            <div class="modal-header bg-gradient-secondary">
                <h5 class="modal-title">แก้ไขลูกจ้าง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="frmEditWorker" id="frmEditWorker" method="POST" style="padding:10px;" action="javascript:void(0);" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 col-sm-12 d-flex gap-2" style="gap: 8px;">
                            <div class="col-msd-3 p-0">
                                <label class="col-form-label">คำนำหน้า :</label>
                                <select class="custom-select" name="titlename" id="titlename" required>
                                    <option value=""></option>
                                    <option value="นาย">นาย</option>
                                    <option value="น.ส.">น.ส.</option>
                                    <option value="นาง">นาง</option>
                                    <option value="ว่าที่ร้อยตรี">ว่าที่ร้อยตรี</option>
                                    <option value="ดร.">ดร.</option>
                                </select>
                            </div>
                            <div class="col-md-9 p-0">
                                <label class="col-form-label">ชื่อ :</label>
                                <input type="text" class="form-control" name="wkname" id="wkname" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">นามสกุล :</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" value="" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">รหัสบัตรประชาชน :</label>
                            <input type="text" class="form-control" name="idcode" id="idcode" value="">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">พาสปอร์ต :</label>
                            <input type="text" class="form-control" name="passport" id="passport" value="" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">วันเกิด :</label>
                            <input type="date" name="wkbirth" id="wkbirth" class="form-control" />
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">วันหมดอายุ พาสปอร์ต:</label>
                            <input type="date" name="passportexpired" id="passportexpired" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">นายจ้าง :</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%; height: 100%;" name="empcode" data-placeholder="เลือกนายจ้าง" data-allow-clear="true">
                                <!--  -->
                            </select>
                        </div>
                    </div>
                </form>
                <div class="section-attach-file">
                    <div class="card">
                        <div class="card-header border-0 w-100 d-flex align-items-center justify-content-between">
                            <h4 class="card-title col-6" style="font-size: 0.9rem; font-weight: 600;">รายการ ไฟล์แนบ</h4>
                            <div class="card-tools col-6 text-right">
                                <a href="#" class="btn btns-tool btn-sm btn-secondary" data-toggle="modal" data-target="#modal-attach" onclick="openMgnFile('#attachFileListEdit')">
                                    <i class="fas fa-paperclip"></i>
                                    <span>แนบไฟล์เอกสาร</span>
                                </a>
                                <input type="file" class="custom-file-input d-none" name="atthFile" onchange="attached(event, '#attachFileListEdit')">
                            </div>
                        </div>
                        <div class="card-body table-responsives overflow-auto pt-0" style="max-height:36vh;">
                            <table class="table table-striped table-valign-middle table-bordered table-hovers" id="attachFileListEdit">
                                <thead class="sticky-top table-secondary">
                                    <tr>
                                        <th style="width: 75px; text-align: center;">ลำดับ</th>
                                        <th style="min-width: 100px;">หัวข้อไฟล์</th>
                                        <th style="min-width: 300px;">ไฟล์แนบ</th>
                                        <th style="width: 125px; text-align: center;">ตัวเลือก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" align="center" class="bg-secondary">ไม่มีข้อมูลไฟล์</td>
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
                    <button type="submit" form="frmEditWorker" class="btn btn-primary">แก้ไข</button>
                </div>
            </div>
        </div>
    </div>
</div>