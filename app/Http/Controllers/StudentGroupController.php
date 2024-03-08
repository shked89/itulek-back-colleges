<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentGroupService;

class StudentGroupController extends Controller
{
    protected $studentGroupService;

    public function __construct(StudentGroupService $groupService)
    {
        $this->studentGroupService = $groupService;
    }

    public function indexStudyGroup(Request $request)
    {
        $collegeId = $request->query('college_id');
    
        // Получаем параметры для пагинации из запроса или задаем значения по умолчанию
        $page = $request->query('page', 1); // Если 'page' не указан, используется первая страница
        $perPage = $request->query('per_page', 10); // Если 'per_page' не указан, по умолчанию выводится 10 элементов
    
        // Передаем параметры пагинации в сервис
        $result = $this->studentGroupService->getAllStudyGroups($collegeId, $page, $perPage);
    
        // Возвращаем результат
        return response()->json($result);
    }
    
}