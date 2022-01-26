getDashboardData()

function getDashboardData() {
    $.ajax({
        type:'get',
        url:'/karyawan/dashboard/get',
        success:function(result){
            if (result.length > 0) {
                $('#penilaian').html(`<table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kriteria</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-penilaian">
                                            
                                        </tbody>
                                    </table>`)

                let tbodyPenilaian = ``
                let no = 1
                $.each(result, function(i, v){
                    let kNilai = ``
                    if (v.nilai >= 8) {
                        kNilai = `<span class="label label-success">Sangat Baik</span>`
                    }else if (v.nilai >= 6 && v.nilai < 8) {
                        kNilai = `<span class="label label-info">Baik</span>`
                    }else if (v.nilai >= 4 && v.nilai < 6) {
                        kNilai = `<span class="label label-warning">Kurang</span>`
                    }else if (v.nilai < 4) {
                        kNilai = `<span class="label label-danger">Sangat Kurang</span>`
                    }

                    tbodyPenilaian = tbodyPenilaian + `<tr>
                                                            <td>${no}</td>
                                                            <td>${v.kriteria}</td>
                                                            <td>${v.nilai} &nbsp; ${kNilai}</th>
                                                        </tr>`
                    no = no + 1
                })

                $('#tbody-penilaian').html(tbodyPenilaian)

            }else{
                $('#penilaian').html(`<div class="loader">
                                            <i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                                            <h5 style="margin-top: 2.5rem; opacity: .75">Penilaian bulan ini belum dibuat</h5>
                                        </div>`)
            }
        }
    })
}