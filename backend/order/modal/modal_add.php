<div class="modal fade bd-example-modal-xl pl-0" tabindex="-1" id="modal_add" role="dialog" data-backdrop="static" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content w3-flat-turquoise">
            <div class="modal-header bg-gradient-secondary">
                <h5 class="modal-title">เพิ่มใบรับงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="modalAdd" id="modalAdd" method="POST" style="padding:10px;" action="javascript:void(0);" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">ค้นหาลูกค้า(นายจ้าง)<strong class="text-danger">*</strong> :</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%; height: 100%;" name="empcode" , id="empcode" data-placeholder="เลือกนายจ้าง" data-allow-clear="true" onchange="customerSelected(event)" condi>
                                    <!--  -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">ประเภทใบงานรับงาน<strong class="text-danger">*</strong> :</label>

                                <input type="text" class="form-control" id="productgroupname" value="" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">ลูกค้า(นายจ้าง) : </label>
                            <input type="text" class="form-control" id="customer" value="" readonly  placeholder="โปรดเลือกลูกค้า">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">เบอร์โทรศัพท์ :</label>
                            <input type="text" class="form-control" id="tel" name="tel" value="" placeholder="กรอกเบอร์โทรศัพท์">
                        </div>
                    </div>
                    <div class="form-row">

                    </div>
                </form>
                <div class="section-add" id="addList">
                    <div class="card" id="sec-add-list" block-event="true" titles="กรุณาเลือกข้อมูลให้ครบก่อน">
                        <div class="card-header">
                            <h4 class="card-title col-6" style="font-size: 0.9rem; font-weight: 600;">เพิ่มรายการ</h4>
                        </div>
                        <div class="card-body p-3">
                            <form action="#" id="form-list-add">
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">
                                                เลือกรายการ(ลูกจ้าง)
                                                <strong class="text-danger">*</strong> :
                                            </label>
                                            <div class="d-flex align-items-start">
                                                <select class="form-control select2 select2-hidden-accessible" multiple="multiple" style="width: 100%; height: 100%;" name="wkcode" data-placeholder="เลือกลูกจ้าง" data-allow-clear="true" required>
                                                    <!--  -->
                                                </select>
                                                <button class="btn ml-1 mt-2 btn-xs btn-success text-nowrap" type="button" data-toggle="modal" data-target="#modal-add-multi">
                                                    <i class="far fa-list-alt mr-2"></i>
                                                    <span>เลือกแบบหลายรายการ</span>
                                                </button>                                                
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">ประเภทรายการ<strong class="text-danger">*</strong> :</label>
                                            <select class="form-control selectpicker" name="productid" id="productid" title="เลือกประเภทรายการ">
                                                <!--  -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">ราคา<strong class="text-danger">*</strong> :</label>
                                            <input class="form-control" name="price" placeholder="กรอกราคา" numberOnly="true" addComma="true" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="payment">การชำระเงิน<strong class="text-danger">*</strong> :</label>
                                            <select class="form-control selectpicker" name="payment" id="payment" title="เลือกประเภทรายการ">
                                                <option value="เงินสด">เงินสด</option>
                                                <option value="โอนชำระ">โอนชำระ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="col-form-label" for="remark">หมายเหตุ :</label>
                                        <textarea class="form-control" name="remark" style="height: 10vh; max-height: 10vh; min-height: 10vh;"></textarea>
                                    </div>
                                </div>
                            </form>
                            <div class="form-row">
                                <div class="col-md-12 col-sm-12 pt-3 text-right sec-add">
                                    <button class="btn btns-tool btn-sm btn-primary btn-add-row" id="btn-list-add">
                                        <i class="far fa-plus-square mr-2"></i>
                                        <span>เพิ่มรายการ</span>
                                    </button>
                                </div>
                                <div class="col-md-12 col-sm-12 pt-3 text-right sec-edit d-none">
                                    <button class="btn btns-tool btn-sm btn-success btn-edit" id="btn-list-edit">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <span>ยืนยันการแก้ไข</span>
                                    </button>
                                    <button class="btn btns-tool btn-sm btn-secondary btn-cancel" id="btn-list-cancel">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        <span>ยกเลิก</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="sec-table-list" block-event="false" titles="รอแก้ไขข้อมูล">
                        <div class="card-header border-0 w-100 d-flex align-items-center justify-content-between">
                            <h4 class="card-title col-6" style="font-size: 0.9rem; font-weight: 600;">รายการ(ลูกจ้าง)</h4>
                            <!-- <div class="card-tools col-6 text-right">
  
                            </div> -->
                        </div>
                        <div class="card-body pt-0" style="min-height:36vh;">
                            <div class="table-responsives overflow-auto ">
                                <table class="table table-striped table-valign-middle table-bordered table-hovers text-nowarp" id="tableDetail">
                                    <thead class="sticky-top table-defalut bg-info">
                                        <tr>
                                            <th style="width: 80px;">ลำดับ</th>
                                            <th>รายการ(ลูกจ้าง)</th>
                                            <th>ประเภทรายการ</th>
                                            <th style="width: 140px; text-align: end;">ราคา</th>
                                            <th style="width: 140px; text-align: center;">การชำระเงิน</th>
                                            <th style="text-align: center; border-right-width: 0px;">หมายเหตุ</th>
                                            <th style="width: 60px; text-align: center; border-left-width: 0px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="7" align="center" class="bg-secondary-50">ไม่มีรายการ</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="sticky-bottom table-defalut bg-secondary">
                                        <tr>
                                            <td colspan="3" class="border-left-0 border-right-0">รวมเงิน (Total)</td>
                                            <td class="border-left-0 border-right-0 text-right">0.00</td>
                                            <td class="border-left-0 border-right-0 text-center">บาท(หน่วย)</td>
                                            <td class="text-center" colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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