@extends('penyediajasa.index')

@section('konten')
    @foreach ($transaksis as $item)
        <div class="row">
            <!-- Konten Utama -->




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
                                    {{-- <p>Harga: {{ number_format($item->Detail_transaksi->harga) }}</p> --}}
                                    <p>Biaya Admin: {{ number_format($item->biaya_admin) }}</p>
                                    <p>Biaya penanganan: {{ number_format($item->Detail_transaksi->harga * 0.10) }}</p>
                                    <p>Total Harga: {{ number_format($item->total_harga) }}</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="detail({{ $item->id }})">
                                        Konfirmasi
                                      </button>
                                </div>
                                <div class="mb-3">
                                    {{ $transaksis->links() }}
                                </div>
                            </div>

                        </div>
                    </div>





                    <!-- Profil -->

                    <!-- Deskripsi -->

                </div>


                <!-- Sidebar di Kanan -->

        </div>
    @endforeach



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pesananan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('konfirmasi') }}" method="post">
                @csrf
                <input type="hidden" name="id" id="id_transaksi">

                <div class="form-group">

                  <label for="status">Status</label>
                  <select class="form-control" id="status" name="status">
                    <option value="Dikonfirmasi">Setuju</option>
                    <option value="Dibatalkan">tolak</option>
                  </select>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>

            </div>
            </form>
          </div>
        </div>
      </div>


      <script>

        function detail(id) {
            document.getElementById("id_transaksi").value = id;
        }
      </script>


@endsection
