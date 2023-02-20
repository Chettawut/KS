<div class="modal fade bd-example-modal-xl" tabindex="-1" id="modal_edit" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content w3-flat-turquoise">
            <div class="modal-header bg-gradient-secondary">
                <h5 class="modal-title">แก้ไขนายจ้าง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="frmEditCustomer" id="frmEditCustomer" method="POST" style="padding:10px;"
                    action="javascript:void(0);" enctype="multipart/form-data">
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
                            <label class="col-form-label">วันที่ </label>
                            <input type="date" class="form-control" name="empbirth" id="empbirth" required>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">แนบไฟล์ :</label>
                            <div class="file-list d-flex flex-column" style="gap:0.6rem;">
                                <template>
                                    <div class="input-group" temp>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="atthFile"
                                                onchange="fileChange(this)">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append d-none">
                                            <button type="button" class="btn btn-sm rounded" onclick="removeFile(this)">
                                                <i class="far fa-times-circle text-danger"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <!-- <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="atthFile"
                                            onchange="fileChange(this)">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append d-none">
                                        <button type="button" class="btn btn-sm rounded" onclick="removeFile(this)">
                                            <i class="far fa-times-circle text-danger"></i>
                                        </button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </form>
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