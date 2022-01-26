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

getKriteria().then(function(result){
    $('#thead-penilaian').empty()
    $('#thead-normalisasi-penilaian').empty()

    $('#thead-penilaian').append(`<th>Karyawan</th>`)
    $('#thead-normalisasi-penilaian').append(`<th>Karyawan</th>`)
    $.each(result.data, function(i, v){
        $('#thead-penilaian').append(`<th>${v.nama}</th>`)
        $('#thead-normalisasi-penilaian').append(`<th>${v.nama}</th>`)
    })
    $('#thead-penilaian').append(`<th></th>`)
})

let normalisasiKriteria = []
let normalisasiPenilaian = []

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
getNormalisasiKriteria().then(function(result){
    normalisasiKriteria = result
})

$('#periode-penilaian').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'yy-mm',
    onClose: function(dateText, inst) { 
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    }
})

$('#search-penilaian').on('click', function(){
    if ($('#periode-penilaian').val().length == 0) {
        alert('Masukkan periode penilaian')
    }else{
        $('#table-penilaian').hide()
        $('#penilaian-karyawan-loader').html(`<div class="loader4"></div>
                                            <h5 style="margin-top: 2.5rem">Mencari data penilaian</h5>`)
        $('#penilaian-karyawan-loader').show()
        getPenilaian($('#periode-penilaian').val())
    }
})

function getPenilaian(params) {
    $.ajax({
        type:'post',
        url:'/penilaian-karyawan/get',
        data:{
            "periode": params
        },
        success:function(result){
            if (result.response == false) {
                $('#penilaian-karyawan-loader').html(`<h5 style="margin-top: 1rem">Data penilaian periode ${result.periode} belum dibuat</h5>`)
                $('#btn-buat-penilaian').unbind('click')
                $('#btn-buat-penilaian').on('click', function(){
                    createPenilaian(result.periode)
                })

                $('#table-normalisasi-penilaian').hide()
                $('#normalisasi-penilaian-loader').html(`<i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                        <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>`)
                $('#normalisasi-penilaian-loader').show()

                $('#table-hasil-penilaian').hide()
                $('#hasil-chart').hide()
                $('#hasil-loader').html(`<i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                                        <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>`)
                $('#hasil-loader').show()
            }else if (result.response == true) {
                console.log(result);
                $('#tbody-penilaian').empty()
                $.each(result.data, function(iRow, vRow){
                    $('#tbody-penilaian').append(`<tr id="row-penilaian-karyawan-${iRow}">
                                                        <td>${vRow.nama}</td>
                                                    </tr>`)

                    $.each(vRow.nilai, function(i, nilai){
                        let kNilai = ``
                        if (nilai.nilai >= 8) {
                            kNilai = `<span class="label label-success">Sangat Baik</span>`
                        }else if (nilai.nilai >= 6 && nilai.nilai < 8) {
                            kNilai = `<span class="label label-info">Baik</span>`
                        }else if (nilai.nilai >= 4 && nilai.nilai < 6) {
                            kNilai = `<span class="label label-warning">Kurang</span>`
                        }else if (nilai.nilai < 4) {
                            kNilai = `<span class="label label-danger">Sangat Kurang</span>`
                        }

                        $(`#row-penilaian-karyawan-${iRow}`).append(`<td>${nilai.nilai} ${kNilai}</td>`)
                    })
                })

                $('#penilaian-karyawan-loader').empty()
                $('#penilaian-karyawan-loader').hide()
                $('#table-penilaian').show()

                getNormalisasiPenilaian(params)
            }
        }
    })
}

function getNormalisasiPenilaian(params) {
    $('#normalisasi-penilaian-loader').html(`<div class="loader4"></div>
                                            <h5 style="margin-top: 2.5rem">Membuat normalisasi penilaian</h5>`)
    $('#normalisasi-penilaian-loader').show()
    $('#table-normalisasi-penilaian').hide()
    $.ajax({
        type:'post',
        url:'/normalisasi-penilaian-karyawan/get',
        data:{
            "periode": params
        },
        success:function(result){
            console.log(result);
            normalisasiPenilaian = result.data
            if (result.response == true) {
                $('#tbody-normalisasi-penilaian').empty()
                $.each(result.data, function(iRow, vRow){
                    $('#tbody-normalisasi-penilaian').append(`<tr id="row-normalisasi-penilaian-${iRow}">
                                                                    <td>${vRow.nama}</td>
                                                                </tr>`)

                    $.each(vRow.nilai, function(i, nilai){
                        $(`#row-normalisasi-penilaian-${iRow}`).append(`<td>${nilai.nilai}</td>`)
                    })
                })

                $('#normalisasi-penilaian-loader').empty()
                $('#normalisasi-penilaian-loader').hide()
                $('#table-normalisasi-penilaian').show()

                getFinalResult(normalisasiKriteria, normalisasiPenilaian)
            }
        }
    })
}

let chartHasilSet = false
let chartHasil

function getFinalResult(normalisasiKriteria, normalisasiPenilaian) {
    $('#hasil-loader').html(`<div class="loader4"></div>
                            <h5 style="margin-top: 2.5rem">Membuat peringkat</h5>`)
    $('#hasil-loader').show()
    $('#table-hasil-penilaian').hide()
    $('#hasil-chart').hide()
    $.ajax({
        type: 'post',
        url: '/penilaian-karyawan/final-result/get',
        data: {
            "nk": normalisasiKriteria,
            "np": normalisasiPenilaian
        },
        success:function(result){
            console.log(result);
            $('#tbody-hasil').empty()
            let no = 1;
            $.each(result, function(i, v){
                $('#tbody-hasil').append(`<tr>
                                                <td>${no}</td>
                                                <td>${v.nama}</td>
                                                <td>${v.nilai}</td>
                                            </tr>`)
                no = no + 1;
            })

            $('#hasil-loader').empty()
            $('#hasil-loader').hide()
            $('#table-hasil-penilaian').show()
            $('#hasil-chart').show()

            if (chartHasilSet == false) {
                createChartHasil(result)
            }else{
                updateChartHasil(chartHasil, result)
            }
        }
    })
}

function createChartHasil(result) {
    let chartLabels = []
    let chartData = []
    let chartHeight = 0

    $.each(result, function(i, v){
        chartLabels.push(v.nama)
        chartData.push(v.nilai)
        chartHeight = chartHeight + 75
    })

    $('#hasil-chart').css('max-height', `${chartHeight}px`)

    let ctx = document.getElementById("hasil-chart").getContext('2d')
    
    chartHasil = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Nilai',
                    data: chartData,
                    borderWidth: 3,
                    borderColor: mainColor,
                    backgroundColor: chartBarColor,
                    barThickness: 25
                }
            ]
        },
        options: {
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    chartHasilSet = true
}

function updateChartHasil(chartHasil, result) {
    let chartLabels = []
    let chartData = []
    let chartHeight = 0

    $.each(result, function(i, v){
        chartLabels.push(v.nama)
        chartData.push(v.nilai)
        chartHeight = chartHeight + 75
    })

    $('#hasil-chart').css('max-height', `${chartHeight}px`)

    chartHasil.data = {
        labels: chartLabels,
        datasets: [
            {
                label: 'Nilai',
                data: chartData,
                borderWidth: 3,
                borderColor: mainColor,
                backgroundColor: chartBarColor,
                barThickness: 25
            }
        ]
    }

    chartHasil.update()
}