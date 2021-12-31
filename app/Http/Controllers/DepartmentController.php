<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Staff;
use Validator;

class DepartmentController extends Controller
{
    public function allDepartments()
    {
        $departments = Department::all();
        return response()->json([
            "status" => "success",
            "status_code"=> 200,
            'departments'=> $departments
        ], 200);
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
            "status" => "success",
            "status_code"=> 201,
            "message"=> "Department Added Successfully",
            "department"=> $department
        ], 201);
    }

    public function getDepartment(Department $department)
    {
        return response()->json([
            "status" => "success",
            "status_code"=> 200,
            "department"=>$department
        ], 200);
    }

    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update($request->all());
        return response()->json([
            "status" => "success",
            "status_code"=> 200,
            "department"=>$department
        ], 200);
    }

    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json([
            "status" => "success",
            "status_code"=> 200,
            "message"=> "Department Deleted"
        ], 200);
    }

    public function addStaffToDepartment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'staff_id' => 'required',
                'department_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $staffId = $request->staff_id;
            $deptId = $request->department_id;

            $staff = Staff::findOrFail($staffId);
            $dept = Department::findOrFail($deptId);

            $staff->department()->attach($deptId);
            $staffDept = $staff->department;
            return \response()->json([
                "status" => "success",
                "status_code"=> 200,
                "messag" => "Staff Added to department",
                "staff" => $staff
            ]);
        } catch (\Illuminate\Database\QueryException $err) {
            return \response()->json([
                "message"=> "Server Error: An Error occurred because a staff can no have the same department twice"
            ]);
        }


    }

    public function removeStaffFromDepartment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'staff_id' => 'required',
                'department_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $staffId = $request->staff_id;
            $deptId = $request->department_id;

            $staff = Staff::findOrFail($staffId);
            $dept = Department::findOrFail($deptId);

            $staff->department()->detach($deptId);
            $staffDept = $staff->department;
            return \response()->json([
                "status" => "success",
                "status_code"=> 200,
                "messag" => "Staff Added to department",
                "staff" => $staff
            ]);
        } catch (\Illuminate\Database\QueryException $err) {
            return \response()->json([
                "message"=> "Server Error: An Error occurred because a staff can no have the same department twice"
            ]);
        }


    }

    public function makeHeadOfDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'department_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $staffId = $request->staff_id;
        $deptId = $request->department_id;
        $dept = Department::findOrFail($deptId);
        $staffs = $dept->staff;
        foreach($staffs as $staff)
        {
            $staff->unMakeHod();
        }
        $employee = Staff::findOrFail($staffId);

        $employee->makeHod();
        return \response()->json([
            "status" => "success",
            "status_code"=> 200,
            "message" => "Appointed as Head of Department",
            "staff" => $employee
        ]);
    }

    public function unMakeHeadOfDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'department_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $staffId = $request->staff_id;
        $deptId = $request->department_id;
        $dept = Department::findOrFail($deptId);

        $employee = Staff::findOrFail($staffId);

        $employee->unMakeHod();
        return \response()->json([
            "status" => "success",
            "status_code"=> 200,
            "message" => "Remove as Head of Department",
            "staff" => $employee
        ]);
    }
}
