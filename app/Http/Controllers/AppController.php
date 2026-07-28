<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AppController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function about()
    {
        return view('about');
    }

    public function service()
    {
        return view('service');
    }

    public function delete($table, $id)
    {
        // Validate the table name to prevent SQL injection
        $allowedTables = ['parties', 'gst_bills']; // Add more allowed table names as needed
        if (!in_array($table, $allowedTables)) {
            abort(404); // Return a 404 error if the table is not allowed
        }

        // Perform the soft delete operation
        DB::table($table)->where('id', $id)->update(['is_deleted' => 1]);

        return redirect()->back()->with('success', 'Record deleted successfully.');
    }

    public function profile()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
