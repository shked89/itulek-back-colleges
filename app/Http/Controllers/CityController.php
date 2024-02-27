<?php

namespace App\Http\Controllers;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index()
    {
        return response()->json($this->cityService->getAll());
    }

    public function show($id)
    {
        return response()->json($this->cityService->getById($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return response()->json($this->cityService->create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return response()->json($this->cityService->update($id, $validated));
    }

    public function destroy($id)
    {
        $this->cityService->delete($id);
        return response()->json(null, 204);
    }
}