@extends('aktor.operator.layouts.app')
@section('title', 'SPP ONLINE | SMKS JAMBI IX LURAH 2')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat bg-primary text-white">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-team-line widget-icon bg-white text-primary"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Siswa">Siswa</h6>
                            <h3 class="my-3">{{ $siswa->count() }} Siswa</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat bg-info text-white">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-user-2-line widget-icon bg-white text-info"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Wali">Wali</h6>
                            <h3 class="my-3">{{ $wali->count() }} Wali</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat bg-success text-white">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-bookmark-line widget-icon bg-white text-success"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Riwayat Peminjam">Riwayat Pembayaran</h6>
                            <h3 class="my-3">{{ $riwayat->flatten()->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat bg-warning text-white">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-bookmark-2-line widget-icon bg-white text-warning"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Pemasukan">Pemasukan</h6>
                            <h3 class="my-3">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
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
                                    @if (count($aktivity) > 0)
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($aktivity as $row)
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
                                            @php
                                                $rowNumber++;
                                            @endphp
                                        @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="10">Tidak ada riwayat aktivity</td>
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
@endsection
