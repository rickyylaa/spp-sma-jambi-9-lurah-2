<?php

namespace App\Http\Controllers\Operator;

use Carbon\Carbon;
use App\Models\Spp;
use App\Models\Siswa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Services\TwilioService;
use App\Models\PembayaranDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('kelas')->orderBy('id', 'ASC')->get();
        $notification = Notification::getNotifications();
        return view('aktor.operator.halaman.pembayaran.index', compact('siswa', 'notification'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswaID' => 'required|exists:siswas,id',
            'untuk_bulan' => 'required|string',
            'jumlah' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $existingPendingPayment = Pembayaran::where('siswa_id', $request->siswaID)->where('status', 'pending')->first();

            if ($existingPendingPayment) {
                Alert::toast('<span class="toast-information">Masih ada pembayaran pending yang harus dikonfirmasi.</span>')->hideCloseButton()->padding('25px')->toHtml();
                return redirect()->back();
            }

            $siswa = Siswa::where('id', $request->siswaID)->first();
            $spp = Spp::where('id', $request->sppID)->first();

            if (!$spp) {
                Alert::toast('<span class="toast-information">Data SPP tidak ditemukan.</span>')->hideCloseButton()->padding('25px')->toHtml();
                return redirect()->back();
            }

            $lastPayment = Pembayaran::orderBy('id', 'DESC')->first();
            $lastInvoiceNumber = $lastPayment ? intval(substr($lastPayment->invoice, 4)) : 0;
            $invoiceNumber = str_pad($lastInvoiceNumber + 1, 3, '0', STR_PAD_LEFT);
            $invoice = 'INV-' . $invoiceNumber;

            $pembayaran = Pembayaran::create([
                'invoice' => $invoice,
                'siswa_id' => $siswa->id,
                'spp_id' => $spp->id,
                'untuk_bulan' => $request->untuk_bulan,
                'jumlah' => $request->jumlah,
                'status' => 'diterima'
            ]);

            PembayaranDetail::create([
                'pembayaran_id' => $pembayaran->id,
                'siswa_id' => $pembayaran->siswa_id,
                'spp_id' => $pembayaran->spp_id,
                'wali_id' => $siswa->wali->id,
                'bulan_terakhir' => $request->untuk_bulan
            ]);

            DB::commit();

            Alert::toast('<span class="toast-information">Pembayaran berhasil dibuat</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat membuat pembayaran: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }

    public function pending()
    {
        $pembayaran = Pembayaran::with(['siswa', 'spp'])->where('status', 'pending')->orderBy('created_at', 'DESC')->get();
        $notification = Notification::getNotifications();
        return view('aktor.operator.halaman.pembayaran.pending', compact('pembayaran', 'notification'));
    }

    public function terima()
    {
        $pembayaran = Pembayaran::with(['siswa', 'spp'])->where('status', 'diterima')->orderBy('created_at', 'DESC')->get();
        $notification = Notification::getNotifications();
        return view('aktor.operator.halaman.pembayaran.terima', compact('pembayaran', 'notification'));
    }

    public function tolak()
    {
        $pembayaran = Pembayaran::with('pembayaranDetail')->where('status', 'ditolak')->orderBy('created_at', 'DESC')->get();
        $notification = Notification::getNotifications();
        return view('aktor.operator.halaman.pembayaran.tolak', compact('pembayaran', 'notification'));
    }

    public function terimaStore($invoice)
    {
        try {
            DB::beginTransaction();

            $pembayaran = Pembayaran::with(['siswa', 'spp'])->where('invoice', $invoice)->first();

            if (!$pembayaran) {
                Alert::toast('<span class="toast-information">Pembayaran tidak ditemukan</span>')->hideCloseButton()->padding('25px')->toHtml();
            }

            if ($pembayaran->status == 'pending') {
                $pembayaran->update([
                    'status' => 'diterima'
                ]);

                $siswa = $pembayaran->siswa;
                $wali = $siswa->wali;

                $message = "Pembayaran SPP Anda telah diterima sebesar: " . number_format($pembayaran->jumlah);
                $this->sendMessage($wali->telepon, $message);
            }

            DB::commit();

            Alert::toast('<span class="toast-information">Pembayaran berhasil diterima</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat menerima pembayaran: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }

    public function tolakStore(Request $request, $invoice)
    {
        try {
            DB::beginTransaction();

            $pembayaran = Pembayaran::with(['siswa', 'spp', 'pembayaranDetail'])->where('invoice', $invoice)->first();

            if (!$pembayaran) {
                Alert::toast('<span class="toast-information">Pembayaran tidak ditemukan</span>')->hideCloseButton()->padding('25px')->toHtml();
                return redirect()->back();
            }

            if ($pembayaran->status == 'pending') {
                $pembayaran->update([
                    'status' => 'ditolak'
                ]);

                foreach ($pembayaran->pembayaranDetail as $detail) {
                    $detail->update([
                        'alasan' => $request->alasan
                    ]);
                }

                $siswa = $pembayaran->siswa;
                $wali = $siswa->wali;

                $message = "Pembayaran SPP Anda telah ditolak karena: $request->alasan";
                $this->sendMessage($wali->telepon, $message);
            }

            DB::commit();

            Alert::toast('<span class="toast-information">Pembayaran berhasil ditolak</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat menolak pembayaran: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }

    public function getSemuaPembayaran($nisn)
    {
        $siswa = Siswa::where('nisn', $nisn)->first();

        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $allPayments = Pembayaran::where('siswa_id', $siswa->id)->orderBy('created_at', 'DESC')->get();

        $months = [
            "Juli", "Agustus", "September", "Oktober", "November", "Desember",
            "Januari", "Februari", "Maret", "April", "Mei", "Juni"
        ];

        $lastPaidPayment = $allPayments->where('status', 'diterima')->first();
        $lastPaidMonth = $lastPaidPayment ? $lastPaidPayment->untuk_bulan : null;

        $availableMonths = [];
        if ($lastPaidMonth === "Juni") {
            $availableMonths = $months;
        } elseif ($lastPaidMonth) {
            $startIndex = array_search($lastPaidMonth, $months) + 1;
            $availableMonths = array_slice($months, $startIndex);
        } else {
            $availableMonths = $months;
        }

        $rejectedMonths = $allPayments->where('status', 'ditolak')
            ->pluck('untuk_bulan')
            ->filter(function ($month) use ($allPayments) {
                return !$allPayments->where('untuk_bulan', $month)->where('status', 'diterima')->count();
            })->unique()->toArray();

        return response()->json([
            'available_months' => $availableMonths,
            'last_payment_month' => $lastPaidMonth,
            'rejected_months' => $rejectedMonths
        ]);
    }

    public function getPembayaranTerakhir($nisn)
    {
        $siswa = Siswa::where('nisn', $nisn)->first();

        if (!$siswa) {
        return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $allPayments = Pembayaran::where('siswa_id', $siswa->id)->orderBy('created_at', 'DESC')->get();

        if ($allPayments->isEmpty()) {
        return response()->json(['message' => 'Belum melakukan pembayaran'], 200);
        }

        $payments = $allPayments->map(function ($payment) {
        return [
            'month' => $payment->untuk_bulan,
            'jumlah' => $payment->jumlah,
            'status' => $payment->status,
            'created_at' => $payment->created_at->format('d-m-Y')
        ];
        });

        return response()->json(['payments' => $payments]);
    }

    public function getSpp(Request $request)
    {
        $angkatan = $request->input('angkatan');

        $spp = Spp::all();

        $filteredSpp = $spp->filter(function ($sppItem) use ($angkatan) {
            $periode = explode('/', $sppItem->periode);
            return $periode[0] == $angkatan;
        });

        if ($filteredSpp->isEmpty()) {
            $filteredSpp = $spp->sortByDesc(function ($sppItem) {
                $periode = explode('/', $sppItem->periode);
                return (int) $periode[0];
            })->take(1);
        }

        return response()->json($filteredSpp);
    }

    # https://fonnte.com/ #

    private function sendMessage($phone, $message)
    {
        $token = "#token";
        $curl = curl_init();

        $postData = json_encode([
            'target' => $phone,
            'message' => $message,
            'countryCode' => '62'
        ]);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            throw new \Exception(curl_error($curl));
        }

        curl_close($curl);
    }

    # https://fonnte.com/ #
}
