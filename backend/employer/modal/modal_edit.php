<div class="modal fade bd-example-modal-xl" tabindex="-1" id="modal_edit" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content w3-flat-turquoise">
            <div class="modal-header bg-gradient-secondary">
                <h5 class="modal-title">แก้ไขนายจ้าง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="frmEditCustomer" id="frmEditCustomer" method="POST" style="padding:10px;" action="javascript:void(0);" enctype="multipart/form-data">
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
                                <input type="text" class="form-control" name="empname" id="empname" value="" required>
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
                            <input type="text" class="form-control" name="idcode" id="idcode" value="" required>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">พาสปอร์ต :</label>
                            <input type="text" class="form-control" name="passport" id="passport" value="" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">วันเกิด :</label>
                            <input type="date" class="form-control" name="empbirth" id="empbirth" required>
                        </div>
                    </div>
                    <!-- <div class="form-row">
                        <div class="file-group w-100 d-flex ">
                            <div class="col-md-6 col-sm-12">
                                <label class="col-form-label">ชื่อไฟล์ :
                                    <small class="text-danger d-none">
                                        <i class="fas fa-info-circle"></i>
                                        กรุณากรอกชื่อไฟล์ก่อนแนบไฟล์ทุกครั้ง
                                    </small>
                                </label>
                                <input type="text" class="form-control" name="attname" id="attname" value="" placeholder="กรุณากรอกชื่อไฟล์">
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="file-list d-flex flex-column h-100 justify-content-end py-1" style="gap:0.6rem;">
                                    <div class="input-group">
                                        <div class="custom-file h-100 justify-content-start" style="gap:10px;">
                                            <input type="file" class="custom-file-input d-none" name="atthFile" onchange="fileChange(this)">
                                            <small class="text-nowrap text-truncate attach-lable" style="max-width: 100%;">กรุณาแนบไฟล์...</small>
                                            <button type="button" class="btn-at btn btn-sm btn-primary rounded-circle" uloadFile style="width: 30px;height: 30px;">
                                                <i class="fas fa-paperclip"></i>
                                            </button>
                                            <button type="button" class="btn-dl btn btn-sm btn-danger rounded-circle d-none" onclick="removeFile(this)" style="width: 30px;height: 30px;">
                                                <i class="fas fa-times text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </form>
                <template form_upfile>
                    <div class="form-row" addnew>
                        <div class="file-group w-100 d-flex ">
                            <div class="col-md-6 col-sms-12">
                                <label class="col-form-label">
                                    ชื่อไฟล์ :
                                    <small class="text-danger d-none">
                                        <i class="fas fa-info-circle"></i>
                                        กรุณากรอกชื่อไฟล์ก่อนแนบไฟล์ทุกครั้ง
                                    </small>
                                </label>
                                <input type="text" class="form-control" name="attname" id="attname" value="" placeholder="กรุณากรอกชื่อไฟล์">
                            </div>
                            <div class="col-md-6 col-sms-12">
                                <div class="file-list d-flex flex-column h-100 justify-content-end py-1" style="gap:0.6rem;">
                                    <div class="input-group">
                                        <div class="custom-file h-100 justify-content-start" style="gap:10px;">
                                            <input type="file" class="custom-file-input d-none" name="atthFile" onchange="fileChange(this)">
                                            <small class="text-nowrap text-truncate attach-lable" style="max-width: 100%;">กรุณาแนบไฟล์...</small>
                                            <button type="button" class="btn-at btn btn-sm btn-primary rounded-circle" uloadFile style="width: 30px;height: 30px;">
                                                <i class="fas fa-paperclip"></i>
                                            </button>
                                            <button type="button" class="btn-dl btn btn-sm btn-danger rounded-circle d-none" onclick="removeFile(this)" style="width: 30px;height: 30px;">
                                                <i class="fas fa-times text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="modal-footer">
                <div class="col text-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" form="frmEditCustomer" class="btn btn-primary">แก้ไข</button>
                </div>
            </div>
        </div>
    </div>
</div>