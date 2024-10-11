@extends('penyediajasa.index')

@section('konten')
    <section class="checkout spad">
        <div class="container">
            <div class="row">

            </div>
            <div class="checkout__form">
                <h4>Check Out</h4>
                <form action="/" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout__input">
                                <p>Biaya Penanganan<span>*</span></p>
                                <input type="text" name="nama" value="{{ $sepuluh_persen }}" readonly>
                            </div>
                            <div class="checkout__input">
                                <p>Biaya Admin<span>*</span></p>
                                <input type="text" name="nama" value="{{ number_format($biaya_admin) }}" readonly>
                            </div>
                            <div class="checkout__input">
                                <p>Total Harga<span>*</span></p>
                                <input type="text" name="nama" value="{{ number_format($total_harga) }}" readonly>
                            </div>
                            <div class="checkout__input">
                                <p>Dari tanggal<span>*</span></p>
                                <input type="date" name="tgl_awal" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                            <div class="checkout__input">
                                <p>Sampai Tanggal<span>*</span></p>
                                <input type="date" name="tgl_akhir"
                                    value="{{ date('Y-m-d', strtotime('+' . $paket_produk->lama_hari . ' days')) }}"
                                    readonly>
                            </div>


                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card" style="width: 18rem;">
                                        <img src="{{ asset('produk/' . $paket_produk->produk->gambar) }}"
                                            class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <p class="card-text"> Nama : Produk : {{ $paket_produk->produk->nama }}</p>
                                            <p class="card-text"> Harga : Rp. {{ number_format($paket_produk->harga) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="pay-button" class="site-btn">tambah</button>
                </form>
            </div>
        </div>
    </section>
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snap_token }}', {
                onSuccess: function(result) {
                    $.ajax({
                        url: '/checkout-success', // Endpoint untuk menyimpan data transaksi
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Token CSRF untuk keamanan
                            id_pengguna: '{{ auth()->user()->pengguna->id }}', // ID pengguna
                            id_paketproduk: '{{ $paket_produk->id }}', // ID paket produk
                            biaya_admin: '{{ $biaya_admin }}', // ID paket produk
                            harga: '{{ $paket_produk->harga }}', // ID paket produk
                            tgl_awal: '{{ date('Y-m-d') }}', // Tanggal awal
                            tgl_akhir: '{{ date('Y-m-d', strtotime('+' . $paket_produk->lama_hari . ' days')) }}', // Tanggal akhir
                            produk: '{{ $paket_produk->produk->nama }}', // Nama produk
                            paket: '{{ $paket_produk->paket }}', // Nama paket
                            lama_hari: '{{ $paket_produk->lama_hari }}', // Lama hari paket
                            deskripsi: '{{ $paket_produk->deskripsi }}', // Deskripsi paket
                            total_harga: '{{ $total_harga }}', // Total harga
                            metode: result.payment_type, // Metode pembayaran
                            snap_token: '{{ $snap_token }}', // Token Midtrans
                            result_data: result // Data hasil dari Midtrans
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Transaction Success!",
                                text: "Pembayaran Berhasil",
                                icon: "success"
                            });
                            window.location.href = '/home_customer'; // Redirect ke halaman terima kasih
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
        };
    </script>


    <script></script>
@endsection
