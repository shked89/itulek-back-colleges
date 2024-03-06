<?php

namespace App\Services;

use App\Models\Discipline;
use App\Models\DisciplineType;
use App\Models\RefDepartmentToDiscipline;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Log;

class DisciplineService
{
    /**
     *
     * @param array $data
     * @return Discipline
     */

        public static function createDisciplineAndLinkToDepartment($data)
        {
            return DB::transaction(function () use ($data) {
                // Создание дисциплины без department_id
                $discipline = Discipline::create([
                    'caption' => $data['caption'],
                    'discipline_type_id' => $data['discipline_type_id'],
                    'college_id' => $data['college_id'],
                ]);
    
                // Создание записи связи в ref_department_to_discipline
                $ref = RefDepartmentToDiscipline::create([
                    'department_id' => $data['department_id'],
                    'discipline_id' => $discipline->id,
                ]);

    
                return compact('discipline', 'ref');
            });
        }
 



    public function getAllDisciplinesWithRelations(int $collegeId = null): LengthAwarePaginator
    {
        $query = Discipline::with(['departments', 'discipline_type', 'college']);

        if ($collegeId) {
            $query->where('college_id', $collegeId);
        }

        return $query->paginate(10);
    }

    public function getDisciplineTypes(?string $searchTerm): Collection
    {
        $query = DisciplineType::query();

        if (!is_null($searchTerm)) {
            $query->where('title', 'like', "%{$searchTerm}%");
        }

        return $query->get();
    }
    
    

    // public function updateDisciplineNew(int $id, array $data)
    // {
    //     return DB::transaction(function () use ($id, $data) {
    //         // Находим и обновляем дисциплину
    //         $discipline = Discipline::find($id);
    //         if (!$discipline) {
    //             // Обработка случая, если дисциплина не найдена
    //             return null;
    //         }
    //         $discipline->update([
    //             'caption' => $data['caption'],
    //             'discipline_type_id' => $data['discipline_type_id'],
    //             'college_id' => $data['college_id'],
    //         ]);
    
    //         // Находим и обновляем запись связи. Предполагаем, что между департаментом и дисциплиной существует уникальная связь.
    //         $ref = RefDepartmentToDiscipline::where('discipline_id', $id)->first();
    //         if ($ref) {
    //             $ref->update([
    //                 'department_id' => $data['department_id'],
    //             ]);
    //         } else {
    //             // Если запись связи не найдена, создаем новую
    //             $ref = RefDepartmentToDiscipline::create([
    //                 'department_id' => $data['department_id'],
    //                 'discipline_id' => $discipline->id,
    //             ]);
    //         }
    
    //         return compact('discipline', 'ref');
    //     });
    // }

    public static function updateDisciplineAndLinkToDepartment($id, $data)
{
    return DB::transaction(function () use ($id, $data) {
        // Находим и обновляем дисциплину
        $discipline = Discipline::find($id);
        if (!$discipline) {
            // Обработка случая, если дисциплина не найдена
            return null;
        }
        $discipline->update([
            'caption' => $data['caption'],
            'discipline_type_id' => $data['discipline_type_id'],
            'college_id' => $data['college_id'],
        ]);

        // Находим и обновляем запись связи. Предполагаем, что между департаментом и дисциплиной существует уникальная связь.
        $ref = RefDepartmentToDiscipline::where('discipline_id', $id)->first();
        if ($ref) {
            $ref->update([
                'department_id' => $data['department_id'],
            ]);
        } else {
            // Если запись связи не найдена, создаем новую
            $ref = RefDepartmentToDiscipline::create([
                'department_id' => $data['department_id'],
                'discipline_id' => $discipline->id,
            ]);
        }

        return compact('discipline', 'ref');
    });
}
   
   /**
    * Удаляет дисциплину и связанные с ней данные из ref_department_to_discipline.
    *
    * @param int $id ID дисциплины для удаления
    * @return bool Возвращает true, если удаление прошло успешно
    */
   public function deleteDiscipline(int $id): bool
   {
       return DB::transaction(function () use ($id) {
           // Удаляем связанные данные из ref_department_to_discipline
           DB::table('college.ref_department_to_discipline')->where('discipline_id', $id)->delete();
   
           // Теперь удаляем саму дисциплину
           $discipline = Discipline::findOrFail($id);
           return $discipline->delete();
       });
   }
}
