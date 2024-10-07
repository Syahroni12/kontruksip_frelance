@extends('penyediajasa.index')

@section('konten')
<section class="checkout spad">
    <div class="container">
        <div class="row">

        </div>
        <div class="checkout__form">
            <h4>Tambah Produk</h4>
            <form action="{{ route('tambah_produkact') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="checkout__input">
                            <p>Nama Produk<span>*</span></p>
                            <input type="text" name="nama" value="{{ old('nama') }}">
                        </div>
                        <div class="checkout__input">
                            <p>Kategori Produk <span>*</span></p>
                          
                            <select id="id_kategori" name="id_kategori" class="checkout__input custom-select">
                                @foreach ($kategori as $kategorijasa)
                                    <option value="{{ $kategorijasa->id }}">{{ $kategorijasa->kategori }}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        {{-- <br> --}}
                        <div class="checkout__input">
                            <p>Gambar Produk<span>*</span></p>
                            <input type="file" id="gambarProduk" name="gambar" value="{{ old('gambar') }}" accept="image/*">
                        </div>
                        <div class="checkout__input">
                            <p>Paket 1<span>*</span></p>
                            <input type="text" readonly name="paket[]" value="silver">
                            <p>Harga<span>*</span></p>
                            <input type="text" id="harga1" name="harga[]" required min="1">
                            <p>Deskripsi<span>*</span></p>
                            <textarea class="form-control" placeholder="" id="floatingTextarea1" rows="4" name="deskripsi[]"></textarea>
                            <p>Durasi<span>*</span></p>
                            <input type="number" name="lama_hari[]" required><span>Hari</span>
                            <hr>
                        </div>
                        <div class="checkout__input">
                            <p>Paket 2<span>*</span></p>
                            <input type="text" readonly name="paket[]" value="gold">
                            <p>Harga<span>*</span></p>
                            <input type="text" id="harga2" name="harga[]" required min="1" >
                            <p>Deskripsi<span>*</span></p>
                            <textarea class="form-control" placeholder="" id="floatingTextarea2" rows="4" name="deskripsi[]"></textarea>
                            <p>Durasi<span>*</span></p>
                            <input type="number" name="lama_hari[]" required><span>Hari</span>
                            <hr>
                        </div>
                        <div class="checkout__input">
                            <p>Paket 3<span>*</span></p>
                            <input type="text" readonly name="paket[]" value="diamond">
                            <p>Harga<span>*</span></p>
                            <input type="text" id="harga3" name="harga[]" required min="1">
                            <p>Deskripsi<span>*</span></p>
                            <textarea class="form-control" placeholder="" id="floatingTextarea3" rows="4" name="deskripsi[]"></textarea>
                            <p>Durasi<span>*</span></p>
                            <input type="number" name="lama_hari[]" required><span>Hari</span>
                            <hr>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <img id="imagePreview" src="" alt="Pratinjau Gambar" style="max-width: 100%; height: auto;">
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
