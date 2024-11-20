<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">

    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

    <link rel="stylesheet" href="{{ asset('pdf/vendor/bootstrap/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('pdf/vendor/font-awesome/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('pdf/css/stylesheet.css') }}" type="text/css">
</head>
<body>
    <div class="container-fluid invoice-container">
        <main>
            <div class="table-responsive">
                <table class="table table-bordered border border-secondary mb-0">
                    <tbody>
                        <tr>
                            <td colspan="2" class="bg-light text-center">
                                <h3 class="mb-0">SPP ONLINE SMKS JAMBI IX LURAH 2</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center text-uppercase">
                                DINAS PENDIDIKAN PEMERINTAH KOTA JAMBI<br>
                                SEKOLAH MENENGAH KEJURUAN JAMBI IX LURAH 2<br>
                                Alamat : Jalan Kol. Amir Hamzah, Selamat, Jambi City, Jambi
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="p-0">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr class="bg-light">
                                            <td class="col-1"><strong>Invoice</strong></td>
                                            <td class="col-1"><strong>Siswa</strong></td>
                                            <td class="col-1"><strong>Wali</strong></td>
                                            <td class="col-1"><strong>Pembayaran</strong></td>
                                            <td class="col-1"><strong>Tanggal Pembayaran</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @forelse ($pembayaran as $data)
                                            <tr>
                                                <td class="col-1">{{ $data->invoice }}</td>
                                                <td class="col-1">
                                                    <span class="m-0">{{ ucwords($data->siswa->nama) }}</span> <br>
                                                    <span class="mb-0">{{ $data->siswa->nisn }}</span>
                                                </td>
                                                <td class="col-1">
                                                    <span class="m-0">{{ ucwords($data->siswa->wali->nama) }}</span> <br>
                                                    <span class="mb-0">{{ $data->siswa->wali->telepon }}</span>
                                                </td>
                                                <td class="col-1">
                                                    @php
                                                        $months = [
                                                            "Juli", "Agustus", "September", "Oktober", "November", "Desember",
                                                            "Januari", "Februari", "Maret", "April", "Mei", "Juni"
                                                        ];

                                                        $sppNominal = $data->spp->nominal ?? 0;

                                                        $monthsPaid = $sppNominal > 0 ? intval($data->jumlah / $sppNominal) : 1;

                                                        $currentMonth = $data->untuk_bulan;
                                                        $currentMonthIndex = array_search($currentMonth, $months);

                                                        $startMonthIndex = max(0, $currentMonthIndex - $monthsPaid + 1);

                                                        if ($monthsPaid > 1) {
                                                            $monthRange = $months[$startMonthIndex] . ' - ' . $months[$currentMonthIndex];
                                                        } else {
                                                            $monthRange = $currentMonth;
                                                        }
                                                    @endphp
                                                    <span class="mb-0">Metode Pembayaran : {{ ucwords($data->metode_pembayaran) }}</span> <br>
                                                    <span class="mb-0">Untuk Bulan: {{ $monthRange }}</span> <br>
                                                    <span class="mb-0">Nominal: Rp.{{ number_format($data->jumlah) }},-</span>
                                                </td>
                                                <td class="col-1">{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</td>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Anda tidak memiliki data dalam tabel ini</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
        <footer class="text-center mt-4">
            <div class="btn-group btn-group-sm d-print-none">
                <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none">
                    <i class="fa fa-print"></i> Print & Download
                </a>
            </div>
        </footer>
    </div>
</body>
</html>
