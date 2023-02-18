<script type="text/javascript">
$(function() {

    $.ajax({
        type: "POST",
        url: "ajax/get_user.php",
        //    data: $("#frmMain").serialize(),
        success: function(result) {
            var type;
            for (count = 0; count < result.username.length; count++) {

                if(result.type[count]=='01')
                type = 'ธุรการ'
                if(result.type[count]=='02')
                type = 'Messenger'
                if(result.type[count]=='03')
                type = 'บัญชี'
                if(result.type[count]=='99')
                type = 'Admin'

                $('#tableUser').append(
                    '<tr data-toggle="modal" data-target="#modelUserEdit" id="' + result
                    .username[
                        count] + '" data-whatever="' + result.username[
                        count] + '"><td>' + result.username[count] + '</td><td>' +
                    result.firstname[count] + '</td><td>' +
                    result.lastname[count] + '</td><td>' + type + '</td></tr>');
            }

            var table = $('#tableUser').DataTable({
                "dom": '<"pull-right"f>rt<"bottom"p><"clear">',"ordering": false
            });

            $(".dataTables_filter input[type='search']").attr({
                size: 40,
                maxlength: 40
            });

        }
    });
   

})
$('#modelUserEdit').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var recipient = button.data('whatever');
    var modal = $(this);

    $.ajax({
        type: "POST",
        url: "ajax/getsup_user.php",
        data: "idcode=" + recipient,
        success: function(result) {
            modal.find('.modal-body #editusername').val(result.username);            
            modal.find('.modal-body #editpassword').val(result.password);            
            modal.find('.modal-body #editfirstname').val(result.firstname);
            modal.find('.modal-body #editlastname').val(result.lastname);
            modal.find('.modal-body #editstatus').val(result.status);
            modal.find('.modal-body #edittype').val(result.type);
            modal.find('.modal-body #editemail').val(result.email);
           
        }
    });
});

$("#btnRefresh").click(function() {
    window.location.reload();
});

//ส่งใบแจ้ง
$("#frmAddUser").submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "ajax/add_user.php",
        data: $("#frmAddUser").serialize(),
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

$("#btnEditUser").click(function() {

    $.ajax({
        type: "POST",
        url: "ajax/edit_user.php",
        data: $("#frmEditUser").serialize(),
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

$("#btnDeleteUser").click(function() {

$.ajax({
    type: "POST",
    url: "ajax/delete_user.php",
    data: $("#frmEditUser").serialize(),
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
</script>