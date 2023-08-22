<?php

namespace App\Http\Controllers;
    
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\JsonResponse;
use DataTables;

class TransactionController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:transaction-list|transaction-create|transaction-edit|transaction-delete', ['only' => ['index','show']]);
         $this->middleware('permission:transaction-create', ['only' => ['create','store']]);
         $this->middleware('permission:transaction-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:transaction-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $pageName = "Transactions";
        return view('transactions.index', compact('pageName'));
    }
    
    public function get_transactions_data(){
        $jsonData = TransactionResource::collection(Transaction::all())->toJson();
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
            Transaction::where('id', $request->input('id'))->update($data);
            return response()->json(['success' => 'Transaction Updated successfully']);              
        }else{
            Transaction::create($data);
            return response()->json(['success' => 'Transaction Created successfully']);              
        }
    }
    
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }
    
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json(['success' => 'Transaction deleted successfully']);
    }
    
    // public function create(){}
    // public function edit(transaction $transaction){}
    // public function update(Request $request, transaction $transaction){}
}