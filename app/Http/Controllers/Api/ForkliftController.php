<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Forklift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ForkliftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forklift = Forklift::all();

        return response()->json([
            "status" => "berhasil",
            "data" => $forklift
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
            "pekerjaan" => "string",
            // "kapal" => "string",
            // "no_palka" => "string",
            // "area" => "string",
            // 'time_start' => 'date_format:H:i',
            // 'time_end' => 'date_format:H:i|after:time_start'
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "Gagal",
                "message" => $validator->errors()
            ], 400);
        }

        $forklift = new Forklift();
        $forklift->no_order = $request->no_order;
        $forklift->pekerjaan = $request->pekerjaan;
        $forklift->kapal = $request->kapal;
        $forklift->no_palka = $request->no_palka;
        $forklift->kegiatan = $request->kegiatan;
        $forklift->area = $request->area;
        $forklift->time_start = $request->time_start;
        $forklift->time_end = $request->time_end;
        $forklift->save();

        return response()->json([
            "status" => "berhasil",
            "data" => $forklift
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
