<div class="modal fade bd-example-modal-xl" id="modelUserEdit" tabindex="-1" role="dialog"
    aria-labelledby="modelEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content w3-flat-turquoise">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel"><i class="fa fa-users" aria-hidden="true"></i>
                    แก้ไขผู้ใช้ (Edit User)</h2>
            </div>
            <form name="frmEditUser" id="frmEditUser" method="POST" style="padding:10px;" action="javascript:void(0);">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-5 col-12">
                            <label class="col-form-label">User</label>
                            <input type="text" class="form-control" name="editusername" id="editusername">
                        </div>
                        <div class="form-group col-lg-5 col-12">
                            <label class="col-form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required disabled>
                        </div>
                        <div class="form-group col-lg-2 col-12">
                            <label class="col-form-label">รีเซ็ต Password</label>
                            <button type="button" class="btn btn-secondary form-control" data-toggle="modal"
                                data-target="#modal_reset" data-dismiss="modal">Reset</button>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="col-form-label">ชื่อจริง</label>
                            <input type="text" class="form-control" name="editfirstname" id="editfirstname">
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label">ชื่อสกุล</label>
                            <input type="text" class="form-control" name="editlastname" id="editlastname">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="col-form-label">ประเภท</label>
                            <select class="form-control" name="edittype" id="edittype">
                                <option value="01">ฝ่ายขาย</option>
                                <option value="02">คนจัดเก็บข้อมูล</option>
                                <option value="99">Admin</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label">Status</label>
                            <select class="form-control" name="editstatus" id="editstatus">
                                <option value="Y">Y</option>
                                <option value="N">N</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <label class="col-form-label">Email</label>
                            <input type="text" class="form-control" name="editemail" id="editemail">
                        </div>
                    </div>


                    <!-- <div class="form-group col-md-6">
                                <label for="inputEmail4">Money</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" disabled>
                            </div> -->



                    <input type="hidden" class="form-control" name="code" id="code" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" form="frmEditUser" class="btn btn-primary">แก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>