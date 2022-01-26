@extends('layouts.master')
@section('content')
<div class="panel panel-profile">
    <div class="clearfix">
        <div class="profile-left">
            <div class="profile-header">
                <div class="overlay"></div>
                <div class="profile-main">
                    @if (Auth::user()->karyawan->jenis_kelamin == "Laki-laki")
                        <div style="background-image: url('{{ asset('assets/img/admin.png') }}')" id="user-picture"></div>
                    @else
                        <div style="background-image: url('{{ asset('assets/img/user-female.png') }}')" id="user-picture"></div>
                    @endif
                    <h3 class="name" id="user-name">{{ Auth::user()->karyawan->nama }}</h3>
                </div>
            </div>

            <div class="profile-detail">
                <div class="profile-info">
                    <h4 class="heading">Informasi Pengguna</h4>
                    <ul class="list-unstyled list-justify">
                        <li>Tanggal Lahir <span>{{ date('d F Y', strtotime(Auth::user()->karyawan->tgl_lahir)) }}</span></li>
                        <li>Jenis Kelamin <span id="user-telepon">{{ Auth::user()->karyawan->jenis_kelamin }}</span></li>
                        <li>Alamat <span>{{ Auth::user()->karyawan->alamat }}</span></li>
                    </ul>
                </div>
                {{-- <div class="text-center"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalEditProfil">Edit Profile</a></div> --}}
            </div>
        </div>
        
        <div class="profile-right">
            <h4 class="heading">Penilaian bulan {{ date('F Y') }}</h4>
            <div class="row">
                <div class="col-12" id="penilaian">
                    <div class="loader">
                        <div class="loader4"></div>
                        <h5 style="margin-top: 2.5rem">Loading data</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="modal fade" id="modalEditProfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Profil</h4>
            </div>
            <div class="modal-body">
                <div class="edit-img">
                    <div style="background-image: url({{ Auth::user()->karyawan->foto }})" data-image="{{ Auth::user()->karyawan->foto }}" id="editImgView"></div>
                    <input type="file" id="editImgInput">
                    <br>
                    <button class="btn btn-primary" id="btn-choose-img">Choose file</button>
                </div>
                <hr>
                <p>Nama lengkap</p>
                <input type="text" id="nama" class="form-control" value="{{ Auth::user()->name }}">
                <br>
                <p>Telepon</p>
                <input type="text" id="telepon" class="form-control" value="{{ Auth::user()->karyawan->telepon }}">
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save-profile">Simpan</button>
            </div>
        </div>
    </div>
</div> --}}
@endsection