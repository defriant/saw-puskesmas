let normalisasiKriteria = []

getKriteria().then(function(result){
    kriteriaComponent(result)
})

getNormalisasiKriteria().then(function(result){
    normalisasiKriteriaComponent(result)
})

function getKriteria() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'get',
            url: '/kriteria/get',
            success:function(result){
                resolve(result)
            }
        })
    })
}

function kriteriaComponent(result) {
    $('#panel-body-kriteria').html(`<table class="table">
                                        <thead>
                                            <tr>
                                                <th>Kriteria</th>
                                                <th>Bobot</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-kriteria">
                                            
                                        </tbody>
                                    </table>
                                    <button class="btn btn-info" id="btn-add-kriteria"><i class="far fa-plus"></i> &nbsp; Tambah Kriteria</button>`)

    $('#data-kriteria').empty()
    $('#thead-penilaian').empty()
    $('#thead-normalisasi-penilaian').empty()

    $('#thead-penilaian').append(`<th>Karyawan</th>`)
    $('#thead-normalisasi-penilaian').append(`<th>Karyawan</th>`)
    $.each(result.data, function(i, v){
        $('#data-kriteria').append(`<tr>
                                        <td style="width: 50%">${v.nama}</td>
                                        <td style="width: 20%">${v.bobot}</td>
                                        <td style="width: 30%; text-align: right">
                                            <button class="btn-table-action edit update-kriteria" data-id="${v.id}" data-nama="${v.nama}" data-bobot="${v.bobot}"><i class="fas fa-pen"></i></button> &nbsp;
                                            <button class="btn-table-action delete delete-kriteria" data-id="${v.id}" data-nama="${v.nama}"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>`)

        $('#thead-penilaian').append(`<th>${v.nama}</th>`)
        $('#thead-normalisasi-penilaian').append(`<th>${v.nama}</th>`)
    })
    $('#thead-penilaian').append(`<th></th>`)

    buttonAddKriteria()
    buttonUpdateKriteria()
    buttonDeleteKriteria()
}

function buttonUpdateKriteria() {
    $('.update-kriteria').unbind('click')
    $('.update-kriteria').on('click', function(){
        let oldRowKriteria = $(this).parent().parent().html()
        let kriteriaRow = $(this).parent().parent()
        let kriteriaId = $(this).data('id')
        let kriteriaNama = $(this).data('nama')
        let kriteriaBobot = $(this).data('bobot')
        
        kriteriaRow.html(`<td style="width: 50%"><input type="text" class="form-control" placeholder="Nama kriteria" id="update-kriteria-nama" value="${kriteriaNama}"></td>
                            <td style="width: 20%"><input type="text" class="form-control" placeholder="Bobot" id="update-kriteria-bobot" value="${kriteriaBobot}"></td>
                            <td style="width: 30%; text-align: right">
                                <button class="btn-table-action acc" id="update-kriteria"><i class="fas fa-check"></i></button> &nbsp;
                                <button class="btn-table-action delete" id="cancel-update-kriteria"><i class="fas fa-times"></i></button>
                            </td>`)
        $('#update-kriteria-nama').focus()
        $('.update-kriteria').addClass('btn-hide')
        $('.delete-kriteria').addClass('btn-hide')
        $('#btn-add-kriteria').addClass('btn-hide')

        $('#update-kriteria').unbind('click')
        $('#update-kriteria').on('click', function(){
            if ($('#update-kriteria-nama').val().length == 0) {
                alert('Masukkan nama kriteria')
            }else if($('#update-kriteria-bobot').val().length == 0){
                alert('Masukkan bobot')
            }else{
                $('#update-kriteria').attr('disabled', 'disabled')
                $('#cancel-update-kriteria').attr('disabled', 'disabled')
                $.ajax({
                    type: 'post',
                    url: '/kriteria/update',
                    data: {
                        "id": kriteriaId,
                        "nama": $('#update-kriteria-nama').val(),
                        "bobot": $('#update-kriteria-bobot').val()
                    },
                    success:function(result){
                        if (result.response == "success") {
                            getKriteria().then(function(result){
                                kriteriaComponent(result)
                                $('#btn-add-kriteria').removeClass('btn-hide')
                            })
                            getNormalisasiKriteria().then(function(result){
                                normalisasiKriteriaComponent(result)
                            })
                            $('#table-penilaian').hide()
                            $('#table-normalisasi-penilaian').hide()
                            $('#normalisasi-penilaian-loader').html(`<i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                                    <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>`)
                            $('#normalisasi-penilaian-loader').show()

                            $('#table-hasil-penilaian').hide()
                            $('#hasil-chart').hide()
                            $('#hasil-loader').html(`<i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                                    <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>`)
                            $('#hasil-loader').show()
                        }
                    }
                })
            }
        })

        $('#cancel-update-kriteria').on('click', function(){
            kriteriaRow.html(oldRowKriteria)
            buttonUpdateKriteria()
            $('.update-kriteria').removeClass('btn-hide')   
            $('.delete-kriteria').removeClass('btn-hide')                          
            $('#btn-add-kriteria').removeClass('btn-hide')
        })
    })
}

