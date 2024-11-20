@extends('aktor.admin.layouts.app')
@section('title', 'Perpustakaan SMPN 11 Kota Jambi')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.laporan') }}" class="needs-validation">
                            <div>
                                <label class="form-label mb-2" for="date">Pilih Rentan Tanggal Pengembalian Pinjaman</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="date">
                                        <i class="ri-calendar-line fs-21"></i>
                                    </span>
                                    <input type="text" name="date" id="date" class="form-control date" data-toggle="date-picker" data-cancel-class="btn-warning">
                                    <button type="submit" class="btn btn-primary fs-16">
                                        <i class="ri-search-line me-1"></i> Cari Laporan
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <p class="text-muted fs-14">Laporan Transaksi Peminjaman dan Pengembalian Buku</p>
                                <a target="_blank" class="btn btn btn-outline-success" id="exportpdf">
                                    <i class="ri-printer-line me-1"></i> Print
                                </a>
                            </div>
                        </form>
                        <div class="table-responsive mb-0 pb-0">
                            <table id="basic-datatable" class="table table-striped table-centered dt-responsive nowrap w-100">
                                <thead>
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
                                                @if ($row->status == 'pending')
                                                    <h5><span class="badge bg-primary">{{ ucwords($row->status) }}</span></h5>
                                                @elseif($row->status == 'diterima')
                                                    <h5><span class="badge bg-success">{{ ucwords($row->status) }}</span></h5>
                                                @elseif($row->status == 'ditolak')
                                                    <h5><span class="badge bg-warning">{{ ucwords($row->status) }}</span></h5>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="10">
                                                <div class="col-12">
                                                    <div class="text-center mt-4">
                                                        <h6 class="fw-lighter text-secondary small mb-2">Anda tidak memiliki data dalam tabel ini</h6>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" type="text/css">
@endsection

@section('script')
<script>
    $(document).ready(function() {
        let start = moment().startOf('month');
        let end = moment().endOf('month');

        function formatDateForLink(date) {
            return date.format('DD MMMM YYYY');
        }

        $('#date').daterangepicker({
            startDate: start,
            endDate: end,
            locale: {
                format: 'DD MMMM YYYY',
            }
        }, function(first, last) {
            $('#exportpdf').attr('href', '/admin/laporan/pdf/' + formatDateForLink(first) + '+' + formatDateForLink(last));
        });

        $('#exportpdf').attr('href', '/admin/laporan/pdf/' + formatDateForLink(start) + '+' + formatDateForLink(end));
    });
    </script>
@endsection
