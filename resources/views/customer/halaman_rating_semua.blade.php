@extends('penyediajasa.index')

@section('konten')
    <style>
        .star {
            font-size: 30px;
            /* Ukuran ikon bintang */
            cursor: pointer;
            /* Menampilkan kursor pointer saat hover */
            color: gray;
            /* Warna bintang tidak aktif */
        }

        .star.active {
            color: gold;
            /* Warna bintang aktif */
        }
    </style>
    @foreach ($transaksis as $item)
        <div class="row">
            <!-- Konten Utama -->

            <div class="d-flex align-items-center mt-4">
                <!-- Gambar Profil -->
                <div class="me-3">
                    <img src="{{ asset('foto_profile/' . $item->detailTransaksi->owner->foto) }}" class="rounded-circle"
                        alt="Profile Image" style="width: 50px; height: 50px;">
                </div>


                <!-- Detail Profil -->
                <div>
                    <h5 class="mb-0">{{ $item->detailTransaksi->owner->foto }}</h5>
                    <div class="d-flex align-items-center mt-1">
                        <span class="text-dark me-2">
                            <i class="fas fa-star text-warning"></i> <strong>5.0</strong> (29)
                        </span>
                        <span class="text-muted">6 orders in queue</span>
                    </div>
                </div>
            </div>


            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img src="{{ asset('produk_pesan/' . $item->detailTransaksi->gambar) }}" class="img-fluid"
                                alt="..." style="width: 150px; height: auto;">
                        </div>
                        <div class="col-md-5">
                            <div class="card-body text-start"> <!-- Mengatur teks ke kiri -->
                                <h5>Produk: {{ $item->detailTransaksi->produk }}</h5>
                                <h5>Paket: {{ $item->detailTransaksi->paket }}</h5>
                                <p>Kategori: {{ $item->detailTransaksi->kategori->kategori }}</p>
                                <p>Harga: {{ number_format($item->detailTransaksi->harga) }}</p>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex flex-column">
                            <!-- Kolom untuk input di sebelah kanan -->
                            <form action="{{ route('ratingact') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mt-4 w-100"> <!-- Memberikan margin atas pada input -->
                                    <label for="ulasan" class="form-label">ulasan</label>
                                    <textarea name="ulasan" id="" cols="30" rows="3" class="form-control"></textarea>
                                    <!-- Input tersembunyi untuk rating -->
                                    {{-- <input type="text" class="form-control" placeholder="Masukkan rating..." readonly> --}}
                                </div>

                                <input type="hidden" name="rating" id="rating" value="0">
                                <div class="mt-4 w-100"> <!-- Memberikan margin atas pada input -->
                                    <label for="upload_gambar" class="form-label">Upload gambar (opsional)</label>
                                    <input type="file" class="form-control" name="gambar" id="upload_gambar">
                                </div>
                                <div class="mt-3"> <!-- Ruang antara input dan bintang -->
                                    <label for="star-rating" class="form-label">Bintang Rating</label>
                                    <div id="star-rating" class="d-flex">
                                        <!-- Ikon bintang -->
                                        <span class="star" data-value="1">&#9733;</span>
                                        <span class="star" data-value="2">&#9733;</span>
                                        <span class="star" data-value="3">&#9733;</span>
                                        <span class="star" data-value="4">&#9733;</span>
                                        <span class="star" data-value="5">&#9733;</span>
                                    </div>


                                </div>
                                <input type="hidden" name="id_transaksi" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-primary mt-1 mb-2">simpan</button>
                            </form>
                        </div>
                    </div>
                </div>





                <!-- Profil -->

                <!-- Deskripsi -->

            </div>


            <!-- Sidebar di Kanan -->

        </div>
    @endforeach


    <script>
        const stars = document.querySelectorAll('.star');
        let rating = 0;

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const starValue = star.getAttribute('data-value');

                // Toggle logic: jika bintang yang diklik sudah aktif
                if (star.classList.contains('active')) {
                    // Jika bintang yang aktif diklik lagi, non-aktifkan bintang tersebut
                    star.classList.remove('active');
                    rating = 0; // Reset rating ke 0 jika tidak ada bintang yang aktif
                    stars.forEach(s => s.classList.remove('active')); // Non-aktifkan semua bintang
                } else {
                    // Aktifkan bintang yang diklik dan semua bintang sebelumnya
                    rating = starValue; // Update rating sesuai bintang yang dipilih
                    stars.forEach(s => s.classList.remove('active')); // Non-aktifkan semua bintang
                    for (let i = 0; i < starValue; i++) {
                        stars[i].classList.add('active'); // Aktifkan bintang yang dipilih dan sebelumnya
                    }
                }

                // Update input dengan nilai rating
                document.getElementById('rating').value =
                rating; // Mengisi input rating dengan nilai bintang
                document.querySelector('input[type="text"]').value =
                rating; // Mengisi input teks dengan nilai bintang
            });
        });
    </script>
@endsection
