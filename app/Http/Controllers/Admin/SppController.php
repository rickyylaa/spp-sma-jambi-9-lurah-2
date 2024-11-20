<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spp;
use Illuminate\Http\Request;
use App\Services\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class SppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spp = Spp::orderBy('id', 'ASC')->get();
        $notification = Notification::getNotifications();
        return view('aktor.admin.halaman.spp.index', compact('spp', 'notification'));
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
    public function store(Request $request, Spp $spp)
    {
        $request->validate([
            'angkatan' => 'required|numeric',
            'periode' => 'required|regex:/^\d{4}\/\d{4}$/',
            'nominal' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $spp->create([
                'angkatan' => $request->angkatan,
                'periode' => $request->periode,
                'nominal' => $request->nominal
            ]);

            DB::commit();

            Alert::toast('<span class="toast-information">Spp berhasil dibuat</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat membuat spp: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
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
            'angkatan' => 'required|numeric',
            'periode' => 'required|regex:/^\d{4}\/\d{4}$/',
            'nominal' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $spp = Spp::where('id', $id)->firstOrFail();

            $spp->update([
                'angkatan' => $request->angkatan,
                'periode' => $request->periode,
                'nominal' => $request->nominal
            ]);

            DB::commit();

            Alert::toast('<span class="toast-information">Spp berhasil diperbarui</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat memperbarui spp: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
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

            $spp = Spp::where('id', $id)->firstOrFail();
            $spp->delete();

            DB::commit();

            Alert::toast('<span class="toast-information">Spp berhasil dihapus</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat menghapus spp: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }
}
