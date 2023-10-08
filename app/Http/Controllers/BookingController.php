<?php

namespace App\Http\Controllers;
    
use App\Models\Bed;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\BookingResource;
use Illuminate\Http\JsonResponse;
use DataTables;

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
        $data = [
            'user_id' => $request->input('user_id'),
            'price' => $request->input('price'),
            'status' => $request->input('status'),
            'type' => $request->input('type'),
            'booking_date' => $request->input('booking_date'),
            'bed_id' => $request->input('bed_id'),
            'booking_type' => $request->input('booking_type'),
            'rent' => $request->input('rent'),
            'mess_status' => $request->input('mess_status'),
            'mess' => $request->input('mess'),
            'discount' => $request->input('discount'),
            'total' => $request->input('total'),
            'paid' => $request->input('paid'),
            'balance' => $request->input('balance'),
            'detail' => $request->input('detail'),
            'due' => $request->input('due'),
            'next_due_date' => $request->input('next_due_date'),
            'check_in_date' => $request->input('check_in_date'),
            'check_out_date' => $request->input('check_out_date'),
        ];        
        if($request->input('id')){
            Booking::where('id', $request->input('id'))->update($data);
            return response()->json(['success' => 'Booking Updated successfully']);              
        }else{
            Booking::create($data);
            return response()->json(['success' => 'Booking Created successfully']);              
        }
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