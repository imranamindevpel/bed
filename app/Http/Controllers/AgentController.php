<?php

namespace App\Http\Controllers;
    
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\AgentResource;
use Illuminate\Http\JsonResponse;
use DataTables;

class AgentController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:agent-list|agent-create|agent-edit|agent-delete', ['only' => ['index','show']]);
         $this->middleware('permission:agent-create', ['only' => ['create','store']]);
         $this->middleware('permission:agent-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:agent-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $pageName = "Agents";
        return view('agents.index', compact('pageName'));
    }
    
    public function get_agents_data(){
        $jsonData = AgentResource::collection(Agent::all())->toJson();
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
            Agent::where('id', $request->input('id'))->update($data);
            return response()->json(['success' => 'Agent Updated successfully']);              
        }else{
            Agent::create($data);
            return response()->json(['success' => 'Agent Created successfully']);              
        }
    }
    
    public function show($id)
    {
        $agent = Agent::findOrFail($id);
        return response()->json($agent);
    }
    
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return response()->json(['success' => 'Agent deleted successfully']);
    }
    
    // public function create(){}
    // public function edit(Agent $Agent){}
    // public function update(Request $request, Agent $Agent){}
}