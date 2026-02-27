<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        $setting = SiteSetting::query()->firstOrCreate(
            ['id' => 1],
            ['site_name' => 'AQUA POS']
        );

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(UpdateSiteSettingRequest $request): RedirectResponse
    {
        $setting = SiteSetting::query()->firstOrCreate(
            ['id' => 1],
            ['site_name' => 'AQUA POS']
        );

        $setting->update($request->validated());

        return redirect()->route('admin.settings.edit')->with('success', 'Site settings updated successfully.');
    }
}
