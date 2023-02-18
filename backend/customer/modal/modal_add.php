<div class="modal fade bd-example-modal-xl" tabindex="-1" id="modal_add" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content w3-flat-turquoise">
            <div class="modal-header bg-gradient-secondary">
                <h5 class="modal-title">เพิ่มลูกค้า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="frmAddCustomer" id="frmAddCustomer" method="POST" style="padding:10px;"
                    action="javascript:void(0);">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="col-form-label">วันที่ </label>
                            <input type="date" class="form-control" name="add_cusdate" id="add_cusdate" required>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">Code Ref </label>
                            <input type="text" class="form-control" name="add_code" id="add_code" required>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">เลข Chaiyo </label>
                            <input type="text" class="form-control" name="add_codeno" id="add_codeno" value="">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-3">
                            <label class="col-form-label">คำนำหน้า :</label>
                            <select class="custom-select" name="add_titlename" id="add_titlename" required>
                                <option value=""></option>
                                <option value="นาย">นาย</option>
                                <option value="น.ส.">น.ส.</option>
                                <option value="นาง">นาง</option>
                                <option value="ว่าที่ร้อยตรี">ว่าที่ร้อยตรี</option>
                                <option value="ดร.">ดร.</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">ชื่อ :</label>
                            <input type="text" class="form-control" name="add_cusname" id="add_cusname" value="" required>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">นามสกุล :</label>
                            <input type="text" class="form-control" name="add_lastname" id="add_lastname" value="" required>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="col-form-label">ทะเบียนรถ </label>
                            <input type="text" class="form-control" name="add_plateno" id="add_plateno" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">ประเภทสินเชื่อ</label>
                            <select class="custom-select" name="add_credittype" id="add_credittype" required>
                                <option value=""></option>
                                <option value="จำนำ">จำนำ</option>
                                <option value="เช่าซื้อ">เช่าซื้อ</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">ไฟแนนซ์เดิม</label>
                            <input type="text" class="form-control" name="add_oldfinance" id="add_oldfinance">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="col-form-label">ยอดปิดบัญชี </label>
                            <input type="number" class="form-control" name="add_closeprice" id="add_closeprice" step="0.01" value="">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">ยอดปิดจาก Vender </label>
                            <input type="number" class="form-control" name="add_closevender" id="add_closevender" step="0.01" value="">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">ส่วนต่าง </label>
                            <input type="text" class="form-control" name="add_diff" id="add_diff" value="">
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">ชื่อสาขา</label>
                            <input type="text" class="form-control" name="add_branch" id="add_branch">
                        </div>
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">จังหวัด</label>
                            <select class="form-control" name="add_province" id="add_province">
                                <?php getProvince();?>
                            </select>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col text-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" form="frmAddCustomer"
                        class="btn btn-primary">เพิ่ม</button>
                </div>
            </div>
        </div>
    </div>
</div>