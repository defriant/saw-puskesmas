@extends('layouts.master')
@section('content')
<div class="panel panel-headline">
    <div class="panel-heading">
        <h3 class="panel-title">Sistem Pelaporan Kinerja Pegawai</h3>
        <p class="panel-subtitle">
            {{ date('d F Y') }}
        </p>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="metric">
                    <span class="icon"><i class="fas fa-users"></i></span>
                    <p>
                        <span class="number" style="margin-bottom: .5rem" id="terjual">{{ $karyawan }}</span>
                        <span class="title" style="font-size: 1.4rem;">Karyawan</span>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric">
                    <span class="icon"><i class="fas fa-chart-line"></i></span>
                    <p>
                        <span class="number" style="margin-bottom: .5rem" id="totalPendapatan">{{ $kriteria }}</span>
                        <span class="title" style="font-size: 1.4rem;">Kriteria Penilaian</span>
                    </p>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12" style="height: 300px; display: flex; flex-direction: column; justify-content: center; align-items:center;">
                <img src="{{ asset('assets/img/logo-puskesmas-1.png') }}" style="width: 230px;">
                <h4><b></b></h4>
            </div>
        </div>
        <br><br>
    </div>
</div>
@endsection