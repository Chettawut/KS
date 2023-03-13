<script src="<?= PATH ?>/addon/thai-bath/thai-bath.js"></script>
<script src="src/index.js"></script>
<script type="text/javascript">
    let _employer_option = undefined;
    let _worker_option = undefined;
    let _worker_mult_option = undefined;
    let _product_list_option = undefined;
    let _tableList = [];
    let _orderDetailList = [];
    let _orderList = [];
    let _orderListSeleted = [];
    $(async function() {
        _orderList = await gettingOrder();

        gettingOptionEmployer().then((result) => {
            _employer_option = result
        });

        gettingOptionProductList().then((result) => {
            _product_list_option = result

        });

        let dataArray = _orderList.map(m => setRowTable(m));
        let ignoreSorting = HEADER.map((m, i) => (["ตัวเลือก", "สถานะ"].includes(m.title) ? i : -1)).filter(f => f != -1);
        let configTb = {
            lengthMenu: [
                [10, 20, 50, -1],
                ['10', '20', '50', 'All']
            ],
            order: [
                [0, 'asc']
            ],
            columnDefs: [{
                'targets': ignoreSorting,
                'orderable': false,
            }],
            createdRow: actionRow
        }
        tables("#tableList", HEADER, dataArray, configTb);
    });

    $("#btnRefresh").click(function() {
        window.location.reload();
    });



    //แก้ไขลูกจ้าง
    $("#frmEditWorker").submit(async function(e) {
        e.preventDefault();
        $(':disabled').each(function(e) {
            $(this).removeAttr('disabled');
        });
        let wkcode = $("#modal_edit").attr("data-wkcode");
        let form = $(this).serializeArray();
        let formData = new FormData();

        let fileUpdate = _fileList.filter(f => f?.upd);
        let fileAttach = _fileList.filter(f => !f.attached);

        for (let f of fileUpdate) {
            if (f.udf) formData.append(`file${f.code}`, f.file);
            let a = (_attachList.filter(e => e.code == f.code))[0];
            let p = a.url.split("//");
            let r = p[p.length - 1];
            _fileFormData.push({
                attname: f.attname,
                file_name: !f.udf ? f.attname : null,
                code: f.code,
                url: a.url,
                percode: a.percode,
                fname: r.slice(0, r.lastIndexOf(".")),
            });
        }

        for (let f of fileAttach) {
            formData.append("file[]", f.file);
            formData.append("attname[]", f.attname);
        }

        for (let f of form) {
            formData.append(f.name, f.value);
        }

        formData.append("fileData", JSON.stringify(_fileFormData));
        formData.append("fileDelete", JSON.stringify(_filesDelete));
        formData.append("wkcode", wkcode);
        $.ajax({
            type: "POST",
            url: "ajax/edit_worker.php",
            processData: false,
            contentType: false,
            data: formData,
            success: async function(result) {
                if (result.status == 1) // Success
                {
                    await Swal.fire('สำเร็จ', result.message, 'success');
                    window.location.reload();
                    // console.log(result.message);
                } else {
                    Swal.fire('เกิดข้อผิดพลาด', "เกิดปัญหาในหารเพิ่มข้อมูลกรุณาลองใหม่อีกครั้ง", 'error');
                }
            },
            error: function(error) {
                Swal.fire('เกิดข้อผิดพลาด', error.responseText, 'error')
            }
        });

    });

    $(document).on("click", "tr[id-ref]", function() {
        if (!$(this).attr("selected")) {
            $("[selected]").removeAttr("style");
            $("[selected]").removeAttr("selected");
            $(this).css({
                "background": "#838a93",
                "color": "white",
                "font-weight": "600"
            });
            $(this).attr("selected", "");
        } else {
            $(this).removeAttr("style");
            $(this).removeAttr("selected");
        }
    });

    $(document).on("click", "button.btn-edit", async function() {
        let modal = $("#modal_edit");
        let parent = $(this).closest("tr");

        let socode = parent.attr("id-ref");
        modal.attr("data-socode", socode);


        $("#modal_edit").modal("show");
    });

    $(document).on("show.bs.modal", "#modal_add", function() {
        const m = $(this);
        m.find(".modal-title").text(`เพิ่มใบรับงานสำหรับประเภท ${PRODUCT_GROUP_NAME}`)
        m.find("#productgroupname").val(`${PRODUCT_GROUP_NAME}`);
        m.find("select[name=empcode]").select2({
            destroy: true,
            data: _employer_option,
            dropdownParent: $("#modalAdd")
        }).val(null).trigger('change');

        m.find(`#productid`).empty();
        _product_list_option?.forEach((val, i) => {
            m.find(`#productid`).append(`<option value=${val.id}>${val.text}</option>`);
        });
        m.find("select[name=wkcode]").select2({
            destroy: true,
            //data: _employer_option,
            dropdownParent: $("#addList")
        }).val(null).trigger('change');


        m.find(".selectpicker").selectpicker('setStyle', 'select-custom').selectpicker('refresh');

        let obj = {
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).next(".select2").find(".select2-selection").addClass("border border-danger");
                $(element).next(".btn.dropdown-toggle").addClass("border border-danger");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).next(".select2").find(".select2-selection").removeClass("border border-danger");
                $(element).next(".btn.dropdown-toggle").removeClass("border border-danger");
            },
        }

        m.find('#modalAdd').validate({
            ...obj,
            rules: {
                empcode: {
                    required: true,
                },
            },
            messages: {
                empcode: {
                    required: "กรุณาเลือก ลูกค้า(นายจ้าง)",
                },
            },
            submitHandler: function() {
                onAddOrder(m);
            }
        });

        m.find('#form-list-add').validate({
            ...obj,
            rules: {
                wkcode: {
                    required: true,
                },
                price: {
                    required: true,
                    number: true,
                },
                payment: {
                    required: true,
                },
                productid: {
                    required: true
                }
            },
            messages: {
                wkcode: {
                    required: "กรุณาเลือก รายการ(ลูกจ้าง)",
                },
                price: {
                    required: "กรุณากรอก ราคา",
                    number: "กรุณากรอก ตัวเลขเท่านั่น"
                },
                payment: {
                    required: "กรุณาเลือก การชำระเงิน",
                },
                payment: {
                    required: "กรุณาเลือก ประเภทรายการ",
                },
            },
            submitHandler: function() {
                onAddList(m);
            }
        });
    }); 

    $(document).on("show.bs.modal", "#modal_edit", async function(e) {
        let modal = $(this);
        let socode = modal.attr("data-socode"); 
        let order = (_orderList.filter(f => f.socode == socode))[0];
        let obj = {
            reset:true,
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).next(".select2").find(".select2-selection").addClass("border border-danger");
                $(element).next(".btn.dropdown-toggle").addClass("border border-danger");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).next(".select2").find(".select2-selection").removeClass("border border-danger");
                $(element).next(".btn.dropdown-toggle").removeClass("border border-danger");
            },
        } 
        modal.find('#form-list-add')?.validate({
            ...obj,
            rules: {
                wkcode: {
                    required: true,
                },
                price: {
                    required: true,
                    number: true,
                },
                payment: {
                    required: true,
                },
                productid: {
                    required: true
                }
            },
            messages: {
                wkcode: {
                    required: "กรุณาเลือก รายการ(ลูกจ้าง)",
                },
                price: {
                    required: "กรุณากรอก ราคา",
                    number: "กรุณากรอก ตัวเลขเท่านั่น"
                },
                payment: {
                    required: "กรุณาเลือก การชำระเงิน",
                },
                payment: {
                    required: "กรุณาเลือก ประเภทรายการ",
                },
            },
            submitHandler: function() {
                onAddList(modal);
            }
        });
        
        const empcode = order["empcode"];
        const productgroupname = order["productgroupname"];
        const customer = order["customer"];
        const tel = order["tel"];
        modal.find("#productgroupname").val(productgroupname);
        modal.find("#customer").val(`${empcode} / ${customer}`);
        modal.find("#tel").val(tel);

        
        modal.find(`#productid`).empty();
        _product_list_option?.forEach((val, i) => {
            modal.find(`#productid`).append(`<option value=${val.id}>${val.text}</option>`);
        });
        modal.find(".selectpicker").selectpicker('setStyle', 'select-custom').selectpicker('refresh');

        orderDetailList = await gettingOrderDetail(socode);
        _orderListSeleted = orderDetailList?.map(m=>m.wkcode); 
        await setWorkerList(modal, empcode);

        let sel = _worker_mult_option = _worker_mult_option.filter( f => !_orderListSeleted.includes(f.id)); 
        let t = orderDetailList.map(m => ({
            wkcode: m.wkcode,
            price: parseFloat(m.price),
            payment: m.payment,
            remark: m.remark,
            productlistid: parseInt(m.productlistid),
        }));
        modal.find("select[name=wkcode]").empty().select2({
            destroy: true,
            data: sel,
            dropdownParent:  modal.find("#addList")
        }).val(null).trigger('change');
        $(`#multi-list`).bootstrapDualListbox('refresh');

        setTimeout( ()=>{


            _tableList = [..._tableList, ...t];
            onGenarateTable(modal); 
        }, 200);

    });

    $(document).on("show.bs.modal", "#modal-add-multi", function() {
        $('#multi-list').bootstrapDualListbox({
            filterTextClear: "แสดงทั้งหมด",
            nonSelectedListLabel: 'รายการที่สามารถเลือกได้',
            selectedListLabel: 'รายการที่เลือก',
            preserveSelectionOnMove: 'moved',
            moveAllLabel: 'เลือกทั้งหมด',
            btnMoveAllText: 'เลือกทั้งหมด',
            removeAllLabel: 'ยกเลิกทั้งหมด',
            btnRemoveAllText: 'ยกเลิกทั้งหมด',
            infoText: 'รายการทั้งหมด {0} รายการ',
            infoTextEmpty: 'ไม่มีรายการที่เลือก',
            infoTextFiltered: '<span class="badge badge-warning">ค้นหาเจอ</span> {0} จาก {1}',
            filterPlaceHolder: "ค้นหารายการ",
            helperSelectNamePostfix: "_listadd",
        });
    }); 

    $(document).on("hidden.bs.modal", "#modal_add", function() {
        let modal = $(this);
        $.each(modal.find("[name]"), function(i, e) {
            $(e).val(null);
        });

        modal.find(".modal-title").text(`เพิ่มใบรับงานสำหรับประเภท ${PRODUCT_GROUP_NAME}`);
        modal.find("select.select2").empty().select2("destroy");
        $('.selectpicker').val(null).selectpicker('refresh');
        let v = modal.find('#form-list-add')?.validate();
        v.resetForm();
        v.reset();
        modal.find('#form-list-add .is-invalid').removeClass('is-invalid');
        modal.find(".border.border-danger").removeClass("border border-danger");
        modal.find('.field-validation-error').removeClass('field-validation-error').addClass('field-validation-valid').html('');        
        _tableList = [];
        onGenarateTable(modal);
    });

    $(document).on("hidden.bs.modal", "#modal_edit", function() {
        let modal = $(this);
        modal.find("select[name=empcode]").empty().select2("destroy");
        modal.find("select[name=wkcode]").empty().select2("destroy");
        let v = modal.find('#form-list-add')?.validate();
        v.resetForm();
        v.reset();
        modal.find('#form-list-add .is-invalid').removeClass('is-invalid');
        modal.find(".border.border-danger").removeClass("border border-danger");
        modal.find('.field-validation-error').removeClass('field-validation-error').addClass('field-validation-valid').html('');
        _tableList = [];
        _orderDetailList = [];
        _orderListSeleted = [];
    });

    $(document).on("hidden.bs.modal", ".sub-modal.modal", function() {
        let model = $(this);
        model.closest("body").addClass("modal-open").css({
            "padding-right": "0px;"
        });
    });

    $(document).on("change", "#modalAdd [condi]", function() {
        const m = $("#modalAdd");
        const c = (m.find("[condi]")).toArray();
        const f = c.filter(f => !!!$(f).val());
        if (!!!f[0]) $("#sec-add-list").attr("block-event", "false");
        else {
            $("#sec-add-list").attr("block-event", "true");
        }

    });

    $(document).on("click", "#btn-list-add", function(e) {
        let modal = $(this).closest("div.modal");
        modal.find('#form-list-add').submit();
    });

    $(document).on("change", "select[name=wkcode]", function(e) {
        const modal = $(this).closest("div.modal");
        let val = $(this).val();
        _orderListSeleted = [...new Set([..._orderListSeleted, ...val])];

        //val = _orderListSeleted;
        //_orderListSeleted = [...val];
        //if (!!val[0]) {
            const mul = !!val[0] ? _worker_mult_option?.filter(f => !val.includes(f.id)) : _worker_mult_option;

            $("#multi-list").empty();
            mul?.forEach((f, i) => {
                $("#multi-list").append(`<option value="${f.id}" >${f.text}</option>`);
            });        
            $(`#multi-list`).bootstrapDualListbox('refresh');
        //}

        // _orderListSeleted = val;
        // $(`#multi-list option`).attr("hidden", false);
        // if (!!val[0]) {
        //     _orderListSeleted?.forEach((val, i) => {
        //         $(`#multi-list option[value=${val}]`).attr("hidden", _orderListSeleted.includes(val));
        //     });
        // }
    });

    $(document).on("click", "#btn-multi-list-add", function(e) {
        const modal = $(this).closest("div.modal");
        const mulSelect = $("#multi-list").val();
        _orderListSeleted = [...new Set([..._orderListSeleted, ...mulSelect])];
        $('select[name=wkcode]').val(_orderListSeleted).trigger('change');

        $("#multi-list").val(null).bootstrapDualListbox('refresh');
        modal.modal("hide");
    });

    $(document).on("click", "#tableDetail .btn-del-row", function() {
        const modal = $(this).closest("div.modal");
        const row = $(this).closest("tr");
        const index = row.attr("row-id");
        const wkcode = _tableList[Number(index)]?.wkcode;
        const d = (_worker_option.filter(f => f.id == wkcode))[0];
        _worker_mult_option = [ ...new Map([..._worker_mult_option, d].map(item => [JSON.stringify(item), item])).values()];
        _tableList.splice(Number(index), 1);

        var newOption = new Option(d.text, d.id, true, true);
        modal.find('select[name=wkcode]').append(newOption).val(null).trigger('change');

        onGenarateTable(modal);
        row.remove();
    });

    $(document).on("click", "#tableDetail .btn-edit-row", function() {
        const modal = $(this).closest("div.modal");
        const row = $(this).closest("tr");
        const index = row.attr("row-id");
        const table = _tableList[Number(index)];
        const d = (_worker_option.filter(f => f.id == table.wkcode))[0];
        //_worker_mult_option = [ ...new Map([..._worker_mult_option, d].map(item => [JSON.stringify(item), item])).values()];
        //_tableList.splice(Number(index), 1);

        var newOption = new Option(d.text, d.id, true, true);
        modal.find('select[name=wkcode]').append(newOption).trigger('change').prop("disabled", true);

        modal.find("input[name=price]").val(table.price).blur();
        modal.find("select[name=payment]").val(table.payment).selectpicker('refresh');
        modal.find("select[name=productid]").val(table.productlistid).selectpicker('refresh');
        modal.find("textarea[name=remark]").val(table.remark);        

        modal.find(".btn-multi").addClass("d-none");
        modal.find(".sec-add").addClass("d-none");
        modal.find(".sec-edit").removeClass("d-none").attr("row-id", index);

        modal.find("#sec-table-list").attr("block-event", "true");
        //onGenarateTable(modal);
        //row.remove();
    });

    $(document).on("click", "#btn-list-edit", function(){
        const modal = $(this).closest("div.modal");
        const sec_edit = $(this).closest("div.sec-edit");
        const index = Number(sec_edit.attr("row-id"));

        const wkcode = _orderListSeleted = modal.find("select[name=wkcode]").val();
        const price = parseFloat(modal.find("input[name=price]").val()?.replaceAll(',', ''));
        const payment = modal.find("select[name=payment]").val();
        const productid = modal.find("select[name=productid]").val();
        const remark = modal.find("textarea[name=remark]").val(); 

        _tableList[index].productlistid = productid;
        _tableList[index].price = price;
        _tableList[index].payment = payment;
        _tableList[index].remark = remark;

        onGenarateTable(modal);
        modal.find('select[name=wkcode]').prop("disabled", false);
        modal.find("select[name=wkcode] option:selected").remove().trigger('change');
        modal.find("input[name=price]").val(null);
        modal.find("select[name=payment]").val(null).selectpicker('refresh');
        modal.find("select[name=productid]").val(null).selectpicker('refresh');
        modal.find("textarea[name=remark]").val(null);  
        
        modal.find(".btn-multi").removeClass("d-none");
        modal.find(".sec-add").removeClass("d-none");
        modal.find(".sec-edit").addClass("d-none").removeAttr("row-id", index);

        modal.find("#sec-table-list").attr("block-event", "false");

    });

    $(document).on("click", "#btn-list-cancle", function(){
        const modal = $(this).closest("div.modal");
        modal.find('select[name=wkcode]').prop("disabled", false);
        modal.find("select[name=wkcode] option:selected").remove().trigger('change');
        modal.find("input[name=price]").val(null);
        modal.find("select[name=payment]").val(null).selectpicker('refresh');
        modal.find("select[name=productid]").val(null).selectpicker('refresh');
        modal.find("textarea[name=remark]").val(null);  
        
        modal.find(".btn-multi").removeClass("d-none");
        modal.find(".sec-add").removeClass("d-none");
        modal.find(".sec-edit").addClass("d-none").removeAttr("row-id", index);

        modal.find("#sec-table-list").attr("block-event", "false");
    });

    async function customerSelected(e) {
        let a = $($(e)[0].target);
        const empcode = a?.val();
        const empname = a?.find("option:selected").text();
        const modal = a.closest("div.modal");
        //modal.find("input[id=empname").val(empname);
        modal.find("button.btn-add-row").attr("disabled", !!!empcode);
        
        
        if (!!!empcode) return;
        
        modal.find("input[id=customer").val(`${empcode} / ${empname}`);
        setWorkerList(modal, empcode);
        // modal.find("select[name=wkcode]").select2("destroy");


    }

    function setWorkerList(modal, empcode){
        return new Promise( function(resolve){
            setTimeout(() => {
                gettingWorkerOption("GetByEmployer", empcode).then(r => {
                    _worker_option = _worker_mult_option = r;
                    modal.find("select[name=wkcode]").empty().select2({
                        destroy: true,
                        data: r,
                        dropdownParent: modal.find("#addList"),
                    }).val(r.length == 1 ? r[0].id : null).trigger('change');

                    $("#multi-list").empty();
                    r?.forEach((f, i) => {
                        $("#multi-list").append(`<option value="${f.id}" >${f.text}</option>`);
                    });

                    $(`#multi-list`).bootstrapDualListbox('refresh');
                    resolve(true);
                });
            }, 100);
        }); 
    }

    function onGenarateTable(modal) {
        const table = modal.find("#tableDetail");
        table.find("tbody").empty();
        let total = 0;
        _tableList?.forEach((val, i) => {
            const d = (_worker_option.filter(f => f.id == val.wkcode))[0];
            const p = (_product_list_option.filter(f => f.id == val.productlistid))[0];
            let row = `
            <td>${+(i) + 1}</td>
            <td>${d.text}</td>
            <td>${p.text}</td>
            <td align="right"><a class="ed-link" href="#" num>${val.price.toLocaleString('en-US', {maximumFractionDigits: 5})}</a></td>
            <td align="center"><a class="ed-link" href="#" sec>${val.payment}</a></td>
            <td align="center"><a class="ed-link" href="#" are>${val.remark || "-"}</a></td>
            <td align="center" class="text-nowrap">
                <button class="btn btn-sm btn-danger btn-del-row">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button class="btn btn-sm btn-primary btn-edit-row">
                    <i class="fas fa-pencil-alt"></i>
                </button>
            </td>
            `
            table.find("tbody").append(`<tr row-id="${i}">${row}</tr>`);

            total += val.price;
            table.find("tfoot").find("td").eq(1).text(total.toLocaleString('en-US', {
                maximumFractionDigits: 5
            }));
            table.find("tfoot").find("td").eq(3).text(ArabicNumberToText(total));
        });

        if (_tableList.length < 1) {
            table.find("tbody").html(`<tr><td colspan="6" align="center" class="bg-secondary-50">ไม่มีรายการ</td></tr>`);
            table.find("tfoot").find("td").eq(1).text("0.00".toLocaleString('en-US', {
                maximumFractionDigits: 5
            }));
            table.find("tfoot").find("td").eq(3).text("");
        }
    }

    function onAddList(modal) {
        const wkcode = _orderListSeleted = modal.find("select[name=wkcode]").val();
        const price = parseFloat(modal.find("input[name=price]").val()?.replaceAll(',', ''));
        const payment = modal.find("select[name=payment]").val();
        const productid = modal.find("select[name=productid]").val();
        const remark = modal.find("textarea[name=remark]").val(); 
        const productname = modal.find("select[name=productid] option:selected").text();
        
        _worker_mult_option = _worker_mult_option.filter( f => !wkcode.includes(f.id));

        let t = wkcode.map(m => ({
            wkcode: m,
            price: price,
            payment: payment,
            remark: remark,
            productlistid: parseInt(productid), 
        }));

        _tableList = [..._tableList, ...t];
        onGenarateTable(modal);
        modal.find("select[name=wkcode] option:selected").remove().trigger('change');
        modal.find("input[name=price]").val(null);
        modal.find("select[name=payment]").val(null).selectpicker('refresh');
        modal.find("select[name=productid]").val(null).selectpicker('refresh');
        modal.find("textarea[name=remark]").val(null);
    }

    async function onAddOrder(modal) {
        //const modal = $(this).closest("div.modal")
        const form = modal.find("#modalAdd");
        if (!!!_tableList[0]) {
            await Swal.fire('ไม่มีข้อมูลรายการ', "กรุณาเลือกรายการ", 'warning');
            throw new Error("เลือกรายการก่อน")
        }
        const empcode = form.find("select[name=empcode] option:selected").val();
        const tel = form.find("input[name=tel]").val();
        const orderDetail = _tableList;
        const dto = {
            empcode: empcode,
            productgroupid: PRODUCT_GROUP_ID,
            list: orderDetail,
            tel:tel,
        }
        Swal.fire({
            title: 'ยืนยันการเพิ่มรายการ',
            text: "ตกลง เพื่อเพิ่มรายการ",
            icon: 'warning',
            backdrop: 'swal2-backdrop-show',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonText: 'ยกเลิก การเพิ่มรายการ',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ตกลง',
        }).then(async (result) => {
            if (result.isConfirmed) {
                const res = await $.post("ajax/add_order.php", dto, null, "json").catch(error => {
                    Swal.fire('เกิดข้อผิดพลาด', "เกิดปัญหาในหารเพิ่มข้อมูลกรุณาลองใหม่อีกครั้ง", 'error')
                    throw new Error(error?.message || 'เกิดข้อผิดพลาด');
                });

                Swal.fire('เสร็จสิ้น!', 'เพิ่มรายการเสร็จสิ้น', 'success').then(() => {
                    window.location.reload();
                })
            }
        });
    }

    async function onEditOrder(e) {
        const modal = $($(e)[0].target).closest("div.modal");
        let socode = modal.attr("data-socode"); 
        let order = (_orderList.filter(f => f.socode == socode))[0]; 
        if (!!!_tableList[0]) {
            await Swal.fire('ไม่มีข้อมูลรายการ', "กรุณาเลือกรายการ", 'warning');
            throw new Error("เลือกรายการก่อน")
        }
        const empcode = order.empcode;
        const tel = modal.find("input[name=tel]").val();
        const orderDetail = _tableList;
        const dto = {
            socode:socode,
            empcode: empcode,
            productgroupid: PRODUCT_GROUP_ID,
            list: orderDetail,
            tel:tel,
        }
        Swal.fire({
            title: 'ยืนยันการแก้ไขรายการ',
            text: "ตกลง เพื่อแก้ไขรายการ",
            icon: 'warning',
            backdrop: 'swal2-backdrop-show',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonText: 'ยกเลิก การแก้ไขรายการ',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ตกลง',
        }).then(async (result) => {
            if (result.isConfirmed) {
                const res = await $.post("ajax/edit_order.php", dto, null, "json").catch(error => {
                    Swal.fire('เกิดข้อผิดพลาด', "เกิดปัญหาในหารเพิ่มข้อมูลกรุณาลองใหม่อีกครั้ง", 'error')
                    throw new Error(error?.message || 'เกิดข้อผิดพลาด');
                });

                Swal.fire('เสร็จสิ้น!', 'แก้ไขรายการเสร็จสิ้น', 'success').then(() => {
                    window.location.reload();
                })
            }
        });
    }
</script>