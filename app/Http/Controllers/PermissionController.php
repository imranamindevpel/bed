<?php

namespace App\Http\Controllers;
    
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\JsonResponse;
use DataTables;

class PermissionController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','show']]);
         $this->middleware('permission:permission-create', ['only' => ['create','store']]);
         $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $pageName = "Permissions";
        return view('permissions.index', compact('pageName'));
    }
    
    public function get_permissions_data(){
        $jsonData = PermissionResource::collection(Permission::all())->toJson();
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
            Permission::where('id', $request->input('id'))->update($data);
            return response()->json(['success' => 'Permission Updated successfully']);              
        }else{
            Permission::create($data);
            return response()->json(['success' => 'Permission Created successfully']);              
        }
    }
    
    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }
    
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['success' => 'Permission deleted successfully']);
    }
    
    // public function create(){}
    // public function edit(Permission $permission){}
    // public function update(Request $request, Permission $permission){}
}