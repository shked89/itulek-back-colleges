<?php

namespace App\Services;
use App\Models\StudyGroup;


class StudyGroupService
{
    public function getAll()
    {
        return StudyGroup::all();
    }

    public function getById($id)
    {
        return StudyGroup::findOrFail($id);
    }

    public function create(array $data)
    {
        return StudyGroup::create($data);
    }

    public function update($id, array $data)
    {
        $studyGroup = StudyGroup::findOrFail($id);
        $studyGroup->update($data);
        return $studyGroup;
    }

    public function delete($id)
    {
        $studyGroup = StudyGroup::findOrFail($id);
        $studyGroup->delete();
    }
}