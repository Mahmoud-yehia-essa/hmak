@extends('frontend.master_dashboard')
@section('main')

    <div class="hero10-section-area">

<div class="container">
    <h1>Test Order</h1>
    <p>Click the button below to simulate a purchase event.</p>

    <form action="{{ route('orders.complete') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            Complete Order
        </button>
    </form>
</div>
    </div>
@endsection
