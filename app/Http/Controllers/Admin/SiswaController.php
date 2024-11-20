<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::orderBy('id', 'ASC')->get();
        $kelas = Kelas::orderBy('id', 'ASC')->get();

        $wali = User::whereHas('roles', function ($query) {
            $query->where('name', 'wali');
        })->orderBy('id', 'ASC')->get();

        $notification = Notification::getNotifications();
        return view('aktor.admin.halaman.siswa.index', compact('siswa', 'kelas', 'wali', 'notification'));
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
    public function store(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nisn' => 'required|numeric',
            'nama' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
            'foto' => 'nullable|image|mimes:png,jpeg,jpg,gif,webp|max:5000',
            'kelas_id' => 'required|exists:kelas,id',
            'angkatan' => 'required|numeric',
            'wali_id' => 'required|exists:users,id'
        ]);

        try {
            DB::beginTransaction();

            $tanggal_lahir = Carbon::createFromFormat('d/m/Y', $request->input('tanggal_lahir'))->format('Y-m-d');

            if ($request->nisn !== $siswa->nisn) {
                $nisnExists = Siswa::where('nisn', $request->nisn)->exists();
                if ($nisnExists) {
                    Alert::toast('<span class="toast-information">NISN sudah diambil.</span>')->hideCloseButton()->padding('25px')->toHtml();
                    return redirect()->back();
                }
            }

            $filename = 'avatar.png';
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = Str::slug($request->nama) . '-' . rand(0,99999) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/siswa', $filename);
            }

            $siswa->create([
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'tanggal_lahir' => $tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'foto' => $filename,
                'kelas_id' => $request->kelas_id,
                'angkatan' => $request->angkatan,
                'wali_id' => $request->wali_id
            ]);

            DB::commit();

            Alert::toast('<span class="toast-information">Siswa berhasil dibuat</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat membuat siswa: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
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
    public function update(Request $request, string $nisn)
    {
        $request->validate([
            'nisn' => 'required|numeric',
            'nama' => 'required|string',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
            'foto' => 'nullable|image|mimes:png,jpeg,jpg,gif,webp|max:5000',
            'kelas_id' => 'required|exists:kelas,id',
            'angkatan' => 'required|numeric',
            'wali_id' => 'required|exists:users,id'
        ]);

        try {
            DB::beginTransaction();

            $siswa = Siswa::where('nisn', $nisn)->firstOrFail();
            $tanggal_lahir = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');

            if ($request->nisn != $siswa->nisn) {
                $nisnExists = Siswa::where('nisn', $request->nisn)->exists();
                if ($nisnExists) {
                    Alert::toast('<span class="toast-information">NISN sudah diambil.</span>')->hideCloseButton()->padding('25px')->toHtml();
                    return redirect()->back();
                }
            }

            $filename = $siswa->foto;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = Str::slug($request->nama) . '-' . rand(0, 99999) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/siswa', $filename);

                if ($siswa->foto && $siswa->foto !== 'avatar.png') {
                    File::delete(storage_path('app/public/siswa/' . $siswa->foto));
                }
            }

            $siswa->update([
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'tanggal_lahir' => $tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'foto' => $filename,
                'kelas_id' => $request->kelas_id,
                'angkatan' => $request->angkatan,
                'wali_id' => $request->wali_id
            ]);

            DB::commit();

            Alert::toast('<span class="toast-information">Siswa berhasil diperbarui</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat memperbarui siswa: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nisn)
    {
        try {
            DB::beginTransaction();

            $siswa = Siswa::where('nisn', $nisn)->firstOrFail();
            $fotoPath = storage_path('app/public/siswa/' . $siswa->foto);
            if ($siswa->foto !== 'avatar.png' && File::exists($fotoPath)) {
                File::delete($fotoPath);
            }
            $siswa->delete();

            DB::commit();

            Alert::toast('<span class="toast-information">Siswa berhasil dihapus</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat menghapus siswa: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }
}
