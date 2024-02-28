<?php

namespace App\Http\Controllers;

use App\Services\CollegeService;
use Illuminate\Http\Request;
use App\Services\CollegeQualificationService;



class CollegeController extends Controller
{
    protected $collegeService;      
    protected $collegeQualificationService;

    public function __construct(CollegeService $collegeService, CollegeQualificationService $collegeQualificationService)
    {
        $this->collegeService = $collegeService;
        $this->collegeQualificationService = $collegeQualificationService;
    }
    


    public function index()
    {
        $colleges = $this->collegeService->getAll();
        return response()->json($colleges);
    }

    public function show($id)
    {
        $college = $this->collegeService->getById($id);
        return response()->json($college);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $college = $this->collegeService->create($validated);
        return response()->json($college, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $college = $this->collegeService->update($id, $validated);
        return response()->json($college);
    }

    public function destroy($id)
    {
        $this->collegeService->delete($id);
        return response()->json(null, 204);
    }
}
