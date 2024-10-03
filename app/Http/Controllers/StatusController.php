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

        $action = $request->action;
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

    public function getAlberStatusById($alberId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Fetch the latest status of the specific alber using the alberId
        $status = DB::table('statuses')
        ->where('alber_id', $alberId)
            ->orderBy('status_time', 'desc')
            ->first(); // Get the most recent record

        // If no status found, return an appropriate message
        if (!$status) {
            return response()->json(['error' => 'No status found for this alber'], 404);
        }

        return response()->json([
            'alber_id' => $alberId,
            'status' => $status->status,
            'status_time' => $status->status_time,
            'pic' => $status->pic
        ]);
    }

    public function getFinishedAlbers()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Retrieve all albers with the status 'Stop Working'
        $finishedAlbers = Alber::where('status', 'Stop Working')->get();

        if ($finishedAlbers->isEmpty()) {
            return response()->json(['message' => 'No finished albers found'], 404);
        }

        // Return the finished albers
        return response()->json($finishedAlbers);
    }

}
