@extends('penyediajasa.index')

@section('konten')
    <div class="row">
        <!-- Konten Utama -->

        <div class="d-flex align-items-center mt-4">
            <!-- Gambar Profil -->
            <div class="me-3">
                <img src="{{ asset('foto_profile/' . $pengguna->foto) }}" class="rounded-circle" alt="Profile Image"
                    style="width: 50px; height: 50px;">
            </div>


            <!-- Detail Profil -->
            <div>
                <h5 class="mb-0">{{ $pengguna->nama }}</h5>
                <div class="d-flex align-items-center mt-1">
                    <span class="text-dark me-2">
                        <i class="fas fa-star text-warning"></i> <strong>5.0</strong> (29)
                    </span>
                    <span class="text-muted">6 orders in queue</span>
                </div>
            </div>
        </div>


        <div class="col-lg-12">
            <h1>Produk : {{ $produk->nama }}</h1>
            <div class="card mb-4">
                <img src="{{ asset('produk/' . $produk->gambar) }}" class="card-img-top" alt="..."
                    style="width: 150px; height: auto;">
                <div class="card-body">
                    <p class="card-text">
                        Kategori : {{ $produk->kategori->kategori }}
                    </p>
                </div>
            </div>


            <!-- Profil -->


            <!-- Deskripsi -->

        </div>

        <!-- Sidebar di Kanan -->

    </div>
@endsection
