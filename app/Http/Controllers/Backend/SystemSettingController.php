<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SystemSettingRequest;
use App\Models\Setting;

class SystemSettingController extends Controller
{
    public function edit()
    {
        $settings = [
            'logo' => Setting::get('logo'),
            'favicon' => Setting::get('favicon'),
            'footer_text' => Setting::get('footer_text'),
        ];

        return view('Backend.Settings.General', compact('settings'));
    }

    public function update(SystemSettingRequest $request)
    {
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $this->storeFile($request->file('logo'), 'logo');
            Setting::set('logo', $path);
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $path = $this->storeFile($request->file('favicon'), 'favicon');
            Setting::set('favicon', $path);
        }

        if ($request->filled('footer_text')) {
            Setting::set('footer_text', $request->footer_text);
        }

        return redirect()->route('settings.edit')->with('success', 'Settings updated successfully.');
    }

    protected function storeFile($file, string $prefix): string
    {
        $directory = public_path('uploads/settings');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        // Return relative path usable with asset()
        return 'uploads/settings/' . $filename;
    }
}

