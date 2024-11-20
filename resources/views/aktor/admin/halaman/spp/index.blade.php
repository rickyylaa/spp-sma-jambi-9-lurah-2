@extends('aktor.admin.layouts.app')
@section('title', 'Perpustakaan SMPN 11 Kota Jambi')

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
                    <h4 class="page-title">Spp</h4>
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
                                        <th>Angkatan</th>
                                        <th>Periode</th>
                                        <th>Nominal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($spp) > 0)
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($spp as $row)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>{{ $row->angkatan }}</td>
                                                <td>{{ $row->periode }}</td>
                                                <td>Rp.{{ number_format($row->nominal) }},-</td>
                                                <td class="text-center">
                                                    <form method="POST" action="{{ route('admin.sppDestroy', $row->id) }}" id="delete-form-{{ $row->id }}">
                                                        @csrf @method('DELETE')
                                                        <a href="javascript: void(0);" class="text-reset fs-18 px-1" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                            <i class="ri-edit-box-line"></i>
                                                        </a>
                                                        <a href="javascript: void(0);" class="text-reset fs-18 px-1" onclick="confirmDelete('{{ $row->id }}')">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </a>
                                                    </form>
                                                </td>
                                                <div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header modal-colored-header bg-dark">
                                                                <h4 class="modal-title" id="editModalLabel">Edit SPP</h4>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST" action="{{ route('admin.sppUpdate', $row->id) }}" enctype="multipart/form-data">
                                                                @csrf @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label for="angkatan" class="form-label">Angkatan</label>
                                                                            <input type="number" name="angkatan" id="angkatan" class="form-control" value="{{ old('angkatan', $row->angkatan) }}" placeholder="Masukan angkatan spp" required autofocus>
                                                                            <p class="text-danger fs-16">{{ $errors->first('angkatan') }}</p>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="periode" class="form-label">Periode</label>
                                                                            <input type="text" name="periode" id="periode" class="form-control" value="{{ old('periode', $row->periode) }}" placeholder="Masukan periode spp, Contoh: 2024/2025" pattern="^\d{4}\/\d{4}$" required>
                                                                            <p class="text-danger fs-16">{{ $errors->first('periode') }}</p>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label for="nominal" class="form-label">Nominal</label>
                                                                            <input type="number" name="nominal" id="nominal" class="form-control" value="{{ old('nominal', $row->nominal) }}" placeholder="Masukan nominal spp" required>
                                                                            <p class="text-danger fs-16">{{ $errors->first('nominal') }}</p>
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
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat memulihkan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let formId = 'delete-form-' + id;
                    document.getElementById(formId).submit();
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
                    <h4 class="modal-title" id="tambahModalLabel">Tambah Spp</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.sppStore') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <input type="number" name="angkatan" id="angkatan" class="form-control" value="{{ old('angkatan') }}" placeholder="Masukan angkatan spp" required autofocus>
                                <p class="text-danger fs-16">{{ $errors->first('angkatan') }}</p>
                            </div>
                            <div class="col-12">
                                <label for="periode" class="form-label">Periode</label>
                                <input type="text" name="periode" id="periode" class="form-control" value="{{ old('periode') }}" placeholder="Masukan periode spp, Contoh: 2024/2025" pattern="^\d{4}\/\d{4}$" required>
                                <p class="text-danger fs-16">{{ $errors->first('periode') }}</p>
                            </div>
                            <div class="col-12">
                                <label for="nominal" class="form-label">Nominal</label>
                                <input type="number" name="nominal" id="nominal" class="form-control" value="{{ old('nominal') }}" placeholder="Masukan nominal spp" required>
                                <p class="text-danger fs-16">{{ $errors->first('nominal') }}</p>
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
