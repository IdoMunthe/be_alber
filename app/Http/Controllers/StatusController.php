<?php

namespace App\Http\Controllers;

use App\Models\Excavator;
use App\Models\Forklift;
use App\Models\WheelLoader;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function status(Request $request){
        if($request->jenis=='Excavator'){
            Excavator::where('id',$request->id)->update([
                'status'=>true
            ]);
        }
        if($request->jenis=='Forklift'){
            Forklift::where('id',$request->id)->update([
                'status'=>true
            ]);
        } 
        if($request->jenis=='Wheel Loader'){
            WheelLoader::where('id',$request->id)->update([
                'status'=>true
            ]);
        }

        return response()->json([
            'message'=>'berhasil'

        ]);
    }
}
