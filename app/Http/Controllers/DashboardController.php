<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Apprentice;
use App\Models\Area;
use App\Models\Computer;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\TrainingCenter;
use App\Support\AdminDashboard;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $overview = AdminDashboard::overview();

        return view('admin.index', [
            'tables' => $overview['tables'],
            'online' => $overview['online'],
            'apiUrl' => AdminDashboard::baseUrl(),
            'areas' => Area::all(),
            'trainingCenters' => TrainingCenter::all(),
            'computers' => Computer::all(),
            'teachers' => Teacher::with(['area', 'trainingCenter'])->get(),
            'courses' => Course::with(['area', 'trainingCenter'])->get(),
            'apprentices' => Apprentice::with(['course', 'computer'])->get(),
            'admins' => Admin::all(),
        ]);
    }
}
