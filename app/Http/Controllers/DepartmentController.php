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
}
