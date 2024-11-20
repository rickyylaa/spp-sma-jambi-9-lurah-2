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
                    <h4 class="page-title">Rekening</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @if (count($rekening) > 0)
            @php
                $rowNumber = 1;
            @endphp
            @foreach ($rekening as $row)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4 px-2">
                                <img src="{{ asset('storage/bank/'. $row->foto) }}" alt="bank" class="img-fluid rounded-start">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::upper($row->nama_bank) }}</h5>
                                    <p class="card-text">
                                        Nama Pemilik : {{ ucwords($row->pemilik_akun) }} <br>
                                        Rekening : {{ $row->rekening_akun }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-1 me-1">
                            <form method="POST" action="{{ route('admin.rekeningDestroy', $row->id) }}" id="delete-form-{{ $row->id }}">
                                @csrf @method('DELETE')
                                <a href="javascript: void(0);" class="text-reset fs-18 px-1" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                    <i class="ri-edit-box-line"></i>
                                </a>
                                <a href="javascript: void(0);" class="text-reset fs-18 px-1" onclick="confirmDelete('{{ $row->id }}')">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </form>
                        </div>
                        <div class="modal fade" id="editModal-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">
                                    <div class="modal-header modal-colored-header bg-dark">
                                        <h4 class="modal-title" id="editModalLabel">Edit Rekening</h4>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.rekeningUpdate', $row->id) }}" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="nama_bank" class="form-label">Nama Bank</label>
                                                    <select name="nama_bank" id="nama_bank" class="form-select" required autofocus>
                                                        <option value="bca" {{ old('nama_bank', $row->nama_bank) == 'bca' ? 'selected' : '' }}>BCA</option>
                                                        <option value="bri" {{ old('nama_bank', $row->nama_bank) == 'bri' ? 'selected' : '' }}>BRI</option>
                                                        <option value="bni" {{ old('nama_bank', $row->nama_bank) == 'bni' ? 'selected' : '' }}>BNI</option>
                                                        <option value="mandiri" {{ old('nama_bank', $row->nama_bank) == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                                                        <option value="ovo" {{ old('nama_bank', $row->nama_bank) == 'ovo' ? 'selected' : '' }}>OVO</option>
                                                    </select>
                                                    <p class="text-danger fs-16">{{ $errors->first('nama_bank') }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <label for="pemilik_akun" class="form-label">Nama Pemilik</label>
                                                    <input type="text" name="pemilik_akun" id="pemilik_akun" class="form-control" value="{{ old('pemilik_akun', $row->pemilik_akun) }}" placeholder="Masukan pemilik akun" required>
                                                    <p class="text-danger fs-16">{{ $errors->first('pemilik_akun') }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <label for="rekening_akun" class="form-label">No. Rekening</label>
                                                    <input type="number" name="rekening_akun" id="rekening_akun" class="form-control" value="{{ old('rekening_akun', $row->rekening_akun) }}" placeholder="Masukan nomor rekening" required>
                                                    <p class="text-danger fs-16">{{ $errors->first('rekening_akun') }}</p>
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
                    </div>
                </div>
            @endforeach
        @endif
    </div>
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
                    <h4 class="modal-title" id="tambahModalLabel">Tambah Rekening</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.rekeningStore') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="nama_bank" class="form-label">Nama Bank</label>
                                <select name="nama_bank" id="nama_bank" class="form-select" required autofocus>
                                    <option value="bca">BCA</option>
                                    <option value="bri">BRI</option>
                                    <option value="bni">BNI</option>
                                    <option value="mandiri">Mandiri</option>
                                    <option value="ovo">OVO</option>
                                </select>
                                <p class="text-danger fs-16">{{ $errors->first('nama_bank') }}</p>
                            </div>
                            <div class="col-12">
                                <label for="pemilik_akun" class="form-label">Nama Pemilik</label>
                                <input type="text" name="pemilik_akun" id="pemilik_akun" class="form-control" value="{{ old('pemilik_akun') }}" placeholder="Masukan pemilik akun" required>
                                <p class="text-danger fs-16">{{ $errors->first('pemilik_akun') }}</p>
                            </div>
                            <div class="col-12">
                                <label for="rekening_akun" class="form-label">No. Rekening</label>
                                <input type="number" name="rekening_akun" id="rekening_akun" class="form-control" value="{{ old('rekening_akun') }}" placeholder="Masukan nomor rekening" required>
                                <p class="text-danger fs-16">{{ $errors->first('rekening_akun') }}</p>
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
