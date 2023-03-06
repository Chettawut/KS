<script src="src/index.js"></script>
<script type="text/javascript">
    let _employer_option = undefined;
    let _worker_option = undefined;
    let _workerList = undefined;
    let _orderList = []; 
    $(async function() {
        _workerList = await gettingOrder();
        _employer_option = await gettingoptionEmployer();
        let dataArray = _workerList.map(m => setRowTable(m));
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

    //เพิ่มนายจ้าง
    // $("#modalAdd").submit(async function(e) {
    //     e.preventDefault();
    //     let form = $(this).serializeArray();
    //     console.log(form);
    //     return;
    //     let formData = new FormData();
    //     if (_fileList.length > 0) {
    //         let _i = 0;
    //         let _f = _fileList;
    //         for (let elm of _f) {
    //             _fileFormData.push({
    //                 attname: elm.attname,
    //                 file_name: elm.file['name'],
    //                 attno: ++_i
    //             });
    //             formData.append("file[]", elm.file);
    //             //console.log("attName => ", inp, "file  Name => ", file.name);
    //         }
    //         formData.append("fileData", JSON.stringify(_fileFormData));
    //     }

    //     for (let f of form) {
    //         formData.append(f.name, f.value);
    //     }

    //     $.ajax({
    //         type: "POST",
    //         url: "ajax/add_worker.php",
    //         processData: false,
    //         contentType: false,
    //         data: formData,
    //         success: async function(result) {
    //             if (result.status == 1) // Success
    //             {
    //                 await Swal.fire('สำเร็จ', result.message, 'success');
    //                 window.location.reload();
    //                 // console.log(result.message);
    //             } else {
    //                 Swal.fire('เกิดข้อผิดพลาด', "เกิดปัญหาในหารเพิ่มข้อมูลกรุณาลองใหม่อีกครั้ง", 'error')
    //             }
    //         },
    //         error: function(error) {
    //             console.log(error.responseText);
    //             Swal.fire('เกิดข้อผิดพลาด', error.responseText, 'error')
    //         }
    //     });
    // });

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

        let wkcode = parent.attr("id-ref");
        modal.attr("data-wkcode", wkcode);

        _attachList = await gettingFile(wkcode);
        _fileList = [];
        let attach = _attachList;
        for (let i in attach) {
            let pth = attach[i].url.split("//");
            let _f = pth[pth.length - 1];
            _fileList.push({
                attname: attach[i].attname,
                file: {
                    name: `<a href="ajax/load_attachfile.php?path=${attach[i].url}" target="_BLANK" >${_f}</a>`
                },
                attached: true,
                code: attach[i].code,
            })
        };
        genarateRow("#attachFileListEdit");
        $("#modal_edit").modal("show");
    });

    $(document).on("show.bs.modal", "#modal_add", function() {
        const m = $(this);
        m.find("select[name=empcode]").select2({
            destroy: true,
            data: _employer_option,
            dropdownParent: $("#modalAdd")
        }).val(null).trigger('change');

        m.find("select[name=wkcode]").select2({
            destroy: true,
            //data: _employer_option,
            dropdownParent: $("#addList")
        }).val(null).trigger('change');

        m.find(".selectpicker").selectpicker('setStyle', 'select-custom');

        let obj = {
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).next(".select2").find(".select2-selection--single").addClass("border border-danger");
                $(element).next(".btn.dropdown-toggle").addClass("border border-danger");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).next(".select2").find(".select2-selection--single").removeClass("border border-danger");
                $(element).next(".btn.dropdown-toggle").removeClass("border border-danger");
            },
        }
        $('#modalAdd').validate({
            ...obj,
            rules: {
                empcode: {
                    required: true,
                },
                sotype: {
                    required: true,
                },
            },
            messages: {
                empcode: {
                    required: "กรุณาเลือก ลูกค้า(นายจ้าง)",
                },
                sotype: {
                    required: "กรุณาเลือก ประเภทใบงาน",
                },
            },
            submitHandler: function() {
                alert("Submitted!")
            }
        });

        $('#form-list-add').validate({
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
            },
            submitHandler: function() {
                onAddList();
            }
        });
    });

    $(document).on("hidden.bs.modal", "#modal_add", function() {
        let modal = $(this);
        $.each(modal.find("[name]"), function(i, e) {
            console.log(e);
            $(e).val(null);
        });
        modal.find("select[name=empcode]").empty().select2("destroy");
        modal.find("select[name=wkcode]").empty().select2("destroy");
        $('.selectpicker').selectpicker('render');
    });

    $(document).on("show.bs.modal", "#modal_edit", async function(e) {
        let modal = $(this);
        let wkcode = modal.attr("data-wkcode");
        let worker = (_workerList.filter(f => f.wkcode == wkcode))[0];
        Object.keys(worker).forEach((f, k) => {
            modal.find(`.modal-body [name=${f}]`).val(worker[f]);
        });

        modal.find("select[name=empcode]").select2({
            destroy: true,
            data: _employer_option,
        }).val(worker['empcode']).trigger('change');
    });

    $(document).on("hidden.bs.modal", "#modal_edit", function() {
        let model = $(this);
        model.find("select[name=empcode]").empty().select2("destroy");
        model.find("select[name=wkcode]").empty().select2("destroy");
    });

    $(document).on("hidden.bs.modal", ".sub-modal.modal", function() {
        let model = $(this);
        model.closest("body").addClass("modal-open");
    });

    $(document).on("show.bs.modal", "#modal-add-multi", function() {
        $('#multi-list').bootstrapDualListbox({
            filterTextClear:"แสดงทั้งหมด",
            nonSelectedListLabel: 'รายการที่สามารถเลือกได้',
            selectedListLabel: 'รายการที่เลือก',
            preserveSelectionOnMove: 'moved',
            moveAllLabel: 'เลือกทั้งหมด',
            btnMoveAllText: 'เลือกทั้งหมด',
            removeAllLabel: 'ยกเลิกทั้งหมด',
            btnRemoveAllText: 'ยกเลิกทั้งหมด',
            infoText:'รายการทั้งหมด {0} รายการ', 
            infoTextEmpty:'ไม่มีรายการที่เลือก',
            infoTextFiltered:'<span class="badge badge-warning">ค้นหาเจอ</span> {0} จาก {1}',
            filterPlaceHolder:"ค้นหารายการ",
            helperSelectNamePostfix:"_listadd",
        })
    })

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
        $('#form-list-add').submit(); 
    });

    $(document).on("click", "#btn-multi-list-add", function(e) {
        const modal = $(this).closest("div.modal");
        const mulSelect = $("#multi-list").val();
        $('select[name=wkcode]').val(mulSelect).trigger('change');
        $("#multi-list").val(null).bootstrapDualListbox('refresh');
        modal.modal("hide");
    });

    function onAddList(){ 
        const wkcode = $("select[name=wkcode]").val();
        const price = parseFloat($("input[name=price]").val()?.replaceAll(',', ''));
        const payment = $("select[name=payment]").val();
        const remark = $("textarea[name=remark]").val();
        $("#tableDetail tbody").empty();
        let total = 0;
        wkcode?.forEach( (val,i)=>{
            const d = (_worker_option.filter( f => f.id == val))[0];
            let row = `
            <td>${+(i) + 1}</td>
            <td>${d.text}</td>
            <td align="right"><a class="ed-link" href="#" num>${price.toLocaleString('en-US', {maximumFractionDigits: 5})}</a></td>
            <td align="center"><a class="ed-link" href="#" sec>${payment}</a></td>
            <td align="center"><a class="ed-link" href="#" are>${remark || "-"}</a></td>
            <td align="center">
                <button class="btn btn-sm btn-danger">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
            `
            $("#tableDetail tbody").append(`<tr row-id="${d.id}">${row}</tr>`);
            _orderList.push({
                wkcode : d.id,
                price : price,
                payment : payment,
                remark : remark,
            });
            total += price;
            $("#tableDetail tfoot").find("td").eq(1).text(total.toLocaleString('en-US', {maximumFractionDigits: 5}));
        });

    }
</script>