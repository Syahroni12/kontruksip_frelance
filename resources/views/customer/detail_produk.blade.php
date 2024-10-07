@extends('penyediajasa.index')

@section('konten')
    <div class="row">
        <!-- Konten Utama -->
        <div class="col-lg-8">
            <h1>Produk</h1>
            <div class="card mb-4">
                <img src="{{ asset('produk/' . $produk->gambar) }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">
                       Kategori : {{ $produk->kategori->kategori}}
                    </p>
                </div>
            </div>

            <!-- Profil -->
            <div class="d-flex align-items-center mt-4">
                <!-- Gambar Profil -->
                <div class="me-3">
                    <img src="{{$pengguna->foto}}" class="rounded-circle" alt="Profile Image">
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
                    {{$pengguna->}}
                </p>
            </div>

            <!-- Keahlian -->
            <div class="card mb-10">
                <div class="card-body">
                    <h5>Keahlian</h5>
                    <ul>
                        <li>dxfcgvhbjnkl;kjhgcfbnlxmkxshxsidhsuhdishiduhsi</li>
                        <li>dsjdhsdhusdusdushu</li>
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
                            <h5>silver Package</h5>
                            <p>silver description</p>
                            <p>$100</p>
                            <button class="btn btn-primary w-100">Continue</button>
                        </div>

                        <!-- Tab gold -->
                        <div class="tab-pane fade" id="gold" role="tabpanel" aria-labelledby="gold-tab">
                            <h5>gold Package</h5>
                            <p>gold description</p>
                            <p>$200</p>
                            <button class="btn btn-primary w-100">Continue</button>
                        </div>

                        <!-- Tab diamond -->
                        <div class="tab-pane fade" id="diamond" role="tabpanel" aria-labelledby="diamond-tab">
                            <h5>diamond Package</h5>
                            <p>Resume, Cover Letter, and LinkedIn Profile</p>
                            <p>$595</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check"></i> 14-day delivery</li>
                                <li><i class="fas fa-check"></i> 2 Revisions</li>
                                <li><i class="fas fa-check"></i> Source file</li>
                                <li><i class="fas fa-check"></i> Custom design</li>
                            </ul>
                            <button class="btn btn-dark w-100">Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Me Section -->
            <div class="card mt-3">
                <div class="card-body">
                    <button class="btn btn-outline-primary w-100 mb-3">Contact me</button>
                    <p><i class="fas fa-comments"></i> Offers paid consultations</p>
                    <p><i class="fas fa-clock"></i> Offers hourly rates</p>
                </div>
            </div>
        </div>
    </div>
@endsection
