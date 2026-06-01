<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    // Mengembalikan layout utama untuk halaman yang membutuhkan login. Dipanggil di blade dengan <x-app-layout>
    public function render(): View
    {
        return view('layouts.app');
    }
}
