<?php

namespace App\View\Components\Admin;

use App\Enums\PropertyStatus;
use App\Models\ContactMessage;
use App\Models\Property;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminNavbarLayout extends Component
{
    public int $jumlahPending;
    public int $jumlahPesanBaru;

    public function __construct()
    {
        $this->jumlahPending = Property::where('status', PropertyStatus::Pending)->count();
        $this->jumlahPesanBaru = ContactMessage::whereNull('read_at')->count();
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.admin-navbar-layout');
    }
}
