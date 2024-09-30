@extends('admin.layout.sidebar')

@section('title', 'Mapel')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Penyedia Jasa</h6>
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
                            <th>CV</th>
                            <th>alamat</th>
                            <th>foto</th>
                            <th>tanggal lahir</th>
                            <th>No Rekening</th>
                            <th>Pendidikan Terakhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penyediaJasa as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->notelp }}</td>
                                <td>{{ $p->gender }}</td>
                                <td>
                                    @if ($p->CV)
                                        <a href="{{ asset('storage/' . $p->CV) }}" target="_blank">Lihat CV</a>
                                    @else
                                        Tidak ada CV
                                    @endif
                                </td>
                                <td>{{ $p->alamat }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#fotoModal{{ $p->id }}">
                                        <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto" width="50" height="50">
                                    </a>
                                </td>
                                <td>{{ $p->tgllahir }}</td>
                                <td>{{ $p->no_rekening }}</td>
                                <td>{{ $p->pendidikan_terakhir }}</td>
                                <td>{{ $p->status }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateModal{{ $p->id }}">Update</button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('penyediajasa.destroy', $p->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Include the modals here -->
                            @include('admin.penyedia_jasa.modals', ['p' => $p])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Viewing Foto -->
<div class="modal fade" id="fotoModal{{ $p->id }}" tabindex="-1" aria-labelledby="fotoModalLabel{{ $p->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalLabel{{ $p->id }}">Foto Penyedia Jasa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing CV -->
<div class="modal fade" id="cvModal{{ $p->id }}" tabindex="-1" aria-labelledby="cvModalLabel{{ $p->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cvModalLabel{{ $p->id }}">CV Penyedia Jasa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (Str::endsWith($p->CV, ['.pdf']))
                    <iframe src="{{ asset('storage/' . $p->CV) }}" frameborder="0" width="100%" height="500px"></iframe>
                @else
                    <p><a href="{{ asset('storage/' . $p->CV) }}" target="_blank">Download CV</a></p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Updating Status and Akses -->
<div class="modal fade" id="updateModal{{ $p->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $p->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{ $p->id }}">Update Penyedia Jasa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for Updating -->
                <form action="{{ route('penyediajasa.update', $p->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Dropdown for Status -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="aman" {{ $p->status == 'aman' ? 'selected' : '' }}>Aman</option>
                            <option value="blokir" {{ $p->status == 'blokir' ? 'selected' : '' }}>Blokir</option>
                            <option value="sedang_verifikasi" {{ $p->status == 'sedang_verifikasi' ? 'selected' : '' }}>Sedang Verifikasi</option>
                        </select>
                    </div>

                    <!-- Dropdown for Akses -->
                    <div class="form-group">
                        <label for="akses">Akses</label>
                        <select class="form-control" id="akses" name="akses">
                            <option value="customer" {{ $p->akses == 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="penyedia_jasa" {{ $p->akses == 'penyedia_jasa' ? 'selected' : '' }}>Penyedia Jasa</option>
                            <option value="customer_penyediajasa" {{ $p->akses == 'customer_penyediajasa' ? 'selected' : '' }}>Customer Penyedia Jasa</option>
                        </select>
                    </div>

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


