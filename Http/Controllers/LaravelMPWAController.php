<?php

namespace LaravelMPWA\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use LaravelMPWA\Services\LaucherIconService;
use LaravelMPWA\Services\ManifestService;

class LaravelMPWAController extends Controller
{
    public function manifestJson($name = '')
    {
        $output = (new ManifestService)->generate($name);

        return response()->json($output);
    }

    public function offline(){
        return view('laravelmultipwa::offline');
    }
}
