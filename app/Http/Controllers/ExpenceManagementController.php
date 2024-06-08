<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenceManagement;
use Illuminate\Support\Facades\Auth;

class ExpenceManagementController extends Controller
{

  
    // public function indexess()
    // {
    //     $expenses = ExpenceManagement::where('user_id', Auth::id())
    //     ->orderBy('created_at','desc')
    //     ->get();
    //     return response()->json($expenses);
    // }
    

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'category' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'comments' => 'nullable|string',
    ]);

    // Set the user_id to the authenticated user's ID
    $validatedData['user_id'] = Auth::id();

    ExpenceManagement::create($validatedData);

    return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
}

public function index()
{
    // Retrieve only expenses associated with the authenticated user
    $expenses = ExpenceManagement::where('user_id', Auth::id())
                                  ->orderBy('created_at','desc')
                                  ->get();
    return view('expenses.index', compact('expenses'));
}

    public function create()
    {
        return view('expenses.create');
    }
   
    public function show($id)
    {
        $expense = ExpenceManagement::findOrFail($id);
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $expense = ExpenceManagement::findOrFail($id);
        return view('expenses.edit', compact('expense'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'comments' => 'nullable|string',
        ]);

        ExpenceManagement::whereId($id)->update($validatedData);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expense = ExpenceManagement::findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
