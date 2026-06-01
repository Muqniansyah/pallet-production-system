<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    // Mengembalikan layout untuk halaman yang belum login.  Dipanggil di blade dengan <x-guest-layout>
    public function render(): View
    {
        return view('layouts.guest');
    }
}
