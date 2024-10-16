@extends('penyediajasa.index')

@section('konten')
    <link rel="stylesheet" href="{{ asset('template_user/css/custom-css/chat.css') }}" type="text/css">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-12 wrapper-left">
                <div class="py-3 px-2">
                    <h2 class="text-center">Halaman Chat</h2>
                    @foreach ($transaksis as $item)
                        <div
                            class="d-flex align-items-center wrapper p-1 border-bottom  {{ $item->id == $id ? 'active' : '' }}">
                            <img src="{{ asset('foto_profile/' . $item->Detail_transaksi->owner->foto) }}" alt=""
                                class="rounded-circle me-2" width="50" height="50" loading="lazy">
                            <div class="w-100 p-2">
                                <p class="text-dark fs-5 text-capitalize mb-0">{{ $item->Detail_transaksi->owner->nama }}
                                    ({{ $item->Detail_transaksi->produk }} :{{ $item->Detail_transaksi->paket }})
                                </p>
                                {{-- <i class="bi bi-check2"></i> checklist 1 --}}
                                {{-- <i class="bi bi-check2-all text-primary"></i> checklist 2 --}}
                                @if ($item->chat->first())
                                    @if ($item->chat->first()->customer_id == null)
                                        {{-- @if ($item->chat->first()->is_read == 0)
                                            <i class="bi bi-check2"></i> <span class="text-secondary">item bang</span>
                                        @else
                                            <i class="bi bi-check2-all text-primary"></i> <span class="text-secondary">item
                                                bang</span>
                                        @endif --}}
                                    @else
                                        @if ($item->chat->first()->is_read == 0)
                                            @if ($item->chat->first()->is_send == 0)
                                                <i class="bi bi-check2"></i> <span
                                                    class="text-secondary">{{ $item->chat->first()->message }}</span>
                                            @else
                                                <i
                                                    class="bi bi-check2-all text-primary"></i>{{ $item->chat->first()->message }}</span>
                                            @endif
                                        @else
                                            <i class="bi bi-check2-all text-primary"></i> <span class="text-secondary">item
                                                bang</span>
                                        @endif
                                    @endif
                                @endif
                                {{-- <span class="text-secondary">transaksi bang</span> --}}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="col-md-8 col-sm-12 wrapper-right ">
                <div class="wrap-right d-flex align-items-center ps-3 py-2">
                    <button class="btn btn-link btn-back d-none" onclick="goBack()"><i
                            class="bi bi-arrow-left text-dark"></i></button>
                    <img src="{{ asset('foto_profile/' . $tran->Detail_transaksi->owner->foto) }}" alt=""
                        class="rounded-circle me-2" width="50" height="50">
                    <div class="w-100 p-2">
                        <p class="text-capitalize fs-5 text-dark mb-0">{{ $tran->Detail_transaksi->owner->nama }}</p>
                        @if ($tran->Detail_transaksi->owner->user->status_login == true)
                            <span class="text-secondary">Online</span>
                        @endif
                    </div>
                </div>

                <div class="chat px-5">
                    @foreach ($chat as $item)
                        @if ($item->customer_id == auth()->user()->pengguna->id)
                            <div class="message-right">
                                <p class="bubble-right">{{ $item->message }}</p>
                                <br>
                                @if ($item->is_send == 0)
                                    {{-- <div class="message-right"> --}}

                                    <i class="bi bi-check2"></i>
                                    {{-- </div> --}}
                                @else
                                @endif
                            </div>
                            @if ($item->file != null)
                                <div class="message-right">

                                    <img src="{{ asset('foto_profile/' . $item->transaksi->Detail_transaksi->owner->foto) }}"
                                        alt=""></p>

                                </div>
                                @if ($item->is_send == 0)
                                    {{-- <div class="message-right"> --}}

                                    <i class="bi bi-check2"></i>
                                    {{-- </div> --}}
                                @else
                                @endif
                            @endif
                        @else
                            <div class="message-left">
                                <p class="bubble-left">{{ $item->message }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                @if ($tran->status == 'Sedang konsultasi')
                    <form action="{{ route('chat_actcus') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="wrap-bottom w-100 py-1 d-flex justify-content-between align-items-center px-3">
                            <input type="hidden" name="id_transaksi" value="{{ $tran->id }}">
                            <input type="file" name="file" id="file" class="form-control d-none">
                            <label for="file" class="btn">
                                <i class="bi bi-plus fs-4"></i>
                            </label>
                            <input type="text" class="form-control" name="pesan" placeholder="Ketik Pesan">
                            <button class="btn"><i class="bi bi-send-fill fs-5"></i></button>
                        </div>

                        <div id="filePreview" class="mt-2"></div>
                    </form>
                @endif

            </div>
        </div>
    </div>
    <script>
        function previewFile() {
            const fileInput = document.getElementById('file');
            const filePreview = document.getElementById('filePreview');
            const file = fileInput.files[0];

            // Clear any previous previews
            filePreview.innerHTML = '';

            if (file) {
                const fileReader = new FileReader();
                fileReader.onload = function(e) {
                    // Create an image element for image files
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'File Preview';
                        img.width = 100; // You can adjust the size
                        img.className = 'img-thumbnail';
                        filePreview.appendChild(img);
                    } else {
                        const fileName = document.createElement('p');
                        fileName.textContent = `Selected file: ${file.name}`;
                        filePreview.appendChild(fileName);
                    }
                };
                fileReader.readAsDataURL(file);
            }
        }
    </script>
    <script src="{{ 'template_user/js/custom-js/chat.js' }}"></script>

@endsection
