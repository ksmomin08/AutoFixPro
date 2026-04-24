<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private $razorpayId;
    private $razorpayKey;

    public function __construct()
    {
        $this->razorpayId = env('RAZORPAY_KEY');
        $this->razorpayKey = env('RAZORPAY_SECRET');
    }

    public function checkout($appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        
        // Define price mapping (same as in services.blade.php)
        $services = [
            'General Maintenance' => 499,
            'Engine Oil Service' => 299,
            'Brake Overhaul' => 249,
            'Chain & Sprocket' => 199,
            'Clutch & Gearbox' => 449,
            'Electrical Diagnostics' => 349,
            'Performance Tuning' => 599,
            'Professional Wash' => 249,
            'Suspension Service' => 899,
            'Tyre & Wheel Care' => 149,
            'Body Restoration' => 1499,
            'Major Overhaul' => 3499,
        ];

        $total_amount = $services[$appointment->service] ?? 500; // Default to 500 if not found
        $booking_fee = 200; // Fixed booking fee
        
        $appointment->update([
            'total_amount' => $total_amount,
            'amount' => $booking_fee // Use amount field for the current Razorpay order
        ]);

        $api = new Api($this->razorpayId, $this->razorpayKey);

        $orderData = [
            'receipt'         => 'rcpt_' . $appointment->id,
            'amount'          => $booking_fee * 100, // Amount in paise (200 * 100)
            'currency'        => 'INR',
            'payment_capture' => 1 // Auto-capture
        ];

        try {
            $razorpayOrder = $api->order->create($orderData);
            $appointment->update(['razorpay_order_id' => $razorpayOrder['id']]);
            
            return view('payment.checkout', [
                'appointment' => $appointment,
                'razorpay_order_id' => $razorpayOrder['id'],
                'razorpay_key' => $this->razorpayId,
                'amount' => $booking_fee,
                'total_amount' => $total_amount,
                'user' => Auth::user()
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay Order Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to initiate payment. Please try again.');
        }
    }

    public function verify(Request $request)
    {
        $success = true;
        $error = "Payment Failed";

        if (empty($request->razorpay_payment_id) === false) {
            $api = new Api($this->razorpayId, $this->razorpayKey);

            try {
                $attributes = [
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ];

                $api->utility->verifyPaymentSignature($attributes);
            } catch (\Exception $e) {
                $success = false;
                $error = 'Razorpay Error: ' . $e->getMessage();
            }
        } else {
            $success = false;
        }

        if ($success === true) {
            $appointment = Appointment::where('razorpay_order_id', $request->razorpay_order_id)->first();
            if ($appointment) {
                $appointment->update([
                    'payment_status' => 'advance_paid',
                    'advance_paid' => 200,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'status' => 'pending' // Move from 'pending_payment' to 'pending'
                ]);
            }
            return view('payment.success', compact('appointment'));
        } else {
            return redirect()->route('appointment')->with('error', 'Payment failed: ' . $error);
        }
    }

    public function checkoutFull($appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        
        $balance = $appointment->total_amount - $appointment->advance_paid;
        
        if ($balance <= 0) {
            return redirect()->route('bookings')->with('success', 'This appointment is already fully paid.');
        }

        $api = new Api($this->razorpayId, $this->razorpayKey);

        $orderData = [
            'receipt'         => 'rcpt_full_' . $appointment->id,
            'amount'          => $balance * 100, // Amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // Auto-capture
        ];

        try {
            $razorpayOrder = $api->order->create($orderData);
            $appointment->update(['razorpay_order_id' => $razorpayOrder['id']]);
            
            return view('payment.checkout', [
                'appointment' => $appointment,
                'razorpay_order_id' => $razorpayOrder['id'],
                'razorpay_key' => $this->razorpayId,
                'amount' => $balance,
                'total_amount' => $appointment->total_amount,
                'is_full_payment' => true,
                'user' => Auth::user()
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay Full Order Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to initiate final payment. Please try again.');
        }
    }

    public function verifyFull(Request $request)
    {
        $success = true;
        $error = "Payment Failed";

        if (empty($request->razorpay_payment_id) === false) {
            $api = new Api($this->razorpayId, $this->razorpayKey);

            try {
                $attributes = [
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ];

                $api->utility->verifyPaymentSignature($attributes);
            } catch (\Exception $e) {
                $success = false;
                $error = 'Razorpay Error: ' . $e->getMessage();
            }
        } else {
            $success = false;
        }

        if ($success === true) {
            $appointment = Appointment::where('razorpay_order_id', $request->razorpay_order_id)->first();
            if ($appointment) {
                $appointment->update([
                    'payment_status' => 'paid',
                    'final_payment_status' => 'paid',
                    'advance_paid' => $appointment->total_amount, // Mark total as paid
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                ]);
            }
            return view('payment.success', compact('appointment'));
        } else {
            return redirect()->route('bookings')->with('error', 'Final payment failed: ' . $error);
        }
    }
}
