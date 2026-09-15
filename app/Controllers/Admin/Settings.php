<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ImageUploader;
use App\Models\SettingModel;

class Settings extends BaseController
{
    public function index()
    {
        $settings = new SettingModel();
        return view('admin/settings/homepage', [
            'logoImage' => $settings->getValue('logo_image'),
            'logoAlt' => $settings->getValue('logo_alt', 'PURABAYA GO'),
            'heroImage' => $settings->getValue('hero_image'),
            'heroAlt' => $settings->getValue('hero_alt', 'Bus keberangkatan dari Terminal Purabaya'),
            'terminalImage' => $settings->getValue('terminal_image'),
            'terminalAlt' => $settings->getValue('terminal_alt', 'Terminal Purabaya Bungurasih'),
        ]);
    }

    public function update()
    {
        $settings = new SettingModel();
        $uploader = new ImageUploader();
        $changes = [
            ['file' => 'logo_image', 'key' => 'logo_image', 'directory' => 'homepage'],
            ['file' => 'hero_image', 'key' => 'hero_image', 'directory' => 'homepage'],
            ['file' => 'terminal_image', 'key' => 'terminal_image', 'directory' => 'homepage'],
        ];

        foreach ($changes as $change) {
            $file = $this->request->getFile($change['file']);
            $uploaded = $uploader->upload($file, $change['directory']);
            if ($uploaded === false) {
                return redirect()->back()->withInput()->with('error', 'Foto gagal diunggah. Gunakan JPG, PNG, atau WebP maksimal 2 MB.');
            }
            if ($uploaded !== null) {
                $old = $settings->getValue($change['key']);
                if (!$settings->setValue($change['key'], $uploaded)) {
                    $uploader->delete($change['directory'], $uploaded);
                    return redirect()->back()->withInput()->with('error', 'Foto gagal disimpan.');
                }
                $uploader->delete($change['directory'], $old);
            }
        }

        $settings->setValue('logo_alt', trim((string) $this->request->getPost('logo_alt')) ?: 'PURABAYA GO');
        $settings->setValue('hero_alt', trim((string) $this->request->getPost('hero_alt')) ?: 'Bus keberangkatan dari Terminal Purabaya');
        $settings->setValue('terminal_alt', trim((string) $this->request->getPost('terminal_alt')) ?: 'Terminal Purabaya Bungurasih');

        return redirect()->to(site_url('admin/settings/homepage'))->with('success', 'Pengaturan foto homepage berhasil diperbarui.');
    }

    public function delete(string $type)
    {
        $keys = ['logo' => 'logo_image', 'hero' => 'hero_image', 'terminal' => 'terminal_image'];
        if (!isset($keys[$type])) {
            return redirect()->back()->with('error', 'Foto tidak ditemukan.');
        }

        $settings = new SettingModel();
        $uploader = new ImageUploader();
        $key = $keys[$type];
        $uploader->delete('homepage', $settings->getValue($key));
        $settings->setValue($key, null);

        return redirect()->to(site_url('admin/settings/homepage'))->with('success', 'Foto berhasil dihapus. Placeholder akan digunakan.');
    }
}
