<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('appointment.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required|string',
            'vehicle' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'details' => 'nullable|string',
            'workshop_id' => 'required|string',
            'workshop_name' => 'required|string',
            'pickup_address' => 'required|string',
            'user_lat' => 'nullable|numeric',
            'user_lng' => 'nullable|numeric',
        ]);

        $user = Auth::user();

        $appointment = Appointment::create([
            'user_id' => $user->id,
            'fullname' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? 'N/A', 
            'vehicle' => $validated['vehicle'],
            'date' => $validated['date'],
            'service' => $validated['service'],
            'workshop_id' => $validated['workshop_id'],
            'workshop_name' => $validated['workshop_name'],
            'pickup_address' => $validated['pickup_address'],
            'user_lat' => $validated['user_lat'],
            'user_lng' => $validated['user_lng'],
            'details' => $validated['details'] ?? '',
            'status' => 'pending_payment',
        ]);

        return redirect()->route('payment.checkout', $appointment->id);
    }

    public function cancel($id)
    {
        $updated = Appointment::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['status' => 'cancelled']);

        if ($updated) {
            return back()->with('success', 'Appointment cancelled successfully.');
        }

        return back()->with('error', 'Could not cancel appointment.');
    }

    public function bookings()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted', 'in-progress'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('appointment.list', compact('appointments'));
    }

    public function history()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('appointment.history', compact('appointments'));
    }
}
