<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operator = User::whereHas('roles', function ($query) {
            $query->where('name', 'operator');
        })->orderBy('id', 'ASC')->get();

        $notification = Notification::getNotifications();
        return view('aktor.admin.halaman.operator.index', compact('operator', 'notification'));
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
    public function store(Request $request, User $operator)
    {
        $request->validate([
            'username' => 'required|string',
            'nama' => 'required|string',
            'telepon' => 'required|numeric',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
            'password' => 'required|string|min:8',
            'foto' => 'nullable|image|mimes:png,jpeg,jpg,gif,webp|max:5000',
            'alamat' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            if ($request->username !== $operator->username) {
                $usernameExists = User::where('username', $request->username)->exists();
                if ($usernameExists) {
                    Alert::toast('<span class="toast-information">Username sudah diambil.</span>')->hideCloseButton()->padding('25px')->toHtml();
                    return redirect()->back();
                }
            }

            $filename = 'avatar.png';
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = Str::slug($request->username) . '-' . rand(0,99999) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/profil', $filename);
            }

            $telepon = $request->telepon;
            if (substr($telepon, 0, 1) === '0') {
                $telepon = '+62' . substr($telepon, 1);
            }

            $operator->create([
                'username' => $request->username,
                'nama' => $request->nama,
                'telepon' => $telepon,
                'jenis_kelamin' => $request->jenis_kelamin,
                'password' => Hash::make($request->password),
                'foto' => $filename,
                'alamat' => $request->alamat,
                'status' => 'aktif'
            ])->assignRole('operator');

            DB::commit();

            Alert::toast('<span class="toast-information">Operator berhasil dibuat</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat membuat operator: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
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
    public function update(Request $request, string $username)
    {
        $request->validate([
            'username' => 'required|string',
            'nama' => 'required|string',
            'password' => 'nullable|string|min:8',
            'telepon' => 'required|numeric',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
            'foto' => 'nullable|image|mimes:png,jpeg,jpg,gif,webp|max:5000',
            'alamat' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $operator = User::where('username', $username)->firstOrFail();

            if ($request->username != $operator->username) {
                $usernameExists = User::where('username', $request->username)->exists();
                if ($usernameExists) {
                    Alert::toast('<span class="toast-information">Username sudah diambil.</span>')->hideCloseButton()->padding('25px')->toHtml();
                    return redirect()->back();
                }
            }

            $filename = $operator->foto;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = Str::slug($request->nama) . '-' . rand(0, 99999) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/profil', $filename);

                if ($operator->foto !== 'avatar.png') {
                    File::delete(storage_path('app/public/profil/' . $operator->foto));
                }
            }

            $telepon = $request->telepon;
            if (substr($telepon, 0, 1) === '0') {
                $telepon = '+62' . substr($telepon, 1);
            }

            $operator->update([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => Hash::make($request->password),
                'telepon' => $telepon,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'foto' => $filename
            ]);

            DB::commit();

            Alert::toast('<span class="toast-information">Operator berhasil diperbarui</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat memperbarui operator: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $username)
    {
        try {
            DB::beginTransaction();

            $operator = User::where('username', $username)->firstOrFail();
            $fotoPath = storage_path('app/public/profil/' . $operator->foto);
            if ($operator->foto !== 'avatar.png' && File::exists($fotoPath)) {
                File::delete($fotoPath);
            }
            $operator->delete();

            DB::commit();

            Alert::toast('<span class="toast-information">Operator berhasil dihapus</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::toast('<span class="toast-information">Terjadi kesalahan saat menghapus operator: ' . $e->getMessage() . '</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect()->back();
        }
    }
}
