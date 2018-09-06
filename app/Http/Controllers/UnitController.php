<?php

namespace App\Http\Controllers;

use App\unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = auth()->user()->units;
 
        return response()->json([
            'success' => true,
            'data' => $units
        ]);
    }
 
    public function show($id)
    {
        $unit = auth()->user()->units()->find($id);
 
        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'Unit with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $unit->toArray()
        ], 400);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'unit_name' => 'required',
            'description' => 'required|string'
        ]);
 
        $unit = new unit();
        $unit->unit_name = $request->unit_name;
        $unit->description = $request->description;
 
        if (auth()->user()->units()->save($unit))
            return response()->json([
                'success' => true,
                'data' => $unit->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'unit could not be added'
            ], 500);
    }
 
    public function update(Request $request, $id)
    {
        $unit = auth()->user()->units()->find($id);
 
        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'unit with id ' . $id . ' not found'
            ], 400);
        }
 
        $updated = $unit->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'unit could not be updated'
            ], 500);
    }
 
    public function destroy($id)
    {
        $unit = auth()->user()->units()->find($id);
 
        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'unit with id ' . $id . ' not found'
            ], 400);
        }
 
        if ($unit->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'unit could not be deleted'
            ], 500);
        }
    }
}