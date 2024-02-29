<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    /**
     * Вывод всех отделов с возможностью поиска по названию.
     */
    public function indexDepartments(Request $request)
    {
        $searchTerm = $request->query('search');
        $departments = $this->departmentService->searchDepartments($searchTerm);
        return response()->json($departments);
    }

    public function addDepartment(Request $request)
    {
        $result = $this->departmentService->addDepartmentWithRelation(
            $request->query('caption'),
            $request->query('college_id'),
            $request->query('speciality_id')
        );

        if ($result) {
            // В случае успеха возвращаем пустой JSON объект или подтверждение успеха
            return response()->json(['success' => true], 200);
        } else {
            // В случае ошибки возвращаем пустой JSON объект или информацию об ошибке
            return response()->json(['success' => false], 500);
        }
    }

    public function getDepartments(Request $request)
    {
        $collegeId = $request->query('college_id'); // Получаем college_id из query параметра

        $data = $this->departmentService->getDepartmentsWithDetailsPaginated($collegeId);

        return response()->json($data);
    }

    public function deleteDepartment(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|integer'
        ]);

        $result = $this->departmentService->deleteDepartment($validated['department_id']);

        if ($result) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 500);
        }
    }

    public function updateDepartment(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|integer',
            'caption' => 'required|string',
            'college_id' => 'required|integer',
            'speciality_id' => 'required|integer' // Убедитесь, что этот параметр действительно необходим
        ]);
    
        $updatedDepartment = $this->departmentService->updateDepartment(
            $validated['department_id'],
            $validated['caption'],
            $validated['college_id'],
            $validated['speciality_id']
        );
    
        if ($updatedDepartment) {
            // Возвращаем измененный массив данных
            return response()->json(['success' => true, 'updatedDepartment' => $updatedDepartment], 200);
        } else {
            return response()->json(['success' => false], 500);
        }
    }
}
