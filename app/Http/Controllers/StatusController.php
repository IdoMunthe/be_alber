<?php

namespace App\Http\Controllers;

use App\Models\Excavator;
use App\Models\Forklift;
use App\Models\WheelLoader;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function status(Request $request){
        $current_timestamp = Carbon::now()->toDateTimeString();;
        if($request->jenis=='Excavator'){
            Excavator::where('id',$request->id)->update([
                'status'=>true,
                'approve_time'=>$current_timestamp
            ]);
        }
        if($request->jenis=='Forklift'){
            Forklift::where('id',$request->id)->update([
                'status'=>true,
                'approve_time'=>$current_timestamp
            ]);
        } 
        if($request->jenis=='Wheel Loader'){
            WheelLoader::where('id',$request->id)->update([
                'status'=>true,
                'approve_time'=>$current_timestamp
            ]);
        }

        return response()->json([
            'message'=>'berhasil'

        ]);
    }
}
