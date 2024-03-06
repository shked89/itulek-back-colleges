<?php

namespace App\Http\Controllers;

use App\Services\CollegeQualificationService;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CollegeQualificationController extends Controller
{
    protected $collegeQualificationService;

    public function __construct(CollegeQualificationService $collegeQualificationService)
    {
        $this->collegeQualificationService = $collegeQualificationService;
    }

    //Метод добавления Квалификаций
    public function storeQualification(Request $request)
    {
        $collegeId = $request->query('college_id');
        $qualificationId = $request->query('qualification_id');

        if (!$collegeId || !$qualificationId) {
            return response()->json(['error' => 'Необходимы college_id и qualification_id'], 400);
        }

        $collegeQualification = $this->collegeQualificationService->insertCollegeQualification($collegeId, $qualificationId);

        return response()->json($collegeQualification, 201);
    }
    //Метод Вывода Квалификаций на главную страницу

    public function getQualificationsByCollege(Request $request)
    {
        $collegeId = $request->query('college_id');
    
        if (!$collegeId) {
            return response()->json(['error' => 'Необходим college_id'], 400);
        }
    
        $collegeId = (int) $collegeId;
        $qualifications = $this->collegeQualificationService->getSpecialitiesWithQualificationsByCollege($collegeId);
    
        return response()->json($qualifications);
    }
    //Вывод Специальностей по поиску на главную страницу
    public function indexSpecialities(Request $request)
    {

        $searchTerm = $request->query('search');
        $specialities = $this->collegeQualificationService->searchSpecialities($searchTerm);

        return response()->json($specialities);
    }
    //Вывод Квалификаций по специальностям и поиску

    public function indexQalifications(Request $request)
    {
        $specialityId = $request->query('speciality_id');
        $specialityId = $specialityId !== null ? (int) $specialityId : null;
        $searchTerm = $request->query('search');

        $qualifications = $this->collegeQualificationService->getQualificationsBySpecialityAndSearch($specialityId, $searchTerm);

        return response()->json($qualifications);
    }

    //Обновление Квалификаций

    public function updateQualification(Request $request)
    {
        $id = $request->query('id');
        $collegeId = $request->query('college_id');
        $qualificationId = $request->query('qualification_id');

        if (!$id || !$collegeId || !$qualificationId) {
            return response()->json(['error' => 'Необходимы id, college_id и qualification_id'], 400);
        }

        $collegeQualification = $this->collegeQualificationService->updateCollegeQualification($id, $collegeId, $qualificationId);

        return response()->json($collegeQualification, 200);
    }

    //Удаление Квалификаций

    public function deleteQualification(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            return response()->json(['error' => 'Необходим id'], 400);
        }

        $deleted = $this->collegeQualificationService->deleteCollegeQualificationByQualificationId($id);

        if ($deleted) {
            return response()->json(['message' => 'Запись успешно удалена'], 200);
        } else {
            return response()->json(['error' => 'Запись не найдена'], 404);
        }
    }
}
