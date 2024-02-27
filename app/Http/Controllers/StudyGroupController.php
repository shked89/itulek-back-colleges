<?php

namespace App\Http\Controllers;
use App\Services\StudyGroupService;
use Illuminate\Http\Request;

class StudyGroupController extends Controller
{
    protected $studyGroupService;

    public function __construct(StudyGroupService $studyGroupService)
    {
        $this->studyGroupService = $studyGroupService;
    }

    public function index()
    {
        return response()->json($this->studyGroupService->getAll());
    }

    public function show($id)
    {
        return response()->json($this->studyGroupService->getById($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'study_group_title' => 'required|string|max:255',
            'language_iso' => 'required|string|max:2',
            'faculty_id' => 'required|exists:college.faculties,id',
        ]);

        return response()->json($this->studyGroupService->create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'study_group_title' => 'required|string|max:255',
            'language_iso' => 'required|string|max:2',
            'faculty_id' => 'required|exists:college.faculties,id',
        ]);

        return response()->json($this->studyGroupService->update($id, $validated));
    }

    public function destroy($id)
    {
        $this->studyGroupService->delete($id);
        return response()->json(null, 204);
    }
}
