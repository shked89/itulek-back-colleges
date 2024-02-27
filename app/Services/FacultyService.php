<?php

namespace App\Services;
use App\Models\Faculty;

class FacultyService
{
    public function getAll()
    {
        return Faculty::all();
    }

    public function getById($id)
    {
        return Faculty::findOrFail($id);
    }

    public function create(array $data)
    {
        return Faculty::create($data);
    }

    public function update($id, array $data)
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->update($data);
        return $faculty;
    }

    public function delete($id)
    {
        $faculty = Faculty::findOrFail($id);
        $faculty->delete();
    }
}