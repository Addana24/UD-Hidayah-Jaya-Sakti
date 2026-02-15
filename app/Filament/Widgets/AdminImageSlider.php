<?php


namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminImageSlider extends Widget
{
    protected string $view = 'filament.widgets.admin-image-slider';
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $disk = Storage::disk('public');
        $storageDir = 'images/admin-slider';
        $files = $disk->exists($storageDir) ? $disk->files($storageDir) : [];

        $images = [];

        foreach ($files as $file) {
            if (preg_match('/\.(png|jpe?g|webp|gif)$/i', $file)) {
                $images[] = asset('storage/' . $file);
            }
        }

        $publicImagesDir = public_path('images');
        if (is_dir($publicImagesDir)) {
            foreach (File::files($publicImagesDir) as $file) {
                $name = $file->getFilename();
                if (preg_match('/\.(png|jpe?g|webp|gif)$/i', $name)) {
                    $images[] = asset('images/' . $name);
                }
            }
        }

        $images = array_values(array_unique($images));

        if (empty($images)) {
            if (file_exists(public_path('images/login-bg.jpeg'))) {
                $images[] = asset('images/login-bg.jpeg');
            }
        }

        return [
            'images' => $images,
            'autoplayMs' => 4000,
            'aspectW' => 21,
            'aspectH' => 9,
        ];
    }
}
