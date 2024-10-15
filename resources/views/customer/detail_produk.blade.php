@extends('penyediajasa.index')

@section('konten')
    <div class="row">
        <!-- Konten Utama -->
        <div class="col-lg-8">
            <h1>Produk : {{ $produk->nama }}</h1>
            <div class="card mb-4">
                <img src="{{ asset('produk/' . $produk->gambar) }}" class="card-img-top" alt="..." style="width: 150px; height: auto;">
                <div class="card-body">
                    <p class="card-text">
                       Kategori : {{ $produk->kategori->kategori }}
                    </p>
                </div>
            </div>


            <!-- Profil -->
            <div class="d-flex align-items-center mt-4">
                <!-- Gambar Profil -->
                <div class="me-3">
                    <img src="{{ asset('foto_profile/' . $pengguna->foto) }}" class="rounded-circle" alt="Profile Image" style="width: 50px; height: 50px;">
                </div>


                <!-- Detail Profil -->
                <div>
                    <h5 class="mb-0">{{$pengguna->nama}}</h5>
                    <div class="d-flex align-items-center mt-1">
                        <span class="text-dark me-2">
                            <i class="fas fa-star text-warning"></i> <strong>5.0</strong> (29)
                        </span>
                        <span class="text-muted">6 orders in queue</span>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mt-5">
                <h4>Deskripsi Penyedia Jasa</h4>
                <p>
                    {{$pengguna->deskripsi}}
                </p>
            </div>

            <!-- Keahlian -->
            <div class="card mb-10">
                <div class="card-body">
                    <h5>Keahlian</h5>
                    <ul>
                        @foreach ($keahlian as $item)

                        <li>{{ $item->keahlian }}</li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar di Kanan -->
        <div class="col-lg-4">
            <!-- Tab Packages -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="silver-tab" data-bs-toggle="tab" href="#silver" role="tab" aria-controls="basic" aria-selected="true">silver</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="gold-tab" data-bs-toggle="tab" href="#gold" role="tab" aria-controls="gold" aria-selected="false">gold</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="premium-tab" data-bs-toggle="tab" href="#diamond" role="tab" aria-controls="diamond" aria-selected="false">diamond</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <!-- Tab silver -->
                        <div class="tab-pane fade show active" id="silver" role="tabpanel" aria-labelledby="silver-tab">
                            <h5>Paket silver</h5>
                            <p> Deskripsi: {{ $silver->deskripsi }}</p>

                            <p> Lama Hari :  {{ $silver->lama_hari }}</p>
                            <p> Harga :{{ number_format($silver->harga) }}</p>
                            <p> Biaya Admin :{{ number_format($biaya_admin) }}</p>
                            <p> Biaya penanganan :{{ number_format($silver->harga * 0.10) }}</p>
                            <p> Total Harga :{{ number_format($silver->harga + $biaya_admin + $silver->harga * 0.10) }}</p>

                            <a href="{{ route('checkout', $silver->id) }}" class="btn btn-primary w-100">beli</a>
                        </div>

                        <!-- Tab gold -->
                        <div class="tab-pane fade" id="gold" role="tabpanel" aria-labelledby="gold-tab">
                            <h5>gold Package</h5>
                            <p> Deskripsi: {{ $gold->deskripsi }}</p>

                            <p> Lama Hari :  {{ $gold->lama_hari }}</p>

                            <p>Harga : {{ number_format($gold->harga) }}</p>
                            <p> Biaya Admin :{{ number_format($biaya_admin) }}</p>
                            <p> Biaya penanganan :{{ number_format($gold->harga * 0.10) }}</p>
                            <p> Total Harga :{{ number_format($gold->harga + $biaya_admin + $gold->harga * 0.10) }}</p>
                            <a href="{{ route('checkout', $gold->id) }}" class="btn btn-primary w-100">beli</a>
                        </div>

                        <!-- Tab diamond -->
                        <div class="tab-pane fade" id="diamond" role="tabpanel" aria-labelledby="diamond-tab">
                            <h5>diamond Package</h5>
                            <p> Deskripsi: {{ $diamond->deskripsi }}</p>

                            <p> Lama Hari :  {{ $diamond->lama_hari }}</p>
                            <p>Harga :{{ number_format($diamond->harga) }}</p>
                            <p> Biaya Admin :{{ number_format($biaya_admin) }}</p>
                            <p> Biaya penanganan :{{ number_format($diamond->harga * 0.10) }}</p>
                            <p> Total Harga :{{ number_format($diamond->harga + $biaya_admin + $diamond->harga * 0.10) }}</p>
                            <a href="{{ route('checkout', $diamond->id) }}" class="btn btn-primary w-100">beli</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Me Section -->

        </div>
    </div>
@endsection
