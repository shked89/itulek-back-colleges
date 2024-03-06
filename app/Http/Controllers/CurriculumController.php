<?php

namespace App\Http\Controllers;

use App\Services\CurriculumService;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    protected $curriculumService;

    public function __construct(CurriculumService $curriculumService)
    {
        $this->curriculumService = $curriculumService;
    }

    public function create(Request $request)
    {
        $validated = $request->query();
        
        $validated = $request->validate([
            'title' => 'required|string',
            'year' => 'required|string',
            'speciality_id' => 'required|integer',
            'study_group_id' => 'required|integer',
            'college_id' => 'required|integer'
        ]);

        // Создание Curriculum через сервис с проверкой на уникальность
        $result = $this->curriculumService->createCurriculum($validated);
        // Проверка на ошибку из сервиса
        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 409); // Конфликт
        }

        return response()->json(['message' => 'Curriculum created successfully', 'data' => $result]);
    }
}
