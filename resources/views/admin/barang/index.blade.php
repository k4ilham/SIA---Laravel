@extends('layouts.admin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Barang</h1>
</div>

<hr>

<div class="card-header py-3" align="right">
    <button type="button" class="d-none d-sm-inline-block btn btn-sm btn￾primary shadow-sm" data-toggle="modal" data-target="#exampleModalScrollable">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah
    </button>
</div>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr align="center">
                        <th width="5%">No</th>
                        <th width="25%">Kode</th>
                        <th width="20%">Nama</th>
                        <th width="15%">Harga</th>
                        <th width="15%">Stok</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($barang as $row)
                        <tr>
                            <td align="center">{{ $no }}</td>
                            <td>{{ $row->kd_brg }}</td>
                            <td>{{ $row->nm_brg }}</td>
                            <td>{{ number_format($row->harga,2) }}</td>
                            <td>{{ number_format($row->stok,0) }}</td>

                            <td align="center">
                                <a href="{{route('barang.edit' ,[$row->kd_brg])}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                    <i class="fas fa-edit fa-sm text-white-50"></i>Edit Akses
                                </a>
                                <a href="/barang/hapus/{{ $row->kd_brg }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                    <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php $no++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">

    <div class="modal-dialog modal-dialog-scrollable" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>


        <form action="#" method="POST">
        @csrf

            <div class="modal-body">

                <div class="form-group">
                    <label for="exampleFormControlInput1">Kode Barang</label>
                    <input type="text" name="addkdbrg" id="addkdbrg" class="form-control" maxlegth="5" id="exampleFormControlInput1" >
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Nama Barang</label>
                    <input type="text" name="addnmbrg" id="addnmbrg" class="form-control" id="exampleFormControlInput1" >
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Harga Barang</label>
                    <input type="number" name="addharga" id="addharga" class="form-control" id="exampleFormControlInput1" >
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Stok Barang</label>
                    <input type="number" name="addstok" id="addstok" class="form-control" id="exampleFormControlInput1" >
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <input type="submit" class="btn btn-primary btn-send" value="Simpan">
            </div>


        </form>

        </div>
    </div>
</div>
@endsection
