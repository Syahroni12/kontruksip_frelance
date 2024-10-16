@include('templating_admin.header')


<body>


    @include('sweetalert::alert')

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="../assets/images/logos/logo-light.svg" alt="">
                                </a>
                                <p class="text-center">Registrasi</p>
                                <form method="POST" action="{{ route('daftar_customer') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            aria-describedby="textHelp" value="{{ old('nama') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="notelp" class="form-label">No telfon</label>
                                        <input type="number" class="form-control" id="notelp" name="notelp"
                                            aria-describedby="textHelp" value="{{ old('notelp') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">gender</label>
                                        <select id="gender" class="form-select" name="gender">
                                            <option>Pilih Gender</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                          </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgllahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgllahir" name="tgllahir"
                                            aria-describedby="textHelp" value="{{ old('tgllahir') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Foto" class="form-label">Foto profile</label>
                                        <input type="file" class="form-control" id="Foto" name="foto"
                                            aria-describedby="textHelp" value="{{ old('foto') }}" accept=".jpg, .jpeg, .png">
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat </label>
                                        {{-- <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                     --}}
                                        <textarea name="alamat" id="alamat" cols="30" rows="4" class="form-control" placeholder="alamat">{{ old('alamat') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email </label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" value="{{ old('email') }}" name="email">
                                    </div>
                                    <div class="mb-4 position-relative">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                        <i class="fa-solid fa-eye position-absolute" id="togglePassword"
                                            style="right: 15px; top: 45px; cursor: pointer;"></i>
                                    </div>
                                    <div class="mb-4 position-relative">
                                        <label for="password2" class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control" id="password2" name="password2">
                                        <i class="fa-solid fa-eye position-absolute" id="togglePassword2"
                                            style="right: 15px; top: 45px; cursor: pointer;"></i>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">Daftar</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                                        <a class="text-primary fw-bold ms-2"
                                            href="{{ route('login') }}">Sign In</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        const togglePassword2 = document.querySelector('#togglePassword2');
        const password2 = document.querySelector('#password2');

        togglePassword2.addEventListener('click', function() {
            const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
            password2.setAttribute('type', type);

            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Confirm password validation
        // document.querySelector('#registerBtn').addEventListener('click', function(event) {
        //     event.preventDefault(); // Mencegah pengiriman form secara langsung

        //     if (password.value !== password2.value) {
        //         alert('Password dan konfirmasi password tidak cocok!');
        //     } else {
        //         alert('Pendaftaran berhasil!');
        //         // Arahkan ke halaman berikutnya atau lakukan proses lain
        //     }
        // });
    </script>


    @include('templating_admin.footer_js')
