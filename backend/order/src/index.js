
const STATUS_SO = {

}

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
    let res = (await $.get("ajax/get_order.php", {g:PRODUCT_GROUP_ID}).catch(async (e) => {
        let res = e.responseJSON;
        await Swal.fire("มีข้อผิดพลาดเกิดขึ้น", res?.message || "Unhandle  error.", "error");
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

async function gettingOptionEmployer() {
    let res = (await $.get("ajax/get_optionemployer.php").catch(async (e) => {
        let res = e.responseJSON;
        await Swal.fire("มีข้อผิดพลาดเกิดขึ้น", res?.message, "error");
    })) || [];

    return res;
}

async function gettingOptionEmployer(code) {
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

async function gettingWorkerOption(ky, code){
    let rst = (await $.get("ajax/get_optionworker.php", {ky:ky, em:code}).catch(async (e) => {
        let res = e.responseJSON;
        await Swal.fire("มีข้อผิดพลาดเกิดขึ้น", res?.message, "error");
    })) || [];

    return rst;
}

async function gettingOptionProductList(){
    let rst = (await $.get("ajax/get_optionproductlist.php", {g:PRODUCT_GROUP_ID}).catch(async (e) => {
        let res = e.responseJSON;
        await Swal.fire("มีข้อผิดพลาดเกิดขึ้น", res?.message, "error");
    })) || [];

    return rst;
}

function tables($this, col, data, option) {
    return $($this).DataTable(
        Object.assign(
            {
                columns: col,
                data: data,
                dom: '<"top d-flex justify-content-between flex-wrap"lf><"tbox customscroll"t><"bottom d-flex justify-content-between flex-wrap"<"start"i><"end"p>><"clear">',
                destroy: true,
                //initComplete:tableLoad
            },
            option
        )
    );
}

function setRowTable(m) {
    return [
        m.socode,
        m.sodate,
        m.customer,
        m.sotype, 
        `<span class="label badge ${m.status == 'รอชำระ' ? 'bg-warning' : m.status == 'ชำระเสร็จสิ้น' ? 'bg-success' : 'bg-danger'} label-white middle">${m.status}</span>`,
        `<div>
            <button class="btn btn-sm rounded btn-primary btn-edit" data-whatever="${m.socode}" data-wkcode="${m.socode}">
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
    modal.find("input[id=empcode").val(empcode);
    modal.find("input[id=empname").val(empname);
    modal.find("button.btn-add-row").attr("disabled", !!!empcode );
    
    
    if(!!!empcode) return;

    // modal.find("select[name=wkcode]").select2("destroy");
    setTimeout( ()=>{
        gettingWorkerOption("GetByEmployer", empcode).then( r => {
            modal.find("select[name=wkcode]").empty().select2({
                destroy: true,
                data: r,
                dropdownParent: $("#addList"),
            }).val(r.length == 1 ? r[0].id : null).trigger('change');

            $("#multi-list").empty();
            r?.forEach( (f, i) => {
                $("#multi-list").append(`<option value="${f.id}" >${f.text}</option>`);
            });
            _worker_option = r;
        });        
    }, 100);

    
    // console.log(worker);
    // modal.find("select[name=wkcode]").trigger({
    //     type: 'select2:select',
    //     params: {
    //         data: worker_option
    //     }
    // });

}  

$(document).on("keypress keyup", "[numberOnly]",function (e) {
    const elm = $(this);
    let val = elm.val().replace(/\,/g,'');
    elm.val(val.replace(/[^0-9\.]/g,'')); 

    if ((e.which != 46 || elm.val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {
        e.preventDefault();
    }
 });

$(document).on("blur", "[addComma]",function (e) {
    const elm = $(this);  
    let val = elm.val().replace(/\,/g,'');
    if(["focusout"].indexOf(e.type) >= 0 && !!val )
    {
        const n = Number(val).toLocaleString('en-US', {maximumFractionDigits: 5}); 
        // const n =  elm.val().replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
        // elm.val(`${n}${(elm.val().endsWith('.')) ? "." : ""}`);
        elm.val(n);
    } 

 });
 
 
 