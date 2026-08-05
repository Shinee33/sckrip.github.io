<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function __construct(protected ActivityLogService $activityLogService)
    {
    }

    public function index(Request $request): View
    {
        $logs = $this->activityLogService->paginate($request->only(['search', 'action']), 15);

        return view('admin.logs.index', compact('logs'));
    }
}
