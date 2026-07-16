<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use Illuminate\Support\Facades\DB;

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
}
