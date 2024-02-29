<?php

namespace App\Http\Controllers;

use App\Models\DisciplineType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DisciplineService;
use Illuminate\Support\Facades\Validator;

class DisciplineController  extends Controller
{
    protected $disciplineService;

    public function __construct(DisciplineService $disciplineService)
    {
        $this->disciplineService = $disciplineService;
    }


    //Создание новой дисциплины для своего колледжа
    public function createDisciplinesToCollege(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'caption' => 'required|string',
            'discipline_type_id' => 'required|integer',
            'department_id' => 'required|integer',
            'college_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $validator->validated();

        $discipline = $this->disciplineService->createDisciplineAndLinkToDepartment($data);

        return response()->json($discipline, 201);
    }

    //Вывод всех Дисциплин Колледжа с пагинацией
    public function indexDisciplinesMain(Request $request)
    {
        $collegeId = $request->query('college_id');

        $disciplines = $this->disciplineService->getAllDisciplinesWithRelations($collegeId);

        return response()->json($disciplines);
    }

    //Вывод типов дисциплин
    public function indexDisciplineType(Request $request)
    {
        $searchTerm = $request->query('search');
        $disciplineTypes = $this->disciplineService->getDisciplineTypes($searchTerm);

        return response()->json($disciplineTypes);
    }

    public function updateDiscipline(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'id' => 'required|integer|exists:disciplines,id',
            'caption' => 'sometimes|string',
            'discipline_type_id' => 'sometimes|integer',
            'department_id' => 'sometimes|integer',
            'college_id' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $validator->validated();
        $id = $data['id'];
        unset($data['id']); // Удаляем ID из данных для обновления

        $discipline = $this->disciplineService->updateDiscipline($id, $data);

        return response()->json($discipline);
    }

    public function deleteDiscipline(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            return response()->json(['error' => 'ID is required'], 400);
        }

        $success = $this->disciplineService->deleteDiscipline($id);

        if ($success) {
            return response()->json(['message' => 'Discipline deleted successfully']);
        } else {
            return response()->json(['error' => 'Discipline not found'], 404);
        }
    }
}
