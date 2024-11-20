@extends('aktor.wali.layouts.app')
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
                    <form method="POST" action="{{ route('wali.pembayaranStore') }}" enctype="multipart/form-data">
                        @csrf <input type="hidden" name="siswaAngkatan" id="siswaAngkatan" value="{{ $siswa->angkatan }}">
                        <input type="hidden" name="siswaID" id="siswaID" value="{{ $siswa->id }}">
                        <input type="hidden" name="jumlah" id="jumlah" class="form-control" value="0">
                        <input type="hidden" name="sppID" id="sppID" class="form-control" value="0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="siswa" class="form-label">NISN</label>
                                    <input type="text" name="siswa" id="siswa" class="form-control" value="{{ old('siswa', $siswa->nisn) }}" placeholder="nomor induk siswa" required readonly>
                                    <p class="text-danger fs-16">{{ $errors->first('siswa') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}" placeholder="Nama siswa" required readonly>
                                    <p class="text-danger fs-16">{{ $errors->first('nama') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <input type="text" name="kelas" id="kelas" class="form-control" value="{{ old('kelas', $siswa->kelas->nama_kelas) }}" placeholder="Kelas siswa" required readonly>
                                    <p class="text-danger fs-16">{{ $errors->first('kelas') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <div>
                                        <label for="last_month" class="form-label">Pembayaran Terakhir</label>
                                        <input type="text" name="last_month" id="last_month" class="form-control" value="{{ old('last_month') }}" placeholder="Riwayat" required readonly>
                                        <p class="text-danger fs-16">{{ $errors->first('last_month') }}</p>
                                    </div>
                                    <div>
                                        <label for="untuk_bulan" class="form-label">Bulan</label>
                                        <select name="untuk_bulan" id="untuk_bulan" class="form-select" required>
                                            <option value="">Pilih Bulan</option>
                                        </select>
                                        <p class="text-danger fs-16">{{ $errors->first('untuk_bulan') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div>
                                        <label for="metode_pembayaran" class="form-label">Bank</label>
                                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                            <option value="">Pilih Bank</option>
                                            @foreach ($rekening as $data)
                                                <option value="{{ $data->nama_bank }}">{{ Str::upper($data->nama_bank) }}</option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger fs-16">{{ $errors->first('metode_pembayaran') }}</p>
                                    </div>
                                    <div>
                                        <label for="bukti" class="form-label">Bukti Pembayaran</label>
                                        <input type="file" name="bukti" id="bukti" class="form-control" value="{{ old('bukti') }}" required>
                                        <p class="text-danger fs-16">{{ $errors->first('bukti') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="rincian" class="form-label">Rincian SPP</label>
                                    <div class="card text-bg-success" id="rincianCard">
                                        <div class="card-body">
                                            <div class="d-grid">
                                                <span class="small mb-2">Rp. <strong class="h3" id="total_biaya">0,-</strong></span>
                                                <span>Biaya SPP 1 Bulan</span>
                                                <span>Rp. <span id="biaya_spp">0,-</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-dark btn-md">Tambah</button>
                        </div>
                    </form>
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
    $(document).ready(function() {
        var siswaNisn = $('#siswa').val();
        var siswaAngkatan = $('#siswaAngkatan').val();

        var months = [
            "Juli", "Agustus", "September", "Oktober", "November", "Desember",
            "Januari", "Februari", "Maret", "April", "Mei", "Juni"
        ];

        var lastMonth = '';
        var totalMonths = 0;

        $.ajax({
            url: '/pembayaran/semua/' + siswaNisn,
            method: 'GET',
            success: function(response) {
                console.log(response);

                var availableMonths = response.available_months || [];
                var rejectedMonths = response.rejected_months || [];

                var allMonths = [...new Set([...availableMonths, ...rejectedMonths])];
                lastMonth = response.last_payment_month || '';

                console.log("Semua bulan:", allMonths);
                console.log("Bulan terakhir:", lastMonth);

                var bulanSelect = $('#untuk_bulan');
                bulanSelect.empty();
                bulanSelect.append('<option value="">Pilih Bulan</option>');

                allMonths.forEach(function(month) {
                    bulanSelect.append('<option value="' + month + '">' + month + '</option>');
                });

                $('#last_month').val(lastMonth);
            },
            error: function(xhr, status, error) {
                console.error("Kesalahan mengambil bulan yang tersedia:", error);
            }
        });

        $.ajax({
            url: '/pembayaran/terakhir/' + siswaNisn,
            method: 'GET',
            success: function(response) {
                var payments = response.payments || [];

                if (payments.length > 0) {
                    var lastPayment = payments[0];
                    var lastMonth = lastPayment.month + ' (' + lastPayment.status.toUpperCase() + ')';
                    var lastAmount = lastPayment.jumlah;
                    var lastStatus = lastPayment.status;

                    $('#last_month').val(lastMonth);
                    $('#last_amount').val(lastAmount);
                    $('#last_status').val(lastStatus);
                    $('#last_date').val(lastPayment.created_at);
                } else {
                    lastMonth = '';
                    $('#last_month').val('Belum melakukan pembayaran');
                    $('#last_amount').val('0');
                    $('#last_status').val('Belum Bayar');
                    $('#last_date').val('');
                }
            },
            error: function(xhr, status, error) {
                console.error("Kesalahan pengambilan pembayaran terakhir:", error);
            }
        });

        $.ajax({
            url: '/pembayaran/getSpp',
            method: 'GET',
            data: { angkatan: siswaAngkatan },
            success: function(sppResponse) {
                console.log(sppResponse);

                var sppArray = Array.isArray(sppResponse) ? sppResponse : Object.values(sppResponse);

                var matchingSpp = sppArray.filter(function(spp) {
                    var periodStartYear = parseInt(spp.periode.split('/')[0]);
                    var periodEndYear = parseInt(spp.periode.split('/')[1]);

                    return siswaAngkatan >= periodStartYear && siswaAngkatan <= periodEndYear;
                });

                if (matchingSpp.length > 0) {
                    var selectedSpp = matchingSpp[0];
                    var biayaSpp = selectedSpp.nominal;
                    var sppID = selectedSpp.id;

                    console.log('Biaya SPP:', biayaSpp);

                    $('#sppID').val(sppID);
                    $('#biaya_spp').text(numberWithCommas(biayaSpp));
                    $('#total_biaya').text(numberWithCommas(0));

                    $('#untuk_bulan').change(function() {
                        var selectedBulan = $(this).val();
                        var totalBiaya = 0;
                        var totalMonths = 0;

                        var selectedBulanIndex = months.indexOf(selectedBulan);

                        if (lastMonth && lastMonth !== '') {
                            var lastMonthIndex = months.indexOf(lastMonth);

                            if (lastMonth === "Juni" && selectedBulanIndex >= 0) {
                                totalMonths = selectedBulanIndex + 1;
                                totalBiaya = biayaSpp * totalMonths;
                            } else if (selectedBulanIndex > lastMonthIndex) {
                                totalMonths = selectedBulanIndex - lastMonthIndex;
                                totalBiaya = biayaSpp * totalMonths;
                            }
                        } else {
                            if (selectedBulan) {
                                totalMonths = selectedBulanIndex + 1;
                                totalBiaya = biayaSpp * totalMonths;
                            }
                        }

                        $('#biaya_spp').text(numberWithCommas(biayaSpp));
                        $('#total_biaya').text(numberWithCommas(totalBiaya));
                        $('#jumlah').val(totalBiaya);
                    });
                } else {
                    console.log('Tidak ada periode yang sesuai');
                }
            },
            error: function(xhr, status, error) {
                console.error("Kesalahan mengambil SPP:", error);
            }
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    });
</script>
@endsection
