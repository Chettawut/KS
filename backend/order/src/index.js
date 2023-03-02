
let _attachList = undefined;
let _filesDelete = [];
let _fileRename = [];
let _fileFormData = [];
let _fileList = [];
const HEADER = [
    {
        title: "รหัสใบงาน",
    },
    {
        title: "วันที่ใบงาน",
    },
    {
        title: "(ลูกค้า)นายจ้าง",
    },
    {
        title: "ประเภทใบรับงาน",
    },
    {
        title: "สถานะ",
    },
    {
        title: "ตัวเลือก",
    },
]; 
 
async function gettingOrder() {
    let res = (await $.get("ajax/get_order.php").catch(async (e) => {
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

async function gettingoptionEmployer(code) {
    let res = (await $.get("ajax/get_optionemployer.php", {empcode:code} ).catch(async (e) => {
        let res = e.responseJSON;
        await Swal.fire("มีข้อผิดพลาดเกิดขึ้น", res?.message, "error");
    })) || [];

    return res;
}

async function gettingCustomerDetail(code) {
    let res = (await $.get("ajax/get_employerdetail.php", {empcode:code} ).catch(async (e) => {
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
 
async function customerSelected(e){
    let a = $( $(e)[0].target );
    const empcode = a?.val();
    const empname = a?.find("option:selected").text();
    const modal = a.closest("div.modal");
    //if(!empcode) return;
    modal.find("input[id=empcode").val(empcode);
    modal.find("input[id=empname").val(empname);
    modal.find("button.btn-add-row").attr("disabled", !!!empcode )
    // let empDetail = await gettingCustomerDetail(empcode);
} 
