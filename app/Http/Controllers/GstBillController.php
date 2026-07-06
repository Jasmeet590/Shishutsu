<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;

class GstBillController extends Controller
{
    
   public function addGstBill()
    {
        $data['parties'] = Party::where('party_type', 'client')->orderBy('full_name')->get();

        return view('gst-bill.add', $data);
    }


   public function index()
    {
        return view('gst-bill.manage');
    }


   public function print()
    {
        return view('gst-bill.print');
    }


   public function createGstBill(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'party_name' => 'required|string|max:255',
            'party_address' => 'required|string|max:255',
            'party_gst_number' => 'required|string|max:15',
            'invoice_number' => 'required|string|max:50',
            'invoice_date' => 'required|date',
            'item_description' => 'required|string|max:255',
            'item_quantity' => 'required|integer|min:1',
            'item_price' => 'required|numeric|min:0',
        ]);

        // Process the validated data (e.g., save to database, generate invoice, etc.)
        // For demonstration purposes, we'll just return a success message.
        return redirect()->back()->with('success', 'GST Bill created successfully!');
    } 



}
