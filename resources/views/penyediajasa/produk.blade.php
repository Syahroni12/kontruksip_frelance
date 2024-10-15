@extends('penyediajasa.index')

@section('konten')
    <style>
        .featured__item__pic {
            background-size: cover;
            /* Atur agar gambar menutupi seluruh area */
            background-position: center;
            /* Pusatkan gambar di dalam area */
            width: 100%;
            /* Atur lebar sesuai kebutuhan */
            height: 200px;
            /* Atur tinggi sesuai kebutuhan */
            /* Anda bisa menyesuaikan ukuran ini */
        }
    </style>
    <section class="hero">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 me-auto">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="" method="GET">

                                <input type="text" placeholder="What do yo u need?" name="search" {{ Request()->search }}>
                                <div class="input-group-append">
                                    <button type="submit" class="site-btn">SEARCH</button>
                                </div>
                            </form>
                        </div>

                        <a href="{{ route('home_penyediajasa') }}" class="btn btn-primary ms-3 mb-2">refresh</a>
                    </div>
                    <div class="hero__item set-bg" data-setbg="{{ asset('template_user/img/hero/banner.jpg') }}">
                        {{-- <div class="hero__text">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="#" class="primary-btn">SHOP NOW</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->

    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Produk</h2>
                    </div>

                </div>
            </div>
            <div class="mb-5">

                <a href="{{ route('tambah_produk') }}" class="btn btn-primary">Tambah Produk</a>
            </div>
            <div class="row featured__filter">
                @foreach ($data as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                        <div class="featured__item">
                            <div class="featured__item__pic"
                                style="background-image: url('{{ asset('produk/' . $item->gambar) }}');">

                                <ul class="featured__item__pic__hover">
                                    <li><a href="{{ route('edit_produk', $item->id) }}"><i class="fa fa-pencil"></i></a>
                                    </li>
                                    <li><a href="#" onclick="hapus({{ $item->id }})"><i
                                                class="fa fa-trash"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="featured__item__text">
                                <h6>Nama produk: {{ $item->nama }}</h6>
                                <h7>Kategori produk :{{ $item->kategori->kategori }}</h6>
                                    {{-- @foreach ($item->paket as $index => $paket) --}}
                                    @php
                                        $paket = $item->paket->sortBy(function ($paket) {
                                            return array_search($paket->paket, ['silver', 'gold', 'diamond']);
                                        });
                                    @endphp
                                    @if (count($paket) > 0)
                                        <h5>Harga: {{ $item->paket[0]->harga }} sampai</h5>
                                    @endif

                                    @if (count($paket) > 2)
                                        <h5>Harga: {{ $item->paket[2]->harga }}</h5>
                                    @endif


                                    {{-- @endforeach --}}
                            </div>
                        </div>
                    </div>
                @endforeach







            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $data->links() }}
        </div>
    </section>


    <script>
        function hapus(id) {

            // const itemId = document.getElementById("soal");
            Swal.fire({
                title: "Apakah Kamu Yakin?",
                text: "Apakah Kamu Yakin Ingin Menghapus Data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Ya"
            }).then((result) => {
                if (result.isConfirmed) {
                    // console.log(id);
                    window.location.href = `/hapus_produk/${id}`;
                    // window.location.href = "/selesaikan/".itemId "";
                    // Swal.fire({
                    //     title: "Deleted!",
                    //     text: "Your file has been deleted.",
                    //     icon: "success"
                    // });
                }
            });
        }
    </script>
@endsection
