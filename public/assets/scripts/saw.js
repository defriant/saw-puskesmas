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