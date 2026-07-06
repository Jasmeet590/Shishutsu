<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vaildator;

class PartyController extends Controller
{
    public function addParty()
    {
        return view('party.add');
    }

    public function Index()
    {
        //$parties = Party::all();

        //Getting required columns only
        $parties = Party::select('id', 'party_type', 'full_name', 'phone_no', 'address', 'account_holder_name', 'account_no', 'bank_name', 'ifsc_code', 'branch_address', 'created_at')->get();

        return view('party.index', compact('parties'));
    }

     
    public function createParty(Request $request)
    {

        $request->validate([
          'full_name'=>'required|string|min:2|max:20',
          'party_type'=>'required',
          'phone_no'=>'required|regex:/^[0-9]{10}$/',
          'address'=>'required|max:255',

          'account_holder_name'=>'required|min:2|max:20',
          'account_no'=>'required|numeric',
          'bank_name'=>'required|max:20',
          'ifsc_code'=>'required|max:30',
          'branch_address'=>'required|max:20',

        ]);

         $formData = $request->all();

         // Unset token from form data
         unset($formData['_token']);

         Party::create($formData);


         //Redirect user to add party page

         return redirect()->route('add-party')->with('success', 'Party created successfully');

    }


    public function editParty($id)
    {
        $data['party'] = Party::find($id);
        return view('party.edit', $data);
    }


    public function updateParty(Request $request)
    {
        $request->validate([
            'full_name'=>'required|string|min:2|max:20',
            'party_type'=>'required',
            'phone_no'=>'required|regex:/^[0-9]{10}$/',
            'address'=>'required|max:255',
            'account_holder_name'=>'required|min:2|max:20',
            'account_no'=>'required|numeric',
            'bank_name'=>'required|max:20',
            'ifsc_code'=>'required|max:30',
            'branch_address'=>'required|max:20',
            'party_id' => 'required|exists:parties,id',
        ]);

        $formData = $request->all();
        unset($formData['_token']);
        unset($formData['_method']);

        $party = Party::find($formData['party_id']);
        $party->update($formData);

        return redirect()->route('manage-parties')->with('success', 'Party updated successfully');
    }


    public function deleteParty($id)
    {
        $party = Party::find($id);
        if ($party) {
            $party->delete();
            return redirect()->route('manage-parties')->with('success', 'Party deleted successfully');
        } else {
            return redirect()->route('manage-parties')->with('error', 'Party not found');
        }
    }





}
