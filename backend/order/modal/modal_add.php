<div class="modal fade bd-example-modal-xl" tabindex="-1" id="modal_add" role="dialog" data-backdrop="static" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
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
                            <div class="form-group">
                                <label class="col-form-label">ค้นหาลูกค้า(นายจ้าง)<strong class="text-danger">*</strong> :</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%; height: 100%;" name="empcode" , id="empcode" data-placeholder="เลือกนายจ้าง" data-allow-clear="true" onchange="customerSelected(event)" condi>
                                    <!--  -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">ประเภทใบงาน<strong class="text-danger">*</strong> :</label>

                                <select class="form-control selectpicker" name="sotype" id="sotype" placeholder="เลือกประเภทใบงาน"  data-container="#modalAdd" condi>
                                    <option value="">เลือกประเภทใบงาน</option>
                                    <option value="รายงานตัว90วัน">รายงานตัว90วัน</option>
                                    <option value="เปลี่ยนนายจ้าง">เปลี่ยนนายจ้าง</option>
                                    <option value="ต่อวีซ่า">ต่อวีซ่า</option>
                                    <option value="ทำพาสปอร์ต">ทำพาสปอร์ต</option>
                                    <option value="นำเข้าแรงงานMOU">นำเข้าแรงงานMOU</option>
                                    <option value="ผลิตบัตรชมพู">ผลิตบัตรชมพู</option>
                                    <option value="ต่อใบอนุญาติทำงาน">ต่อใบอนุญาติทำงาน</option>
                                    <option value="ขึ้นทะเบียนใหม">ขึ้นทะเบียนใหม่</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            <label class="col-form-label">รหัสลูกค้า(นายจ้าง) : </label>
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
                <div class="section-add" id="addList">
                    <div class="card" id="sec-add-list" block-event="true">
                        <div class="card-header">
                            <h4 class="card-title col-6" style="font-size: 0.9rem; font-weight: 600;">เพิ่มรายการ</h4>
                        </div>
                        <div class="card-body p-3">
                            <form action="#" id="form-list-add">
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">เลือกรายการ(ลูกจ้าง)<strong class="text-danger">*</strong> :</label>
                                            <select class="form-control select2 select2-hidden-accessible" multiple="multiple" style="width: 100%; height: 100%;" name="wkcode" data-placeholder="เลือกลูกจ้าง" data-allow-clear="true" required>
                                                <!--  -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">&nbsp;<strong class="text-danger"></strong></label>
                                            <div class="w-100 button-group d-flex align-items-end">
                                                <button class="btn btn-success mb-3" type="button" data-toggle="modal" data-target="#modal-add-multi">
                                                    <i class="far fa-list-alt mr-2"></i>
                                                    <span>เลือกแบบหลายรายการ</span>
                                                </button>
                                            </div>
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
                                            <select class="custom-select form-control selectpicker" name="payment" id="payment">
                                                <option value="">เลือกการชำระเงิน</option>
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
                                <div class="col-md-12 col-sm-12 pt-3 text-right">
                                    <button class="btn btns-tool btn-sm btn-primary btn-add-row" id="btn-list-add">
                                        <i class="far fa-plus-square mr-2"></i>
                                        <span>เพิ่มรายการ</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
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
                                            <th style="width: 140px; text-align: end;">ราคา</th>
                                            <th style="width: 140px; text-align: center;">การชำระเงิน</th>
                                            <th style="text-align: center;">หมายเหตุ</th>
                                            <th style="width: 60px; text-align: center;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" align="center" class="bg-secondary-50">ไม่มีรายการ</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="sticky-bottom table-defalut bg-secondary">
                                        <tr>
                                            <td colspan="2" class="border-left-0 border-right-0" >รวมเงิน (Total)</td>
                                            <td class="border-left-0 border-right-0 text-right" >0.00</td>
                                            <td class="border-left-0 border-right-0 text-center" >บาท(หน่วย)</td>
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