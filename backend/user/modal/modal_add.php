<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel"><i class="fa fa-users" aria-hidden="true"></i>
                    เพิ่มผู้ใช้ (Add User)</h2>
            </div>
            <form name="frmAddUser" id="frmAddUser" action="" method="post">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="col-form-label">User</label>
                            <input type="text" class="form-control" name="userusername" id="userusername" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="col-form-label">Password</label>
                            <input type="password" class="form-control" name="userpassword" id="userpassword" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">

                            <label class="col-form-label">ชื่อจริง</label>
                            <input type="text" class="form-control" name="userfirstname" id="userfirstname" required>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label">นามสกุล</label>
                            <input type="text" class="form-control" name="userlastname" id="userlastname" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="col-form-label">ประเภท</label>
                            <select class="form-control" name="usertype" id="usertype">
                                <option value="01">Store</option>
                                <option value="02">Sales Leader</option>
                                <option value="03">Accounting</option>
                                <option value="04">Manager</option>
                                <option value="05">Sales</option>
                                <option value="99">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" name="usertel" id="usertel">
                        </div>

                    </div>


                    <div class="form-row">
                        <div class="col-md-12">
                            <label class="col-form-label">Email</label>
                            <input type="email" class="form-control" name="useremail" id="useremail">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>
            </form>

        </div>
    </div>
</div>