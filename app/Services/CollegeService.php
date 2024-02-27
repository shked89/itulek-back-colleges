<?php

namespace App\Services;

use App\Models\College;

class CollegeService
{
    public function getAll()
    {
        return College::all();
    }

    public function getById($id)
    {
        return College::findOrFail($id);
    }

    public function create(array $data)
    {
        return College::create($data);
    }

    public function update($id, array $data)
    {
        $college = College::findOrFail($id);
        $college->update($data);
        return $college;
    }

    public function delete($id)
    {
        $college = College::findOrFail($id);
        $college->delete();
        return $college;
    }
}