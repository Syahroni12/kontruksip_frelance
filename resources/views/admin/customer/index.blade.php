@extends('admin.layout.sidebar')

@section('title', 'Daftar Customer')

@section('content')
@include('sweetalert::alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Customer</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Nama</th>
                            <th>No Telp</th>
                            <th>Gender</th>
                            <th>alamat</th>
                            <th>foto</th>
                            <th>tanggal lahir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer as $c)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->nama }}</td>
                                <td>{{ $c->notelp }}</td>
                                <td>{{ $c->gender }}</td>
                                <td>{{ $c->alamat }}</td>
                                <td>
                                    @if ($c->foto)
                                        <a href="#" data-toggle="modal" data-target="#fotoModal"
                                            onclick="showImage('{{ asset('foto_profile/' . $c->foto) }}')">
                                            lihat gambar
                                        </a>
                                    @else
                                        Tidak ada gambar
                                    @endif

                                </td>
                                <td>{{ $c->tgllahir }}</td>
                                <td>{{ $c->status }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal"
                                    onclick="update({{ json_encode($c) }})">Update</button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('penyediajasa.destroy', $c->id) }}" method="POST"
                                        style="display:inline;" onsubmit="confirmDelete(this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Include the modals here -->
                            {{-- @include('admin.penyedia_jasa.modals', ['p' => $p]) --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Viewing Foto -->
    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fotoModalLabel">Foto Penyedia Jasa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="Foto" class="img-fluid" id="foto_penyediajasa">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Updating Status and Akses -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for Updating -->
                    <form action="/customer_updateee" method="POST">
                        @csrf
                        {{-- @method('PUT') --}}

                        <!-- Dropdown for Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="aman">Aman</option>
                                <option value="blokir">Blokir</option>

                            </select>
                        </div>
                        <input type="hidden" name="id" id="id_user">

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>



    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}'
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Oopss...',
                text: '{{ $errors->first() }}'
            });
        </script>
    @endif

@endsection

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush

<script>
    function showImage(url) {
        console.log("URL Gambar:", url); // Debug URL
        document.getElementById("foto_penyediajasa").src = url;
    }

    function update(data) {
        document.getElementById('status').value = data.status;
        document.getElementById('akses').value = data.akses;
        document.getElementById('id_user').value = data.id;
    }



    function confirmDelete(form) {
        event.preventDefault(); // prevent form from submitting
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit form if confirmed
            }
        });
    }
</script>


<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
