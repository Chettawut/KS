 <script type="text/javascript">
    const HEADER = [
        { title:"รหัสนายจ้าง" },
        { title:"ชื่อนายจ้าง" },
        { title:"นามสกุล" },
        { title:"รหัสประชาชน" },
        { title:"พาสปอร์ต" },
        { title:"สถานะ" },
        { title:"ตัวเลือก" },
    ];
    let _employerList = undefined;
    let _filesDelete = [];
    $(async function() {
        $("#add_cusdate").val(new Date().toISOString().substring(0, 10)); 
        _employerList = await gettingEmployer();

        let dataArray = _employerList.map( m => setRowTable(m));
        let ignoreSorting = HEADER.map( (m, i) => ( ["ตัวเลือก", "สถานะ"].includes(m.title) ? i : -1) ).filter( f => f != -1 );
        let configTb = {
            lengthMenu: [ [10, 20, 50, -1 ], ['10', '20', '50', 'All' ]],
            order: [[1, 'asc']],
            columnDefs: [ {'targets': ignoreSorting, 'orderable': false, }],
            createdRow : actionRow
        } 
        tables("#tableEmployer", HEADER, dataArray, configTb);
    }); 

    $("#btnRefresh").click(function() {
         window.location.reload();
    });

    //เพิ่มผู้ขาย
    $("#frmAddEmployer").submit(function(e) {
         e.preventDefault();
         $(':disabled').each(function(event) {
             $(this).removeAttr('disabled');
         });
         let form = $(this).serializeArray();
         let files = $("[attaced]");
         let formData = new FormData();
         if(files.length < 1) {
            alert("กรุณา แนบไฟล์");
            return;
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
             success: function(result) {
                 if (result.status == 1) // Success
                 {
                     alert(result.message);
                     window.location.reload();
                     // console.log(result.message);
                 } else {
                     alert('รหัสซ้ำ');
                 }
             },
             error: function(error) {
                console.log(error.responseText);
                alert(error.responseText);
             }
         }); 
    });

    $("#frmEditCustomer").submit(function(e) {
         e.preventDefault();
         $(':disabled').each(function(e) {
             $(this).removeAttr('disabled');
         })
         let attached = $("[attached]");
         let form = $(this).serializeArray();
         let files = $("[attaced]");
         let formData = new FormData();
         let empcode = $("#modal_edit").attr("data-empcode"); 
         if(files.length < 1 && attached.length < 1) {
            alert("กรุณา แนบไฟล์");
            return;
         }

         for (let f of form) {
             formData.append(f.name, f.value);
         }

         for (let f of files) {
             formData.append("file[]", f.files[0])
         }
         formData.append("fileDelete", JSON.stringify( _filesDelete ) );
         formData.append("empcode", empcode );
         $.ajax({
             type: "POST",
             url: "ajax/edit_employer.php",
             processData: false,
             contentType: false,
             data: formData,
             success: function(result) {
                 if (result.status == 1) // Success
                 {
                     alert(result.message);
                     window.location.reload();
                     // console.log(result.message);
                 } else {
                     alert('รหัสซ้ำ');
                 }
             },
             error: function(error) {
                console.log(error.responseText);
                alert(error.responseText);
             }
         }); 

    });

    $(document).on("click", "tr[id-ref]", function(){
        if(!$(this).attr("selected")){
            $("[selected]").removeAttr("style");
            $("[selected]").removeAttr("selected");
            $(this).css({"background": "#838a93", "color": "white", "font-weight": "600"});
            $(this).attr("selected", "");
        }else{
            $(this).removeAttr("style");
            $(this).removeAttr("selected");
        } 
    });

    $(document).on("click", "button.btn-edit", function(){
        let modal = $("#modal_edit");
        let parent = $(this).closest("tr");

        let empcode = parent.attr("id-ref");
        modal.attr("data-empcode", empcode);

        $("#modal_edit").modal({ backdrop:false});
        $("#modal_edit").modal("show");
    });

    $(document).on("show.bs.modal", "#modal_edit", async function(e){
        let modal = $(this);
        let empcode = modal.attr("data-empcode"); 
        let employer =( _employerList.filter(f => f.empcode == empcode) )[0];
        let attach = await gettingFile(empcode);
        Object.keys(employer).forEach( (f, k) => {
            modal.find(`.modal-body [name=${f}]`).val(employer[f]); 
        });
        const fileList = modal.find(".modal-body .file-list");
        const filetemp = fileList.find("template").html();
 
        for(let f of attach ){
            let inputGroup = $(filetemp);
            inputGroup.find("input").hide();
            inputGroup.find("label")
                .text(f.attname) 
                .removeClass('custom-file-label')
                .addClass("w-100 px-2 py-1 m-0 rounded text-nowrap text-truncate")
                .css({
                    "border": "1px solid #ced4da",
                    "line-height": "1.83344",
                    "background": "#e7eaed"
                });
            inputGroup.removeAttr("temp").attr("attached", "");
            inputGroup.find(".input-group-append").removeClass("d-none"); 
            inputGroup.find(".input-group-append button")
                .removeAttr("onClick")
                .attr({code:f.code, precode:f.percode, no:f.attno, fn:f.attname, noatt:""});
            fileList.append(inputGroup); 
        };
        let _input = $(filetemp);
        _input.attr("attachment", "");
        fileList.append(_input);

    });

    $(document).on("hidden.bs.modal", "#modal_edit", function(){
        let model = $(this);
        model.find(".modal-body .file-list template~*").remove();
    });

    $(document).on("click", "button[noatt]", function(){
        let btn = $(this);
        let percode = btn.attr("precode");
        let code = btn.attr("code");
        let no = btn.attr("no");
        let fn = btn.attr("fn");
        _filesDelete.push({percode:percode, code:code, no:no, fn:fn});
        removeFile(this);
    });

    function fileChange(e) {
         const file = $(e)[0]?.files[0];
         const fileList = $(e).closest(".file-list");
         const inputGroup = $(e).closest(".input-group");
         const markFile = $($(fileList, "template").html());
         $(e).attr("attaced", "");
         $(e).next("label").text(file.name);
         inputGroup.find("input").hide();
         inputGroup.find("label")
             .removeClass('custom-file-label')
             .addClass("w-100 px-2 py-1 m-0 rounded text-nowrap text-truncate")
             .css({
                 "border": "1px solid #ced4da",
                 "line-height": "1.83344",
                 "background": "#e7eaed"
             });
         inputGroup.find(".input-group-append").removeClass("d-none");
         inputGroup.removeAttr("markfile");

         markFile.find("input[type=file]").val('');
         markFile.find("label").text('');
         fileList.append(`${markFile.html()}`);
    }

    function removeFile(e) {
         const i = $(e).closest('.input-group').attr("rm", "");

         $("[rm]").remove();
    }

    async function gettingEmployer(){
       let res = await $.get("ajax/get_employer.php");

       return res;
    }

    async function gettingFile(empcode){
       let res = await $.get("ajax/get_attachfile.php",{empcode:empcode});

       return res;
    }

    function tables($this, col, data, option){
        return $($this).DataTable(Object.assign({
            columns : col,
            data:data,
            dom: '<"top d-flex justify-content-between"lf><"tbox customscroll"t><"bottom d-flex justify-content-between"<"start"i><"end"p>><"clear">',
            destroy:true,
            //initComplete:tableLoad
        },option));
    }

    function setRowTable(m){
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

    function actionRow( row, data, dataIndex ) { 
        $( row ).attr('id-ref', data[0] );
    }
 </script>
