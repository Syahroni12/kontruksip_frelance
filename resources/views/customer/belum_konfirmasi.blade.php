@extends('penyediajasa.index')

@section('konten')
    @foreach ($transaksis as $item)
        <div class="row">
            <!-- Konten Utama -->
            <div class="card">
                <div class="d-flex align-items-center mt-4 ms-5">
                    <!-- Gambar Profil -->
                    <div class="mb-3">
                        <img src="{{ asset('foto_profile/' . $item->Detail_transaksi->owner->foto) }}" class="rounded-circle"
                            style="width: 50px; height: 50px;">
                    </div>


                    <!-- Detail Profil -->
                    <div>
                        <h5 class="mb-0 ms-3">Nama owner:{{ $item->Detail_transaksi->owner->nama }}</h5>
                        <div class="d-flex align-items-center mt-1">
                            {{-- <span class="text-dark me-2">
                                <i class="fas fa-star text-warning"></i> <strong>5.0</strong> (29)
                            </span>
                            <span class="text-muted">6 orders in queue</span> --}}
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">

                    <div class="card mb-4">
                        <div class="row g-0">
                            <div class="col-md-2 mb-2">
                                <img src="{{ asset('produk_pesan/' . $item->Detail_transaksi->gambar) }}" class="img-fluid"
                                    alt="..." style="width: 150px; height: auto;">
                            </div>
                            <div class="col-md-5">
                                <div class="card-body text-start"> <!-- Mengatur teks ke kiri -->
                                    <h5>Produk: {{ $item->Detail_transaksi->produk }}</h5>
                                    <h5>Paket: {{ $item->Detail_transaksi->paket }}</h5>
                                    <p>Kategori: {{ $item->Detail_transaksi->kategori->kategori }}</p>
                                    <p>Harga: {{ number_format($item->Detail_transaksi->harga) }}</p>
                                    <p>Biaya Admin: {{ number_format($item->biaya_admin) }}</p>
                                    <p>Biaya penanganan: {{ number_format($item->Detail_transaksi->harga * 0.10) }}</p>
                                    <p>Total Harga: {{ number_format($item->total_harga) }}</p>
                                </div>
                                <div class="mb-3">
                                    @if ($item->status == 'Belum dikonfirmasi')
                                        <button class="btn btn-warning" disabled>Belum Dikonfirmasi</button>
                                    @elseif ($item->status == 'Dikonfirmasi')
                                        <button type="button" id="pay-button" class="site-btn"
                                            onclick="checkout({{ $item }})">Checkout</button>
                                    @elseif ($item->status == 'Dibatalkan')
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>





                    <!-- Profil -->

                    <!-- Deskripsi -->

                </div>


                <!-- Sidebar di Kanan -->
            </div>
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
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        function checkout(item) {
            // console.log(result);
            snap.pay(item.snap_token, {
                onSuccess: function(result) {

                    $.ajax({
                        url: '/checkout-success', // Endpoint untuk menyimpan data transaksi
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Token CSRF untuk keamanan
                            // ID paket produk
                            // Total harga
                            id_transaksi: item.id, // Metode pembayaran
                            metode: result.payment_type, // Metode pembayaran
                            snap_token: item.snap_token, // Token Midtrans
                            result_data: result // Data hasil dari Midtrans
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Transaction Success!",
                                text: "Pembayaran Berhasil",
                                icon: "success"
                            });
                            window.location.href =
                                '/home_customer'; // Redirect ke halaman terima kasih
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            Swal.fire({
                                title: "Transaction Failed!",
                                text: "Terjadi kesalahan saat menyimpan transaksi.",
                                icon: "error"
                            });
                        }
                    });
                },
                onPending: function(result) {
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                onError: function(result) {
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        }
        // document.getElementById('pay-button').onclick = function() {

        // };
    </script>
@endsection
