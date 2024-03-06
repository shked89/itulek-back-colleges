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

    public function updateDisciplineMethod(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer', // Валидация идентификатора дисциплины
            'caption' => 'required|string',
            'discipline_type_id' => 'required|integer',
            'college_id' => 'required|integer',
            'department_id' => 'required|integer',
        ]);

        $id = $data['id']; // Извлекаем идентификатор дисциплины из данных запроса

        $result = DisciplineService::updateDisciplineAndLinkToDepartment($id, $data);

        if (!$result) {
            // Обработка случая, если дисциплина не найдена или другая ошибка
            return response()->json(['message' => 'Дисциплина не найдена или ошибка обновления'], 404);
        }

        return response()->json(['message' => 'Дисциплина и связь успешно обновлены', 'data' => $result], 200);
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
