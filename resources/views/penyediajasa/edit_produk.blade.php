@extends('penyediajasa.index')

@section('konten')
<section class="checkout spad">
    <div class="container">
        <div class="row">

        </div>
        <div class="checkout__form">
            <h4>edit_produk</h4>
            <form action="{{ route('update_produk', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- <input type="hidden" name="id_produk" value="{{ $data->id }}"> --}}
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="checkout__input">
                            <p>Nama Produk<span>*</span></p>
                            <input type="text" name="nama" value="{{ $data->nama }}">
                        </div>
                        <div class="checkout__input">
                            <p>Kategori Produk <span>*</span></p>
                          
                            <select id="id_kategori" name="id_kategori" class="checkout__input custom-select">
                                @foreach ($kategori as $kategorijasa)
                                    <option value="{{ $kategorijasa->id }}" {{ $kategorijasa->id == $data->id_kategori ? 'selected' : '' }}>{{ $kategorijasa->kategori }}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        {{-- <br> --}}
                        <div class="checkout__input">
                            <p>Gambar Produk<span>*</span></p>
                            <input type="file" id="gambarProduk" name="gambar" value="{{ old('gambar') }}" accept="image/*">
                        </div>
                        @foreach ($paket as $item)
                        
                     <input type="hidden" name="id_paket[]" value="{{ $item->id }}">
                        <div class="checkout__input">
                            <p>Paket {{ $loop->iteration }}<span>*</span></p>
                            <input type="text" readonly name="paket[]" value="{{ $item->paket }}">
                            <p>Harga<span>*</span></p>
                            <input type="text" id="harga{{ $loop->iteration }}" name="harga[]" required min="1" value="{{ $item->harga }}">
                            <p>Deskripsi<span>*</span></p>
                            <textarea class="form-control" placeholder="" id="floatingTextarea1" rows="4" name="deskripsi[]">{{ $item->deskripsi }}</textarea>
                            <p>Durasi<span>*</span></p>
                            <input type="number" name="lama_hari[]" value="{{ $item->lama_hari }}" required><span>Hari</span>
                            <hr>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <img id="imagePreview" src="{{ asset('produk/'.$data->gambar) }}" alt="Pratinjau Gambar" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="site-btn">simpan</button>
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
