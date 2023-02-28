<script src="src/index.js"></script>
<script type="text/javascript">
    let _employer_option = undefined;
    let _workerList = undefined;
    $(async function() {
        $("#add_cusdate").val(new Date().toISOString().substring(0, 10));
        _workerList = await gettingWorker();
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
        tables("#tableWorker", HEADER, dataArray, configTb); 
    });

    $("#btnRefresh").click(function() {
        window.location.reload();
    });

    //เพิ่มนายจ้าง
    $("#frmAddWorker").submit(async function(e) {
        e.preventDefault();
        $(':disabled').each(function(event) {
            $(this).removeAttr('disabled');
        });
        let form = $(this).serializeArray();
        let formData = new FormData();
        if (_fileList.length > 0) {
            let _i = 0;
            let _f = _fileList;
            for (let elm of _f) {
                _fileFormData.push({
                    attname: elm.attname,
                    file_name: elm.file['name'],
                    attno: ++_i
                });
                formData.append("file[]", elm.file);
                //console.log("attName => ", inp, "file  Name => ", file.name);
            }
            formData.append("fileData", JSON.stringify(_fileFormData));
        }

        for (let f of form) {
            formData.append(f.name, f.value);
        }

        $.ajax({
            type: "POST",
            url: "ajax/add_worker.php",
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
                    Swal.fire('เกิดข้อผิดพลาด', "เกิดปัญหาในหารเพิ่มข้อมูลกรุณาลองใหม่อีกครั้ง", 'error')
                }
            },
            error: function(error) {
                console.log(error.responseText);
                Swal.fire('เกิดข้อผิดพลาด', error.responseText, 'error')
            }
        });
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
        }).val(null).trigger('change');
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
        _attachList = [];
        _fileList = [];
        genarateRow("#attachFileListEdit");
    });
</script>