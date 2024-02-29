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
    
    
    /** 
    * @param int $id ID дисциплины для обновления
    * @param array $data Новые данные для дисциплины
    * @return Discipline Обновленная модель дисциплины
    */
    public function updateDiscipline(int $id, array $data)
    {

        

        return DB::transaction(function () use ($id, $data) {
            $discipline = Discipline::findOrFail($id);
            $discipline->update($data);
    
            // Предполагая, что $data['department_ids'] содержит массив ID департаментов
            if (isset($data['department_ids'])) {
                // Обновляем связи в college.ref_department_to_discipline
                // Сначала удаляем старые связи
                DB::table('college.ref_department_to_discipline')->where('discipline_id', $id)->delete();
                // Добавляем новые связи
                foreach ($data['department_ids'] as $departmentId) {
                    DB::table('college.ref_department_to_discipline')->insert([
                        'discipline_id' => $id,
                        'department_id' => $departmentId,
                    ]);
                    
                }
                
            }

    
            return $discipline;
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
