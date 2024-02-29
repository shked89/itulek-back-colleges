<?php

namespace App\Services;

use App\Models\CollegeQualification;
use App\Models\College;
use App\Models\Qualification;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Speciality;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CollegeQualificationService
{
    /**
     *
     * @param int $collegeId
     * @param int $qualificationId
     * @return CollegeQualification
     */
    //Вставка Данных
    public function insertCollegeQualification(int $collegeId, int $qualificationId): CollegeQualification
    {
        $collegeQualification = new CollegeQualification([
            'college_id' => $collegeId,
            'qualification_id' => $qualificationId,
        ]);

        $collegeQualification->save();

        return $collegeQualification;
    }

    /**
     *
     * @param int $collegeId
     * @return Collection
     * 
     */
    //Вывод Квалификаций на главную страницу 
    public function getSpecialitiesWithQualificationsByCollege(int $collegeId): LengthAwarePaginator
    {
        $specialities = Speciality::whereHas('qualifications.collegeQualifications', function ($query) use ($collegeId) {
            $query->where('college_id', $collegeId);
        })->with(['qualifications' => function ($query) use ($collegeId) {
            $query->whereHas('collegeQualifications', function ($query) use ($collegeId) {
                $query->where('college_id', $collegeId);
            });
        }])->paginate(20);  // кол-во элементов на страницу

        return $specialities;
    }

    //Поиск Специальностей

    public function searchSpecialities(?string $searchTerm): Collection
    {
        $query = Speciality::query();

        if ($searchTerm) {
            $query->where('title', 'like', "%{$searchTerm}%")
                ->orWhere('speciality_code', 'like', "%{$searchTerm}%");
        }

        return $query->get();
    }



    // public function searchSpecialities(?string $searchTerm): Collection
    // {
    //     $query = Speciality::query();

    //     if ($searchTerm) {
    //         $query->where('title', 'like', "%{$searchTerm}%")
    //             ->orWhere('speciality_code', 'like', "%{$searchTerm}%");
    //     }

    //     return $query->with('qualifications')->get();
    // }

    /**
     *
     * @param  int|null  $specialityId
     * @param  string|null  $searchTerm
     * @return Collection
     */
    //Поиск Квалификации по специальности
    public function getQualificationsBySpecialityAndSearch(?int $specialityId, ?string $searchTerm): Collection
    {
        $query = Qualification::with('speciality');

        if ($specialityId !== null) {
            $query->where('speciality_id', $specialityId);
        }

        if ($searchTerm) {
            $query->where('title', 'like', "%{$searchTerm}%");
        }

        return $query->get();
    }
    //Обновление Квалификаций у колледжа
    public function updateCollegeQualification(int $id, int $collegeId, int $qualificationId): CollegeQualification
    {
        $collegeQualification = CollegeQualification::findOrFail($id);
        $collegeQualification->update([
            'college_id' => $collegeId,
            'qualification_id' => $qualificationId,
        ]);

        return $collegeQualification;
    }

    //Удаление Квалификаций у колледжа

    public function deleteCollegeQualification(int $id): bool
    {
        $collegeQualification = CollegeQualification::findOrFail($id);
        return $collegeQualification->delete();
    }
}
