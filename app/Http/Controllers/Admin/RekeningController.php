<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rekening;
use Illuminate\Http\Request;
use App\Services\Notification;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekening = Rekening::orderBy('id', 'ASC')->get();
        $notification = Notification::getNotifications();
        return view('aktor.admin.halaman.rekening.index', compact('rekening', 'notification'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Rekening $rekening)
    {
        $request->validate([
            'nama_bank' => 'required|string',
            'pemilik_akun' => 'required|string',
            'rekening_akun' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $fotoPath = $request->nama_bank . '.png';

            $rekening->create([
                'nama_bank' => $request->nama_bank,
                'pemilik_akun' => $request->pemilik_akun,
                'rekening_akun' => $request->rekening_akun,
                'foto' => $fotoPath
            ]);

            DB::commit();

            Alert::toast('<span class="toast-information">Rekening berhasil dibuat</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat membuat rekening: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_bank' => 'required|string',
            'pemilik_akun' => 'required|string',
            'rekening_akun' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $rekening = Rekening::where('id', $id)->firstOrFail();

            $fotoPath = $request->nama_bank . '.png';

            $rekening->update([
                'nama_bank' => $request->nama_bank,
                'pemilik_akun' => $request->pemilik_akun,
                'rekening_akun' => $request->rekening_akun,
                'foto' => $fotoPath
            ]);

            DB::commit();

            Alert::toast('<span class="toast-information">Rekening berhasil diperbarui</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat memperbarui rekening: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $rekening = Rekening::where('id', $id)->firstOrFail();
            $rekening->delete();

            DB::commit();

            Alert::toast('<span class="toast-information">Rekening berhasil dihapus</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat menghapus rekening: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }
}
