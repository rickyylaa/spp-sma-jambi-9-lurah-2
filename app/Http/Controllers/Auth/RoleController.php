<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (auth()->user()->hasRole(['admin'])) {
            Alert::toast('<span class="toast-information">Anda telah berhasil masuk</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect('admin/dashboard');
        } elseif (auth()->user()->hasRole(['operator'])) {
            Alert::toast('<span class="toast-information">Anda telah berhasil masuk</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect('operator/dashboard');
        } elseif (auth()->user()->hasRole(['wali'])) {
            Alert::toast('<span class="toast-information">Anda telah berhasil masuk</span>')->hideCloseButton()->padding('25px')->toHtml();
            return redirect('wali/pembayaran');
        } else {
            return redirect('/');
        }
    }
}
