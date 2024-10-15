@extends('penyediajasa.index')

@section('konten')
<link rel="stylesheet" href="{{ asset('template_user/css/custom-css/chat.css') }}" type="text/css">
   <div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-12 wrapper-left">
            <div class="py-3 px-2">
                <h2 class="text-center">Halaman Chat</h2>
                <div class="d-flex align-items-center wrapper p-1 border-bottom active">
                    <img src="{{ asset('foto_profile/1727542586.png') }}" alt="" class="rounded-circle me-2" width="50" height="50" loading="lazy">
                    <div class="w-100 p-2">
                        <p class="text-dark fs-5 text-capitalize mb-0">peler(,mkdks)</p>
                        {{-- <i class="bi bi-check2"></i> checklist 1 --}}
                          <i class="bi bi-check2-all text-primary"></i> {{-- checklist 2 --}}
                        <span class="text-secondary">transaksi bang</span>
                    </div>
                </div>

            </div>
        </div>
            <div class="col-md-8 col-sm-12 wrapper-right ">
                <div class="wrap-right d-flex align-items-center ps-3 py-2">
                    <button class="btn btn-link btn-back d-none" onclick="goBack()"><i class="bi bi-arrow-left text-dark"></i></button>
                    <img src="{{ asset('foto_profile/1727542586.png') }}" alt="" class="rounded-circle me-2" width="50" height="50">
                    <div class="w-100 p-2">
                        <p class="text-capitalize fs-5 text-dark mb-0">peler</p>
                        <span class="text-secondary">online</span>
                    </div>
                </div>

                    <div class="chat px-5">
                        <div class="message-left">
                            <p class="bubble-left">oi cok</p>
                        </div>

                        <div class="message-right">
                            <p class="bubble-right">opo su</p>
                        </div>
                        <div class="message-left">
                            <p class="bubble-left">oi cok</p>
                        </div>

                        <div class="message-right">
                            <p class="bubble-right">opo su</p>
                        </div>
                        <div class="message-left">
                            <p class="bubble-left">oi cok</p>
                        </div>

                        <div class="message-right">
                            <p class="bubble-right">opo su</p>
                        </div>
                        <div class="message-left">
                            <p class="bubble-left">oi cok</p>
                        </div>

                        <div class="message-right">
                            <p class="bubble-right">opo su</p>
                        </div>
                        <div class="message-left">
                            <p class="bubble-left">oi cok</p>
                        </div>

                        <div class="message-right">
                            <p class="bubble-right">opo su</p>
                        </div>
                        <div class="message-left">
                            <p class="bubble-left">oi cok</p>
                        </div>

                        <div class="message-right">
                            <p class="bubble-right">opo su</p>
                        </div>
                        <div class="message-left">
                            <p class="bubble-left">oi cok</p>
                        </div>

                        <div class="message-right">
                            <p class="bubble-right">opo su</p>
                        </div>
                        <div class="message-left">
                            <p class="bubble-left">oi cok</p>
                        </div>

                        <div class="message-right">
                            <p class="bubble-right">opo su</p>
                        </div>
                        <div class="message-left">
                            <p class="bubble-left">oi cok</p>
                        </div>

                        <div class="message-right">
                            <p class="bubble-right">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos, repudiandae error? Modi magnam eos neque laudantium, voluptate ad molestiae? Modi distinctio eligendi cumque culpa suscipit numquam voluptatum vero quae dolore!</p>
                        </div>
                    </div>
                    <form action="#" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="wrap-bottom w-100 py-1 d-flex justify-content-between align-items-center px-3">

                        <input type="file" name="file" id="file" class="form-control d-none">
                        <label for="file" class="btn">
                            <i class="bi bi-plus fs-4"></i>
                        </label>
                        <input type="text" class="form-control" name="chat" placeholder="Ketik Pesan">
                        <button class="btn"><i class="bi bi-send-fill fs-5"></i></button>
                    </div>
                </form>
            </div>
    </div>
   </div>

   <script src="{{ 'template_user/js/custom-js/chat.js' }}"></script>
@endsection
