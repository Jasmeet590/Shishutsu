@extends('layout.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">
          <div class="text-center mb-4">
            <h3 class="mb-1">Choose your subscription</h3>
            <p class="text-muted mb-0">Pick a plan that fits your business needs and keep your billing organised.</p>
          </div>

          <form method="POST" action="{{ route('subscribe') }}">
            @csrf

            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @php
              $plans = [
                  [
                      'id' => 'free',
                      'name' => 'Free Tier',
                      'price' => '$0',
                      'period' => 'forever',
                      'description' => 'A simple starting point for light usage and testing.',
                      'features' => ['Basic access', '1 user', 'Limited reports']
                  ],
                  [
                      'id' => '1-month',
                      'name' => '1 Month Tier',
                      'price' => '$19',
                      'period' => 'per month',
                      'description' => 'Great for short-term use with full access to essentials.',
                      'features' => ['Full access', 'Unlimited invoices', 'Priority support']
                  ],
                  [
                      'id' => '6-months',
                      'name' => '6 Months Tier',
                      'price' => '$99',
                      'period' => 'per 6 months',
                      'description' => 'Best for steady monthly work with better value.',
                      'features' => ['Full access', 'Advanced reports', 'Priority support']
                  ],
                  [
                      'id' => '1-year',
                      'name' => '1 Year Tier',
                      'price' => '$179',
                      'period' => 'per year',
                      'description' => 'Perfect for long-term use with the best savings.',
                      'features' => ['Full access', 'All premium features', 'Dedicated support']
                  ]
              ];
            @endphp

            <div class="row">
              @foreach($plans as $index => $plan)
                <div class="col-lg-6 col-xl-3 mb-3">
                  <label class="plan-card card h-100 border border-light shadow-sm">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="mb-0">{{ $plan['name'] }}</h5>
                        <input class="plan-radio" type="radio" name="subscription_plan[]" value="{{ $plan['id'] }}" {{ $index === 0 ? 'checked' : '' }}>
                      </div>

                      <div class="d-flex align-items-baseline flex-wrap mb-1">
                        <span class="display-4 font-weight-bold line-height-1">{{ $plan['price'] }}</span>
                      </div>
                      <p class="text-muted mb-3">{{ $plan['period'] }}</p>
                      <p class="small text-muted mb-3">{{ $plan['description'] }}</p>

                      <ul class="list-unstyled small mb-0">
                        @foreach($plan['features'] as $feature)
                          <li class="mb-2">
                            <i class="mdi mdi-check-circle text-success mr-2"></i>{{ $feature }}
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  </label>
                </div>
              @endforeach
            </div>

            <div class="text-center mt-3">
              <button type="submit" class="btn btn-primary btn-lg">Continue</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
