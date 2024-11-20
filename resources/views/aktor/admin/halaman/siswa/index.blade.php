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
                    <h4 class="page-title">Siswa</h4>
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
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Lahir</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($siswa) > 0)
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($siswa as $row)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/siswa/'. $row->foto) }}" alt="avatar" class="d-flex me-2 rounded-circle bg-secondary-subtle" height="60">
                                                        <div class="w-100">
                                                            <h5 class="m-0 fs-14">{{ ucwords($row->nama) }}</h5>
                                                            <span class="fs-12 mb-0">{{ $row->nisn }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="w-100">
                                                            <h5 class="m-0 fs-14">{{ ucwords($row->kelas->nama_kelas) }} ({{ $row->angkatan }})</h5>
                                                            <span class="fs-12 mb-0">{{ $row->kelas->kompetensi_keahlian }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ ucwords($row->jenis_kelamin) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->tanggal_lahir)->format('d F Y') }}</td>
                                                <td class="text-center">
                                                    <form method="POST" action="{{ route('admin.siswaDestroy', $row->nisn) }}" id="delete-form-{{ $row->nisn }}">
                                                        @csrf @method('DELETE')
                                                        <a href="javascript: void(0);" class="text-reset fs-18 px-1" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->nisn }}">
                                                            <i class="ri-edit-box-line"></i>
                                                        </a>
                                                        <a href="javascript: void(0);" class="text-reset fs-18 px-1" onclick="confirmDelete('{{ $row->nisn }}')">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </a>
                                                    </form>
                                                </td>
                                                <div class="modal fade" id="editModal-{{ $row->nisn }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header modal-colored-header bg-dark">
                                                                <h4 class="modal-title" id="editModalLabel">Edit Siswa</h4>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST" action="{{ route('admin.siswaUpdate', $row->nisn) }}" enctype="multipart/form-data">
                                                                @csrf @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="nisn" class="form-label">Nomor Induk Siswa Nasional</label>
                                                                            <input type="number" name="nisn" id="nisn" class="form-control" value="{{ old('nisn', $row->nisn) }}" placeholder="Masukan nomor induk siswa nasional" required autofocus>
                                                                            <p class="text-danger fs-16">{{ $errors->first('nisn') }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="nama" class="form-label">Nama</label>
                                                                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $row->nama) }}" placeholder="Masukan nama" required>
                                                                            <p class="text-danger fs-16">{{ $errors->first('nama') }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                                                                <option value="laki-laki" {{ old('jenis_kelamin', $row->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                                                <option value="perempuan" {{ old('jenis_kelamin', $row->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                                            </select>
                                                                            <p class="text-danger fs-16">{{ $errors->first('jenis_kelamin') }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                                            <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir',  \Carbon\Carbon::parse($row->tanggal_lahir)->format('d/m/Y')) }}" required>
                                                                            <p class="text-danger fs-16">{{ $errors->first('tanggal_lahir') }}</p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="kelas_id" class="form-label">Kelas</label>
                                                                            <select name="kelas_id" id="kelas_id" class="form-control selectpicker" data-live-search="true" required>
                                                                                <option value="">Pilih salah satu</option>
                                                                                @foreach ($kelas as $data)
                                                                                    <option value="{{ $data->id }}" {{ (($row->kelas_id == $data->id) ? 'selected' : '') }}>{{ $data->nama_kelas }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <p class="text-danger fs-16">{{ $errors->first('kelas_id') }}</p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="angkatan" class="form-label">Angkatan</label>
                                                                            <input type="number" name="angkatan" id="angkatan" class="form-control" value="{{ old('angkatan', $row->angkatan) }}" required>
                                                                            <p class="text-danger fs-16">{{ $errors->first('angkatan') }}</p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="wali_id" class="form-label">Wali</label>
                                                                            <select name="wali_id" id="wali_id" class="form-control selectpicker" data-live-search="true" required>
                                                                                <option value="">Pilih salah satu</option>
                                                                                @foreach ($wali as $data)
                                                                                    <option value="{{ $data->id }}" {{ (($row->wali_id == $data->id) ? 'selected' : '') }}>{{ $data->nama }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <p class="text-danger fs-16">{{ $errors->first('wali_id') }}</p>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="foto" class="form-label">Foto</label>
                                                                            <input type="file" name="foto" id="foto" class="form-control">
                                                                            <p class="text-danger fs-16">{{ $errors->first('foto') }}</p>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" type="text/css">
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
        function confirmDelete(nisn) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat memulihkan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let formNISN = 'delete-form-' + nisn;
                    document.getElementById(formNISN).submit();
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('#tanggal_lahir', {
                dateFormat: 'd/m/Y',
                allowInput: true
            });
        });
    </script>
@endsection

@section('modal')
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-dark">
                    <h4 class="modal-title" id="tambahModalLabel">Tambah siswa</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.siswaStore') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nisn" class="form-label">Nomor Induk Siswa Nasional</label>
                                <input type="number" name="nisn" id="nisn" class="form-control" value="{{ old('nisn') }}" placeholder="Masukan nomor induk siswa nasional" required autofocus>
                                <p class="text-danger fs-16">{{ $errors->first('nisn') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" placeholder="Masukan nama" required>
                                <p class="text-danger fs-16">{{ $errors->first('nama') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                    <option value="laki-laki">Laki-Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                <p class="text-danger fs-16">{{ $errors->first('jenis_kelamin') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                                <p class="text-danger fs-16">{{ $errors->first('tanggal_lahir') }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="kelas_id" class="form-label">Kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-control selectpicker" data-live-search="true" required>
                                    <option value="">Pilih salah satu</option>
                                    @foreach ($kelas as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger fs-16">{{ $errors->first('kelas_id') }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <input type="number" name="angkatan" id="angkatan" class="form-control" value="{{ old('angkatan') }}" required>
                                <p class="text-danger fs-16">{{ $errors->first('angkatan') }}</p>
                            </div>
                            <div class="col-md-4">
                                <label for="wali_id" class="form-label">Wali</label>
                                <select name="wali_id" id="wali_id" class="form-control selectpicker" data-live-search="true" required>
                                    <option value="">Pilih salah satu</option>
                                    @foreach ($wali as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger fs-16">{{ $errors->first('wali_id') }}</p>
                            </div>
                            <div class="col-12">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                                <p class="text-danger fs-16">{{ $errors->first('foto') }}</p>
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
