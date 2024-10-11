@extends('penyediajasa.index')

@section('konten')
    <section class="checkout spad">
        <div class="container">
            <div class="row">

            </div>
            <div class="checkout__form">
                <h4>Profile</h4>
                <form action="{{ route('profile_customeract') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout__input">
                                <p>Nama <span>*</span></p>
                                <input type="text" name="nama" value="{{ $data->nama }}">
                            </div>

                            <div class="checkout__input">
                                <p>No. Telepon <span>*</span></p>
                                <input type="number" name="notelp" value="{{ $data->notelp }}" required>
                            </div>
                            <div class="checkout__input">
                                <p>Pendidikan Terakhir <span>*</span></p>
                                <input type="text" name="pendidikan_terakhir" value="{{ $data->pendidikan_terakhir }}"
                                    required>
                            </div>

                            <!-- Gender -->
                            <div class="checkout__input">
                                <p>Jenis Kelamin <span>*</span></p>
                                <select name="gender" class="checkout__input custom-select" required>
                                    <option value="Laki-laki" {{ $data->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="Perempuan" {{ $data->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>

                            <!-- Alamat -->
                            <div class="checkout__input">
                                <p>Alamat <span>*</span></p>
                                <textarea class="form-control" placeholder="" id="floatingTextarea1" rows="4" name="alamat">{{ $data->alamat }}</textarea>
                            </div>

                            <div class="checkout__input">
                                <p>No.Rekening <span>*</span></p>
                                <input type="number" name="no_rekening" value="{{ $data->no_rekening }}" required>
                            </div>
                            <div class="checkout__input">
                                <p>Jenis Rekening <span>*</span></p>
                                <select name="jenis_rekening" class="checkout__input custom-select" required>
                                    <option value="Bank Mandiri">Bank Mandiri</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                    <option value="BSI">BSI</option>
                                    <option value="GoPay">GoPay</option>
                                    <option value="OVO">OVO</option>
                                    <option value="DANA">DANA</option>
                                    <option value="ShopeePay">ShopeePay</option>
                                    <option value="LinkAja">LinkAja</option>
                                </select>
                            </div>


                            <div class="checkout__input">
                                <p>Tanggal Lahir <span>*</span></p>
                                <input type="date" name="tgllahir" value="{{ $data->tgllahir }}" readonly>
                            </div>


                            <div class="checkout__input">
                                <p>Password <span>*</span></p>
                                <input type="text" name="password" value="{{ old('password') }}">
                            </div>



                            {{-- <br> --}}
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($sertifikat as $item)
                                <div class="checkout__input">
                                    <p>Sertifikat {{ $no++ }}<span>*</span></p>
                                    <a href="{{ asset('sertifikat/' . $item->sertif) }}" class="btn btn-primary"
                                        target="_blank">Lihat</a>
                                    <button class="btn btn-danger" onclick="deleteSertifikat({{ $item->id }})"
                                        type="button">Hapus</button>
                                </div>
                            @endforeach
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Tambah Sertifikat
                            </button>

                            <div class="checkout__input">
                                <p>CV<span>*</span></p>
                                <input type="file" name="CV" value="{{ $data->CV }}" accept="pdf">
                            </div>

                            <div class="checkout__input">
                                <p>Foto Profile<span>*</span></p>
                                <input type="file" id="gambarProduk" name="foto" value="{{ old('gambar') }}"
                                    accept="image/*">
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <img id="imagePreview" src="{{ asset('foto_profile/' . $data->foto) }}"
                                        alt="Pratinjau Gambar" style="max-width: 100%; height: auto;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">simpan</button>
                </form>
            </div>
        </div>





        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Sertifikat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tambah_sertifikat') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="sertifikat">Sertifikat</label>
                                <input type="file" name="sertifikat" id="sertifikat" class="form-control" accept=".pdf">
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
    </section>

    <script>
        function deleteSertifikat(id) {
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
                    window.location.href = `/hapus_sertifikat/${id}`;
                    // window.location.href = "/selesaikan/".itemId "";
                    // Swal.fire({
                    //     title: "Deleted!",
                    //     text: "Your file has been deleted.",
                    //     icon: "success"
                    // });
                }
            });
        }



        const gambarProdukInput = document.getElementById('gambarProduk');
        const imagePreview = document.getElementById('imagePreview');

        gambarProdukInput.addEventListener('change', function() {
            const file = gambarProdukInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
