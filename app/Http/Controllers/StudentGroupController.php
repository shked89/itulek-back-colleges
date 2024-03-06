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
        $result = $this->studentGroupService->getAllStudyGroups($collegeId);

        return response()->json($result);
    }
}
