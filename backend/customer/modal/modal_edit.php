<div class="modal fade bd-example-modal-xl" tabindex="-1" id="modal_edit" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content w3-flat-turquoise">
            <div class="modal-header bg-gradient-secondary">
                <h5 class="modal-title">แก้ไขลูกค้า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="frmEditCustomer" id="frmEditCustomer" method="POST" style="padding:10px;"
                action="javascript:void(0);">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="col-form-label">วันที่ </label>
                            <input type="date" class="form-control" name="cusdate" id="cusdate" required>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">Code Ref </label>
                            <input type="text" class="form-control" name="code" id="code" required>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">เลข Chaiyo </label>
                            <input type="text" class="form-control" name="codeno" id="codeno" value="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
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
                        <div class="col-md-4">
                            <label class="col-form-label">ชื่อ :</label>
                            <input type="text" class="form-control" name="cusname" id="cusname" value="" required>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">นามสกุล :</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" value="" required>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="col-form-label">ทะเบียนรถ </label>
                            <input type="text" class="form-control" name="plateno" id="plateno" value="">
                        </div>
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">ประเภทสินเชื่อ</label>
                            <select class="custom-select" name="credittype" id="credittype" required>
                                <option value=""></option>
                                <option value="จำนำ">จำนำ</option>
                                <option value="เช่าซื้อ">เช่าซื้อ</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">ไฟแนนซ์เดิม</label>
                            <input type="text" class="form-control" name="oldfinance" id="oldfinance">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <label class="col-form-label">ยอดปิดบัญชี </label>
                            <input type="number" class="form-control" name="closeprice" id="closeprice" step="0.01" >
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">ยอดปิดจาก Vender </label>
                            <input type="number" class="form-control" name="closevender" id="closevender" step="0.01" >
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">ส่วนต่าง </label>
                            <input type="number" class="form-control" name="diff" id="diff" disabled>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">ชื่อสาขา</label>
                            <input type="text" class="form-control" name="branch" id="branch">
                        </div>
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">จังหวัด</label>
                            <select class="form-control" name="province" id="province">
                                <?php getProvince();?>
                            </select>
                        </div>

                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">วันที่ยื่นตามเอกสารตัวจริง</label>
                            <input type="date" class="form-control" name="followdate" id="followdate">
                        </div>
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">วันที่รับเล่ม</label>
                            <input type="date" class="form-control" name="bookdate" id="bookdate">
                        </div>
                        <div class="col-md-4">
                            <label for="recipient-name" class="col-form-label">เลขที่ Tracking</label>
                            <input type="text" class="form-control" name="trackno" id="trackno">
                        </div>
                        

                    </div>
                    <input type="hidden" id="cuscode" name="cuscode">
                </div>
                <div class="modal-footer">
                    <div class="col text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" form="frmEditCustomer" class="btn btn-primary">แก้ไข</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>