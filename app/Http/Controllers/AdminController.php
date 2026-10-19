<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $overview = Admin::overview();

        return view('admin.index', [
            'tables' => $overview['tables'],
            'online' => $overview['online'],
            'apiUrl' => Admin::baseUrl(),
        ]);
    }
}
