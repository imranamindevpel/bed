<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Mail\SimpleEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $total_users = User::count();
        return view('dashboard')->with('total_users', $total_users);
    }
    public function sendEmail()
    {
        Mail::to('muhammadimran4884@gmail.com')->send(new SimpleEmail());
        return "Email sent successfully!";
    }
    
}
