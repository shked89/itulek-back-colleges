<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use App\Models\RefDepartmentToSpecialist;
use Illuminate\Support\Facades\DB;


class DepartmentService
{
    /**
     * Получает отделы с возможностью поиска по названию.
     *
     * @param string|null $searchTerm
     * @return Collection
     */
    public function searchDepartments(?string $searchTerm): Collection
    {
        if ($searchTerm) {
            return Department::where('caption', 'like', "%{$searchTerm}%")->get();
        } else {
            return Department::all();
        }
    }

    public function addDepartmentWithRelation($caption, $collegeId, $specialityId)
    {
        return DB::transaction(function () use ($caption, $collegeId, $specialityId) {
            $department = Department::create([
                'caption' => $caption,
                'college_id' => $collegeId,
            ]);

            RefDepartmentToSpecialist::create([
                'department_id' => $department->id,
                'speciality_id' => $specialityId,
                'college_id' => $collegeId,
            ]);

            return true;
        });
    }

    public function getDepartmentsWithDetailsPaginated($collegeId = null)
    {
        $query = RefDepartmentToSpecialist::with(['department', 'speciality']);

        // Фильтрация по college_id, если параметр передан
        if ($collegeId !== null) {
            $query = $query->whereHas('college', function ($q) use ($collegeId) {
                $q->where('id', $collegeId);
            });
        }

        // Фиксированное количество элементов на страницу
        $perPage = 15;

        return $query->paginate($perPage);
    }

    public function deleteDepartment($departmentId)
    {
        return DB::transaction(function () use ($departmentId) {
            // Удаление связанных данных
            RefDepartmentToSpecialist::where('department_id', $departmentId)->delete();
    
            // Удаление самого отделения
            Department::findOrFail($departmentId)->delete();
    
            return true;
        });
    }

    public function updateDepartment($departmentId, $caption, $collegeId, $specialityId)
    {
        return DB::transaction(function () use ($departmentId, $caption, $collegeId, $specialityId) {
            $department = Department::findOrFail($departmentId);
            $department->update([
                'caption' => $caption,
                'college_id' => $collegeId,
            ]);
    
            // Обновите это согласно определению вашего отношения
            RefDepartmentToSpecialist::where('department_id', $departmentId)->update([
                'speciality_id' => $specialityId,
                'college_id' => $collegeId,
            ]);
    
            // Используйте правильное имя отношения здесь
            return Department::with(['specialities', 'college'])->findOrFail($departmentId);
        });
    }
    

    


}