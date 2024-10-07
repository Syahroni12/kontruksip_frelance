@extends('admin.layout.sidebar')

@section('title', 'Transaksi')

@section('content')
@include('sweetalert::alert')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email Pembeli</th>
                        <th>Email Penjual</th>
                        <th>Nama Produk</th>
                        <th>Tgl Awal</th>
                        <th>Tgl Akhir</th>
                        <th>Lama Hari</th>
                        <th>Deksripsi</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksisAll as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->email_pembeli }}</td>
                            <td>{{ $t->email_penjual }}</td>
                            <td>{{ $t->nama_produk }}</td>
                            <td>{{ $t->tgl_awal }}</td>
                            <td>{{ $t->tgl_akhir }}</td>
                            <td>{{ $t->lama_hari }}</td>
                            <td>{{ $t->deskripsi }}</td>
                            <td>{{ $t->total_harga }}</td>
                            <td>{{ $t->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            {{ $transaksisAll->links() }}

        </div>
    </div>
</div>

@endsection
