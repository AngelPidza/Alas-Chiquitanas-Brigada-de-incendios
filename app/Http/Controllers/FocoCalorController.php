<?php

namespace App\Http\Controllers;

use App\Models\FocosCalor;
use Illuminate\Http\Request;

class FocoCalorController extends Controller
{
    public function index()
    {
        $focos = FocosCalor::orderBy('acq_date', 'desc')->paginate(20);
        return view('focos-calor.index', compact('focos'));
    }

    public function mapa()
    {
        $focos = FocosCalor::orderBy('acq_date', 'desc')->limit(100)->get();
        return view('focos-calor.mapa', compact('focos'));
    }

    public function api()
    {
        $focos = FocosCalor::orderBy('acq_date', 'desc')->limit(100)->get();
        return response()->json($focos);
    }
}
