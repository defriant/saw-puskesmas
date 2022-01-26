$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$('.date-picker').datetimepicker({
    timepicker: false,
    format: 'Y-m-d'
})

$('.periodePicker').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy',
    onClose: function (dateText, inst) {
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    }
})

$('#btn-change-password').on('click', function(){
    if ($('#old-pass').val().length == 0) {
        alert("Masukkan password lama")
    }else if ($('#new-pass').val().length == 0) {
        alert("Masukkan password baru")
    }else if ($('#confirm-pass').val().length == 0) {
        alert("Masukkan konfirmasi password")
    }else if ($('#new-pass').val() !== $('#confirm-pass').val()) {
        alert("Password baru dan konfirmasi password tidak sesuai")
    }else{
        $('#btn-change-password').attr('disabled', true)

        let params = {
            "oldPass": $('#old-pass').val(),
            "newPass": $('#new-pass').val()
        }

        $.ajax({
            type: 'POST',
            url: '/user/change-password',
            dataType: "json",
            contentType: 'application/json',
            data: JSON.stringify(params),
            success:function(result){
                if (result.response == "success") {
                    $('#btn-change-password').removeAttr('disabled')
                    toastr.option = {
                        "timeout": "5000"
                    }
                    toastr["success"](result.message)
                    $('#old-pass').val('')
                    $('#new-pass').val('')
                    $('#confirm-pass').val('')
                    $('#modalChangePassword').modal('hide')
                }else if(result.response == "failed"){
                    alert(result.message)
                    $('#btn-change-password').removeAttr('disabled')
                }
            }
        })
    }
})



