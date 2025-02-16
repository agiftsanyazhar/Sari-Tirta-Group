<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\{Appointment, User};
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();
        $users = User::all();

        $data = [
            'title' => 'Appointments',
            'appointments' => $appointments,
            'users' => $users
        ];

        return view('dashboard.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->saveAppointment($request, null);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        return $this->saveAppointment($request, $request->id);
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
                return redirect()->route('dashboard.appointment.index')->with('error', 'Data bukan milik Anda.');
            }

            $appointment->delete();

            return redirect()->route('dashboard.appointment.index')->with('success', 'Data berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('dashboard.appointment.index')->with('error', 'Terjadi kesalahan.');
        }
    }

    private function saveAppointment(Request $request, $id = null)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'receiver_id' => 'required|integer',
                'start' => 'required',
                'end' => 'required',
            ]);

            $data['creator_id'] = auth()->id();

            $userTimezone = auth()->user()->preferred_timezone;

            $start = Helper::convertToUserTimezone($request->start, $userTimezone);
            $end = Helper::convertToUserTimezone($request->end, $userTimezone);

            $validationError = $this->validateAppointmentTime($start, $end);
            if ($validationError) {
                return $validationError;
            }

            if ($id) {
                $appointment = Appointment::where([
                    'id' => $id,
                    'creator_id' => auth()->id(),
                ])->first();

                if (!$appointment) {
                    return redirect()->route('dashboard.appointment.index')->with('error', 'Data bukan milik Anda.');
                }

                $appointment->update($data);
            } else {
                Appointment::create($data);
            }

            $status = 'success';
            $message = 'Data berhasil disimpan.';
        } catch (Exception $e) {
            $status = 'error';
            $message = 'Gagal disimpan. ' . $e->getMessage();
        }

        return redirect()->back()->with($status, $message);
    }

    private function validateAppointmentTime($start, $end)
    {
        $userTimezone = auth()->user()->preferred_timezone;
        $userLocalTime = Carbon::now($userTimezone)->toDateTimeString();

        if (!Helper::isWorkingHours($start) || !Helper::isWorkingHours($end)) {
            return redirect()->back()->with('error', 'Your timezone is set to ' . $userTimezone . ' and your local time is ' . $userLocalTime . ', which is outside of working hours (08:00 - 17:00). Start time or end time must be within working hours (08:00 - 17:00).');
        }

        if ($end->lte($start)) {
            return redirect()->back()->with('End time must be later than start time.');
        }

        return null;
    }
}
