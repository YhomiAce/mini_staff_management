<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Validator;

class DepartmentController extends Controller
{
    public function allDepartments()
    {
        $departments = Department::all();
        return response()->json(['departments'=> $departments], 200);
    }

    public function createDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments',
            'slug' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $department = Department::create([
            'name'=> $request->name,
            'slug'=> $request->slug,
        ]);
        return \response()->json([
            "message"=> "Department Added Successfully",
            "department"=> $department
        ], 201);
    }

    public function getDepartment(Department $department)
    {
        return response()->json(["department"=>$department], 200);
    }

    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update($request->all());
        return response()->json($department, 200);
    }

    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json(["message"=> "Department Deleted"], 200);
    }
}
