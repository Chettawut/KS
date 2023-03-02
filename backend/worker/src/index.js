
let _attachList = undefined;
let _filesDelete = [];
let _fileRename = [];
let _fileFormData = [];
let _fileList = [];
const HEADER = [
    {
        title: "รหัสลูกจ้าง",
    },
    {
        title: "ชื่อลูกจ้าง",
    },
    {
        title: "นามสกุล",
    },
    {
        title: "รหัสประชาชน",
    },
    {
        title: "พาสปอร์ต",
    },
    {
        title: "นายจ้าง",
    },
    {
        title: "สถานะ",
    },
    {
        title: "ตัวเลือก",
    },
];
const FILE_REQUIRED = ["application/pdf", "image/jpg", "image/png", "image/jpeg"];
function fileChange(e) {
    const countFile = $("#frmEditCustomer [name=atthFile]").length;
    const file = $(e)[0]?.files[0];
    const form = $(e).closest("form[enctype='multipart/form-data']");
    const formRow = $(e).closest(".form-row");
    const inputGroup = $(e).closest(".input-group");
    const template = $($("template[form_upfile]").html());
    inputGroup
        .find("small")
        .text(file.name)
        .removeClass("custom-file-label")
        .addClass("px-2 py-1 m-0 rounded text-nowrap text-truncate")
        .css({
            "font-weight": "600",
        });
    inputGroup.find(".btn-at").remove();
    inputGroup.find(".btn-dl").removeClass("d-none");

    formRow.find("small.d-none").remove();
    formRow.find("label.col-form-label").text(`ชื่อไฟล์ (${countFile}) :`);
    formRow.find("input[name=attname").attr("addnew", "");
    formRow.attr("attached", "");
    form.append(template);
}

function removeFile(e) {
    const i = $(e).closest(".form-row").attr("rm", "");

    $("[rm]").remove();
}

async function gettingWorker() {
    let res = (await $.get("ajax/get_worker.php").catch(async (e) => {
        let res = e.responseJSON;
        await Swal.fire("มีข้อผิดพลาดเกิดขึ้น", res.message, "error");
    })) || [];

    return res;
}

async function gettingFile(code) {
    let res =
        (await $.get("ajax/get_attachfile.php", {
            wkcode: code,
        }).catch(async (e) => {
            let res = e.responseJSON;
            await Swal.fire("มีข้อผิดพลาดเกิดขึ้น", res?.message, "error");
        })) || [];

    return res;
}

async function gettingoptionEmployer(wkcode) {
    let res = (await $.get("ajax/get_optionemployer.php").catch(async (e) => {
        let res = e.responseJSON;
        await Swal.fire("มีข้อผิดพลาดเกิดขึ้น", res?.message, "error");
    })) || [];

    return res;
}

function tables($this, col, data, option) {
    return $($this).DataTable(
        Object.assign(
            {
                columns: col,
                data: data,
                dom: '<"top d-flex justify-content-between"lf><"tbox customscroll"t><"bottom d-flex justify-content-between"<"start"i><"end"p>><"clear">',
                destroy: true,
                //initComplete:tableLoad
            },
            option
        )
    );
}

function setRowTable(m) {
    return [
        m.wkcode,
        m.wkname,
        m.lastname,
        m.idcode,
        m.passport,
        (m.empcode) 
        ? `${m.empname}  ${m.emp_lastname}` 
        : `<span class="label badge bg-primary label-white middle">ว่าง</span>`,
        `<span class="label badge ${m.status == 'Y' ? 'bg-success' : 'bg-danger'} label-white middle">${m.status == 'Y' ? 'ใช้งาน' : 'ไม่ใช้งาน'}</span>`,
        `<div>
            <button class="btn btn-sm rounded btn-primary btn-edit" data-whatever="${m.wkcode}" data-wkcode="${m.wkcode}">
                <i class="fas fa-pencil-alt"></i>
            </button>
        </div>`,
    ];
}

function actionRow(row, data, dataIndex) {
    $(row).attr("id-ref", data[0]);
}

async function attached(e, t) {
    const modal = $(e.target).parents("div.modal");
    const n = $(e.target);
    const f = n[0].files[0];
    if(!FILE_REQUIRED.includes(f.type)){
        await Swal.fire(`ไฟล์ชนิดนี้ไม่ได้รับอนุญาตให้แนบ`, `กรุณาแนบไฟล์นามสกุลที่อนุญาติเท่านั้น`, 'warning');
        n.val(null);
        return;
    }
    const f_result = modal.find(".file-result");
    const t_result = $(f_result.html());
    const e_result = f_result.find(".f-empty");
    f_result.find("[attached]").remove();
    if (f?.name) {
        t_result.find(".mi").html(`<i class="far fa-file-alt"></i>`);
        t_result.find(".ms").html(`<strong>${f.name}</strong>`);
        t_result.attr("attached", "");
        e_result.removeClass("d-flex").addClass("d-none");
        t_result.removeClass("border-danger");
        f_result.append(t_result);
    } else {
        e_result.removeClass("d-none").addClass("d-flex border-danger");
    }
}

function onClearmModal(modal) {
    const e = modal.find(".f-empty");
    const f = modal.find(".modal-body [attached]");
    const h = modal.find(".modal-body input[name=attname]");
    const a = modal.find(".modal-body input[name=atthFile]");
    const s = h.closest(".form-group").find("label small");
    f.remove();
    h.val("").removeClass("border-danger");
    a.val(null);
    s.find("strong").remove();
    e.removeClass("d-none border-danger").addClass("d-flex");
    modal.modal("hide");
}

