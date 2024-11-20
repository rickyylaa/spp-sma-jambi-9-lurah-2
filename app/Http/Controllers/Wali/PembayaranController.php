<?php

namespace App\Http\Controllers\Wali;

use Pusher\Pusher;
use App\Models\Spp;
use App\Models\Siswa;
use App\Models\Rekening;
use App\Models\Pembayaran;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\PembayaranDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranController extends Controller
{
    public function index()
    {
        $rekening = Rekening::orderBy('id', 'ASC')->get();
        $siswa = Siswa::with('kelas')->where('wali_id', auth()->user()->id)->first();
        return view('aktor.wali.halaman.pembayaran.index', compact('rekening', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswaID' => 'required|exists:siswas,id',
            'metode_pembayaran' => 'required|string',
            'untuk_bulan' => 'required|string',
            'jumlah' => 'required|integer',
            'bukti' => 'required|image|mimes:png,jpeg,jpg,gif,webp,heic|max:5000'
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

            $filename = 'bukti.png';
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $filename = Str::slug($siswa->nama) . '-' . rand(0,99999) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/bukti', $filename);
            }

            $pembayaran = Pembayaran::create([
                'invoice' => $invoice,
                'siswa_id' => $siswa->id,
                'spp_id' => $spp->id,
                'metode_pembayaran' => $request->metode_pembayaran,
                'untuk_bulan' => $request->untuk_bulan,
                'jumlah' => $request->jumlah,
                'bukti' => $filename,
                'deskripsi' => $request->deskripsi,
                'status' => 'pending'
            ]);

            PembayaranDetail::create([
                'pembayaran_id' => $pembayaran->id,
                'siswa_id' => $pembayaran->siswa_id,
                'spp_id' => $pembayaran->spp_id,
                'wali_id' => $siswa->wali->id,
                'bulan_terakhir' => $request->untuk_bulan
            ]);

            Notification::create([
                'pembayaran_id' => $pembayaran->id,
                'siswa_id' => $siswa->id,
                'spp_id' => $spp->id,
                'wali_id' => auth()->user()->id,
                'is_read' => 0
            ]);

            $options = [
                'cluster' => 'ap1',
                'useTLS' => true
            ];

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $data = ['wali_id' => auth()->user()->id];
            $pusher->trigger('my-channel', 'my-event', $data);

            DB::commit();

            Alert::toast('<span class="toast-information">Pembayaran berhasil dibuat</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat membuat pembayaran: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }

    public function riwayat()
    {
        $siswa = Siswa::where('wali_id', auth()->user()->id)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
        }

        $pembayaran = Pembayaran::with(['siswa', 'spp'])->where('siswa_id', $siswa->id)->orderBy('created_at', 'DESC')->get();
        return view('aktor.wali.halaman.pembayaran.riwayat', compact('pembayaran'));
    }
}
