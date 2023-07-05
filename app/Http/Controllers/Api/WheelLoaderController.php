<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WheelLoader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class WheelLoaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wheelloader = WheelLoader::all();

        return response()->json([
            'status' => 'Berhasil',
            'data' => $wheelloader,
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
            "pekerjaan" => "required",
            "kapal" => "required|string",
            "no_palka" => "required|string",
            "kegiatan" => "required",
            "area" => "required",
            'time_start' => 'date_format:H:i',
            'time_end' => 'date_format:H:i|after:time_start'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Gagal',
                'message' => $validator->errors()
            ], 400);
        }

        $wheelloader = new WheelLoader();
        $wheelloader->no_order = $request->no_order;
        $wheelloader->pekerjaan = $request->pekerjaan;
        $wheelloader->kapal = $request->kapal;
        $wheelloader->no_palka = $request->no_palka;
        $wheelloader->kegiatan = $request->kegiatan;
        $wheelloader->area = $request->area;
        $wheelloader->time_start = $request->time_start;
        $wheelloader->time_end = $request->time_end;
        $wheelloader->save();

        return response()->json([
            'status' => 'berhasil',
            'data' => $wheelloader
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
