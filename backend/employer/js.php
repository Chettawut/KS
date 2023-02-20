 <script type="text/javascript">
    const HEADER = [
        { title:"รหัสนายจ้าง"},
        { title:"ชื่อนายจ้าง"},
        { title:"นามสกุล"},
        { title:"รหัสประชาชน"},
        { title:"พาสปอร์ต"},
        { title:"สถานะ"},          
    ]
     $(async function() {
         $("#add_cusdate").val(new Date().toISOString().substring(0, 10));

         let employerList = await gettingEmployer();
         let dataArray = employerList.map( m => setRowTable(m));
         let configTb = { 
            lengthMenu: [ [ -1], [ 'All']],
            order: [[1, 'asc']], 
            createdRow : actionRow 
        }
        console.log(dataArray, HEADER);
         settingWaitActionTable("#tableEmployer", HEADER, dataArray, configTb);
     })

     $('#modal_edit').on('show.bs.modal', function(event) {
         var button = $(event.relatedTarget);
         var recipient = button.data('whatever');
         var modal = $(this);

         $.ajax({
             type: "POST",
             url: "ajax/getsup_customer.php",
             data: "idcode=" + recipient,
             success: function(result) {
                 modal.find('.modal-body #cuscode').val(result.cuscode);
                 modal.find('.modal-body #cusname').val(result.cusname);
                 modal.find('.modal-body #lastname').val(result.lastname);
                 modal.find('.modal-body #titlename').val(result.titlename);
                 modal.find('.modal-body #cusdate').val(result.cusdate);
                 modal.find('.modal-body #code').val(result.code);
                 modal.find('.modal-body #codeno').val(result.codeno);
                 modal.find('.modal-body #plateno').val(result.plateno);
                 modal.find('.modal-body #credittype').val(result.credittype);
                 modal.find('.modal-body #oldfinance').val(result.oldfinance);
                 modal.find('.modal-body #closeprice').val(result.closeprice);
                 modal.find('.modal-body #closevender').val(result.closevender);
                 modal.find('.modal-body #diff').val(result.diff);
                 modal.find('.modal-body #branch').val(result.branch);
                 modal.find('.modal-body #province').val(result.province);
                 modal.find('.modal-body #followdate').val(result.followdate);
                 modal.find('.modal-body #bookdate').val(result.bookdate);
                 modal.find('.modal-body #trackno').val(result.trackno);


             }
         });
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
         let _form = $(this).serializeArray();
         let _file = $("[attaced]");
         let _formData = new FormData();
         for (let f of _form) {
             _formData.append(f.name, f.value);
         }

         for (let f of _file) {
             _formData.append("file[]", f.files[0])
         }
         $.ajax({
             type: "POST",
             url: "ajax/add_employer.php",
             processData: false,
             contentType: false,
             data: _formData,
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
                 console.log(error);
             }
         });


     });

     $("#frmEditCustomer").submit(function(e) {
         e.preventDefault();
         $(':disabled').each(function(e) {
             $(this).removeAttr('disabled');
         })
         $.ajax({
             type: "POST",
             url: "ajax/edit_customer.php",
             data: $("#frmEditCustomer").serialize(),
             success: function(result) {

                 if (result.status == 1) // Success
                 {
                     alert(result.message);
                     window.location.reload();
                     // console.log(result.message);
                 }
             }
         });

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
             .addClass("w-100 px-2 py-1 m-0 rounded")
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
         const _i = $(e).closest('.input-group').attr("rm", "");

         $("[rm]").remove();
     }

     async function gettingEmployer(){
        let res = await $.get("ajax/get_employer.php");

        return res;
     }

     function settingWaitActionTable($this, col, data, option){
        return $($this).DataTable(Object.assign({
            columns : col, 
            data:data,
            dom: '<"top"f><"tbox customscroll"t><"bottom"i><"clear">',
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
        ];
    }      

    function actionRow( row, data, dataIndex ) { 
        $( row ).attr('id-ref', data[dataIndex]?.empcode ); 
    }
 </script>