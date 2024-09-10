<?php

namespace App\Http\Controllers;

use App\Models\Alber;
use App\Models\Excavator;
use App\Models\Forklift;
use App\Models\WheelLoader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function historyOrder(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $action = $request->action; // Action from the frontend (e.g 'submit_new_request')
        $alberId = $request->id; // WE NEED TO LOOK AT THIS, THERE IS A POSSIBLE ERROR IN THE FUTURE

        $current_timestamp = Carbon::now()->toDateTimeString();

        $statusMap = [
            // 'submit_new_request' => 'Order Request',
            'request_accepted' => 'Manage Alber',
            'managed_alber' => 'Checklist',
            'alber_to_hatch' => 'Alber To Hatch',
            'start_working' => 'Start working',
            'on_working' => 'On Working',
            'stop_working' => 'Stop Working',
            'check_maintenance' => 'Check Maintenance',
            'start_repair' => 'Start Repair',
            'finish_repair' => 'Finish Repair',
        ];

        // Validate the action
        if (!array_key_exists($action, $statusMap)) {
            return response()->json(['error' => 'Invalid action'], 400);
        }

        DB::table('statuses')->insert([
            'alber_id' => $alberId,
            'status' => $statusMap[$action],
            'status_time' => $current_timestamp,
            'pic' => auth()->user()->name,
        ]);

        Alber::where('id', $request->id)->update([
            'status' => $statusMap[$action],
            'status_time' => $current_timestamp
        ]);
        // if($request->jenis=='Excavator'){
        //     Excavator::where('id',$request->id)->update([
        //         'status'=>true,
        //         'approve_time'=>$current_timestamp
        //     ]);
        // }
        // if($request->jenis=='Forklift'){
        //     Forklift::where('id',$request->id)->update([
        //         'status'=>true,
        //         'approve_time'=>$current_timestamp
        //     ]);
        // } 
        // if($request->jenis=='Wheel Loader'){
        //     WheelLoader::where('id',$request->id)->update([
        //         'status'=>true,
        //         'approve_time'=>$current_timestamp
        //     ]);
        // }

        return response()->json([
            'message' => 'status updated successfully',
            'status' => $statusMap[$action],
            'status_time' => $current_timestamp,
            'pic' => auth()->user()->name,
            'pic_role' => auth()->user()->role
        ]);
    }
}
