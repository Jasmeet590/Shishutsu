<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GstBill;
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
        $bills = GstBill::with('party')->where('is_deleted', 0)->orderBy('invoice_date', 'desc')->get();
        return view('gst-bill.manage', compact('bills'));
    }


   public function print($id)
    {
        $bill = GstBill::findOrFail($id);
        return view('gst-bill.print', compact('bill'));
    }


   public function createGstBill(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'party_id' => 'required|exists:parties,id',
            'invoice_date' => 'required|date',
            'invoice_number' => 'required|string|max:50',
            'item_description' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'cgst_rate' => 'nullable|min:0|max:100',
            'cgst_amount' => 'numeric|min:0',
            'sgst_rate' => 'nullable|min:0|max:100',
            'sgst_amount' => 'numeric|min:0',
            'igst_rate' => 'nullable|min:0|max:100',
            'igst_amount' => 'numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'net_amount' => 'required|numeric|min:0'
        ]);

        $data = $request->all();

        unset($data['_token']);
        GstBill::create($data);

        // Process the validated data (e.g., save to database, generate invoice, etc.)
        // For demonstration purposes, we'll just return a success message.
        return redirect()->route('manage-gst-bill')->with('success', 'GST Bill created successfully!');
    } 



}
