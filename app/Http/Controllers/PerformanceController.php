<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Performance;
use Validator;

class PerformanceController extends Controller
{
    public function getPerformanceForMonth(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $performance = Performance::where("month", $month)
                                    ->where('year', $year)
                                    ->orderBy('score', 'DESC')
                                    ->with('staff')
                                    ->get();
        return response()->json([ 'performances'=> $performance ]);
    }

    public function getPerformanceForYear(Request $request)
    {
        $year = $request->year;
        $performance = Performance::where("year", $year)
                                    ->orderBy('score', 'DESC')
                                    ->with('staff')
                                    ->get();
        return response()->json([ 'performances'=> $performance ]);
    }

    public function addPerformance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'month' => 'required|numeric|min:1|max:12',
            'year' => 'required|min:4|max:4',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $performance = Performance::create([
            "month"=>$request->month,
            "year"=>$request->year,
            "score"=>$request->score,
            "staff_id"=>$request->staff_id,
        ]);

        return response()->json([
            "message"=>"Score Added Successfully",
            "performance"=>$performance
        ]);
    }
}
