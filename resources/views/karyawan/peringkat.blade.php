@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-headline" id="panel-prediksi-loading">
            <div class="panel-heading">
                <h3 class="panel-title">Peringkat Karyawan</h3>
            </div>
            <div class="panel-body">
                <p>Periode :</p>
                <div class="input-group" style="width: 300px">
                    <input class="form-control" type="text" id="periode-penilaian" readonly>
                    <span class="input-group-btn"><button class="btn btn-primary" type="button" id="search-penilaian"><i class="fas fa-search"></i></button></span>
                </div>
                <br>
                <div class="loader" id="penilaian-karyawan-loader">
                    
                </div>
                <br>
                <table class="table" id="table-penilaian">
                    <thead>
                        <tr id="thead-penilaian">
                            
                        </tr>
                    </thead>
                    <tbody id="tbody-penilaian">
                        
                    </tbody>
                </table>
            </div>
            <hr>

            <div class="panel-heading">
                <h3 class="panel-title">Normalisasi Penilaian</h3>
            </div>
            <div class="panel-body">
                <div class="loader" id="normalisasi-penilaian-loader">
                    <i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                    <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>
                </div>
                <table class="table" id="table-normalisasi-penilaian">
                    <thead>
                        <tr id="thead-normalisasi-penilaian">
                            
                        </tr>
                    </thead>
                    <tbody id="tbody-normalisasi-penilaian">
                        
                    </tbody>
                </table>
            </div>
            <hr>

            <div class="panel-heading">
                <h3 class="panel-title">Peringkat berdasarkan penilaian</h3>
            </div>
            <div class="panel-body">
                <div class="loader" id="hasil-loader">
                    <i class="fas fa-ban" style="font-size: 5rem; opacity: .5"></i>
                    <h5 style="margin-top: 2.5rem; opacity: .75">Belum ada data yang dipilih</h5>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <table class="table table-bordered" id="table-hasil-penilaian">
                            <thead>
                                <tr>
                                    <th style="width: 15%">No.</th>
                                    <th>Karyawan</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-hasil">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8">
                        <canvas id="hasil-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection