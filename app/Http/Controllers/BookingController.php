<?php

namespace App\Http\Controllers;
    
use App\Models\Bed;
use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\BookingResource;
use Illuminate\Http\JsonResponse;
use DataTables;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:booking-list|booking-create|booking-edit|booking-delete', ['only' => ['index','show']]);
         $this->middleware('permission:booking-create', ['only' => ['create','store']]);
         $this->middleware('permission:booking-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:booking-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $pageName = "Bookings";
        $beds = Bed::all();
        $users = User::all();
        return view('bookings.index', compact('pageName','beds','users'));
    }
    
    public function get_bookings_data(){
        $jsonData = BookingResource::collection(Booking::all())->toJson();
        $data = json_decode($jsonData);
        return Datatables::of($data)->make(true);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // request()->validate([
        //     'name' => 'required',
        //     'price' => 'required',
        //     'quantity' => 'required',
        //     'detail' => 'required',
        // ]);
        $userId = $request->input('user_id');
        $totalAmount = $request->input('total');
        $paidAmount =  $request->input('paid');
        $balanceAmount =  $request->input('balance');
        $data = [
            'user_id' => $userId,
            'price' => $request->input('price'),
            'status' => $request->input('status'),
            'type' => $request->input('type'),
            'booking_date' => $request->input('booking_date'),
            'bed_id' => $request->input('bed_id'),
            'booking_type' => $request->input('booking_type'),
            'rent' => $request->input('rent'),
            'mess_status' => $request->input('mess_status'),
            'mess' => $request->input('mess'),
            'mess_disc_status' => $request->input('mess_disc_status'),
            'mess_disc' => $request->input('mess_disc'),
            'discount' => $request->input('discount'),
            'total' => $request->input('total'),
            'check_in_date' => $request->input('check_in_date'),
            'check_out_date' => $request->input('check_out_date'),
        ];

        if ($request->input('id')) {
            $booking = Booking::find($request->input('id'));
            $booking->update($data);
        } else {
            $booking = Booking::create($data);
        }
        
        DB::transaction(function () use ($booking, $userId, $totalAmount, $paidAmount, $balanceAmount) {
            $transaction = new Transaction;
            $transaction->tenant_id = $userId;
            $transaction->booking_id = $booking->id;
            $transaction->total_amount = $totalAmount;
            $transaction->paid_amount =  $paidAmount;
            $transaction->balance_amount =  $balanceAmount;
            $transaction->balance_due_date = '2023-10-14 18:43:13';
            $transaction->next_due_date = '2023-10-14 18:43:13';
            $transaction->payment_method = 'cash';
            $transaction->status = 'pending';
            $transaction->agent_commission = $paidAmount/2;
            $transaction->save();
        });

        return response()->json(['success' => 'Booking and Transaction Created successfully']);
    }
    
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return response()->json($booking);
    }
    
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(['success' => 'Booking deleted successfully']);
    }
    
    // public function create(){}
    // public function edit(booking $booking){}
    // public function update(Request $request, booking $booking){}
}