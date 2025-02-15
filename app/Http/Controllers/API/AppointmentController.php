<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Appointment::query();
        $userId = auth()->id();

        if ($request->query('creator') === 'true') {
            $query->where('creator_id', $userId);
            $appointments = $query->with('receiver')->get();
        } elseif ($request->query('receiver') === 'true') {
            $query->where('receiver_id', $userId);
            $appointments = $query->with('creator')->get();
        } else {
            $appointments = $query->with('creator', 'receiver')->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved all appointments.',
            'data' => $appointments,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'title',
                'creator_id',
                'receiver_id',
                'start',
                'end',
            ]);

            $data['creator_id'] = auth()->id();

            $userTimezone = auth()->user()->preferred_timezone;

            $start = Helper::convertToUserTimezone($request->start, $userTimezone);
            $end = Helper::convertToUserTimezone($request->end, $userTimezone);

            $validationError = $this->validateAppointmentTime($start, $end);
            if ($validationError) {
                return $validationError;
            }

            if ($id != null) {
                $appointment = Appointment::where([
                    'id' => $id,
                    'creator_id' => auth()->id()
                ])
                    ->first();

                if (!$appointment) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Appointment not found.',
                    ], 404);
                }

                $appointment->update($data);

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment successfully updated.',
                    'data' => $appointment,
                ], 200);
            } else {
                $appointment = Appointment::create($data);

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment successfully created.',
                    'data' => $appointment,
                ], 201);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error occurred.',
                'errors' => ['error' => $e->getMessage()],
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function upcoming(Appointment $appointment)
    {
        $userTimezone = auth()->user()->preferred_timezone;
        $now = Carbon::now($userTimezone);

        $appointments = $appointment->where(function ($query) {
            $query->where('creator_id', auth()->id())
                ->orWhere('receiver_id', auth()->id());
        })
            ->where('start', '>=', $now)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved all upcoming appointments.',
            'data' => $appointments,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $appointment = Appointment::where([
                'id' => $id,
                'creator_id' => auth()->id(),
            ])->first();

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found.',
                ], 404);
            }

            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Appointment successfully deleted.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error occurred.',
                'errors' => ['error' => $e->getMessage()],
            ], 500);
        }
    }

    private function validateAppointmentTime($start, $end)
    {
        $userTimezone = auth()->user()->preferred_timezone;
        $userLocalTime = Carbon::now($userTimezone)->toDateTimeString();

        if (!Helper::isWorkingHours($start) || !Helper::isWorkingHours($end)) {
            return response()->json(['success' => false, 'error' => 'Appointment must be within working hours (08:00 - 17:00).'], 400);
        }

        if ($end->lte($start)) {
            return response()->json([
                'success' => false,
                'error' => 'End time must be later than start time.'
            ], 400);
        }

        return null;
    }
}
