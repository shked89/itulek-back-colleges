<?php

namespace App\Services;

use App\Models\CollegeAddress;


class CollegeAddressService
{
    public function getAll()
    {
        return CollegeAddress::all();
    }

    public function getById($id)
    {
        return CollegeAddress::findOrFail($id);
    }

    public function create(array $data)
    {
        return CollegeAddress::create($data);
    }

    public function update($id, array $data)
    {
        $collegeAddress = CollegeAddress::findOrFail($id);
        $collegeAddress->update($data);
        return $collegeAddress;
    }

    public function delete($id)
    {
        $collegeAddress = CollegeAddress::findOrFail($id);
        $collegeAddress->delete();
    }
}