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
    public function insertCollegeQualification(int $collegeId, int $qualificationId)
    {
        // Проверяем, существует ли уже запись с таким qualification_id
        $existingQualification = CollegeQualification::where('qualification_id', $qualificationId)->first();
    
        if ($existingQualification) {
            // Возвращаем сообщение об ошибке, если такая квалификация уже существует
            return response()->json(['error' => 'Такая квалификация уже существует'], 400);
        }
    
        // Если записи с таким qualification_id нет, создаем новую
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
            })->with(['collegeQualifications' => function ($query) {
                $query->select(['id AS ref_id', 'qualification_id']);
            }])->select(['qualifications.id as special_qual_id', 'qualifications.title', 'qualifications.qualification_code', 'qualifications.speciality_id']);
        }])->paginate(20); // количество элементов на страницу
    
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
    public function updateCollegeQualification(int $searchQualificationId, int $newCollegeId, int $newQualificationId): CollegeQualification
    {
        // Находим запись по qualification_id, который передан как id
        $collegeQualification = CollegeQualification::where('qualification_id', $searchQualificationId)->firstOrFail();
        
        // Обновляем найденную запись новыми значениями
        $collegeQualification->update([
            'college_id' => $newCollegeId,
            'qualification_id' => $newQualificationId,
        ]);
    
        return $collegeQualification;
    }

    //Удаление Квалификаций у колледжа

    public function deleteCollegeQualificationByQualificationId(int $qualificationId): bool
    {
        // Ищем все записи с указанным qualification_id
        $collegeQualifications = CollegeQualification::where('qualification_id', $qualificationId)->get();
    
        if ($collegeQualifications->isEmpty()) {
            // Возможно, вы хотите обработать случай, когда записи не найдены
            // Например, можно выбросить исключение или вернуть false
            return false;
        }
    
        // Проходим по всем найденным записям и удаляем их
        foreach ($collegeQualifications as $collegeQualification) {
            $collegeQualification->delete();
        }
    
        return true; // Возвращаем true, если удаление прошло успешно
    }
}
