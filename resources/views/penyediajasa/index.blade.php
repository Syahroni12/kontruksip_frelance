@include('templating_user.header')

<body>

    <style>
        .profile-img {
            width: 40px;
            /* Atur lebar gambar */
            height: 40px;
            /* Atur tinggi gambar agar sama dengan lebar */
            border-radius: 50%;
            /* Membuat gambar menjadi bundar */
            object-fit: cover;
            /* Memastikan gambar tetap proporsional */
        }

        .dropdown {
            position: relative;
            /* Penting untuk posisi dropdown */
            display: inline-block;
            /* Agar dropdown bersebelahan dengan gambar dan nama */
        }

        .profile-img {
            width: 40px;
            /* Atur lebar gambar */
            height: 40px;
            /* Atur tinggi gambar agar sama dengan lebar */
            border-radius: 50%;
            /* Membuat gambar menjadi bundar */
            object-fit: cover;
            /* Memastikan gambar tetap proporsional */
        }

        .dropdown-content {
            display: none;
            /* Tersembunyi secara default */
            position: absolute;
            /* Menempatkan dropdown di bawah elemen yang di-hover */
            background-color: white;
            /* Warna latar belakang dropdown */
            min-width: 160px;
            /* Lebar minimum dropdown */
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            /* Bayangan untuk dropdown */
            z-index: 1;
            /* Menjaga agar dropdown muncul di atas elemen lain */
        }

        .dropdown:hover .dropdown-content {
            display: block;
            /* Menampilkan dropdown saat di-hover */
        }

        .dropdown-content a {
            color: black;
            /* Warna teks link */
            padding: 12px 16px;
            /* Padding untuk link */
            text-decoration: none;
            /* Menghapus garis bawah */
            display: block;
            /* Membuat link menjadi blok sehingga area klik lebih besar */
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
            /* Mengubah latar belakang saat hover pada link */
        }
    </style>
    <!-- Page Preloder -->
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="img/logo.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            {{-- <ul>
             <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
             <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
         </ul>
         <div class="header__cart__price">item: <span>$150.00</span></div> --}}
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">

            </div>
            <div class="header__top__right__auth">
                <a href="#"><i class="fa fa-user"></i></a>
            </div>
        </div>
        {{-- <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.html">Home</a></li>
                <li><a href="">Produk</a></li> --}}
        {{-- <li><a href="#">Pages</a>
                 <ul class="header__menu__dropdown">
                     <li><a href="./shop-details.html">Shop Details</a></li>
                     <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                     <li><a href="./checkout.html">Check Out</a></li>
                     <li><a href="./blog-details.html">Blog Details</a></li>
                 </ul>
             </li> --}}
        {{-- <li><a href="./blog.html">Blog</a></li> --}}
        {{-- <li><a href="">Profile</a></li>
            </ul>
        </nav> --}}
        <div id="mobile-menu-wrap"></div>

        <div class="humberger__menu__contact">
            <ul>
                {{-- <li><i class="fa fa-envelope"></i>{{ Auth::user()->email}}</li> --}}
                <li></li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i>{{ Auth::user()->email }}</li>
                                {{-- @dd(Auth::user()->pengguna->foto) --}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">


                            <div class="header__top__right__auth">
                                <div class="dropdown">
                                    <img src="{{ asset('foto_profile/' . Auth::user()->pengguna->foto) }}"
                                        class="profile-img" id="profileDropdown">
                                    <span>{{ Auth::user()->pengguna->nama }}</span>
                                    <div class="dropdown-content">
                                        <a href="{{ route('profile') }}" class="text-left">Profil</a>
                                        @if (Auth::user()->akses == 'penyedia_jasa')

                                        <a href="{{ route('bukatutup') }}" class="text-left">Status Toko ({{ Auth::user()->pengguna->status_toko }})</a>
                                        @endif
                                        {{-- <a href="#"  class="text-left">Pengaturan</a> --}}
                                        <a class="text-left" onclick="keluar()">Keluar</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="./index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <nav class="header__menu">
                        <ul>
                            @if (Auth::user()->akses == 'penyedia_jasa')
                            <li class="@if (Route::currentRouteName() == 'dashboard_penyedia') active @endif"><a
                                href="{{ route('dashboard_penyedia') }}" class="text-decoration-none">Home</a></li>
                            @else
                            <li class="@if (Route::currentRouteName() == 'home_customer') active @endif"><a
                                href="{{ route('home_customer') }}">Home</a></li>
                            @endif

                            @if (Auth::user()->akses == 'penyedia_jasa')
                                <li class=" @if (Route::currentRouteName() == 'home_penyediajasa') active @endif"><a
                                        href="{{ route('home_penyediajasa') }}">Produk</a></li>

                            @endif

                            @if (Auth::user()->akses == 'customer')
                                <li class=" @if (Route::currentRouteName() == 'halaman_rating_semua') active @endif"><a
                                        href="{{ route('halaman_rating_semua') }}" class="text-decoration-none">Rating</a></li>
                                <li class=" @if (Route::currentRouteName() == 'belum_konfirmasi') active @endif"><a
                                        href="{{ route('belum_konfirmasi') }}" class="text-decoration-none">Belum konfirmasi</a></li>

                            @endif
                            @if (Auth::user()->akses == 'penyedia_jasa')
                            <li class=" @if (Route::currentRouteName() == 'belum_konfirmasii') active @endif"><a
                                href="{{ route('belum_konfirmasii') }}" class="text-decoration-none">Belum konfirmasi</a></li>
                            @endif

                            {{-- @if (Auth::user()->akses == 'penyedia_jasa')
                            <li class="@if (Route::currentRouteName() == 'dashboard_penyedia') active @endif"><a
                                href="{{ route('dashboard_penyedia') }}">Home</a></li>
                            @else
                            <li class="@if (Route::currentRouteName() == 'home_customer') active @endif"><a
                                href="{{ route('home_customer') }}">Home</a></li>
                            @endif --}}

                            {{-- <li><a href="./shop-grid.html">Shop</a></li> --}}
                            {{-- <li><a href="#">Pages</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="./shop-details.html">Shop Details</a></li>
                                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                                    <li><a href="./checkout.html">Check Out</a></li>
                                    <li><a href="./blog-details.html">Blog Details</a></li>
                                </ul>
                            </li> --}}
                            <li class="@if (Route::currentRouteName() == 'chat_semuacus') active @endif"><a href="{{ route('chat_semuacus') }}">Chat</a></li>

                            <li class="@if (Route::currentRouteName() == 'profile') active @endif">
                                <a href="{{ route('profile') }}" class="text-decoration-none">
                                    Profile
                                </a>
                            </li>



                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">

                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
    @include('sweetalert::alert')
    <!-- Hero Section Begin -->
    @yield('konten')

    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">

        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->

    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->

    <!-- Blog Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="./index.html"><img src="{{ asset('template_user/img/logo.png') }}"
                                    alt=""></a>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script> All rights reserved | This template is made with <i
                                    class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                    target="_blank">Colorlib</a>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            </p>
                        </div>

                    </div>
                </div>
            </div>
    </footer>
    <script>
        function keluar() {
            Swal.fire({
                title: "Apakah Kamu Yakin?",
                text: "Apakah Kamu Yakin Ingin Keluar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Ya"
            }).then((result) => {
                if (result.isConfirmed) {
                    // console.log(id);
                    window.location.href = `/logout`;
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
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    @include('templating_user.footer_js')