function genarateRow(t) {
    let tr = [];
    let f = _fileList;
    if (_fileList.length == 0) {
        $(`${t} tbody`).html(
            `<tr><td colspan="4" align="center" class="bg-secondary">ไม่มีข้อมูลไฟล์</td></tr>`
        );

        return;
    }
    for (let i in _fileList) {
        let ti = f[i]?.attname;
        let fi = f[i]?.file;
        tr.push(
            `
            <tr>
                <td class='text-center' >${parseInt(i) + 1}</td>
                <td>${ti}</td>
                <td class="text-nowrap text-truncate" style='max-width: 300px;'>${fi.name}</td>
                <td class="text-center">
                    <button type="button" class="btn-dl btn btn-sm btn-danger rounded-sm" style="width: 30px;" onclick="removeRow(this, ${i})" >
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    ${(!f[i].attached? "": 
                    `
                    <button type="button" class="btn-ed btn btn-sm btn-info rounded-sm" style="width: 30px;" onclick="editRow(this, ${f[i].code})" >
                        <i class="far fa-edit"></i>
                    </button>
                    `)}
                </td>
            </tr>
            `
        );
    }
    setTimeout(() => {
        $(`${t} tbody`).html(tr.join(""));
    }, 20);
}

async function editRow(e, index) {
    let a = _attachList.filter((f) => f.code == index)[0];
    if (!a) {
        await Swal.fire("เกิดข้อผิดพลาดระบบ", "ไม่พบข้อมูลไฟล์", "error");
    }
    const path = a.url.split("//");
    const name = path[path.length - 1];
    const modal = $("#modal-attach");
    const f_result = modal.find(".file-result");
    const t_result = $(f_result.html());
    const e_result = f_result.find(".f-empty");

    f_result.find("[attached]").remove();
    t_result.find(".mi").html(`<i class="far fa-file-alt"></i>`);
    t_result.find(".ms").html(`<strong>${name}</strong>`);
    t_result.attr("attached", "");
    e_result.removeClass("d-flex").addClass("d-none");
    t_result.removeClass("border-danger");
    f_result.append(t_result);

    const h = modal.find(".modal-body input[name=attname]");
    h.val(a.attname);

    let t = $(e).closest("table");

    modal.attr("data-attach", JSON.stringify(a));
    modal.attr("actable", `#${t.attr("id")}`);

    modal.modal("show");
}

function removeRow(e, index) {
    let t = $(e).closest("table");
    let f = _attachList.filter((f, i) => i == index)[0];
    if (f.code) {
        let p = f.url.split("//");
        let r = p[p.length - 1];
        _filesDelete.push({
            code: f.code,
            url: f.url,
            name: r,
            percode: f.percode,
        });
        _attachList.splice(index, 1);
    }
    _fileList.splice(index, 1);
    genarateRow(`#${t.attr("id")}`);
}

function openMgnFile(t) {
    let m = $("#modal-attach");
    m.attr("actable", t);
    m.modal("show");
}

$(document).on("click", "#cancel-file", function () {
    //const modal = $(this).parents("div.modal");
    onClearmModal($(this).parents("div.modal"));
});

$(document).on("click", "#summit-file", function () {
    const modal = $(this).parents("div.modal");
    const n = modal.find(".modal-body input[name=atthFile]");
    const h = modal.find(".modal-body input[name=attname]");
    const e = modal.find(".f-empty");
    const a = modal.find("[attached]");
    const f = n[0].files[0];
    if (!f && a.length == 0) {
        e.addClass("border-danger");
        return;
    }
    if (!h.val()) {
        h.addClass("border-danger");
        const s = h.closest(".form-group").find("label small");
        s.html(
            "<strong class='text-danger font-italic'>กรุณากรอกข้อมูลให้ครบถ้วน</strong>"
        );
        s.removeClass("d-none");
        return;
    }
    const d = JSON.parse(modal.attr("data-attach") || null);
    if (d) {
        let i = _fileList.findIndex((c) => c.code == d.code);
        let p = d.url.split("//");
        let r = p[p.length - 1];
        _fileList[i].attname = h.val();
        _fileList[i].file = f || {
            name: `<a href="ajax/load_attachfile.php?path=${d.url}" >${r}</a>`,
        };
        _fileList[i]["upd"] = true;
        _fileList[i]["udf"] = !!f;
        modal.modal("hide");
    } else {
        _fileList.push({ attname: h.val(), file: f });
        modal.modal("hide");
    }

    //$("#attachFileList")
}); 

$(document).on("hidden.bs.modal", "#modal-attach", function () {
    $("body").addClass("modal-open");
    const modal = $(this);
    const ac_table = modal.attr("actable");
    modal.removeAttr("data-attach");
    onClearmModal(modal);
    genarateRow(ac_table);
});

$(document).on("change", "[req]", function () {
    let h = $(this);
    if (h.val()) {
        h.removeClass("border-danger");
        const s = h.closest(".form-group").find("label small");
        s.html("");
        s.addClass("d-none");
    } else {
        h.addClass("border-danger");
        const s = h.closest(".form-group").find("label small");
        s.html(
            "<strong class='text-danger font-italic'>กรุณากรอกข้อมูลให้ครบถ้วน</strong>"
        );
        s.removeClass("d-none");
    }
});
