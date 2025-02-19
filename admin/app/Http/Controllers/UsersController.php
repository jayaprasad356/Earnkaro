<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Avatars;
use App\Models\Transactions;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $filterDate = $request->get('filter_date') ?: now()->toDateString(); // Defaults to today's dat
    
        $users = Users::query()
            ->when(!$search, function ($query) use ($filterDate) {
                // Filter only users created today (without time)
                return $query->whereDate('created_at', $filterDate);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('mobile', 'like', '%' . $search . '%');
                });
            })
          
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('users.index', compact('users'));
    }
    
    
    
    // Show the form to edit an existing user
    public function edit($id)
    {
        $user = Users::findOrFail($id);
    
    
        return view('users.edit', compact('user'));
    }

    // Update an existing user
    public function update(Request $request, $id)
    {
        $user = Users::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = $request->password; 
        $user->age = $request->age;
        $user->status = $request->status;
        $user->state = $request->state;
        $user->pincode = $request->pincode;
        $user->gender = $request->gender; 
        $user->refer_code = $request->refer_code;
        $user->referred_by = $request->referred_by; 
        $user->c_referred_by = $request->c_referred_by; 
        $user->d_referred_by = $request->d_referred_by;
        $user->e_referred_by = $request->e_referred_by;
        $user->balance = $request->balance; 
        $user->recharge = $request->recharge; 
        $user->blocked = $request->blocked; 
        $user->updated_at = now();
        $user->save();

        return redirect()->route('users.index')->with('success', 'user successfully updated.');
    }

       // Handle Add Coins form submission
       public function addBalance(Request $request, $id)
       {
           // Validate the input
           $request->validate([
               'balance' => 'required|numeric|min:1',
           ]);
   
           $user = Users::findOrFail($id); // Retrieve the user by ID
   
           // Update the user's coins
           $user->balance += $request->input('balance');
           $user->save();
   
           // Create a new transaction record
           Transactions::create([
               'user_id' => $user->id,
               'type' => 'admin_bonus',
               'amount' => $request->input('balance'),
               'datetime' => now(),
           ]);
   
           return redirect()->route('users.index')->with('success', 'Balance Added Successfully.');
       }

    // Delete a user
    public function destroy($id)
    {
        $user = Users::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'user successfully deleted.');
    }

}
