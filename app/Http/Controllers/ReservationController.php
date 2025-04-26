<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        try {
            $totalReservations = Reservation::count();
            $totalRevenue = Reservation::sum('total_bill');
            $reservations = Reservation::orderBy('reservation_time', 'desc')->get();

            return view('admin', [
                'totalReservations' => $totalReservations,
                'totalRevenue' => $totalRevenue,
                'reservations' => $reservations,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching data: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'room_type' => 'required|string|max:50',
            'room_capacity' => 'required|string|max:50',
            'payment_type' => 'required|string|max:50',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        try {
            $fromDate = new \DateTime($request->from_date);
            $toDate = new \DateTime($request->to_date);
            $numDays = $fromDate->diff($toDate)->days;

            $rates = [
                'Single' => ['Regular' => 1000, 'Deluxe' => 3000, 'Suite' => 5000],
                'Double' => ['Regular' => 2000, 'Deluxe' => 5000, 'Suite' => 8000],
                'Family' => ['Regular' => 5000, 'Deluxe' => 7500, 'Suite' => 10000],
            ];

            $dailyRate = $rates[$request->room_capacity][$request->room_type];
            $subTotal = $dailyRate * $numDays;

            $discount = ($numDays >= 6) ? 0.15 : 0.10;
            $discountAmount = $subTotal * $discount;

            $additionalCharge = 0;
            if ($request->payment_type === 'Cheque') {
                $additionalCharge = $subTotal * 0.05;
            } elseif ($request->payment_type === 'Credit') {
                $additionalCharge = $subTotal * 0.10;
            }

            $totalBill = $subTotal + $additionalCharge - $discountAmount;

            Reservation::create([
                'customer_name' => $request->customer_name,
                'contact_number' => $request->contact_number,
                'room_type' => $request->room_type,
                'room_capacity' => $request->room_capacity,
                'payment_type' => $request->payment_type,
                'from_date' => $fromDate->format('Y-m-d'),
                'to_date' => $toDate->format('Y-m-d'),
                'num_days' => $numDays,
                'sub_total' => $subTotal,
                'additional_charge' => $additionalCharge,
                'discount_amount' => $discountAmount,
                'total_bill' => $totalBill,
                'reservation_time' => now(),
            ]);

            return back()->with('success', 'Reservation added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error adding reservation: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return response()->json($reservation);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'room_type' => 'required|string|max:50',
            'room_capacity' => 'required|string|max:50',
            'payment_type' => 'required|string|max:50',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        try {
            $reservation = Reservation::findOrFail($id);

            $fromDate = new \DateTime($request->from_date);
            $toDate = new \DateTime($request->to_date);
            $numDays = $fromDate->diff($toDate)->days;

            $rates = [
                'Single' => ['Regular' => 1000, 'Deluxe' => 3000, 'Suite' => 5000],
                'Double' => ['Regular' => 2000, 'Deluxe' => 5000, 'Suite' => 8000],
                'Family' => ['Regular' => 5000, 'Deluxe' => 7500, 'Suite' => 10000],
            ];

            $dailyRate = $rates[$request->room_capacity][$request->room_type];
            $subTotal = $dailyRate * $numDays;

            $discount = ($numDays >= 6) ? 0.15 : 0.10;
            $discountAmount = $subTotal * $discount;

            $additionalCharge = 0;
            if ($request->payment_type === 'Cheque') {
                $additionalCharge = $subTotal * 0.05;
            } elseif ($request->payment_type === 'Credit') {
                $additionalCharge = $subTotal * 0.10;
            }

            $totalBill = $subTotal + $additionalCharge - $discountAmount;

            $reservation->update([
                'customer_name' => $request->customer_name,
                'contact_number' => $request->contact_number,
                'room_type' => $request->room_type,
                'room_capacity' => $request->room_capacity,
                'payment_type' => $request->payment_type,
                'from_date' => $fromDate->format('Y-m-d'),
                'to_date' => $toDate->format('Y-m-d'),
                'num_days' => $numDays,
                'sub_total' => $subTotal,
                'additional_charge' => $additionalCharge,
                'discount_amount' => $discountAmount,
                'total_bill' => $totalBill,
            ]);

            return back()->with('success', 'Reservation updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating reservation: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();

            return back()->with('success', 'Reservation deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting reservation: ' . $e->getMessage());
        }
    }
    public function showReservationDetails(Request $request)
{
    $request->validate([
        'customerName' => 'required|string|max:255',
        'contactNumber' => 'required|string|max:20',
        'roomType' => 'required|string|max:50',
        'roomCapacity' => 'required|string|max:50',
        'paymentType' => 'required|string|max:50',
        'fromDate' => 'required|date',
        'toDate' => 'required|date|after:fromDate',
    ]);

    try {
        $rates = [
            'Single' => ['Regular' => 100, 'De Luxe' => 300, 'Suite' => 500],
            'Double' => ['Regular' => 200, 'De Luxe' => 500, 'Suite' => 800],
            'Family' => ['Regular' => 500, 'De Luxe' => 750, 'Suite' => 1000],
        ];

        $customerName = $request->customerName;
        $contactNumber = $request->contactNumber;
        $roomType = $request->roomType;
        $roomCapacity = $request->roomCapacity;
        $paymentType = $request->paymentType;
        $fromDate = new \DateTime($request->fromDate);
        $toDate = new \DateTime($request->toDate);

        $numDays = $fromDate->diff($toDate)->days;

        $dailyRate = $rates[$roomCapacity][$roomType] ?? 0;
        $subTotal = $dailyRate * $numDays;

        $discount = ($numDays >= 6) ? 0.15 : 0.10;
        $discountAmount = $subTotal * $discount;

        $additionalCharge = 0;
        if ($paymentType === 'Cheque') {
            $additionalCharge = $subTotal * 0.05;
        } elseif ($paymentType === 'Credit') {
            $additionalCharge = $subTotal * 0.10;
        }

        $totalBill = $subTotal + $additionalCharge - $discountAmount;

        $formattedFromDate = $fromDate->format('F d, Y');
        $formattedToDate = $toDate->format('F d, Y');
        $reservationTime = now();

        return view('reservation_info', compact(
            'customerName',
            'contactNumber',
            'roomType',
            'roomCapacity',
            'paymentType',
            'formattedFromDate',
            'formattedToDate',
            'numDays',
            'subTotal',
            'discountAmount',
            'additionalCharge',
            'totalBill',
            'reservationTime'
        ));
    } catch (\Exception $e) {
        return back()->with('error', 'Error processing reservation: ' . $e->getMessage());
    }
}
}