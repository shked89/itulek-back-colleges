<?php

namespace App\Http\Controllers;

use App\Services\FacultyService;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    protected $facultyService;

    public function __construct(FacultyService $facultyService)
    {
        $this->facultyService = $facultyService;
    }

    public function index()
    {
        $faculties = $this->facultyService->getAll();
        return response()->json($faculties);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'caption' => 'required|string|max:255',
            'faculty_code' => 'required|string|max:255'
        ]);

        $faculty = $this->facultyService->create($validated);
        return response()->json($faculty, 201);
    }

    public function show($id)
    {
        $faculty = $this->facultyService->getById($id);
        return response()->json($faculty);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'caption' => 'required|string|max:255',
            'faculty_code' => 'required|string|max:255',
            // Добавьте другие поля и правила здесь
        ]);

        $faculty = $this->facultyService->update($id, $validated);
        return response()->json($faculty);
    }

    public function destroy($id)
    {
        $this->facultyService->delete($id);
        return response()->json(null, 204);
    }
}
