@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Alternatif / Kriteria</h3>
            </div>
            <div class="panel-body" id="panel-body-kriteria">
                <div class="loader">
                    <div class="loader4"></div>
                    <h5 style="margin-top: 2.5rem">Loading data</h5>
                </div>
                {{-- <table class="table">
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
                <button class="btn btn-info" id="btn-add-kriteria"><i class="far fa-plus"></i> &nbsp; Tambah Kriteria</button> --}}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Normalisasi Kriteria</h3>
            </div>
            <div class="panel-body" id="panel-body-normalisasi-kriteria">
                <div class="loader">
                    <div class="loader4"></div>
                    <h5 style="margin-top: 2.5rem">Loading data</h5>
                </div>

                {{-- <table class="table">
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
                <button class="btn btn-info" style="visibility: hidden"><i class="far fa-plus"></i></button> --}}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-headline" id="panel-prediksi-loading">
            {{-- Penilaian --}}
            <div class="panel-heading">
                <h3 class="panel-title">Penilaian Karyawan</h3>
            </div>
            <div class="panel-body">
                <p>Periode penilaian :</p>
                <div class="input-group" style="width: 300px">
                    <input class="form-control" type="text" id="periode-penilaian" readonly>
                    <span class="input-group-btn"><button class="btn btn-primary" type="button" id="search-penilaian"><i class="fas fa-search"></i></button></span>
                </div>
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

            {{-- Normalisasi Penilaian --}}
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

            {{-- Hasil --}}
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

<div class="modal fade" id="modalDeleteKriteria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" style="margin-top: 3rem" id="delete-warning-message"></h4>
                <input type="hidden" id="delete_id_kriteria">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-data">Hapus</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdatePenilaian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>
@endsection