<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Plan::where('is_active', true)
            ->orderBy('price')
            ->get()
            ->map(function ($plan) {
                $plan->features = is_array($plan->features) ? $plan->features : json_decode($plan->features, true) ?? [];
                return $plan;
            });

        return view('subscription.index', compact('plans'));
    }

    public function subscribe(Request $request)
    {
        $planId = $request->input('subscription');
        // Here you can handle the subscription logic, e.g., save the selected plan to the database or process payment.
        // For demonstration purposes, we'll just return a success message.
        echo print_r($request->all(), true);
    }
}
