<?php

namespace App\Http\Controllers;

use App\Models\AlberVisualization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlberVisualizationController extends Controller
{
    // Method to fetch all visualizations
    public function index()
    {
        $visualizations = DB::table('alber_visualization')->get();
        return response()->json($visualizations);
    }

    // Method to update the color of a specific alber_id
    public function update(Request $request, $id)
    {
        $request->validate([
            'color' => 'required'
        ]);

        DB::table('alber_visualization')
        ->where('alber_id', $id)
        ->update(['color' => $request->color]);

        return response()->json(['message' => 'color updated successfully']);
    }

}
