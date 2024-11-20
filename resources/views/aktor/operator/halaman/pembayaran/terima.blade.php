@extends('aktor.operator.layouts.app')
@section('title', 'SPP ONLINE | SMKS JAMBI IX LURAH 2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Pembayaran</h4>
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
                                        <th>Invoice</th>
                                        <th>Siswa</th>
                                        <th>Wali</th>
                                        <th>Pembayaran</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($pembayaran) > 0)
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($pembayaran as $row)
                                            <tr>
                                                <td>{{ $row->invoice }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/profil/'. $row->siswa->foto) }}" alt="avatar" class="d-flex me-2 rounded-circle bg-secondary-subtle" height="60">
                                                        <div class="w-100">
                                                            <h5 class="m-0 fs-14">{{ ucwords($row->siswa->nama) }}</h5>
                                                            <span class="fs-12 mb-0">{{ $row->siswa->nisn }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/profil/'. $row->siswa->wali->foto) }}" alt="avatar" class="d-flex me-2 rounded-circle bg-secondary-subtle" height="60">
                                                        <div class="w-100">
                                                            <h5 class="m-0 fs-14">{{ ucwords($row->siswa->wali->nama) }}</h5>
                                                            <span class="fs-12 mb-0">{{ $row->siswa->wali->telepon }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="w-100">
                                                            <span class="fs-12 mb-0">Metode Pembayaran : {{ ucwords($row->metode_pembayaran) }}</span> <br>
                                                            @php
                                                                $months = [
                                                                    "Juli", "Agustus", "September", "Oktober", "November", "Desember",
                                                                    "Januari", "Februari", "Maret", "April", "Mei", "Juni"
                                                                ];

                                                                $sppNominal = $row->spp->nominal ?? 0;

                                                                $monthsPaid = $sppNominal > 0 ? intval($row->jumlah / $sppNominal) : 1;

                                                                $currentMonth = $row->untuk_bulan;
                                                                $currentMonthIndex = array_search($currentMonth, $months);

                                                                $startMonthIndex = max(0, $currentMonthIndex - $monthsPaid + 1);

                                                                if ($monthsPaid > 1) {
                                                                    $monthRange = $months[$startMonthIndex] . ' - ' . $months[$currentMonthIndex];
                                                                } else {
                                                                    $monthRange = $currentMonth;
                                                                }
                                                            @endphp
                                                            <span class="fs-12 mb-0">Untuk Bulan: {{ $monthRange }}</span> <br>
                                                            <span class="fs-12 mb-0">Nominal: Rp.{{ number_format($row->jumlah) }},-</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}</td>
                                                <td>
                                                    <h5><span class="badge bg-success">{{ ucwords($row->status) }}</span></h5>
                                                </td>
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
