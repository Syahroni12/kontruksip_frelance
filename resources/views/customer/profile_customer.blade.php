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

                        <!-- Gender -->
                        <div class="checkout__input">
                            <p>Jenis Kelamin <span>*</span></p>
                            <select name="gender" class="checkout__input custom-select" required>
                                <option value="Laki-laki" {{ $data->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $data->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <!-- Alamat -->
                        <div class="checkout__input">
                            <p>Alamat <span>*</span></p>
                            <textarea class="form-control" placeholder="" id="floatingTextarea1" rows="4" name="alamat">{{ $data->alamat }}</textarea>
                        </div>
                        <div class="checkout__input">
                            <p>Tanggal Lahir <span>*</span></p>
                            <input type="date" name="tgllahir" value="{{ $data->tgllahir }}"  readonly>
                        </div>
                        <div class="checkout__input">
                            <p>Password <span>*</span></p>
                            <input type="text" name="password" value="{{ old('password') }}">
                        </div>
                        {{-- <br> --}}
                        <div class="checkout__input">
                            <p>Foto Profile<span>*</span></p>
                            <input type="file" id="gambarProduk" name="foto" value="{{ old('gambar') }}" accept="image/*">
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <img id="imagePreview" src="{{ asset('foto_profile/'.$data->foto) }}" alt="Pratinjau Gambar" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="site-btn">tambah</button>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const hargaInputs = ['harga1', 'harga2', 'harga3'];

    hargaInputs.forEach(function (id) {
        const inputElement = document.getElementById(id);
        inputElement.addEventListener('input', function () {
            let value = inputElement.value.replace(/\D/g, ''); // Remove all non-numeric characters
            if (!isNaN(value)) {
                inputElement.value = formatRibuan(value);
            }
        });
    });

    function formatRibuan(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
});



     const gambarProdukInput = document.getElementById('gambarProduk');
        const imagePreview = document.getElementById('imagePreview');

        gambarProdukInput.addEventListener('change', function () {
            const file = gambarProdukInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

</script>
@endsection
