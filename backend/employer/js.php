 <script type="text/javascript">
     const HEADER = [{
             title: "รหัสนายจ้าง"
         },
         {
             title: "ชื่อนายจ้าง"
         },
         {
             title: "นามสกุล"
         },
         {
             title: "รหัสประชาชน"
         },
         {
             title: "พาสปอร์ต"
         },
         {
             title: "สถานะ"
         },
         {
             title: "ตัวเลือก"
         },
     ];
     let _employerList = undefined;
     let _filesDelete = [];
     let _fileRename = [];
     let _fileFormData = [];
     $(async function() {
         $("#add_cusdate").val(new Date().toISOString().substring(0, 10));
         _employerList = await gettingEmployer();

         let dataArray = _employerList.map(m => setRowTable(m));
         let ignoreSorting = HEADER.map((m, i) => (["ตัวเลือก", "สถานะ"].includes(m.title) ? i : -1)).filter(f => f != -1);
         let configTb = {
             lengthMenu: [
                 [10, 20, 50, -1],
                 ['10', '20', '50', 'All']
             ],
             order: [
                 [1, 'asc']
             ],
             columnDefs: [{
                 'targets': ignoreSorting,
                 'orderable': false,
             }],
             createdRow: actionRow
         }
         tables("#tableEmployer", HEADER, dataArray, configTb);
     });

     $("#btnRefresh").click(function() {
         window.location.reload();
     });

     //เพิ่มนายจ้าง
     $("#frmAddEmployer").submit(async function(e) {
         e.preventDefault();
         $(':disabled').each(function(event) {
             $(this).removeAttr('disabled');
         });
         let form = $(this).serializeArray();
         let files = $("[attaced] [name=atthFile]");
         let attached = $("[attaced]");
         let formData = new FormData();
         if (files.length > 0) {
             let _i = 0;
             for (let elm of attached) {
                 if (!e) continue;
                 let inp = $(elm).find("[name=attname]").val();
                 let file = $(elm).find("[name=atthFile]")[0]?.files[0];
                 if (inp === "") {
                     await Swal.fire('เกิดข้อผิดพลาด', 'กรุณาใส่ชื่อไฟล์', 'warning')
                 }
                 _fileFormData.push({
                     attname: inp,
                     file_name: file.name,
                     attno: ++_i
                 });
                 //console.log("attName => ", inp, "file  Name => ", file.name);
             }
             formData.append("fileData", JSON.stringify(_fileFormData));
         }

         for (let f of form) {
             formData.append(f.name, f.value);
         }

         for (let f of files) {
             formData.append("file[]", f.files[0])
         }
         $.ajax({
             type: "POST",
             url: "ajax/add_employer.php",
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
                     Swal.fire('เกิดข้อผิดพลาด', "เกิดปัญหาในหารเพิ่มข้อมูลกรุณาลิงใหม่อีกครั้ง", 'error')
                 }
             },
             error: function(error) {
                 console.log(error.responseText);
                 Swal.fire('เกิดข้อผิดพลาด', error.responseText, 'error')
             }
         });
     });

     //แก้ไขนายจ้าง
     $("#frmEditCustomer").submit( async function(e) {
         e.preventDefault();
         $(':disabled').each(function(e) {
             $(this).removeAttr('disabled');
         });
         let attached = $("[attached]");
         let form = $(this).serializeArray();
         let files = $("[attaced] [name=atthFile]");
         let file_rename = $("[attaced] [name=attname][code]");
         let formData = new FormData();
         let empcode = $("#modal_edit").attr("data-empcode");
         
         //  if(files.length < 1 && attached.length < 1) {
         //     alert("กรุณา แนบไฟล์");
         //     return;
         //  }
 
             let _i = 0;
             for (let elm of attached) {
                 if (!elm) continue;
                 let inp = $(elm).find("[name=attname][addnew]").val();
                 let file = $(elm).find("[name=atthFile]")[0]?.files[0];
                 if (inp === "") {
                     await Swal.fire('เกิดข้อผิดพลาด', 'กรุณาใส่ชื่อไฟล์', 'warning')
                 }
                 _fileFormData.push({
                     attname: inp,
                     file_name: file.name,
                     attno: ++_i
                 });
                 //console.log("attName => ", inp, "file  Name => ", file.name);
             }
             formData.append("fileData", JSON.stringify(_fileFormData)); 

             for(let f of file_rename){
                let n = $(f);
                let code = n.attr("code");
                let valu = n.val();
                _fileRename.push({code:code, attname:valu}); 
             }
             formData.append("fileRename", JSON.stringify(_fileRename)); 

         for (let f of form) {
             formData.append(f.name, f.value);
         }

         for (let f of files) {
             formData.append("file[]", f.files[0])
         }
         formData.append("fileDelete", JSON.stringify(_filesDelete));
         formData.append("empcode", empcode);
         $.ajax({
             type: "POST",
             url: "ajax/edit_employer.php",
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
                    Swal.fire('เกิดข้อผิดพลาด', "เกิดปัญหาในหารเพิ่มข้อมูลกรุณาลิงใหม่อีกครั้ง", 'error');
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

     $(document).on("click", "button.btn-edit", function() {
         let modal = $("#modal_edit");
         let parent = $(this).closest("tr");

         let empcode = parent.attr("id-ref");
         modal.attr("data-empcode", empcode);

         $("#modal_edit").modal({
             backdrop: false
         });
         $("#modal_edit").modal("show");
     });

     $(document).on("show.bs.modal", "#modal_edit", async function(e) {
         let modal = $(this);
         let empcode = modal.attr("data-empcode");
         let employer = (_employerList.filter(f => f.empcode == empcode))[0];
         let attach = await gettingFile(empcode);
         Object.keys(employer).forEach((f, k) => {
             modal.find(`.modal-body [name=${f}]`).val(employer[f]);
         });
         const fileList = modal.find(".modal-body .file-list");
          
         const form = modal.find("form[enctype='multipart/form-data']");
         const template = $($("template[form_upfile]").html());
        
         for (let i in attach) {
            let pth = attach[i].url.split("//");
            let _f = pth[pth.length - 1];
            const _t = $($("template[form_upfile]").html());
            const formRow = _t.find(".form-row");
            const fileGroup = _t.find(".file-group");
            const inputGroup = _t.find(".input-group"); 
            inputGroup.find("small")
                .text(_f)
                .removeClass('custom-file-label')
                .addClass("px-2 py-1 m-0 rounded text-nowrap text-truncate")
                .css({
                    "font-weight": "600"
                });
            inputGroup.find(".btn-at").remove();
            inputGroup.find(".btn-dl")
                .removeClass("d-none")
                .attr(attach[i])

            fileGroup.find("small.d-none").remove();
            fileGroup.find("label.col-form-label").text(`ชื่อไฟล์ (${(parseInt(i)+1)}) :`);
            fileGroup.find("input[name=attname]").val(attach[i].attname).attr("code", attach[i].code);
            _t.attr("attaced", "");
            form.append(_t);
         };
         let _input = template.find(".form-row");
         _input.removeAttr("addnew");
         form.append(template);

     });

     $(document).on("hidden.bs.modal", "#modal_edit", function() {
         let model = $(this);
         model.find("[addnew]").remove();
     });

     $(document).on("click", "button[noatt]", function() {
         let btn = $(this);
         let percode = btn.attr("precode");
         let code = btn.attr("code");
         let attno = btn.attr("attno");
         let url = btn.attr("url");
         _filesDelete.push({
             percode: percode,
             code: code,
             attno: attno,
             url: url
         });
         removeFile(this);
     });

     $(document).on("click", "[uloadFile]", function() {
         let b = $(this);
         let p = b.closest(".file-group");
         let inpName = p.find("input[name=attname]");

         if (!!!inpName.val()) {
             inpName.css({
                 "border": "1px solid red"
             });
             p.find("small.d-none").removeClass("d-none");
             return;
         } else {
             inpName.css({
                 "border": "1px solid green"
             });
             p.find("input[type=file]").click();
         }


     });

     function fileChange(e) {
         const countFile = $("[name=atthFile]").length;
         const file = $(e)[0]?.files[0];
         const form = $(e).closest("form[enctype='multipart/form-data']");
         const formRow = $(e).closest(".form-row");
         const inputGroup = $(e).closest(".input-group");
         const template = $($("template[form_upfile]").html());
         inputGroup.find("small")
             .text(file.name)
             .removeClass('custom-file-label')
             .addClass("px-2 py-1 m-0 rounded text-nowrap text-truncate")
             .css({
                 "font-weight": "600"
             });
         inputGroup.find(".btn-at").remove();
         inputGroup.find(".btn-dl").removeClass("d-none");

         formRow.find("small.d-none").remove();
         formRow.find("label.col-form-label").text(`ชื่อไฟล์ (${countFile}) :`);
         formRow.find("input[name=attname").attr("addnew", "");
         formRow.attr("attaced", "")
         form.append(template);
     }

     function removeFile(e) {
         const i = $(e).closest('.form-row').attr("rm", "");

         $("[rm]").remove();
     }

     async function gettingEmployer() {
         let res = await $.get("ajax/get_employer.php");

         return res;
     }

     async function gettingFile(empcode) {
         let res = await $.get("ajax/get_attachfile.php", {
             empcode: empcode
         });

         return res;
     }

     function tables($this, col, data, option) {
         return $($this).DataTable(Object.assign({
             columns: col,
             data: data,
             dom: '<"top d-flex justify-content-between"lf><"tbox customscroll"t><"bottom d-flex justify-content-between"<"start"i><"end"p>><"clear">',
             destroy: true,
             //initComplete:tableLoad
         }, option));
     }

     function setRowTable(m) {
         return [
             m.empcode,
             m.empname,
             m.lastname,
             m.idcode,
             m.passport,
             `<span class="label badge ${m.status == 'Y' ? 'bg-success' : 'bg-danger'} label-white middle">${m.status == 'Y' ? 'ใช้งาน' : 'ไม่ใช้งาน'}</span>`,
             `<div>
                <button class="btn btn-sm rounded btn-primary btn-edit" data-empcode="${m.empcode}">
                    <i class="fas fa-pencil-alt"></i>
                </button>
            </div>`,
         ];
     }

     function actionRow(row, data, dataIndex) {
         $(row).attr('id-ref', data[0]);
     }
 </script>