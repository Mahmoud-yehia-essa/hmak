@extends('frontend.master_dashboard')
@section('main')
<script>
  // Frontend browser event with the SAME eventID → Meta deduplicates
  fbq('track', 'Purchase',
    { value: {{ $order_value }}, currency: 'USD' },
    { eventID: '{{ $eventId }}' }
  );
</script>

<h1>Thank you!</h1>
<p>We’re processing your order.</p>

@endsection

