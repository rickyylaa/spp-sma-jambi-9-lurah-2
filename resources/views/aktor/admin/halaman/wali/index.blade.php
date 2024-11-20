@extends('aktor.admin.layouts.app')
@section('title', 'SPP ONLINE | SMKS JAMBI IX LURAH 2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="javascript: void(0);" class="btn btn-dark ms-2 flex-shrink-0" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            <i class="ri-add-fill"></i> Tambah
                        </a>
                    </div>
                    <h4 class="page-title">Wali</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive-md">
                            <table class="table table-borderless table-centered dt-responsive nowrap w-100" id="basic-datatable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Wali</th>
                                        <th>Telepon</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($wali) > 0)
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($wali as $row)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/profil/'. $row->foto) }}" alt="avatar" class="d-flex me-2 rounded-circle bg-secondary-subtle" height="60">
                                                        <div class="w-100">
                                                            <h5 class="m-0 fs-14">{{ ucwords($row->nama) }}</h5>
                                                            <span class="fs-12 mb-0">{{ $row->username }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ chunk_split($row['telepon'], 4); }}</td>
                                                <td>{{ ucwords($row->jenis_kelamin) }}</td>
                                                <td>{{ ucwords($row->alamat) }}</td>
                                                <td class="text-center">
                                                    <form method="POST" action="{{ route('admin.waliDestroy', $row->username) }}" id="delete-form-{{ $row->username }}">
                                                        @csrf @method('DELETE')
                                                        <a href="javascript: void(0);" class="text-reset fs-18 px-1" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->username }}">
                                                            <i class="ri-edit-box-line"></i>
                                                        </a>
                                                        <a href="javascript: void(0);" class="text-reset fs-18 px-1" onclick="confirmDelete('{{ $row->username }}')">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </a>
                                                    </form>
                                                </td>
                                                <div class="modal fade" id="editModal-{{ $row->username }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header modal-colored-header bg-dark">
                                                                <h4 class="modal-title" id="editModalLabel">Edit Wali</h4>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST" action="{{ route('admin.waliUpdate', $row->username) }}" enctype="multipart/form-data">
                                                                @csrf @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="username" class="form-label">Username</label>
                                                                            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $row->username) }}" placeholder="Masukan username" required autofocus>
                                                                            <p class="text-danger fs-16">{{ $errors->first('username') }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="nama" class="form-label">Nama</label>
                                                                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $row->nama) }}" placeholder="Masukan nama" required>
                                                                            <p class="text-danger fs-16">{{ $errors->first('nama') }}</p>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="password" class="form-label">Password</label>
                                                                            <div class="input-group input-group-merge">
                                                                                <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" placeholder="Masukan password">
                                                                                <div class="input-group-text" data-password="false">
                                                                                    <span class="password-eye"></span>
                                                                                </div>
                                                                            </div>
                                                                            <p class="text-danger fs-16">{{ $errors->first('password') }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="telepon" class="form-label">Telepon</label>
                                                                            <input type="number" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $row->telepon) }}" placeholder="Masukan telepon" required>
                                                                            <p class="text-danger fs-16">{{ $errors->first('telepon') }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                                                                <option value="laki-laki" {{ old('jenis_kelamin', $row->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                                                <option value="perempuan" {{ old('jenis_kelamin', $row->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                                            </select>
                                                                            <p class="text-danger fs-16">{{ $errors->first('jenis_kelamin') }}</p>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="foto" class="form-label d-flex align-items-center">Foto
                                                                                <div class="dropdown ms-1">
                                                                                    <a href="javascript:;" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                        <i class="ri-information-line text-info fs-16"></i>
                                                                                    </a>
                                                                                    <div class="dropdown-menu dropdown-menu-start">
                                                                                        <span class="dropdown-item">Bisa dikosongkan jika tidak ingin mengganti foto</span>
                                                                                    </div>
                                                                                </div>
                                                                            </label>
                                                                            <input type="file" name="foto" id="foto" class="form-control">
                                                                            <p class="text-danger fs-16">{{ $errors->first('foto') }}</p>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="alamat" class="form-label">Alamat</label>
                                                                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $row->alamat) }}</textarea>
                                                                            <p class="text-danger fs-16">{{ $errors->first('alamat') }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-dark">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                            @php
                                                $rowNumber++;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" type="text/css">
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
@endsection

@section('script')
    <script>
        function confirmDelete(username) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat memulihkan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let formUsername = 'delete-form-' + username;
                    document.getElementById(formUsername).submit();
                }
            });
        }
    </script>
@endsection

@section('modal')
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-dark">
                    <h4 class="modal-title" id="tambahModalLabel">Tambah Wali</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.waliStore') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" placeholder="Masukan username" required autofocus>
                                <p class="text-danger fs-16">{{ $errors->first('username') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" placeholder="Masukan nama" required>
                                <p class="text-danger fs-16">{{ $errors->first('nama') }}</p>
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                                <p class="text-danger fs-16">{{ $errors->first('password') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="number" name="telepon" id="telepon" class="form-control" value="{{ old('telepon') }}" placeholder="Masukan telepon" required>
                                <p class="text-danger fs-16">{{ $errors->first('telepon') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                    <option value="laki-laki">Laki-Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                <p class="text-danger fs-16">{{ $errors->first('jenis_kelamin') }}</p>
                            </div>
                            <div class="col-12">
                                <label for="foto" class="form-label d-flex align-items-center">Foto
                                    <div class="dropdown ms-1">
                                        <a href="javascript:;" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-information-line text-info fs-16"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-start">
                                            <span class="dropdown-item">Bisa dikosongkan jika tidak ingin memasukan foto</span>
                                        </div>
                                    </div>
                                </label>
                                <input type="file" name="foto" id="foto" class="form-control">
                                <p class="text-danger fs-16">{{ $errors->first('foto') }}</p>
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                                <p class="text-danger fs-16">{{ $errors->first('alamat') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-dark">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
