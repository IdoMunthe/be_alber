<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Excavator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ExcavatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $excavator = Excavator::all();

        return response()->json([
            'status' => 'Berhasil',
            'data' => $excavator
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "no_order" => "required|string",
            "pekerjaan" => "required|string",
            "kapal" => "nullable|string",
            "no_palka" => "nullable|numeric",
            'kegiatan' => "nullable|string",
            'area' => "nullable|string",
            'time_start' => 'date_format:H:i',
            'time_end' => 'date_format:H:i|after:time_start'
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Gagal',
                'message' => $validator->errors()
            ], 400);
        }

        $excavator = new Excavator();
        $excavator->no_order = $request->no_order;
        $excavator->pekerjaan = $request->pekerjaan;
        $excavator->kapal = $request->kapal;
        $excavator->no_palka = $request->no_palka;
        $excavator->kegiatan = $request->kegiatan;
        $excavator->area = $request->area;
        $excavator->time_start = $request->time_start;
        $excavator->time_end = $request->time_end;
        $excavator->save();

        return response()->json([
            'status' => 'berhasil',
            'data' => $excavator
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
}
