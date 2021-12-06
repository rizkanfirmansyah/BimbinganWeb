<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    //
    public function submission()
    {
        return view('mahasiswa.submission', ['title' => 'Pengajuan Bimbingan']);
    }

    public function result()
    {
        return view('mahasiswa.result', ['title' => 'Hasil Bimbingan']);
    }
}
