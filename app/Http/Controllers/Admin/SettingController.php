<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(protected ActivityLogService $activityLogService)
    {
    }

    public function index(): View
    {
        return view('admin.settings.index');
    }

    public function update(Request $request): RedirectResponse
    {
        $this->activityLogService->log('update_settings', 'Memperbarui pengaturan sistem inventory.');

        return back()->with('success', 'Pengaturan sistem berhasil disimpan.');
    }
}
