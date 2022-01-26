let tableKaryawan = $('#table-karyawan').DataTable({
    'ajax': '/data-karyawan/get',
    'columns': [
        {'data' : 'id'},
        {'data' : 'nama'},
        {'data' : 'username'},
        {'data' : 'jenis_kelamin'},
        {'data' : 'tgl_lahir'},
        {'data' : 'alamat'},
        {
            data:null,
            render:function(data, type, row) {
                return `<div style="display: flex">
                            <button id="editData" class="btn-table-action edit" data-toggle="modal" data-target="#modalEditData" style="margin-right: .75rem"><i class="fas fa-cog"></i></button>
                            <button id="deleteData" class="btn-table-action delete" data-toggle="modal" data-target="#modalDeleteData"><i class="fas fa-trash-alt"></i></button>
                        </div>`
            }
        }
    ]
})

$('#table-karyawan tbody').on('click', '[id*=editData]', function(){
    let data = tableKaryawan.row($(this).parents('tr')).data()
    
    $('#edit_id_karyawan').val(data['id'])
    $('#edit_nama').val(data['nama'])
    $('#edit_jenis_kelamin').val(data['jenis_kelamin'])
    $('#edit_tgl_lahir').val(data['tgl_lahir'])
    $('#edit_alamat').val(data['alamat'])
})

$('#table-karyawan tbody').on('click', '[id*=deleteData]', function(){
    let data = tableKaryawan.row($(this).parents('tr')).data()
    
    $('#delete-warning-message').html(`Hapus data karyawan ${data['nama']}`)
    $('#delete_id_karyawan').val(data['id'])
})

$('#nama').on('input', function(){
    $('#username').val($(this).val().replaceAll(' ', '').toLowerCase())
})

$('#btn-input-data').on('click', function(){
    if ($('#nama').val().length == 0) {
        alert('Masukkan nama karyawan')
    }else if ($('#username').val().length == 0) {
        alert('Masukkan akses username')    
    } else if($('#jenis_kelamin').val().length == 0){
        alert('Pilih jenis kelamin')
    }else if($('#tgl_lahir').val().length == 0){
        alert('Masukkan tanggal lahir')
    }else if($('#alamat').val().length == 0){
        alert('Masukkan alamat')
    }else{
        let karyawanData = {
            "nama": $('#nama').val(),
            "username": $('#username').val(),
            "jenis_kelamin": $('#jenis_kelamin').val(),
            "tgl_lahir": $('#tgl_lahir').val(),
            "alamat": $('#alamat').val()
        }
    
        $.ajax({
            type:'post',
            url:'/data-karyawan/input',
            data: karyawanData,
            success:function(result){
                console.log(result);
                if (result.response == "success") {
                    toastr.option = {
                        "timeout": "5000"
                    }
                    toastr["success"](result.message)
                    $('#nama').val('')
                    $('#username').val('')
                    $('#jenis_kelamin').val('')
                    $('#tgl_lahir').val('')
                    $('#alamat').val('')
                    $('#modalInput').modal('hide')
                    $('#table-karyawan').DataTable().ajax.reload()
                }else if (result.response == "failed") {
                    toastr.option = {
                        "timeout": "5000"
                    }
                    toastr["error"](result.message)
                }
            }
        })
    }
})

$('#btn-edit-data').on('click', function(){
    if ($('#edit_nama').val().length == 0) {
        alert('Masukkan nama karyawan')
    } else if($('#edit_jenis_kelamin').val().length == 0){
        alert('Pilih jenis kelamin')
    }else if($('#edit_tgl_lahir').val().length == 0){
        alert('Masukkan tanggal lahir')
    }else if($('#edit_alamat').val().length == 0){
        alert('Masukkan alamat')
    }else{
        let karyawanData = {
            "id": $('#edit_id_karyawan').val(),
            "nama": $('#edit_nama').val(),
            "jenis_kelamin": $('#edit_jenis_kelamin').val(),
            "tgl_lahir": $('#edit_tgl_lahir').val(),
            "alamat" :$('#edit_alamat').val()
        }
    
        $.ajax({
            type:'post',
            url:'/data-karyawan/update',
            data: karyawanData,
            success:function(result){
                console.log(result);
                if (result.response == "success") {
                    toastr.option = {
                        "timeout": "5000"
                    }
                    toastr["success"](result.message)
                    $('#modalEditData').modal('hide')
                    $('#table-karyawan').DataTable().ajax.reload()
                }
            }
        })
    }
})

$('#btn-delete-data').on('click', function(){
    $.ajax({
        type: 'post',
        url: '/data-karyawan/delete',
        data: {
            "id": $('#delete_id_karyawan').val()
        },
        success:function(result){
            if (result.response == "success") {
                toastr.option = {
                    "timeout": "5000"
                }
                toastr["success"](result.message)
                $('#modalDeleteData').modal('hide')
                $('#table-karyawan').DataTable().ajax.reload()
            }
        }
    })
})