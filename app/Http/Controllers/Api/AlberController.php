<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Alber;
use App\Models\Status;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AlberController extends Controller
{
    public function index()
    {
        $excavator = Alber::all();

        return response()->json([
            'status' => 'Berhasil',
            'data' => $excavator
        ], 200);
    }

    public function requestAlber(Request $request)
    {
        try {
            $request->validate([
                'jenis_alber' => 'required|string',
                // 'no_order' => 'required|string',
                'pekerjaan' => 'required|string',
                "kapal" => "nullable|string",
                "no_palka" => "nullable|numeric",
                'kegiatan' => "nullable|string",
                'area' => "nullable|string",
                "no_lambung" => "nullable|numeric",
                "operator" => "nullable|string",
                'time_start' => 'date_format:H:i',
                'time_end' => 'date_format:H:i|after:time_start',
                // 'time_start' => 'required|date_format:Y-m-d H:i:s',
                // 'time_end' => 'required|date_format:Y-m-d H:i:s',
                // 'status' => 'nullable|string',
                // 'status_time' => 'nullable|date_format:Y-m-d H:i:s'
            ]);

            // Define the template for each jenis_alber
            $prefixes = [
                'Wheel Loader' => 'PO-WD-',
                'Excavator' => 'PO-EX-',
                'Forklift' => 'PO-FO-',
            ];

            // Find the current count of albers with the same jenis_alber
            $count = Alber::where('jenis_alber', $request->jenis_alber)->count();

            // Increment the count for the new order number
            $newOrderNumber = $count + 1;

            // Generate the no_order based on the prefix and the incremented number
            $no_order = $prefixes[$request->jenis_alber] . str_pad($newOrderNumber, 3, '0', STR_PAD_LEFT);


            $alber = new Alber();
            $alber->jenis_alber = $request->jenis_alber;
            $alber->no_order = $no_order;
            $alber->pekerjaan = $request->pekerjaan;
            $alber->kapal = $request->kapal;
            $alber->no_palka = $request->no_palka;
            $alber->kegiatan = $request->kegiatan;
            $alber->area = $request->area;
            $alber->no_lambung = $request->no_lambung;
            $alber->operator = $request->operator;
            $alber->time_start = $request->time_start;
            $alber->time_end = $request->time_end;
            $alber->requested_by = auth()->user()->name;
            $alber->save();

            // dd($request->all()); // Dump and die to inspect the request data

            $current_timestamp = Carbon::now()->toDateTimeString();

            DB::table('statuses')->insert([
                'alber_id' => $alber->id,
                'status' => 'Order Request',
                'status_time' => $current_timestamp,
                'pic' => auth()->user()->name,
            ]);

            Alber::where('id', $alber->id)->update([
                'status' => 'Order Request',
                'status_time' => $current_timestamp
            ]);

            return response()->json([
                'message' => 'alber successfully requested',
                'data' => $alber
            ]);


            // DB::table('albers')->truncate();
        } catch (\Exception $e) {
            // Debug: Output exception message
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function manageAlber(Request $request)
    {
        try {
            Alber::where('id', $request->id)->update([
                'no_lambung' => $request->no_lambung,
                'operator' => $request->operator
            ]);

            return response()->json([
                'message' => 'data updated successfully',
                'no_lambung' => $request->no_lambung,
                'operator' => $request->operator
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function getNextOrder($jenis_alber)
    {
        // Define the template for each jenis_alber
        $prefixes = [
            'Wheel Loader' => 'PO-WD-',
            'Excavator' => 'PO-EX-',
            'Forklift' => 'PO-FO-',
        ];

        // Validate that jenis_alber exists in prefixes
        if (!array_key_exists($jenis_alber, $prefixes)) {
            return response()->json(['error' => 'Invalid jenis_alber'], 400); // Return 400 for bad request
        }

        // Get the latest no_order for the specific jenis_alber
        $latestOrder = Alber::where('jenis_alber', $jenis_alber)
            ->orderBy('no_order', 'desc')
            ->first();

        if ($latestOrder) {
            // Ensure the no_order is properly formatted before extracting numeric part
            preg_match('/\d+$/', $latestOrder->no_order, $matches);  // Extract the numeric part at the end
            $lastNumber = isset($matches[0]) ? (int)$matches[0] : 0;  // Ensure there's a number to increment
            $newOrderNumber = $lastNumber + 1;
        } else {
            // If no record exists, start with 1
            $newOrderNumber = 1;
        }

        // Generate the next no_order
        $no_order = $prefixes[$jenis_alber] . str_pad($newOrderNumber, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'no_order' => $no_order,
        ]);
    }

    public function getAlberForUser(Request $request)
    {
        $role = $request->user()->role;

        if ($role === 'admin') {
            $alber = Alber::all();
            return response()->json(['message' => 'data successfully fetched for ADMIN', 'data' => $alber]);
        }

        if ($role === 'admin_pcs') {
            $alber = Alber::all();
            return response()->json(['message' => 'data successfully fetched for admin_pcs', 'data' => $alber]);
        }

        $username = $request->user()->name;
        $alber = Alber::where('requested_by', $username)->get();

        if ($alber->isEmpty()) {
            return response()->json(['message' => 'No Alber found for this user'], 404);
        }

        return response()->json(['message' => 'data successfully fetched', 'data' => $alber]);
    }

    public function getAlberById($id)
    {
        try {
            $statuses = DB::table('statuses')->where('alber_id', $id)->get();

            if ($statuses->isEmpty()) {
                return response()->json([
                    'message' => 'No status found for this Alber'
                ], 404);
            }

            return response()->json([
                'data' => $statuses,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
