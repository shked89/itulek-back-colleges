<?php

namespace App\Http\Controllers;
use App\Services\CollegeAddressService;
use Illuminate\Http\Request;

class CollegeAddressController extends Controller
{
    protected $collegeAddressService;

    public function __construct(CollegeAddressService $collegeAddressService)
    {
        $this->collegeAddressService = $collegeAddressService;
    }

    public function index()
    {
        return response()->json($this->collegeAddressService->getAll());
    }

    public function show($id)
    {
        return response()->json($this->collegeAddressService->getById($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:college.colleges,id',
            'country_name' => 'required|string|max:255',
            'city_id' => 'required|exists:college.cities,id',
            'address_name' => 'required|string|max:255',
        ]);

        return response()->json($this->collegeAddressService->create($validated), 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:college.colleges,id',
            'country_name' => 'required|string|max:255',
            'city_id' => 'required|exists:college.cities,id',
            'address_name' => 'required|string|max:255',
        ]);

        return response()->json($this->collegeAddressService->update($id, $validated));
    }

    public function destroy($id)
    {
        $this->collegeAddressService->delete($id);
        return response()->json(null, 204);
    }
}