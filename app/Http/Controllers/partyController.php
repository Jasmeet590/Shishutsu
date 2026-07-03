<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vaildator;

class PartyController extends Controller
{
    public function addparty()
    {
        return view('party.add');
    }

    public function Index()
    {
        return view('party.manage');
    }

     
    public function createParty(Request $request)
    {

        $request->validate([
          'full_name'=>'required',
          'party_type'=>'required'
        ]);

         $formData = $request->all();

         // Unset token from form data
         unset($formData['_token']);

         Party::create($formData);


         //Redirect user to add party page

         return redirect()->route('add-party')->with('success', 'Party created successfully');

    }


}
