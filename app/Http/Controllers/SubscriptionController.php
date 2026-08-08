<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    
  public function index()
  {
      return view('subscription.index');
  }

    public function subscribe(Request $request)
    {
        $planId = $request->input('subscription');
        // Here you can handle the subscription logic, e.g., save the selected plan to the database or process payment.
        // For demonstration purposes, we'll just return a success message.
        return redirect()->back()->with('success', 'You have successfully subscribed to plan ID: ' . $planId);
    }

}
