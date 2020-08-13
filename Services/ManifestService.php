<?php

namespace LaravelMPWA\Services;


class ManifestService
{
    public function generate($name = '')
    {
        $baseConfig = config('laravelmultipwa');
        $extraConfig = config("laravelmultipwa.extra.{$name}") ?? [];

        $config = collect($baseConfig)->map(function ($value, $key) use ($extraConfig) {
            if (\is_array($value)) {
                return array_merge($value, $extraConfig[$key] ?? []);
            } else {
                return $value ?? ($extraConfig[$key] ?? null);
            }
        })->toArray();


        $basicManifest =  $config['manifest'];

        // $basicManifest =  [
        //     'name' => config('laravelmultipwa.manifest.name'),
        //     'short_name' => config('laravelmultipwa.manifest.short_name'),
        //     'start_url' => asset(config('laravelmultipwa.manifest.start_url')),
        //     'display' => config('laravelmultipwa.manifest.display'),
        //     'theme_color' => config('laravelmultipwa.manifest.theme_color'),
        //     'background_color' => config('laravelmultipwa.manifest.background_color'),
        //     'orientation' =>  config('laravelmultipwa.manifest.orientation'),
        //     'status_bar' =>  config('laravelmultipwa.manifest.status_bar'),
        //     'splash' =>  config('laravelmultipwa.manifest.splash')
        // ];

        foreach ($config['manifest']['icons'] as $size => $file) {
            $fileInfo = pathinfo($file['path']);
            $basicManifest['icons'][] = [
                'src' => $file['path'],
                'type' => 'image/' . $fileInfo['extension'],
                'sizes' => $size,
                'purpose' => $file['purpose']
            ];
        }

        foreach ($config['manifest']['shortcuts'] as $shortcut) {

            if (array_key_exists("icons", $shortcut)) {
                $fileInfo = pathinfo($shortcut['icons']['src']);
                $icon = [
                    'src' => $shortcut['icons']['src'],
                    'type' => 'image/' . $fileInfo['extension'],
                    'purpose' => $shortcut['icons']['purpose']
                ];
            } else {
                $icon = [];
            }

            $basicManifest['shortcuts'][] = [
                'name' => trans($shortcut['name']),
                'description' => trans($shortcut['description']),
                'url' => $shortcut['url'],
                'icons' => [
                        $icon
                    ]
            ];
        }

        foreach ($config['manifest']['custom'] as $tag => $value) {
             $basicManifest[$tag] = $value;
        }

        return $basicManifest;
    }

}
