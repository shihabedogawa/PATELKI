<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index()
    {
        $jadwal = [
            [
                'judul' => 'Pelatihan Flebotomi Dasar',
                'tanggal' => '20 - 22 Februari 2026',
                'lokasi' => 'Jakarta',
                'status' => 'Dibuka'
            ],
            [
                'judul' => 'Pelatihan Manajemen Laboratorium',
                'tanggal' => '5 - 7 Maret 2026',
                'lokasi' => 'Bandung',
                'status' => 'Penuh'
            ],
            [
                'judul' => 'Workshop Quality Control Lab',
                'tanggal' => '15 Januari 2026',
                'lokasi' => 'Surabaya',
                'status' => 'Selesai'
            ],
        ];

        return view('pelatihan', compact('jadwal'));
    }
}