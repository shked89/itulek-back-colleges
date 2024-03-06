<?php

namespace App\Services;

use App\Models\Curriculum;

class CurriculumService
{
    public function createCurriculum($data)
    {
        // Проверка на существование Curriculum с такими же title, year, speciality_id, study_group_id и college_id
        $existingCurriculum = Curriculum::where('title', $data['title'])
            ->where('year', $data['year'])
            ->where('speciality_id', $data['speciality_id'])
            ->where('study_group_id', $data['study_group_id'])
            ->where('college_id', $data['college_id'])
            ->first();

        if ($existingCurriculum) {
            return ['error' => 'Curriculum with the provided title and data already exists.'];
        }

        $curriculum = Curriculum::create($data);
        return $curriculum;
    }
}
