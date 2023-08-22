<?php

namespace App\Http\Controllers;
    
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use DataTables;

class UserController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $pageName = "Users";
        return view('users.index', compact('pageName'));
    }
    
    public function get_users_data(){
        $jsonData = UserResource::collection(User::all())->toJson();
        $data = json_decode($jsonData);
        return Datatables::of($data)->make(true);
    }
    public function tenants()
    {
        $pageName = "Tenants";
        return view('tenants.index', compact('pageName'));
    }
    public function get_tenants_data(){
        $jsonData = UserResource::collection(User::where('role','tenant')->get())->toJson();
        $data = json_decode($jsonData);
        return Datatables::of($data)->make(true);
    }

    public function agents()
    {
        $pageName = "Agents";
        return view('agents.index', compact('pageName'));
    }
    public function get_agents_data(){
        $jsonData = UserResource::collection(User::where('role','agent')->get())->toJson();
        $data = json_decode($jsonData);
        return Datatables::of($data)->make(true);
    }
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        $data = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Hash the password
            'address' => $request->input('address'),
            'date_of_birth' => $request->input('date_of_birth'),
            'cnic' => $request->input('cnic'),
            'role' => $request->input('role'),
            'percentage' => $request->input('percentage'),
            'status' => $request->input('status'),
        ];
        if($request->input('id')){
            User::where('id', $request->input('id'))->update($data);
            return response()->json(['success' => 'User Updated successfully']);              
        }else{
            // dd($data);
            User::create($data);
            return response()->json(['success' => 'User Created successfully']);              
        }
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => 'User deleted successfully']);
    }
    
    // public function create(){}
    // public function edit(User $user){}
    // public function update(Request $request, User $user){}
}