function buttonDeleteKriteria() {
    $('.delete-kriteria').unbind('click')
    $('.delete-kriteria').on('click', function(){
        $('#delete-warning-message').html('Hapus kriteria ' + $(this).data('nama'))
        $('#delete_id_kriteria').val($(this).data('id'))
        $('#modalDeleteKriteria').modal('show')
    })

    $('#btn-delete-data').unbind('click')
    $('#btn-delete-data').on('click', function(){
        $.ajax({
            type: 'post',
            url: '/kriteria/delete',
            data:{
                "id": $('#delete_id_kriteria').val()
            },
            success:function(result){
                if (result.response == "success") {
                    getKriteria().then(function(result){
                        $('#modalDeleteKriteria').modal('hide')
                        kriteriaComponent(result)
                    })
                    getNormalisasiKriteria().then(function(result){
                        normalisasiKriteriaComponent(result)
                    })
                    $('#table-penilaian').hide()
                    $('#table-normalisasi-penilaian').hide()
                    $('#normalisasi-penilaian-loader').html(`<i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                            <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>`)
                    $('#normalisasi-penilaian-loader').show()

                    $('#table-hasil-penilaian').hide()
                    $('#hasil-chart').hide()
                    $('#hasil-loader').html(`<i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                            <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>`)
                    $('#hasil-loader').show()
                }
            }
        })
    })
}

function buttonAddKriteria() {
    $('#btn-add-kriteria').on('click', function(){
        $('#data-kriteria').append(`<tr id="row-add-kriteria">
                                        <td style="width: 50%"><input type="text" class="form-control" placeholder="Nama kriteria" id="add-kriteria-nama"></td>
                                        <td style="width: 20%"><input type="text" class="form-control" placeholder="Bobot" id="add-kriteria-bobot"></td>
                                        <td style="width: 30%; text-align: right">
                                            <button class="btn-table-action acc" id="add-kriteria"><i class="fas fa-check"></i></button> &nbsp;
                                            <button class="btn-table-action delete" id="cancel-add-kriteria"><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>`)
        $('#add-kriteria-nama').focus()
        $('.update-kriteria').addClass('btn-hide')   
        $('.delete-kriteria').addClass('btn-hide')                          
        $('#btn-add-kriteria').addClass('btn-hide')
    
        $('#cancel-add-kriteria').on('click', function(){
            $('#row-add-kriteria').remove()
            $('.update-kriteria').removeClass('btn-hide')   
            $('.delete-kriteria').removeClass('btn-hide')                          
            $('#btn-add-kriteria').removeClass('btn-hide')
        })
    
        $('#add-kriteria').unbind('click')
        $('#add-kriteria').on('click', function(){
            if ($('#add-kriteria-nama').val().length == 0) {
                alert('Masukkan nama kriteria !')
            }else if ($('#add-kriteria-bobot').val().length == 0){
                alert('Masukkan bobot')
            }else{
                $('#add-kriteria').attr('disabled', 'disabled')
                $('#cancel-add-kriteria').attr('disabled', 'disabled')
                $.ajax({
                    type: 'post',
                    url: '/kriteria/add',
                    data: {
                        "nama": $('#add-kriteria-nama').val(),
                        "bobot": $('#add-kriteria-bobot').val()
                    },
                    success:function(result){
                        if (result.response == "success") {
                            getKriteria().then(function(result){
                                kriteriaComponent(result)
                                $('#btn-add-kriteria').removeClass('btn-hide')
                            })
                            getNormalisasiKriteria().then(function(result){
                                normalisasiKriteriaComponent(result)
                            })
                            $('#table-penilaian').hide()
                            $('#table-normalisasi-penilaian').hide()
                            $('#normalisasi-penilaian-loader').html(`<i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                                    <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>`)
                            $('#normalisasi-penilaian-loader').show()
    
                            $('#table-hasil-penilaian').hide()
                            $('#hasil-chart').hide()
                            $('#hasil-loader').html(`<i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                                    <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>`)
                            $('#hasil-loader').show()
                        }
                    }
                })
            }
        })
    })
}

// Kriteria Ternormalisasi
function getNormalisasiKriteria(){
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'get',
            url: '/kriteria-normalisasi/get',
            success:function(result){
                resolve(result)
            }
        })
    })
}

function normalisasiKriteriaComponent(result) {
    $('#panel-body-normalisasi-kriteria').html(`<table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Kriteria</th>
                                                            <th>Bobot Ternormalisasi</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="data-kriteria-normalisasi">
                                                        
                                                    </tbody>
                                                </table>
                                                <button class="btn btn-info" style="visibility: hidden"><i class="far fa-plus"></i></button>`)

    normalisasiKriteria = result
    $('#data-kriteria-normalisasi').empty()
    $.each(result, function(i, v){
        $('#data-kriteria-normalisasi').append(`<tr>
                                                    <td>${v.nama}</td>
                                                    <td>${v.bobot}</td>
                                                    <td>
                                                        <button class="btn-table-action edit" style="visibility: hidden"><i class="fas fa-pen"></i></button>
                                                    </td>
                                                </tr>`)
    })
}