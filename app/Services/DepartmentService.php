<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

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
}