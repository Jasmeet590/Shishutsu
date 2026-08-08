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

            <div class="row">
              @foreach($plans as $index => $plan)
                <div class="col-lg-6 col-xl-3 mb-3">
                  <label class="plan-card card h-100 border border-light shadow-sm">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="mb-0">{{ $plan->name }}</h5>
                        <input class="plan-radio" type="radio" name="subscription_plan[]" value="{{ $plan->slug }}" {{ $index === 0 ? 'checked' : '' }}>
                      </div>

                      <div class="d-flex align-items-baseline flex-wrap mb-1">
                        <span class="display-4 font-weight-bold line-height-1">${{ number_format($plan->price, 0) }}</span>
                      </div>
                      <p class="text-muted mb-3">{{ $plan->period }}</p>
                      <p class="small text-muted mb-3">{{ $plan->description }}</p>

                      <ul class="list-unstyled small mb-0">
                        @foreach($plan->features as $feature)
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
