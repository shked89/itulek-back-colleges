<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function show($id)
    {
        $speciality = Speciality::find($id);

        if (!$speciality) {
            return response()->json(['message' => 'Speciality not found'], 404);
        }

        return response()->json($speciality);
    }
}
