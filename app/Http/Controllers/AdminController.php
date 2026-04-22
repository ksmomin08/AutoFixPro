<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = \App\Models\User::count();
        $appointmentsCount = \App\Models\Appointment::count();
        $queriesCount = \Illuminate\Support\Facades\DB::table('queries')->count();
        
        $activeBookings = \App\Models\Appointment::whereIn('status', ['pending', 'accepted'])->count();
        $completedBookings = \App\Models\Appointment::where('status', 'completed')->count();
        
        $recentUsers = \App\Models\User::where('role', 'user')->latest()->take(5)->get();
        $recentAppointments = \App\Models\Appointment::latest()->take(5)->get();

        // Mock revenue: Avg 1500 per booking
        $totalRevenue = $completedBookings * 1500;

        return view('admin.dashboard', compact(
            'usersCount', 
            'appointmentsCount', 
            'queriesCount', 
            'activeBookings', 
            'completedBookings',
            'totalRevenue',
            'recentUsers',
            'recentAppointments'
        ));
    }

    public function users()
    {
        $users = \App\Models\User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function appointments()
    {
        $appointments = \App\Models\Appointment::with('user')->orderBy('date', 'asc')->paginate(15);
        return view('admin.appointments', compact('appointments'));
    }

    public function acceptAppointment($id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        $appointment->status = 'accepted';
        $appointment->save();
        return redirect()->back()->with('success', 'Appointment accepted.');
    }

    public function cancelAppointment($id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        $appointment->status = 'cancelled';
        $appointment->save();
        return redirect()->back()->with('success', 'Appointment cancelled.');
    }

    public function markFinalPaid($id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        $appointment->final_payment_status = 'paid';
        $appointment->payment_status = 'paid';
        $appointment->save();
        return redirect()->back()->with('success', 'Final payment marked as paid.');
    }

    public function queries()
    {
        $queries = \Illuminate\Support\Facades\DB::table('queries')->latest()->paginate(15);
        return view('admin.queries', compact('queries'));
    }

    // --- USER CRUD ---
    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->phone = $validated['phone'] ?? $user->phone;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->save();
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        if (\Illuminate\Support\Facades\Auth::id() == $id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    // --- APPOINTMENT CRUD (Edit/Update/Delete) ---
    public function editAppointment($id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        return view('admin.appointments.edit', compact('appointment'));
    }

    public function updateAppointment(Request $request, $id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'vehicle' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:pending,accepted,cancelled',
            'details' => 'nullable|string'
        ]);

        $appointment->update($validated);
        return redirect()->route('admin.appointments')->with('success', 'Appointment updated successfully.');
    }

    public function deleteAppointment($id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);
        $appointment->delete();
        return redirect()->route('admin.appointments')->with('success', 'Appointment deleted successfully.');
    }

    // --- QUERIES CRUD ---
    public function deleteQuery($id)
    {
        \Illuminate\Support\Facades\DB::table('queries')->where('id', $id)->delete();
        return redirect()->route('admin.queries')->with('success', 'Query deleted successfully.');
    }
}
