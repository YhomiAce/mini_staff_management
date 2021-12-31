<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Validator;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Staff::with("department")->orderBy("name", "asc")->get();
        return response()->json([
        "status" => "success",
        "status_code"=> 200,
        "data" => $staff
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:staff'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $staff = Staff::create([
            'name'=> $request->name,
            'email'=> $request->email,
        ]);
        return \response()->json([
            "status" => "success",
            "status_code"=> 201,
            "message"=> "Staff created Successfully",
            "staff"=> $staff
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        $staff->department;
        return response()->json([
            "status" => "success",
            "status_code"=> 200,
            "staff"=>$staff
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $staff->update($request->all());
        return response()->json([
            "status" => "success",
            "status_code"=> 201,
            "staff"=>$staff
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return response()->json([
            "status" => "success",
            "status_code"=> 200,
            "message"=> "Staff Deleted"
        ], 200);
    }


}
