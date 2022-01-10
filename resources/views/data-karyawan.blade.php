@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- RECENT PURCHASES -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Data Karyawan</h3>
                <div class="right">
                    <button type="button" data-toggle="modal" data-target="#modalInput"><i class="far fa-plus"></i>&nbsp; Input Data Karyawan</button>
                </div>
            </div>
            <div class="panel-body">
                <table class="table" id="table-karyawan">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tgl Lahir</th>
                            <th>Alamat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="loading">12</span></td>
                            <td><span class="loading">Lorem, ipsum dolor.</span></td>
                            <td><span class="loading">Lorem, ipsum.</span></td>
                            <td><span class="loading">Lorem, ipsum.</span></td>
                            <td><span class="loading">Lorem ipsum dolor sit amet, consectetur</span></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><span class="loading">12</span></td>
                            <td><span class="loading">Lorem, ipsum dolor.</span></td>
                            <td><span class="loading">Lorem, ipsum.</span></td>
                            <td><span class="loading">Lorem, ipsum.</span></td>
                            <td><span class="loading">Lorem ipsum dolor sit amet, consectetur</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END RECENT PURCHASES -->
    </div>
</div>

<div class="modal fade" id="modalInput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Input Data Karyawan</h4>
            </div>
            <div class="modal-body">
                <p>Nama</p>
                <input type="text" id="nama" class="form-control">
                <br>
                <p>Jenis Kelamin</p>
                <select class="form-control" id="jenis_kelamin">
                    <option value=""></option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <br>
                <p>Tanggal Lahir</p>
                <input type="text" id="tgl_lahir" class="form-control date-picker" readonly>
                <br>
                <p>Alamat</p>
                <textarea id="alamat" class="form-control" placeholder="" rows="4"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-input-data">Input</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Data Karyawan</h4>
            </div>
            <div class="modal-body">
                <p>ID Karyawan</p>
                <input type="text" id="edit_id_karyawan" class="form-control" disabled>
                <br>
                <p>Nama</p>
                <input type="text" id="edit_nama" class="form-control">
                <br>
                <p>Jenis Kelamin</p>
                <select class="form-control" id="edit_jenis_kelamin">
                    <option value=""></option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <br>
                <p>Tanggal Lahir</p>
                <input type="text" id="edit_tgl_lahir" class="form-control date-picker" readonly>
                <br>
                <p>Alamat</p>
                <textarea id="edit_alamat" class="form-control" placeholder="" rows="4"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-edit-data">simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" style="margin-top: 3rem" id="delete-warning-message"></h4>
                <input type="hidden" id="delete_id_karyawan">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-data">Hapus</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection