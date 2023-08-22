<?php

namespace App\Http\Controllers;
    
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;
use DataTables;

class RoleController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','show']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $pageName = "Roles";
        return view('roles.index', compact('pageName'));
    }
    
    public function get_roles_data(){
        $jsonData = RoleResource::collection(Role::all())->toJson();
        $data = json_decode($jsonData);
        return Datatables::of($data)->make(true);
    }

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'detail' => 'required',
        ]);
        $data = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'detail' => $request->input('detail'),
            'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=989&q=80', // Replace with your hardcoded image URL
        ];
        if($request->input('id')){
            Role::where('id', $request->input('id'))->update($data);
            return response()->json(['success' => 'Role Updated successfully']);              
        }else{
            Role::create($data);
            return response()->json(['success' => 'Role Created successfully']);              
        }
    }
    
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }
    
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['success' => 'Role deleted successfully']);
    }
    
    // public function create(){}
    // public function edit(Role $role){}
    // public function update(Request $request, Role $role){}
}