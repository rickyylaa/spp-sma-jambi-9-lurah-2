<?php

namespace App\Http\Controllers\Operator;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $siswa = Siswa::orderBy('id', 'ASC')->get();
        $notification = Notification::getNotifications();
        return view('aktor.operator.halaman.siswa.index', compact('siswa', 'notification'));
    }

    public function getSiswa()
    {
        $siswa = Siswa::all();
        return response()->json($siswa);
    }
}
